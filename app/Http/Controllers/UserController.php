<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use \Google_Client;
use \Google_Service_Calendar;
use \Google_Service_Calendar_Event;
use Twilio\Rest\Client;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Refund;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use App\User;
use App\Classes;
use App\PaymentHistory;
use App\ClassTimetable;
use App\UserQualification;
use App\Qualification;
use App\TrainerEarningHistory;
use App\UserSpecialization;
use App\Specialization;
use App\QuestionAnswer;
use App\Appointment;
use App\UserFitnessGoal;
use App\FitnessGoal;
use App\TrainerImage;
use App\PassPrice;
use stdClass;
use App\Images;
use App\ClassImage;
use App\ClassType;
use App\TrainerTrainingType;
use App\TrainerDocument;
use App\TrainerTimetable;
use App\Payment;
use Stripe\Account;
use App\RefferTrainee;
use App\Notification;
use App\LastLogin;
use App\BusinessCardOrder;
use App\Coupon;
use App\UsedCoupon;
use App\Referral;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

    private $userId;
    private $user;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function userProfileView(Request $request) {
        $data['title'] = 'Ebbsey | My Profile';
        $user = Auth::User();
        $filter = $request->filter;

        if ($user->user_type == 'user') {
            $user_last_login = LastLogin::where('user_id', Auth::id())->orderBy('id', 'desc')->skip(1)->take(1)->first();
//            dd('1');
            $last_login_time = 'N/A';
            if ($user_last_login) {
                $last_login_time = $user_last_login->login_time;
                if ($user->timezone) {
                    $last_login_time = new DateTime($last_login_time, new DateTimeZone('UTC'));
                    $last_login_time->setTimezone(new DateTimeZone($user->timezone));
                    $last_login_time = $last_login_time->format('F d, Y g:i A');
                }
            }
//            $data['user_last_login'] = LastLogin::where('user_id',Auth::id())->orderBy('created_at', 'desc')->first();
            $data['user_last_login'] = $user_last_login;
            $data['last_login_time'] = $last_login_time;

            $data['user_data'] = $user;
            $data['user_sessions'] = Appointment::with('refferAppointment.getUser', 'getReferredBy')
                            ->where(['client_id' => $user->id, 'type' => 'session', 'delete_by_client' => 0])
                            ->when($filter, function($query) use($filter) {
                                if ($filter == 'accepted') {
                                    $query->where('status', 'accepted');
                                }
                                if ($filter == 'completed') {
                                    $query->where('status', 'completed');
                                }
                            })->orderBy('id', 'DESC')->get();
            $data['user_classes'] = Appointment::where(['client_id' => $user->id, 'type' => 'class', 'delete_by_client' => 0])
                            ->when($filter, function($query) use($filter) {
                                if ($filter == 'accepted') {
                                    $query->where('status', 'accepted');
                                }
                                if ($filter == 'completed') {
                                    $query->where('status', 'completed');
                                }
                            })
                            ->orderBy('id', 'DESC')->get();

            return view('user.user-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function sessionDetail($id) {
        $data['title'] = 'Ebbsey | Session Detail';
        $user = Auth::User();
        $data['user_data'] = $user;
        $data['user_sessions'] = Appointment::
                where(function($query) {
                    $query->where('trainer_id', $this->userId)
                    ->orWhere('client_id', $this->userId);
                })
                ->where(['type' => 'session'])
                ->with('refferAppointment.getUser', 'appointmentTrainer', 'appointmentClient')
                ->find($id);
        if (!$data['user_sessions']) {
            return Redirect::to(URL::previous());
        }
        return view('user.sessionhistory', $data);
    }

    function trainerProfileView() {
        $data['title'] = 'Ebbsey | My Profile';
        $user = User::with('trainerRating')->find(Auth::id());

        $total_rating = $user->trainerRating->count();
        $average_rating = 4.9;
        $data['average_rating'] = $average_rating;
        if ($total_rating) {
            $total_sum = $user->trainerRating->sum('rating');
            $average_rating = $total_sum / ($total_rating * 5) * 100;
            $data['average_rating'] = $average_rating * 5 / 100;
        }

        if ($user->user_type == 'trainer') {
            return view('user.trainer-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function classView($id) {

        $data['title'] = 'Ebbsey | Class Detail';
        $data['id'] = $id;
        $data['current_user'] = User::find(Auth::id());

        $classData = Classes::with('classTimetable', 'getImage', 'countSpot.appointmentClient', 'getBooking')->find($id);

        if (!$classData) {
            return redirect('/');
        }
        $data['classData'] = $classData;

        $isGroupTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $classData->classtTrainer->id)->get();
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Group Fitness Instructor') {
                    $isGroupTrainer = 1;
                    break;
                }
            }
        }

        $data['is_already_enrolled'] = false;
        if ($classData->getBooking) {
            $data['is_already_enrolled'] = true;
            $data['today_schedule'] = $classData->getBooking;
        } else {
            $today_day = date('l');
            $data['today_schedule'] = $classData->classTimetable->where('day', lcfirst($today_day))->first();
        }

        $data['isGroupTrainer'] = $isGroupTrainer;

        return view('user.view-class', $data);
    }

    function booking($id) {
        if (Auth::User()->user_type == 'trainer') {
            return redirect()->back();
        }
        $data['title'] = 'Ebbsey | Booking';
        $user_data = User::with('usedPass')->find(Auth::id());
        $data['used_pas'] = $user_data->usedPass->sum('number_of_passes');

        $data['user'] = $user_data;
        $data['pass_price'] = PassPrice::first();
        $classData = Classes::with('classtTrainer', 'classTimetable')->find($id);
        $data['classData'] = $classData;

        $reserver_pass = Appointment::where(['client_id' => Auth::id(),
                    'type' => 'session', 'delete_by_client' => 0, 'status' => 'pending'])->sum('number_of_passes');
        $remaining = 0;
        if ($user_data->passes_count > 0) {
            $remaining = $user_data->passes_count;
            if ($reserver_pass > 0) {
                $remaining = ($user_data->passes_count - $reserver_pass);
            }
        }
        if ($remaining < 0) {
            $remaining = 0;
        }
        $data['remaining_pass'] = $remaining;
        return view('user.booking', $data);
    }

    function appointments(Request $request) {
        $data['title'] = 'Ebbsey | Appointments';
        $search = $request->search;
        $filter = $request->filter;

        $current_user = User::find(Auth::id());
        $data['current_user'] = $current_user;

        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
        $cu_latitude = isset($location->latitude) ? $location->latitude : '';
        $cu_longitude = isset($location->longitude) ? $location->longitude : '';
        if ($cu_latitude && $cu_longitude) {
            $data['current_address'] = getAddress($cu_latitude, $cu_longitude);
        }
        $data['cu_latitude'] = $cu_latitude;
        $data['cu_longitude'] = $cu_longitude;

        if ($this->user->user_type != 'trainer') {
            return redirect()->back();
        }

        $pending_appointments = Appointment::with('appointmentClient.userFitness.goal', 'classAppointment', 'refferAppointment.getUser')
                        ->where('trainer_id', Auth::id())
                        ->where('status', '=', 'pending')
                        ->where('type', 'session')
                        ->when($search, function ($query) use($search) {
                            $query->whereHas('appointmentClient', function($query) use($search) {
                                $query->where('first_name', 'like', "%$search%")
                                ->orwhere('last_name', 'like', "%$search%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$search%' ");
                            });
                        })
                        ->where('delete_by_tranee', 0)
                        ->orderBy('created_at', 'DESC')->get();

        $appointments = Appointment::with('appointmentClient.userFitness.goal', 'classAppointment', 'refferAppointment.getUser')
                        ->where('trainer_id', Auth::id())
                        ->where('status', '!=', 'referred')
                        ->where('type', 'session')
                        ->when($filter, function($query) use($filter) {
                            if ($filter == 'accepted') {
                                $query->where('status', 'accepted');
                            }
                            if ($filter == 'completed') {
                                $query->where('status', 'completed');
                            }
                        })
                        ->when($search, function ($query) use($search) {
                            $query->whereHas('appointmentClient', function($query) use($search) {
                                $query->where('first_name', 'like', "%$search%")
                                ->orwhere('last_name', 'like', "%$search%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$search%' ");
                            });
                        })->where('delete_by_tranee', 0)
                        ->orderBy('created_at', 'DESC')->paginate(10);
        Appointment::where('trainer_id', Auth::id())->where('type', 'session')->update(['is_seen_by_trainer' => 1]);


        $data['tainee'] = '';
        $spec_list = UserSpecialization::whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 1);
                })->where('user_id', Auth::id())->pluck('specialization_id')->toArray();

        if ($spec_list) {
            $ids = implode(",", $spec_list);
            $total_exp = count($spec_list);

//            $exp_user_ids = \DB::select('SELECT user_id FROM user_specializations WHERE specialization_id IN (' . $ids . ') GROUP BY user_id HAVING (count(*)=' . $total_exp . ')');
            $exp_user_ids = \DB::select('SELECT user_id FROM user_specializations WHERE specialization_id IN (' . $ids . ') GROUP BY user_id');
            $users_ids = array();
            if ($exp_user_ids) {
                foreach ($exp_user_ids as $ids) {
                    $users_ids[] = $ids->user_id;
                }
                $data['tainee'] = User::whereIn('id', $users_ids)->where(function($u) use ($current_user) {

                            $u->where('country', $current_user->country);
                            $u->where('city', $current_user->city);
                            $u->where('state', $current_user->state);
                        })->where('id', '!=', Auth::id())->get();
            }
        }


        $data['pending_appointments'] = $pending_appointments;
        $data['result'] = $appointments;

        return view('user.appointments', $data);
    }

    function searchTrannerAjax(Request $request) {
        $search = $request->search;
        $appoint_id = $request->appoint_id;
        $appointment = Appointment::find($appoint_id);


//        $tainee = User::where('user_type', 'trainer')
//                ->where('id', '!=', Auth::id())
//                ->where(function($query) use($search) {
//                    $query->where('first_name', 'LIKE', '%' . $search . '%');
//                    $query->orwhere('last_name', 'LIKE', '%' . $search . '%');
//                })->get();
        $spec_list = UserSpecialization::whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 1);
                })->where('user_id', Auth::id())->pluck('specialization_id')->toArray();
        $tainee = array();
        if ($spec_list) {
            $ids = implode(",", $spec_list);
            $total_exp = count($spec_list);

            $exp_user_ids = \DB::select('SELECT user_id FROM user_specializations WHERE specialization_id IN (' . $ids . ') GROUP BY user_id HAVING (count(*)=' . $total_exp . ')');
            $users_ids = array();
            if ($exp_user_ids) {
                foreach ($exp_user_ids as $ids) {
                    $users_ids[] = $ids->user_id;
                }
                $tainee = User::whereIn('id', $users_ids)
                                ->where('id', '!=', Auth::id())
                                ->where(function($query) use($search) {
                                    $query->where('first_name', 'LIKE', '%' . $search . '%');
                                    $query->orwhere('last_name', 'LIKE', '%' . $search . '%');
                                })->get();
            }
        }

        $html = '';
        if ($tainee && count($tainee) > 0) {
            foreach ($tainee as $traine) {
                if ($traine->image) {
                    $imag_url = asset('public/images/' . $traine->image);
                } else {
                    $imag_url = asset('public/images/users/default.jpg');
                }

                $html .= '<li class="d-flex align-items-center">
                                            <div class="profile_info d-flex align-items-center">
                                                <div class="image">
                                                    <div class="img" style="background-image: url(' . $imag_url . ');"></div>
                                                </div>
                                                <div class="info">
                                                    <div class="name">' . $traine->first_name . ' ' . $traine->last_name . '</div>
                                                    <div class="type">Age ' . date_diff(date_create($traine->dob), date_create('today'))->y . ' years
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-auto"> 
                                                <a href="javascript:void(0)" data-appointment-id="' . $appoint_id . '" data-client-id="' . $appointment->appointmentClient->id . '" data-client-lat="' . $appointment->client_lat . '" data-client-lng="' . $appointment->client_lng . '" data-trainee-id="' . $traine->id . '" class="btn_message refer_to">Refer</a>                                                 
                                            </div>
                                        </li>';
            }
        } else {
            $html .= '<li class="align-items-center d-flex justify-content-center">
                                    <p class="text-center">No record found</p>
                                </li>';
        }

        echo json_encode(array('success' => 1, 'result' => $html));
    }

    function refferTo(Request $request) {

        $refer = new RefferTrainee();
        $refer->appointment_id = $request->appointment_id;
        $refer->trainee_id = $request->trainee_id;
        $refer->save();

        $referred_traner = User::find($request->trainee_id);
        $reffer_name = $referred_traner->first_name . ' ' . $referred_traner->last_name;
        $reffered_profile = url('trainer-public-profile/' . $referred_traner->id);

        $appointment = Appointment::with('appointmentClient', 'appointmentTrainer')->find($request->appointment_id);
        $appointment->trainer_id = $request->trainee_id;
        $appointment->owner_id = Auth::id();
        $appointment->trainer_location = $referred_traner->address;
        $appointment->trainer_lat = $referred_traner->lat;
        $appointment->trainer_lng = $referred_traner->lng;
        $distance = distance($appointment->trainer_lat, $appointment->trainer_lng, $appointment->client_lat, $appointment->client_lng);
        if ($distance['status'] == 'OK') {
            $appointment->distance = $distance['distance'];
            $appointment->travelling_time = $distance['duration'];
        }
        $appointment->is_referral_enabled = 0;
        $appointment->is_seen_by_trainer = 0;
        $appointment->is_seen_by_client = 0;
        $appointment->is_reminder_sent = 0;
        if ($appointment->status == 'accepted') {
            $appointment->referred_by = Auth::id();
        }
        $appointment->status = 'pending';
        $client_id = $appointment->client_id;

        $start_time_utc = strtotime($appointment->start_date);
        $current_time_utc = strtotime(date('Y-m-d H:i:s'));

        $interval = $start_time_utc - $current_time_utc;
        $interval = $interval / 60;
        if ($interval <= 0) {
            $appointment->is_referred_after_allowed_time = 1;
        }
        if ($interval <= 1440) {
            $appointment->is_referred_after_allowed_time = 1;
        }
        $appointment->save();

        $client_email = $appointment->appointmentClient->email;
        $client_name = $appointment->appointmentClient->first_name . ' ' . $appointment->appointmentClient->last_name;
        $tranier_name = $appointment->appointmentTrainer->first_name . ' ' . $appointment->appointmentTrainer->last_name;

        $session_date = date('M d, Y', strtotime($appointment->start_date));
        $session_time = $appointment->start_time;
        $location = $appointment->client_location;

        $viewData['title'] = 'Appointment Referral';
        $viewData['mr'] = 'Hi';
        $viewData['username'] = $appointment->appointmentClient->first_name;
//        $viewData['para_one'] = $tranier_name.' has referred your session to another trainer. Please login to view your new trainer.';
        $viewData['para_one'] = 'Due to unforeseeable circumstance, your trainer ' . $tranier_name . ' cannot make it to the session for ' . $session_date . ' ' . $session_time . ' at ' . $location . '. However, ' . $tranier_name . ' has referral you to another trainer that shares the same fitness discipline.';
        $viewData['para_two'] = 'Your new trainer for  ' . $session_date . ' ' . $session_time . ' at ' . $location . ' is ' . $reffer_name;
        $viewData['para_three'] = 'Checkout  <a href="' . $reffered_profile . '" target="_blank">' . $reffer_name . '</a>';

        Mail::send('email.confirmation', $viewData, function ($m) use ($client_email) {
            $m->from(env('FROM_EMAIL', 'Appointment Referral'), 'Ebbsey');
            $m->to($client_email)->subject('Appointment Referral');
        });

        $trainer = User::find($appointment->owner_id);
        $client = User::find($appointment->client_id);
        if ($client->phone) {
            $phone = $client->phone;
            $message_body = "Ebbsey Appointment\nHi " . $client->first_name . ", your session for " . date('F d, Y', strtotime($appointment->date)) . ", " . $appointment->start_time . " at " . $appointment->client_location . ". was referred to another trainer by " . $trainer->first_name . ". Please login to view your new trainer.";
            sendSms($phone, $message_body);
        }

        $referred_trainer = User::find($appointment->trainer_id);
        if ($referred_trainer->phone) {
            $phone = $referred_trainer->phone;
            $message_body = "Ebbsey Appointment\nHi " . $referred_trainer->first_name . ", " . $trainer->first_name . " has referred you for a session for " . date('F d, Y', strtotime($appointment->date)) . ", " . $appointment->start_time . " at " . $appointment->client_location . ". Please, login to confirm this appointment.";
            sendSms($phone, $message_body);
        }

        echo json_encode(array('success' => 1, 'message' => 'Request reffered successfully', 'text' => ' referred you to another trainer'));
    }

    function calcuteDistanceAjax(Request $request) {
        $data = distance($request->curr_lat, $request->curr_lng, $request->client_lat, $request->client_lng);
        $calute_distance = number_format($data['distance'], 2, '.', '');
        $duration = number_format($data['duration'], 2, '.', '');
        return json_encode(array('success' => 1, 'distance' => $calute_distance, 'duration' => $duration));
    }

    function bookingSession($id) {
        if (Auth::User()->user_type == 'trainer') {
            return redirect()->back()->with('error', 'Only Trainee can book sesstion');
        }
        $data['title'] = 'Ebbsey | Booking';

        $user_data = User::with('trainerTimeTable')->find($id);

        $isPersonalTrainer = 0;
        $isGroupTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $user_data->id)->get();
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Certified Personal Trainer') {
                    $isPersonalTrainer = 1;
                }
                if ($trainerTrainingType->trainingTypes->title == 'Group Fitness Instructor') {
                    $isGroupTrainer = 1;
                }
            }
        }
        $data['isPersonalTrainer'] = $isPersonalTrainer;
        $data['isGroupTrainer'] = $isGroupTrainer;

        $current_user = User::with('usedPass')->find(Auth::id());

        $data['total_pass'] = $current_user->passes_count;
        $data['used_pas'] = $current_user->usedPass->sum('number_of_passes');
        $data['current_user'] = $current_user;

        $data['user'] = $user_data;
        $classData = Classes::with('classTimetable')->find($id);
        $data['pass_price'] = PassPrice::first();

        $data['current_location'] = $this->user->address;
        $data['current_lat'] = $this->user->lat;
        $data['current_lng'] = $this->user->lng;

        $curr_user = User::find(Auth::id());
        return view('user.session_booking', $data);
    }

    function confirmAppointment(Request $request) {
        $id = $request->id;
        $app = Appointment::with('appointmentTrainer')->find($id);

        $client = User::find($app->client_id);
        $trainer = User::find($app->trainer_id);
        $tranner_name = $app->appointmentTrainer->first_name . ' ' . $app->appointmentTrainer->last_name;
        $client_name = $client->first_name . ' ' . $client->last_name;
        $email = $app->appointmentClient->email;

//        if ($client->passes_count < $app->number_of_passes) {
//            $app->status = 'canceled';
//            $app->save();
//            echo json_encode(array('error' => ' appointment is canceled because client\'s passes are less than required passes'));
//            return;
//        }

        $client_id = $app->client_id;
        $start_date = $app->start_date;
        $end_date = $app->end_date;
        $date = $app->date;

        $app->trainer_location = $app->appointmentTrainer->address;
        $app->trainer_lat = $app->appointmentTrainer->lat;
        $app->trainer_lng = $app->appointmentTrainer->lng;
        $app->distance = ($request->trainee_distance) ? $request->trainee_distance : '00';
        $app->travelling_time = $request->travelling_time;
        $app->referred_by = '';
        $app->status = 'accepted';
        $app->save();

        $total_sum_of_referral_passes = Referral::where('user_id', $client->id)->sum('passes_count');

        $checkReferral = Referral::where('passes_count', '>', 0)
                        ->where(['user_id' => $client->id, 'trainer_id' => $trainer->id])->first();

        if ($checkReferral) {

            if ($checkReferral->passes_count >= $app->number_of_passes) {
                $checkReferral->passes_count = $checkReferral->passes_count - $app->number_of_passes;
            } else {
                $checkReferral->passes_count = 0;
            }
            $checkReferral->save();
            $app->is_referral_enabled = 1;
            $app->save();
        } else if ($total_sum_of_referral_passes > $client->passes_count) {

            $passes_to_be_deducted = $total_sum_of_referral_passes - $client->passes_count;

            $allReferrals = Referral::where('passes_count', '>', 0)->where('user_id', $client->id)->get();
            foreach ($allReferrals as $referral) {
                if ($referral->passes_count >= $passes_to_be_deducted) {
                    $referral->passes_count = $referral->passes_count - $passes_to_be_deducted;
                    $referral->save();
                    $passes_to_be_deducted = 0;
                } else {
                    $passes_to_be_deducted = $passes_to_be_deducted - $referral->passes_count;
                    $referral->passes_count = $referral->passes_count - $passes_to_be_deducted;
                    $referral->save();
                }

                if ($passes_to_be_deducted == 0) {
                    break;
                }
            }
        }
        $trainer = User::find($app->trainer_id);

        //Session Confirmation Email to Client
        $trainer_full_name = $trainer->first_name . ' ' . $trainer->last_name;
        $emailData['title'] = 'Appointment Confirmation';
        $emailData['mr'] = 'Hi';
        $emailData['username'] = $client->first_name;
//        $emailData['para_one'] = $trainer_full_name.' has confirmed your appointment with you.';
        $emailData['para_one'] = 'Your appointment has been scheduled.';
        $emailData['para_two'] = 'This email confirms your appointment. If you have questions before your appointment, contact ' . $tranner_name . ' on your message dashboard here <a href="' . url('messages') . '" target="_blank">' . url('messages') . '</a>.';
        $emailData['para_three'] = 'To cancel your appointment before the 24-hour period, please go to your dashboard on Appointments <a href="' . url('user-profile') . '">' . url('user-profile') . '</a>';

        Mail::send('email.confirmation', $emailData, function ($m) use ($email) {
            $m->from(env('FROM_EMAIL', 'Appointment Confirmation'), 'Ebbsey');
            $m->to($email)->subject('Appointment Confirmation');
        });

        $trainer = User::find($app->trainer_id);
        $client = User::find($app->client_id);
        if ($client->phone) {
            $phone = $client->phone;
            $message_body = "Ebbsey Appointment\nHi " . $client->first_name . ", you’re all set! " . $trainer->first_name . " has confirmed your appointment with you for " . date('F d, Y', strtotime($app->date)) . ", " . $app->start_time . " at " . $app->client_location;
            sendSms($phone, $message_body);
        }


        //Send welcome email to tranee and client on his/her first appointment
        //Not need this Now
        // $this->welcomeOnFirstAppointment($client_id);

        $format = 'Y-m-d\TH:i:sP';
        $startdate = new DateTime($app->start_date);
        $startdate = $startdate->format($format);
        $enddate = new DateTime($app->end_date);
        $enddate = $enddate->format($format);

        if (isset($client->google_access_token)) {
            $timezone = 'UTC';
            if ($client->timezone) {
                $timezone = $client->timezone;
            }
            $googleClient = new Google_Client();
            $googleClient->setAuthConfig('client_secret.json');
            $googleClient->setAccessType("offline");
            $googleClient->setApprovalPrompt("force");
            $googleClient->setIncludeGrantedScopes(true);   // incremental auth
            $googleClient->addScope(Google_Service_Calendar::CALENDAR);

            $access_token_old = [
                "access_token" => $client->google_access_token,
                "token_type" => $client->google_token_type,
                "expires_in" => $client->google_token_expires_in,
                "refresh_token" => $client->google_refresh_token,
                "created" => $client->google_token_created
            ];

            $googleClient->setAccessToken($access_token_old);
            if ($googleClient->isAccessTokenExpired()) {
                $access_token = $googleClient->fetchAccessTokenWithRefreshToken($googleClient->getRefreshToken());
                $client->google_access_token = $access_token['access_token'];
                $client->google_refresh_token = $access_token['refresh_token'];
                $client->google_token_type = $access_token['token_type'];
                $client->google_token_expires_in = $access_token['expires_in'];
                $client->google_token_created = $access_token['created'];
                $client->save();
            }

            $service = new Google_Service_Calendar($googleClient);
            $event = new Google_Service_Calendar_Event(array(
                'summary' => "Session",
                'description' => '',
                'start' => array(
                    'dateTime' => $startdate,
                    'timeZone' => $timezone,
                ),
                'end' => array(
                    'dateTime' => $enddate,
                    'timeZone' => $timezone,
                ),
            ));
            $calendarId = 'primary';
            $service->events->insert($calendarId, $event);
        }



        if (isset($trainer->google_access_token)) {
            $timezone = 'UTC';
            if ($trainer->timezone) {
                $timezone = $trainer->timezone;
            }
            $googleClient = new Google_Client();
            $googleClient->setAuthConfig('client_secret.json');
            $googleClient->setAccessType("offline");
            $googleClient->setApprovalPrompt("force");
            $googleClient->setIncludeGrantedScopes(true);   // incremental auth
            $googleClient->addScope(Google_Service_Calendar::CALENDAR);

            $access_token_old = [
                "access_token" => $trainer->google_access_token,
                "token_type" => $trainer->google_token_type,
                "expires_in" => $trainer->google_token_expires_in,
                "refresh_token" => $trainer->google_refresh_token,
                "created" => $trainer->google_token_created
            ];

            $googleClient->setAccessToken($access_token_old);
            if ($googleClient->isAccessTokenExpired()) {
                $access_token = $googleClient->fetchAccessTokenWithRefreshToken($googleClient->getRefreshToken());
                $trainer->google_access_token = $access_token['access_token'];
                $trainer->google_refresh_token = $access_token['refresh_token'];
                $trainer->google_token_type = $access_token['token_type'];
                $trainer->google_token_expires_in = $access_token['expires_in'];
                $trainer->google_token_created = $access_token['created'];
                $trainer->save();
            }
            $service = new Google_Service_Calendar($googleClient);
            $event = new Google_Service_Calendar_Event(array(
                'summary' => "Session",
                'description' => '',
                'start' => array(
                    'dateTime' => $startdate,
                    'timeZone' => $timezone,
                ),
                'end' => array(
                    'dateTime' => $enddate,
                    'timeZone' => $timezone,
                ),
            ));
            $calendarId = 'primary';
            $service->events->insert($calendarId, $event);
        }

        $same_appoint = Appointment::where(['start_date' => $start_date, 'end_date' => $end_date, 'date' => $date, 'status' => 'pending'])
                        ->where('id', '!=', $id)->get();

        if ($same_appoint) {
            foreach ($same_appoint as $value) {

                $find_app = Appointment::with('appointmentClient')->find($value->id);
                $email = $find_app->appointmentClient->email;
                $trainer_name = $find_app->appointmentTrainer->first_name . ' ' . $find_app->appointmentTrainer->last_name;
                $username = $find_app->appointmentClient->first_name . ' ' . $find_app->appointmentClient->last_name;

                $find_app->status = 'canceled';
                $find_app->save();

                $url = url('search?search_type=trainer');

                $viewData['username'] = $find_app->appointmentClient->first_name;
                $viewData['mr'] = 'Dear';
                $viewData['title'] = 'Appointment Cancellation';
//                $viewData['para_one'] = 'Oh no! '.$trainer_full_name.', has cancelled your session. Please login to schedule another appointment';
                $viewData['para_one'] = 'Your appointment has been cancelled.';
                $viewData['para_two'] = 'This is to confirm your recent cancellation of your appointment.'
                        . ' We thank you for informing us and hope to welcome you to your next session with ' . $trainer_name . ' or one of the other trainers. <a href=' . $url . '>' . $url . '</a></p>';

                Mail::send('email.confirmation', $viewData, function ($m) use ($email) {
                    $m->from(env('FROM_EMAIL', 'Appointment Cancellation'), 'Ebbsey');
                    $m->to($email)->subject('Appointment Cancellation');
                });
            }
        }
        echo json_encode(array('success' => 1, 'message' => 'Confirmed successfully', 'text' => ' accepted your session request'));
    }

    function cancelInDueTime(Request $request) {
        $id = $request->id;
        $type = $request->type;

        $appoint = Appointment::find($id);
        $trainer_id = $appoint->trainer_id;
        $client_id = $appoint->client_id;
        $appoint->status = 'canceled';
        $appoint->save();

        $client = User::find($client_id);
        $trainer = User::find($trainer_id);
        $tranner_full_name = $trainer->first_name;
        $tranner_email = $trainer->email;
//        $amount = 35 * 0.8;
        $amount = 35;
        $amount = round($amount, 2);
//        $trainer->total_cash = $trainer->total_cash + ($appoint->number_of_passes * 35);
        $trainer->total_cash = $trainer->total_cash + $amount;
        $trainer->save();

        savePaymentHistory($appoint->client_id, $appoint->trainer_id, $appoint->class_id, $appoint->id, $amount, $appoint->number_of_passes, 'user');

        //Send notificaiton Email to tranner
        $summeryData['username'] = $trainer->first_name;
        $summeryData['title'] = 'Appointment Cancellation';
        $summeryData['para_one'] = 'My apologies, ' . $client->first_name . ' has canceled your session for ' . date('F d, Y', strtotime($appoint->date)) . ', ' . $appoint->start_time . ' at ' . $appoint->client_location . '. Please login to view details.';
        Mail::send('email.confirmation', $summeryData, function ($m) use ($tranner_email) {
            $m->from(env('FROM_EMAIL', 'Appointment Cancellation'), 'Ebbsey');
            $m->to($tranner_email)->subject('Appointment Cancellation');
        });

        if ($trainer->phone) {
            $phone = $trainer->phone;
            $message_body = "Ebbsey Appointment\nMy apologies, " . $client->first_name . ", has canceled your session for " . date('F d, Y', strtotime($appoint->date)) . ', ' . $appoint->start_time . ' at ' . $appoint->client_location . '. Please login to view details';
            sendSms($phone, $message_body);
        }

        echo json_encode(array('success' => 1, 'message' => 'Appointment Cancelled successfully.', 'text' => ' canceled the session appointment'));
    }

    function cancelBeforeTime(Request $request) {
        $id = $request->id;
        $type = $request->type;
        $appoint = Appointment::find($id);
        $client_id = $appoint->client_id;

        $appoint->status = 'canceled';
        $appoint->save();
        $trainer = User::find($appoint->trainer_id);
        $tranner_email = $trainer->email;
        $client = User::find($client_id);

        $c_first_name = $client->first_name;
        $client->passes_count = ($client->passes_count + $appoint->number_of_passes);
        $client->save();
        //Send notificaiton Email to tranner
        $summeryData['username'] = $trainer->first_name;
        $summeryData['title'] = 'Appointment Cancellation';
        $summeryData['para_one'] = 'My apologies, ' . $c_first_name . ' has canceled your session for ' . date('F d, Y', strtotime($appoint->date)) . ', ' . $appoint->start_time . ' at ' . $appoint->client_location . '. Please login to view details.';
        Mail::send('email.confirmation', $summeryData, function ($m) use ($tranner_email) {
            $m->from(env('FROM_EMAIL', 'Appointment Cancellation'), 'Ebbsey');
            $m->to($tranner_email)->subject('Appointment Cancellation');
        });

        if ($trainer->phone) {
            $phone = $trainer->phone;
            $message_body = "Ebbsey Appointment\nMy apologies, " . $c_first_name . ", has canceled your session for " . date('F d, Y', strtotime($appoint->date)) . ', ' . $appoint->start_time . ' at ' . $appoint->client_location . '. Please login to reschedule another appointment.';
            sendSms($phone, $message_body);
        }
        echo json_encode(array('success' => 1, 'message' => 'Appointment Cancelled successfully.', 'text' => ' canceled the session appointment'));
    }

    function cancelAppointmentClass(Request $request) {
        $id = $request->id;
        $type = $request->type;
        $appoint = Appointment::find($id);
        $appoint->status = 'canceled';
        $appoint->save();

        $trainer = User::find($appoint->trainer_id);
//        $amount = 35 * 0.8;
        $amount = 35;
        $amount = round($amount, 2);
//        $trainer->total_cash = $trainer->total_cash + ($appoint->number_of_passes * 35);
        $trainer->total_cash = $trainer->total_cash + $amount;
        $trainer->save();

        echo json_encode(array('success' => 1, 'message' => 'Class Cancelled successfully.'));
    }

    function responseAppointment(Request $request) {
        $id = $request->id;
        $type = $request->type;
        $respond_by = ($request->respond_by) ? $request->respond_by : ''; //traner
        $message = '';
        $app = Appointment::with('appointmentTrainer', 'appointmentClient')->find($id);
        $f_name = $app->appointmentClient->first_name;
        $client_name = $app->appointmentClient->first_name . ' ' . $app->appointmentClient->last_name;
        $client_email = $app->appointmentClient->email;
        $trainer_name = $app->appointmentTrainer->first_name;

        $viewData['start_time'] = $app->start_time;
        $viewData['end_time'] = $app->end_time;
        $viewData['number_of_passes'] = $app->number_of_passes;
        $viewData['location'] = $app->client_location;

        $email = $app->appointmentClient->email;
        $trainer_full_name = $app->appointmentTrainer->first_name . ' ' . $app->appointmentTrainer->last_name;

        if ($type == 'del') {
            if ($request->delete_by == 'client') {
                $app->delete_by_client = 1;
            } else {
                $app->delete_by_tranee = 1;
            }
            $app->save();
            $message = 'Record deleted successfully';
            return json_encode(array('success' => 1, 'message' => $message));
        }

        if ($type == 'cancel') {

            $app->status = 'canceled';
            if (isset($respond_by) && $respond_by == 'tranee') {
                $app->cancel_by = 'tranee';
            } else {
                $app->cancel_by = 'client';
            }
            $app->save();
            $message = ' You have canceled your session successfully ! ';
            $notificationText = ' canceled your session appointment';

            if (isset($respond_by) && $respond_by == 'tranee') {

                //return pass to user
                $client_id = $app->appointmentClient->id;
                $trainer_id = $app->appointmentTrainer->id;
                $used_passes = $app->number_of_passes;

//                $startTime = strtotime($app->start_date);
//                $oneDayBefore = $startTime - (86400);
//                if (strtotime(date("Y-m-d H:i:s")) >= $oneDayBefore) {
                $trainer_user = User::find($trainer_id);
//                $trainer_user->total_cash = $trainer_user->total_cash - (35 * $app->number_of_passes);
                $trainer_user->total_cash = $trainer_user->total_cash - round(35, 2);
                $trainer_user->save();
//                }
                savePaymentHistory($app->client_id, $app->trainer_id, $app->class_id, $app->id, ((-1) * 35), $app->number_of_passes, 'trainer');

                $client_user = User::find($client_id);
                $total_pass = intval($client_user->passes_count) + intval($used_passes);

                $client_user->passes_count = $total_pass;
                $client_user->save();

                $viewData['username'] = $f_name;
                $viewData['mr'] = 'Dear';
                $viewData['title'] = 'Appointment Cancellation';
//                $viewData['para_one'] = 'Oh no! ' . $trainer_full_name . ', has cancelled your session. Please login to schedule another appointment';
                $url = url('search?search_type=trainer');
                $viewData['para_one'] = 'Your appointment has been cancelled.';
                $viewData['para_two'] = 'This is to confirm your recent cancellation of your appointment.'
                        . ' We thank you for informing us and hope to welcome you to your next session with ' . $trainer_user->first_name . ' or one of the other trainers. <a href=' . $url . '>' . $url . '</a></p>';

                Mail::send('email.confirmation', $viewData, function ($m) use ($email) {
                    $m->from(env('FROM_EMAIL', 'Appointment Cancellation'), 'Ebbsey');
                    $m->to($email)->subject('Appointment Cancellation');
                });
                /*
                 * warning email to tranner
                 * Hold this warnings email for the time being
                 * $this->warningEmailToTranee();
                 * 
                 */
                if ($client_user->phone) {
                    $phone = $client_user->phone;
                    $message_body = "Ebbsey Appointment\nMy apologies, " . $trainer_user->first_name . " has canceled your session for " . date('F d, Y', strtotime($app->date)) . ', ' . $app->start_time . ' at ' . $app->client_location . ". Please login to reschedule another appointment.";
                    sendSms($phone, $message_body);
                }
            }
        } else if ($type == 'discard') {
//            if($app->referred_by && $app->is_referred_after_allowed_time){
            if ($app->referred_by) {
                $trainer = User::find($app->referred_by);
//                $trainer->total_cash = $trainer->total_cash - (35 * $app->number_of_passes);
                $trainer->total_cash = $trainer->total_cash - round(35, 2);
                $trainer->save();
                $app->referred_by = '';
//                $app->is_referred_after_allowed_time = 0;
            }
            $app->status = 'rejected';
            $app->save();
            $client = User::find($app->client_id);
            $client->passes_count = $client->passes_count + $app->number_of_passes;
            $client->save();
            $message = 'Request discarted successfully';
            $notificationText = ' rejected your request for session booking';
        } else if ($type == 'accept') {

            $app->status = 'accepted';
            $app->save();
            $message = 'Request accepted successfully';
            $notificationText = ' accepted your request for session booking';
            $client_id = $app->appointmentClient->id;
            $client_user = User::find($client_id);
            $trainer_id = $app->appointmentTrainer->id;
            $trainer_user = User::find($trainer_id);
            if ($client_user->phone) {
                $phone = $client_user->phone;
                $message_body = "Ebbsey Appointment\nHi " . $client_user->first_name . ", you’re all set! " . $trainer_user->first_name . " has confirmed your appointment with you for " . date('F d, Y', strtotime($app->date)) . ", " . $app->start_time . " at " . $app->client_location;
                sendSms($phone, $message_body);
            }
        }
        echo json_encode(array('success' => 1, 'message' => $message, 'text' => $notificationText));
    }

    function warningEmailToTranee() {
        //Warning email to tranee
        $cancell_session = Appointment::with('appointmentTrainer')->where(['trainer_id' => Auth::id(),
                    'status' => 'canceled', 'type' => 'session',
                    'cancel_by' => 'tranee'])->get();

        $user = User::find(Auth::id());
        $email = $user->email;

        if ($cancell_session && $cancell_session->count() == 1) {
            $app_detail = $cancell_session->toArray();

            $viewData['username'] = $user->first_name;
            $viewData['cancell_date'] = isset($app_detail[0]['date']) ? $app_detail[0]['date'] : '';
            Mail::send('email.first_warning', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'First Warning'), 'Ebbsey');
                $m->to($email)->subject('First Warning');
            });
        } else if ($cancell_session && $cancell_session->count() == 2) {
            $app_detail = $cancell_session->toArray();
            $viewData['cancell_date'] = isset($app_detail[1]['date']) ? $app_detail[1]['date'] : '';

            $viewData['username'] = $user->first_name;
            Mail::send('email.second_warning', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Second Warning'), 'Ebbsey');
                $m->to($email)->subject('Second Warning');
            });
        } else if ($cancell_session && $cancell_session->count() > 2) {
            $app_detail = $cancell_session->toArray();


            $current_user = User::find(Auth::id());
            $username = $current_user->first_name;
            $current_time = Carbon::now();
            $current_user->block_time = $current_time;
            $current_user->is_approved_by_admin = 2;
            $current_user->save();
            $cancelled_date = '';

            $viewData['first_date'] = isset($app_detail[0]['date']) ? $app_detail[0]['date'] : '';
            $viewData['second_date'] = isset($app_detail[1]['date']) ? $app_detail[1]['date'] : '';
            $viewData['third_date'] = isset($app_detail[2]['date']) ? $app_detail[2]['date'] : '';

            $viewData['username'] = $username;
            Mail::send('email.third_warning', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Final Warning'), 'Ebbsey');
                $m->to($email)->subject('Final Warning');
            });

            //Account suspended email 
            $viewData['username'] = $username;
            $viewData['mr'] = 'Hi';
            $viewData['title'] = 'Account Suspension';
            $viewData['para_one'] = 'Please know your account has been suspended for thirty days and we also have taken steps to remove personal data from your suspended account so that it is no longer visible on the platform or in searches.';
            $viewData['para_one'] = 'I hope this information is helpful. Should you have any question or need further assistance, please email us at <a href="mailto:support@ebbsey.com">support@ebbsey.com</a>. Your account will automatically be reinstated in thirty days.';

            Mail::send('email.confirmation', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Account suspension'), 'Ebbsey');
                $m->to($email)->subject('Account suspension');
            });

            //LogOut After Block User
            Auth::guard('user')->logout();
        }
    }

    function createBooking(Request $request) {
        $validator = Validator::make($request->all(), [
                    'pick_date' => 'required',
                    'pick_time' => 'required',
                    'no_of_pass' => 'required'
                        ], [
                    'pick_date' => 'Date is required',
                    'pick_time' => 'Time is required',
                    'no_of_pass' => 'Passed is required'
        ]);
        if ($validator->fails()) {
            $errors = implode($validator->errors()->all(), '<br>');
            return json_encode(array('success' => 0, 'message' => $errors));
        }

        $appoint = new Appointment();
        $appoint->client_id = Auth::id();
        $appoint->trainer_id = $request->trainee_id;
        $appoint->class_id = $request->class_id;
        $appoint->type = 'class';
        $appoint->date = $request->pick_date;

        $class = Classes::find($request->class_id);

        $time_slot = $request->pick_time;

        $appoint->start_time = $time_slot;
        $dynamic_end_time = strtotime($time_slot) + (($class->duration) * 60);
        $dynamic_end_time = date('g:i A', $dynamic_end_time);
        $appoint->end_time = $dynamic_end_time;


        $timezone = new DateTimeZone('UTC');
        $start_date = trim($request->pick_date) . ' ' . trim($time_slot);
        $end_date = trim($request->pick_date) . ' ' . trim($dynamic_end_time);

        $start_date = new DateTime($start_date, new DateTimeZone($request['user_timezone']));
        $start_date->setTimeZone(new DateTimeZone('UTC'));
        $start_date = $start_date->format('Y-m-d H:i:s');

        $end_date = new DateTime($end_date, new DateTimeZone($request['user_timezone']));
        $end_date->setTimeZone(new DateTimeZone('UTC'));
        $end_date = $end_date->format('Y-m-d H:i:s');

        $appoint->start_date = $start_date;
        $appoint->end_date = $end_date;

        $appoint->status = 'accepted';
        $appoint->number_of_passes = $request->no_of_pass;
        $appoint->delete_by_client = 0;
        $appoint->delete_by_tranee = 0;

        $checkSession = Appointment::where(['type' => 'session', 'trainer_id' => $request->trainee_id, 'status' => 'accepted',
                    'start_date' => $start_date, 'end_date' => $end_date])->first();
        if ($checkSession) {
            return json_encode(array('success' => 0, 'message' => 'Trainer already has an appointment at this time.'));
        }
        Appointment::where(['type' => 'session', 'trainer_id' => $request->trainee_id, 'status' => 'pending',
            'start_date' => $start_date, 'end_date' => $end_date])->update(['status' => 'canceled']);
        $appoint->save();

        $client = User::find($appoint->client_id);
        $client->passes_count = $client->passes_count - $appoint->number_of_passes;
        $client->save();

        $trainer = User::find($request->trainee_id);

        $client_user = User::find(Auth::id());

        $booked_app = Appointment::find($appoint->id);
        $viewData['title'] = 'Class Booking Detail';
        $viewData['full_name'] = $client_user->first_name;
        $viewData['class_data'] = $class;
        $viewData['detail'] = $booked_app;
        $client_email = $client_user->email;
        Mail::send('email.booking_confirmation', $viewData, function ($m) use ($client_email) {
            $m->from(env('FROM_EMAIL', 'Class Booking'), 'Ebbsey');
            $m->to($client_email)->subject('Class Booking');
        });

        //Send email to trainer 
        $trainee_full_name = $trainer->first_name;
        $client_full_name = $client_user->first_name;
        $viewData['title'] = 'Class Booking Detail';
        $viewData['username'] = $trainer->first_name;
        $viewData['para_one'] = 'Congratulations ' . $trainee_full_name . ', ' . $client_full_name . ' has booked a session with you.';
        $traner_email = $trainer->email;
        Mail::send('email.confirmation', $viewData, function ($m) use ($traner_email) {
            $m->from(env('FROM_EMAIL', 'Class Booking'), 'Ebbsey');
            $m->to($traner_email)->subject('Class Booking');
        });

        if ($trainer->phone) {
            $phone = $trainer->phone;
            $message_body = "Ebbsey Appointment\nCongratulations! " . $trainer->first_name . ", this is a friendly reminder that " . $client->first_name . " has been enrolled in your " . $class->class_name . " class.";
            sendSms($phone, $message_body);
        }

        $class = Classes::find($request->class_id);

        $total_sum_of_referral_passes = Referral::where('user_id', $client->id)->sum('passes_count');

        $checkReferral = Referral::where('passes_count', '>', 0)
                        ->where(['user_id' => $client->id, 'trainer_id' => $trainer->id])->first();

        if ($checkReferral) {

            if ($checkReferral->passes_count >= $appoint->number_of_passes) {
                $checkReferral->passes_count = $checkReferral->passes_count - $appoint->number_of_passes;
            } else {
                $checkReferral->passes_count = 0;
            }
            $checkReferral->save();
            $appoint->is_referral_enabled = 1;
            $appoint->save();
        } else if ($total_sum_of_referral_passes > $client->passes_count) {

            $passes_to_be_deducted = $total_sum_of_referral_passes - $client->passes_count;

            $allReferrals = Referral::where('passes_count', '>', 0)->where('user_id', $client->id)->get();
            foreach ($allReferrals as $referral) {
                if ($referral->passes_count >= $passes_to_be_deducted) {
                    $referral->passes_count = $referral->passes_count - $passes_to_be_deducted;
                    $referral->save();
                    $passes_to_be_deducted = 0;
                } else {
                    $passes_to_be_deducted = $passes_to_be_deducted - $referral->passes_count;
                    $referral->passes_count = $referral->passes_count - $passes_to_be_deducted;
                    $referral->save();
                }

                if ($passes_to_be_deducted == 0) {
                    break;
                }
            }
        }

        $format = 'Y-m-d\TH:i:sP';
        $startdate = new DateTime($appoint->start_date);
        $startdate = $startdate->format($format);
        $enddate = new DateTime($appoint->end_date);
        $enddate = $enddate->format($format);

        if (isset($client->google_access_token)) {
            $timezone = 'UTC';
            if ($client->timezone) {
                $timezone = $client->timezone;
            }
            $googleClient = new Google_Client();
            $googleClient->setAuthConfig('client_secret.json');
            $googleClient->setAccessType("offline");
            $googleClient->setApprovalPrompt("force");
            $googleClient->setIncludeGrantedScopes(true);   // incremental auth
            $googleClient->addScope(Google_Service_Calendar::CALENDAR);

            $access_token_old = [
                "access_token" => $client->google_access_token,
                "token_type" => $client->google_token_type,
                "expires_in" => $client->google_token_expires_in,
                "refresh_token" => $client->google_refresh_token,
                "created" => $client->google_token_created
            ];

            $googleClient->setAccessToken($access_token_old);
            if ($googleClient->isAccessTokenExpired()) {
                $access_token = $googleClient->fetchAccessTokenWithRefreshToken($googleClient->getRefreshToken());
                $client->google_access_token = $access_token['access_token'];
                $client->google_refresh_token = $access_token['refresh_token'];
                $client->google_token_type = $access_token['token_type'];
                $client->google_token_expires_in = $access_token['expires_in'];
                $client->google_token_created = $access_token['created'];
                $client->save();
            }

            $service = new Google_Service_Calendar($googleClient);
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $class->class_name,
                'description' => '',
                'start' => array(
                    'dateTime' => $startdate,
                    'timeZone' => $timezone,
                ),
                'end' => array(
                    'dateTime' => $enddate,
                    'timeZone' => $timezone,
                ),
            ));
            $calendarId = 'primary';
            $service->events->insert($calendarId, $event);
        }

        if (isset($trainer->google_access_token)) {
            $timezone = 'UTC';
            if ($trainer->timezone) {
                $timezone = $trainer->timezone;
            }
            $googleClient = new Google_Client();
            $googleClient->setAuthConfig('client_secret.json');
            $googleClient->setAccessType("offline");
            $googleClient->setApprovalPrompt("force");
            $googleClient->setIncludeGrantedScopes(true);   // incremental auth
            $googleClient->addScope(Google_Service_Calendar::CALENDAR);

            $access_token_old = [
                "access_token" => $trainer->google_access_token,
                "token_type" => $trainer->google_token_type,
                "expires_in" => $trainer->google_token_expires_in,
                "refresh_token" => $trainer->google_refresh_token,
                "created" => $trainer->google_token_created
            ];

            $googleClient->setAccessToken($access_token_old);
            if ($googleClient->isAccessTokenExpired()) {
                $access_token = $googleClient->fetchAccessTokenWithRefreshToken($googleClient->getRefreshToken());
                $trainer->google_access_token = $access_token['access_token'];
                $trainer->google_refresh_token = $access_token['refresh_token'];
                $trainer->google_token_type = $access_token['token_type'];
                $trainer->google_token_expires_in = $access_token['expires_in'];
                $trainer->google_token_created = $access_token['created'];
                $trainer->save();
            }
            $service = new Google_Service_Calendar($googleClient);
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $class->class_name,
                'description' => '',
                'start' => array(
                    'dateTime' => $startdate,
                    'timeZone' => $timezone,
                ),
                'end' => array(
                    'dateTime' => $enddate,
                    'timeZone' => $timezone,
                ),
            ));
            $calendarId = 'primary';
            $service->events->insert($calendarId, $event);
        }

        return json_encode(array('success' => 1, 'message' => 'You Enrolled in Class successfully.'));
    }

    function classes(Request $request) {
        $data['title'] = 'Ebbsey | Classes';
        $user = User::find(Auth::id());
        $data['current_user'] = $user;

        $search_keyword = $request->search;
        if ($user->user_type != 'trainer') {
            return redirect()->back();
        }
        $data['result'] = Classes::with('countSpot', 'classtType', 'classTimetable', 'getImage')
                        ->where('trainer_id', Auth::id())
                        ->where(function($query) use($search_keyword) {
                            if ($search_keyword) {
                                $query->where('class_name', 'LIKE', '%' . $search_keyword . '%');
                            }
                        })->orderBy('updated_at', 'DESC')->paginate(3);
        return view('user.classes', $data);
    }

    function createClass(Request $request, $id = '') {
        $data['title'] = 'Create Class';
        if ($id) {
            $data['title'] = 'Edit Class';
            $data['edit_id'] = $id;
            $data['result'] = Classes::with('classtType', 'classImages', 'getImage')->where(['id' => $id, 'trainer_id' => $this->userId])->first();
            if (!$data['result']) {
                return redirect()->back();
            }

            $monday = ClassTimetable::where(['class_id' => $id, 'day' => 'monday'])->select('start_time', 'end_time')->get()->toArray();
            $tuesday = ClassTimetable::where(['class_id' => $id, 'day' => 'tuesday'])->select('start_time', 'end_time')->get()->toArray();
            $wednesday = ClassTimetable::where(['class_id' => $id, 'day' => 'wednesday'])->select('start_time', 'end_time')->get()->toArray();
            $thursday = ClassTimetable::where(['class_id' => $id, 'day' => 'thursday'])->select('start_time', 'end_time')->get()->toArray();
            $friday = ClassTimetable::where(['class_id' => $id, 'day' => 'friday'])->select('start_time', 'end_time')->get()->toArray();
            $saturday = ClassTimetable::where(['class_id' => $id, 'day' => 'saturday'])->select('start_time', 'end_time')->get()->toArray();
            $sunday = ClassTimetable::where(['class_id' => $id, 'day' => 'sunday'])->select('start_time', 'end_time')->get()->toArray();

            $data['timetable'] = [
                'monday' => $monday,
                'tuesday' => $tuesday,
                'wednesday' => $wednesday,
                'thursday' => $thursday,
                'friday' => $friday,
                'saturday' => $saturday,
                'sunday' => $sunday,
            ];

            $timetable_array_size = 0;
            foreach ($data['timetable'] as $key => $value) {
                $size = sizeof($data['timetable'][$key]);
                if ($size > $timetable_array_size) {
                    $timetable_array_size = $size;
                }
            }
            $data['timetable_array_size'] = $timetable_array_size;
        }

        $data['gallery'] = Images::get();
        $data['class_types'] = ClassType::get();
//        $data['class_type'] = ['individual', 'couples', 'groups'];
        $data['class_type'] = ['groups'];

        return view('user.create-class', $data);
    }

    function postCreateClass(Request $request) {
        $edit_id = $request->edit_id;
        if ($edit_id) {
            $cls_obj = Classes::find($edit_id);

            ClassTimetable::where('class_id', $edit_id)->delete();
            $message = 'Class updated successfully';
        } else {
            $cls_obj = New Classes();
            $message = 'Class added successfully';
        }

        if (date('Y-m-d', strtotime($request->start_date)) < date('Y-m-d')) {
            $result = array('success' => 0, 'message' => 'Start date must be less then current date');
            return json_encode($result);
        }

        $cls_obj->class_name = $request->class_name;
        $cls_obj->trainer_id = Auth::id();
        $cls_obj->difficulty_level = $request->difficulty_level;
        $cls_obj->class_type = $request->clas_type;
        $cls_obj->calories = $request->calories;
        $cls_obj->state = $request->state;
        $cls_obj->location = $request->location;
        $cls_obj->postal_code = $request->postal_code;
        $cls_obj->duration = $request->duration;
        $cls_obj->spot = $request->spot;

        $cls_obj->start_date = date('Y-m-d', strtotime($request->start_date));
        $cls_obj->description = $request->description;

        $cls_obj->image_id = ($request->gallery_images) ? $request->gallery_images : '';
        $cls_obj->save();
        if ($edit_id) {
            ClassImage::where('class_id', $edit_id)->delete();
        } else {
            $edit_id = $cls_obj->id;
        }

        if ($request->monday) {
            foreach ($request->monday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'monday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->tuesday) {
            foreach ($request->tuesday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'tuesday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->wednesday) {
            foreach ($request->wednesday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'wednesday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->thursday) {
            foreach ($request->thursday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'thursday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->friday) {
            foreach ($request->friday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'friday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->saturday) {
            foreach ($request->saturday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'saturday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        if ($request->sunday) {
            foreach ($request->sunday as $time) {
                if ($time) {
                    $time = explode('-', $time);
                    $start_time = $time[0];
                    $end_time = $time[1];
                    $startTime = (int) (strtotime($start_time));
                    $endTime = (int) (strtotime($end_time));
                    $duration = ($endTime - $startTime) / 60;
                    if ($duration >= (int) $cls_obj->duration) {
                        $timetable = new ClassTimetable();
                        $timetable->class_id = $cls_obj->id;
                        $timetable->day = 'sunday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }

        $result = array('success' => 1, 'message' => $message);
        return json_encode($result);
    }

    function editTrainerView() {
        $data['title'] = 'Ebbsey | Edit Trainer';
        $user = Auth::User();
        $trainer_qualifications = UserQualification::where('user_id', $user->id)
                        ->whereHas('getQualification', function($x) {
                            $x->where('is_approved_by_admin', 1);
                        })->get();
        $data['selected_qualifications'] = $trainer_qualifications;
        $trainer_other_qualification = UserQualification::where('user_id', $user->id)
                ->whereHas('getQualification', function($x) {
                    $x->where('is_approved_by_admin', 0);
                })
                ->first();
        $data['trainer_other_qualification'] = $trainer_other_qualification;

        $trainer_specializations = UserSpecialization::where('user_id', $user->id)
                ->whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 1);
                })
                ->get();
        $data['selected_specializations'] = $trainer_specializations;
        $trainer_other_specializations = UserSpecialization::where('user_id', $user->id)
                ->whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 0);
                })
                ->first();
        $data['trainer_other_specializations'] = $trainer_other_specializations;

        $data['questionnaire1'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question1'])->first();
        $data['questionnaire2'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question2'])->first();
        $data['questionnaire3'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question3'])->first();

        $documents = [];
        $data['training_type_ids'] = TrainerTrainingType::where('trainer_id', $user->id)->pluck('training_type_id')->toArray();

        foreach ($data['training_type_ids'] as $id) {
            $arr[$id]['cvs'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'cv', 'type_id' => $id])->pluck('file')->implode(',');
            $arr[$id]['certificates'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'certification', 'type_id' => $id])->pluck('file')->implode(',');
            $documents = $documents + $arr;
        }
        $data['documents'] = $documents;

        $monday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'monday'])->select('start_time', 'end_time')->get()->toArray();
        $tuesday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'tuesday'])->select('start_time', 'end_time')->get()->toArray();
        $wednesday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'wednesday'])->select('start_time', 'end_time')->get()->toArray();
        $thursday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'thursday'])->select('start_time', 'end_time')->get()->toArray();
        $friday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'friday'])->select('start_time', 'end_time')->get()->toArray();
        $saturday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'saturday'])->select('start_time', 'end_time')->get()->toArray();
        $sunday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'sunday'])->select('start_time', 'end_time')->get()->toArray();

        $data['timetable'] = [
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ];

        $timetable_array_size = 0;
        foreach ($data['timetable'] as $key => $value) {
            $size = sizeof($data['timetable'][$key]);
            if ($size > $timetable_array_size) {
                $timetable_array_size = $size;
            }
        }
        $data['timetable_array_size'] = $timetable_array_size;

        $total_earning = PaymentHistory::where('trainer_id', $user->id)->where('is_payout', 1)->sum('amount');
        $data['total_earning'] = $total_earning;

        $this_month_earning = PaymentHistory::where('trainer_id', $user->id)
                ->where('is_payout', 1)
                ->whereMonth('created_at', '=', date('m'))
                ->whereYear('created_at', '=', date('Y'))
                ->sum('amount');
        $data['this_month_earning'] = $this_month_earning;

        $last_month_earning = PaymentHistory::where('trainer_id', $user->id)
                ->where('is_payout', 1)
                ->whereMonth('created_at', '=', date('m', strtotime(date('Y-m') . " -1 month")))
                ->whereYear('created_at', '=', date('Y', strtotime(date('Y-m') . " -1 month")))
                ->sum('amount');
        $data['last_month_earning'] = $last_month_earning;

//        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//        $account = Account::retrieve($this->user->stripe_payout_account_id);
//        $data['bank_account'] = $account;
//        $data['status'] = $account->legal_entity->verification->status;
//        $data['status'] = 'unverified';

        if ($user->user_type == 'trainer') {
            return view('user.edit-trainer-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function earningHistoryView(Request $request) {
        $data['title'] = 'Ebbsey | Earning History';
        $type = $request->type;
        $month_key = $request->month;
        if ($type) {
            if ($type == 'balance') {
                $data['results'] = PaymentHistory::with('appointment')->where('trainer_id', $this->userId)
                        ->where('is_payout', 0)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);
                return view('user.earning_history', $data);
            } else if ($type == 'earning') {
                $month = '';
                $year = '';
                if ($month_key) {
                    if ($month_key == 'current_month') {
                        $month = date('m');
                        $year = date('Y');
                    } else if ($month_key == 'last_month') {
                        $month = date('m', strtotime(date('Y-m') . " -1 month"));
                        $year = date('Y', strtotime(date('Y-m') . " -1 month"));
                    }
                }
                $data['results'] = PaymentHistory::with('appointment')->where('trainer_id', $this->userId)
                        ->where('is_payout', 1)
                        ->when($month && $year, function($q) use($month, $year) {
                            $q->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year);
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);
                return view('user.earning_history', $data);
            }
        }
        return Redirect::to(URL::previous());
    }

    function openBankTab() {
        $data['title'] = 'Ebbsey | Edit Trainer';
        $user = Auth::User();
        $trainer_qualifications = UserQualification::where('user_id', $user->id)
                ->whereHas('getQualification', function($x) {
                    $x->where('is_approved_by_admin', 1);
                })
                ->get();
        $data['selected_qualifications'] = $trainer_qualifications;
        $trainer_other_qualification = UserQualification::where('user_id', $user->id)
                ->whereHas('getQualification', function($x) {
                    $x->where('is_approved_by_admin', 0);
                })
                ->first();
        $data['trainer_other_qualification'] = $trainer_other_qualification;

        $trainer_specializations = UserSpecialization::where('user_id', $user->id)
                ->whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 1);
                })
                ->get();
        $data['selected_specializations'] = $trainer_specializations;
        $trainer_other_specializations = UserSpecialization::where('user_id', $user->id)
                ->whereHas('getSpecialization', function($x) {
                    $x->where('is_approved_by_admin', 0);
                })
                ->first();
        $data['trainer_other_specializations'] = $trainer_other_specializations;

        $data['questionnaire1'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question1'])->first();
        $data['questionnaire2'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question2'])->first();
        $data['questionnaire3'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'question3'])->first();

        $documents = [];
        $data['training_type_ids'] = TrainerTrainingType::where('trainer_id', $user->id)->pluck('training_type_id')->toArray();

        foreach ($data['training_type_ids'] as $id) {
            $arr[$id]['cvs'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'cv', 'type_id' => $id])->pluck('file')->implode(',');
            $arr[$id]['certificates'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'certification', 'type_id' => $id])->pluck('file')->implode(',');
            $documents = $documents + $arr;
        }
        $data['documents'] = $documents;

        $monday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'monday'])->select('start_time', 'end_time')->get()->toArray();
        $tuesday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'tuesday'])->select('start_time', 'end_time')->get()->toArray();
        $wednesday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'wednesday'])->select('start_time', 'end_time')->get()->toArray();
        $thursday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'thursday'])->select('start_time', 'end_time')->get()->toArray();
        $friday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'friday'])->select('start_time', 'end_time')->get()->toArray();
        $saturday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'saturday'])->select('start_time', 'end_time')->get()->toArray();
        $sunday = TrainerTimetable::where(['trainer_id' => $user->id, 'day' => 'sunday'])->select('start_time', 'end_time')->get()->toArray();

        $data['timetable'] = [
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ];

        $timetable_array_size = 0;
        foreach ($data['timetable'] as $key => $value) {
            $size = sizeof($data['timetable'][$key]);
            if ($size > $timetable_array_size) {
                $timetable_array_size = $size;
            }
        }
        $data['timetable_array_size'] = $timetable_array_size;

        $data['alert_for_bank'] = 1;

        if (!(isset($_GET['connect_stripe']) && $_GET['connect_stripe'])) {
            Session::flash('error', 'You must connect to stripe before creating a class');
        }
        if ($user->user_type == 'trainer') {
            return view('user.edit-trainer-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function editTrainer(Request $request) {
        $user = Auth::User();
        $email_changed = 0;
        if ($request->form_name == 'basic_form') {
            if ($request->email != $user->email) {
                $email = $request->email;
                $check = User::where('email', $email)->first();
                if ($check) {
                    Session::flash('error', 'Email already exists!');
                    return Redirect::to(URL::previous());
                }
                $user->email = $email;
                $user->is_verified = 0;
                $activate_code = Str::random(15);
                $user->activation_code = $activate_code;
                $viewData['title'] = 'Ebbsey Account Confirmation';
                $viewData['link'] = url('verify_email') . '/' . $activate_code;
                $viewData['full_name'] = $request->first_name;
                $viewData['user_email'] = $email;
                $viewData['activate_code'] = $activate_code;
                $viewData['message_text'] = 'Your Email Adress is change at Ebbsey. Follow the link below to confirm your account';

                Mail::send('email.email_verification_success', $viewData, function ($m) use ($email) {
                    $m->from(env('FROM_EMAIL', 'Ebbsey Account Confirmation'), 'Ebbsey');
                    $m->to($email)->subject('Confirm your account registration');
                });
                $email_changed = 1;
            }
//            $user->dob = $request->dob;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->postal_code = $request->postal_code;
            $user->fb_url = $request->fb_link;
            $user->insta_url = $request->insta_link;
            if ($request->profile_pic) {
                if ($request->profile_pic != $user->image) {
                    $user->image = $request->profile_pic;
                    $user->original_image = $request->original_image;
                    $user->is_image_approved_by_admin = 0;
                    $user->is_approved_by_admin = 0;

                    //Notification to admin on changed image 
                    $cu_user = User::find(Auth::id());
                    $viewData['mr'] = 'Hello';
                    $viewData['username'] = 'Team Ebbsey';
                    $viewData['title'] = 'Profile Update'; 
                    $viewData['para_one'] = $cu_user->first_name . ' Update his profile Please Review it.';
                    $email_to = 'info@ebbsey.com';
                    Mail::send('email.confirmation', $viewData, function ($m) use ($email_to) {
                        $m->from(env('FROM_EMAIL', 'Profile Update'), 'Ebbsey');
                        $m->to($email_to)->subject('Profile Update');
                    });
                }
            }
            $user->save();
        } else if ($request->form_name == 'qualifications_form') {

            $user->years_of_experience = $request->trainer_experience;

            if ($request->qualifications && $request->qualification_changed == '1') {
                $selected_qualifications = $request->qualifications;

                UserQualification::where('user_id', $user->id)
                        ->whereHas('getQualification', function($x) {
                            $x->where('is_approved_by_admin', 1);
                        })->delete();

                foreach ($selected_qualifications as $qualificationskey => $qualifications) {
                    $qualifications_id = $qualificationskey;
                    $user_qualifications = new UserQualification;
                    $user_qualifications->qualification_id = $qualifications_id;
                    $user_qualifications->user_id = $user->id;
                    $user_qualifications->save();
                }
            }
            if ($request->qualification_other && $request->other_qualification_changed == '1') {

                UserQualification::where('user_id', $user->id)
                        ->whereHas('getQualification', function($x) {
                            $x->where('is_approved_by_admin', 0);
                        })->delete();

                $qualification_other = Qualification::where('title', $request->qualification_other)->first();

                if ($qualification_other) {
                    $user_qualifications = new UserQualification;
                    $user_qualifications->qualification_id = $qualification_other->id;
                    $user_qualifications->user_id = $user->id;
                    $user_qualifications->save();
                } else {
                    $qualification_other = new Qualification();
                    $qualification_other->title = $request->qualification_other;
                    $qualification_other->is_approved_by_admin = 0;
                    $qualification_other->save();
                    $user_qualifications = new UserQualification;
                    $user_qualifications->qualification_id = $qualification_other->id;
                    $user_qualifications->user_id = $user->id;
                    $user_qualifications->save();
                }
            }

//            TrainerTrainingType::where('trainer_id', $user->id)->delete();
//            TrainerDocument::where('trainer_id', $user->id)->delete();
//            $trainer_types = $request->trainer_type;
//            if ($trainer_types) {
//                foreach ($trainer_types as $key => $trainer_type) {
//                    $trainer_type_id = $trainer_type;
//                    $TrainerTrainingType = new TrainerTrainingType;
//                    $TrainerTrainingType->training_type_id = $trainer_type_id;
//                    $TrainerTrainingType->trainer_id = $user->id;
//                    $TrainerTrainingType->save();
//                }
//            }
//
//            if ($request->certificates) {
//                $trainer_certificates = $request->certificates;
//                foreach ($trainer_certificates as $key => $certificates) {
//                    if ($certificates) {
//                        if (array_search($key, $trainer_types)) {
//                            $certificates = explode(',', $certificates);
//                            foreach ($certificates as $file) {
//                                $trainer_type_id = $key;
//                                $TrainerTrainingType = new TrainerDocument;
//                                $TrainerTrainingType->trainer_id = $user->id;
//                                $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
//                                $TrainerTrainingType->document_type = 'certification';
//                                $TrainerTrainingType->type_id = $trainer_type_id;
//                                $TrainerTrainingType->is_approved_by_admin = 0;
//                                $TrainerTrainingType->save();
//                            }
//                        }
//                    }
//                }
//            }
//            if ($request->cv) {
//                $trainer_cv = $request->cv;
//                foreach ($trainer_cv as $key => $cvs) {
//                    if ($cvs) {
//                        if (array_search($key, $trainer_types)) {
//                            $cvs = explode(',', $cvs);
//                            foreach ($cvs as $file) {
//                                $trainer_type_id = $key;
//                                $TrainerTrainingType = new TrainerDocument;
//                                $TrainerTrainingType->trainer_id = $user->id;
//                                $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
//                                $TrainerTrainingType->document_type = 'cv';
//                                $TrainerTrainingType->type_id = $trainer_type_id;
//                                $TrainerTrainingType->is_approved_by_admin = 0;
//                                $TrainerTrainingType->save();
//                            }
//                        }
//                    }
//                }
//            }
            $user->save();
        } else if ($request->form_name == 'availability_form') {

            if ($request->specializations && $request->specializations_changed == '1') {
                $selected_specializations = $request->specializations;
                UserSpecialization::where('user_id', $user->id)
                        ->whereHas('getSpecialization', function($x) {
                            $x->where('is_approved_by_admin', 1);
                        })->delete();
                foreach ($selected_specializations as $specializations) {
                    $specializations_id = $specializations;
                    $UserSpecialization = new UserSpecialization();
                    $UserSpecialization->specialization_id = $specializations_id;
                    $UserSpecialization->user_id = $user->id;
                    $UserSpecialization->save();
                }
            }
            if ($request->other_specialization && $request->other_specializations_changed == '1') {
                UserSpecialization::where('user_id', $user->id)
                        ->whereHas('getSpecialization', function($x) {
                            $x->where('is_approved_by_admin', 0);
                        })->delete();
                $specialization_other = Specialization::where('title', $request->other_specialization)->first();
                if ($specialization_other) {
                    $user_specializations = new UserSpecialization;
                    $user_specializations->specialization_id = $specialization_other->id;
                    $user_specializations->user_id = $user->id;
                    $user_specializations->save();
                } else {
                    $specialization_other = new Specialization();
                    $specialization_other->title = $request->other_specialization;
                    $specialization_other->is_approved_by_admin = 0;
                    $specialization_other->save();
                    $user_specializations = new UserSpecialization;
                    $user_specializations->specialization_id = $specialization_other->id;
                    $user_specializations->user_id = $user->id;
                    $user_specializations->save();
                }
            }

            if (isset($request->trainer_question1)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'question1')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->trainer_question1;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'question1';
                    $QuestionAnswer->choice = $request->trainer_question1;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->trainer_question2)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'question2')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->trainer_question2;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'question2';
                    $QuestionAnswer->choice = $request->trainer_question2;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->trainer_question3)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'question3')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->trainer_question3;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'question3';
                    $QuestionAnswer->choice = $request->trainer_question3;
                }
                $QuestionAnswer->save();
            }

            $user->distance = $request->distance;
            $user->save();

            TrainerTimetable::where('trainer_id', $user->id)->delete();

            if ($request->monday) {
                foreach ($request->monday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'monday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->tuesday) {
                foreach ($request->tuesday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'tuesday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->wednesday) {
                foreach ($request->wednesday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'wednesday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->thursday) {
                foreach ($request->thursday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'thursday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->friday) {
                foreach ($request->friday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'friday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->saturday) {
                foreach ($request->saturday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'saturday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            if ($request->sunday) {
                foreach ($request->sunday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $user->id;
                        $timetable->day = 'sunday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }
        }
        Session::flash('success', 'Your record has been updated !');
        if ($email_changed) {
            Auth::guard('user')->logout();
        }
        return Redirect::to(URL::previous());
    }

    function editUserView() {
        $data['title'] = 'Ebbsey | Edit User';
        $user = Auth::User();
        $fitnessGoalIds = UserFitnessGoal::where('user_id', $user->id)->pluck('fitness_goal_id');
        $data['other_fitness_goal'] = '';
        if (!$fitnessGoalIds->isEmpty()) {
            $other_fitness_goal = FitnessGoal::whereIn('id', $fitnessGoalIds)
                            ->where('is_approved_by_admin', '0')->first();
            if ($other_fitness_goal) {
                $data['other_fitness_goal'] = UserFitnessGoal::where(['user_id' => $user->id, 'fitness_goal_id' => $other_fitness_goal->id])->first();
            }
        }
        $data['selected_fitness_goals'] = UserFitnessGoal::where('user_id', $user->id)->get();
        $data['questionnaire1'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question1'])->first();
        $data['questionnaire2'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question2'])->first();
        $data['questionnaire3'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question3'])->first();
        $data['questionnaire4'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question4'])->first();
        $data['questionnaire5'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question5'])->first();
        $data['questionnaire6'] = QuestionAnswer::where(['user_id' => $user->id, 'question' => 'user_question6'])->first();

        if ($user->user_type == 'user') {
            return view('user.edit-user-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function editUser(Request $request) {
        $user = Auth::User();
        $email_changed = 0;
        if ($request->form_name == 'basic_form') {
//            $user->first_name = $request->first_name;
//            $user->last_name = $request->last_name;
//            $user->dob = $request->dob;
            if ($request->email != $user->email) {
                $email = $request->email;
                $check = User::where('email', $email)->first();
                if ($check) {
                    Session::flash('error', 'Email already exists!');
                    return Redirect::to(URL::previous());
                }
                $user->email = $email;
                $user->is_verified = 0;
                $activate_code = Str::random(15);
                $user->activation_code = $activate_code;
                $viewData['title'] = 'Ebbsey Account Confirmation';
                $viewData['link'] = url('verify_email') . '/' . $activate_code;
                $viewData['full_name'] = $request->first_name;
                $viewData['user_email'] = $email;
                $viewData['activate_code'] = $activate_code;
                $viewData['message_text'] = 'Your Email Adress is change at Ebbsey. Follow the link below to confirm your account';

                Mail::send('email.email_verification_success', $viewData, function ($m) use ($email) {
                    $m->from(env('FROM_EMAIL', 'Ebbsey Account Confirmation'), 'Ebbsey');
                    $m->to($email)->subject('Confirm your account registration');
                });
                $email_changed = 1;
            }
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->lat = $request->lat;
            $user->lng = $request->lng;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->postal_code = $request->postal_code;
            $user->image = $request->profile_pic;
            $user->original_image = $request->original_image;
        } else if ($request->form_name == 'goals_form') {

            if ($request->fitness_goals && $request->fitness_goals_changed == '1') {
                $selected_goals = $request->fitness_goals;
                UserFitnessGoal::where('user_id', $user->id)
                        ->whereHas('goal', function($x) {
                            $x->where('is_approved_by_admin', 1);
                        })->delete();

                foreach ($selected_goals as $goalskey => $goals) {
                    $goals_id = $goalskey;
                    $user_goals = new UserFitnessGoal;
                    $user_goals->fitness_goal_id = $goals_id;
                    $user_goals->user_id = $user->id;
                    $user_goals->save();
                }
            }
            if ($request->other_fitness_goal && $request->other_fitness_goal_changed == '1') {

                UserFitnessGoal::where('user_id', $user->id)
                        ->whereHas('goal', function($x) {
                            $x->where('is_approved_by_admin', 0);
                        })->delete();

                $goal_other = FitnessGoal::where('title', $request->other_fitness_goal)->first();

                if ($goal_other) {
                    $user_goals = new UserFitnessGoal;
                    $user_goals->fitness_goal_id = $goal_other->id;
                    $user_goals->user_id = $user->id;
                    $user_goals->save();
                } else {
                    $goal_other = new FitnessGoal();
                    $goal_other->title = $request->other_fitness_goal;
                    $goal_other->is_approved_by_admin = 0;
                    $goal_other->save();
                    $user_goals = new UserFitnessGoal;
                    $user_goals->fitness_goal_id = $goal_other->id;
                    $user_goals->user_id = $user->id;
                    $user_goals->save();
                }
            }
            if (isset($request->user_question1)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question1')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->user_question1;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question1';
                    $QuestionAnswer->choice = $request->user_question1;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->user_question2)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question2')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->user_question2;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question2';
                    $QuestionAnswer->choice = $request->user_question2;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->user_question3)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question3')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->user_question3;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question3';
                    $QuestionAnswer->choice = $request->user_question3;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->user_question4)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question4')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->user_question4;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question4';
                    $QuestionAnswer->choice = $request->user_question4;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->user_question5)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question5')->first();
                if (isset($QuestionAnswer)) {
                    if ($request->user_question5 == 'yes') {
                        $QuestionAnswer->answer_detail = $request->medical_detail;
                    }
                    $QuestionAnswer->choice = $request->user_question5;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question5';
                    $QuestionAnswer->choice = $request->user_question5;
                }
                $QuestionAnswer->save();
            }
            if (isset($request->user_question6)) {
                $QuestionAnswer = QuestionAnswer::where('user_id', $user->id)->where('question', 'user_question6')->first();
                if (isset($QuestionAnswer)) {
                    $QuestionAnswer->choice = $request->user_question6;
                } else {
                    $QuestionAnswer = new QuestionAnswer;
                    $QuestionAnswer->user_id = $user->id;
                    $QuestionAnswer->question = 'user_question6';
                    $QuestionAnswer->choice = $request->user_question6;
                }
                $QuestionAnswer->save();
            }
        }
        $user->save();
        Session::flash('success', 'Your record has been updated !');
        if ($email_changed) {
            Auth::guard('user')->logout();
        }
        return Redirect::to(URL::previous());
    }

    public function deleteItem(Request $request) {
        $id = $request->id;
        $table = $request->table;

        switch ($table) {
            case "class":
                Classes::where('id', $id)->delete($id);
                $result = array('success' => '1', 'message' => 'Classes deleted successfully!');
                echo json_encode($result);
                break;
            default:
                echo json_encode(array('success' => 0, ',message' => 'Something went wrong'));
        }
    }

    function addGalleryImagesAjax(Request $request) {
        $array = array();
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $trainerImage = new TrainerImage();
                        $input['imagename'] = 'trainer_gallery_' . uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/users');
                        $trainerImage->path = 'users/' . $input['imagename'];
                        $trainerImage->trainer_id = Auth::user()->id;
                        $trainerImage->save();
                        $complete_path = asset('public/images/users/' . $input['imagename']);
                        $path = 'public/images/users/' . $input['imagename'];
                        array_push($array, ['complete_path' => $complete_path, 'path' => $path]);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }
        return response()->json(array('success' => 'Images added successfully', 'data' => $array));
    }

    function addTrainerProfilePicAjax(Request $request) {
        $user = Auth::user();
        $user->image = str_replace('public/images/', '', $request->path);
        $user->save();
        return response()->json(array('success' => 'Profile pic added successfully'));
    }

    function deleteTrainerPicAjax(Request $request) {
        $user = Auth::user();
        $isResetted = 0;
        if ($user->image == $request->path) {
            $user->image = '';
            $user->save();
            $isResetted = 1;
        }
        TrainerImage::where(['trainer_id' => Auth::user()->id, 'path' => $request->path])->delete();
        unlink(base_path('public/images/' . $request->path));
        if ($isResetted) {
            return response()->json(array('success' => 'success', 'profile_pic_resetted' => '1'));
        }
        return response()->json(array('success' => 'success'));
    }

    function getPassesView() {
        $data['title'] = 'Ebbsey | Get Passes';
        $data['pass_price'] = PassPrice::first();
        return view('user.get_passes', $data);
    }

    function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->errors()->all());
        }
        $password = $this->user->password;
        if (Hash::check($request['current_password'], $password)) {

            $newpass = Hash::make($request['password']);
            User::where('id', $this->userId)->update(['password' => $newpass]);
            Session::flash('success', 'Password Updated successfully');

            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Invalid Old Password');
            return Redirect::to(URL::previous());
        }
    }

    function bookSession(Request $request) {
        $validator = Validator::make($request->all(), [
                    'pick_date' => 'required',
                    'pick_time' => 'required',
                    'no_of_pass' => 'required',
                    'location' => 'required',
                    'lat' => 'required',
                    'lng' => 'required'
                        ], [
                    'pick_date' => 'Date is required',
                    'pick_time' => 'Time is required',
                    'no_of_pass' => 'Passes are required',
                    'location' => 'Please enter a valid address',
                    'lat' => '',
                    'lng' => ''
        ]);
        if ($validator->fails()) {
            $errors = implode($validator->errors()->all(), '<br>');
            return json_encode(array('success' => 0, 'message' => $errors));
        }
        $trainer_id = $request->trainer_id;
        $tranee = User::find($trainer_id);
        $distance = $tranee->distance;
        if (!$tranee->lat || !$tranee->lng) {
            return json_encode(array('success' => 0, 'message' => 'Trainer\'s address is not valid!'));
        }
        $cal_dis = distance($request->lat, $request->lng, $tranee->lat, $tranee->lng);

        if ($cal_dis['status'] == 'OK') {
            if ($distance < $cal_dis['distance']) {
                return json_encode(array('success' => 0, 'message' => 'Out of range. trainer can travel only ' . $distance . ' miles. '));
            }
        }

        $user = $this->user;
        $user->passes_count = $user->passes_count - $request->no_of_pass;
        $user->save();

        $appoint = new Appointment();
        $appoint->client_id = Auth::id();
        $appoint->trainer_id = $trainer_id;
        $appoint->type = 'session';
        $appoint->date = $request->pick_date;

        $time_slot = $request->pick_time;
        $appoint->start_time = $time_slot;
        $dynamic_end_time = strtotime($time_slot) + (45 * 60);
        $dynamic_end_time = date('g:i A', $dynamic_end_time);
        $appoint->end_time = $dynamic_end_time;

        $timezone = new DateTimeZone('UTC');
        $start_date = trim($request->pick_date) . ' ' . trim($time_slot);
        $end_date = trim($request->pick_date) . ' ' . trim($dynamic_end_time);

        $start_date = new DateTime($start_date, new DateTimeZone($request['user_timezone']));
        $start_date->setTimeZone(new DateTimeZone('UTC'));
        $start_date = $start_date->format('Y-m-d H:i:s');

        $end_date = new DateTime($end_date, new DateTimeZone($request['user_timezone']));
        $end_date->setTimeZone(new DateTimeZone('UTC'));
        $end_date = $end_date->format('Y-m-d H:i:s');

        $appoint->start_date = $start_date;
        $appoint->end_date = $end_date;

        $appoint->status = 'pending';
        $appoint->number_of_passes = $request->no_of_pass;
        $passPrice = PassPrice::first();
        $appoint->client_location = $request->location;
        $appoint->client_lat = $request->lat;
        $appoint->client_lng = $request->lng;
        $checkSession = Appointment::where(['type' => 'session', 'trainer_id' => $request->trainer_id, 'status' => 'accepted',
                    'start_date' => $start_date, 'end_date' => $end_date])->first();
        if ($checkSession) {
            return json_encode(array('success' => 0, 'message' => 'Trainer already has an appointment at this time.'));
        }
        Appointment::where(['type' => 'session', 'trainer_id' => $request->trainer_id, 'status' => 'pending',
            'start_date' => $start_date, 'end_date' => $end_date])->update(['status' => 'canceled']);
        $appoint->save();
//Send email to client
        $client_user = User::find(Auth::id());
        $booked_app = Appointment::with('appointmentClient')->find($appoint->id);
        $viewData['title'] = 'Session Detail';
        $viewData['type'] = 'session_book';
        $viewData['username'] = $client_user->first_name;
        $viewData['detail'] = $booked_app;
        $client_email = $client_user->email;
        Mail::send('email.booking_confirmation', $viewData, function ($m) use ($client_email) {
            $m->from(env('FROM_EMAIL', 'Appointment Confirmation'), 'Ebbsey');
            $m->to($client_email)->subject('Appointment Confirmation');
        });

        $trainer = User::find($trainer_id);
        $client = User::find($appoint->client_id);
        if ($trainer->phone) {
            $phone = $trainer->phone;
            $message_body = "Ebbsey Appointment\nCongratulations! " . $trainer->first_name . ", this is a friendly reminder that " . $client->first_name . " has booked an appointment with you. Please, login to confirm this appointment.";
            sendSms($phone, $message_body);
        }
        $unread_counter = Appointment::where(['trainer_id' => $request->trainer_id, 'is_seen_by_trainer' => 0, 'type' => 'session'])->count();
        return json_encode(array('success' => 1, 'message' => 'Your request has been sent successfully.', 'unread_counter' => $unread_counter));
    }

    function updateAppointmentSchedule(Request $request) {
        $edit_id = $request->edit_id;
        $new_date = $request->date;
        $new_time = $request->time;

        $appoint = Appointment::with('appointmentClient')->find($edit_id);
        $f_name = $appoint->appointmentClient->first_name;
        $client_name = $appoint->appointmentClient->first_name . ' ' . $appoint->appointmentClient->last_name;
        $client_email = $appoint->appointmentClient->email;

        $dynamic_end_time = strtotime($new_time) + (45 * 60);
        $dynamic_end_time = date('g:i A', $dynamic_end_time);

        $appoint->start_time = $new_time;
        $appoint->end_time = $dynamic_end_time;
        $appoint->date = $new_date;

        $timezone = new DateTimeZone('UTC');
        $start_date = trim($new_date) . ' ' . trim($new_time);
        $end_date = trim($new_date) . ' ' . trim($dynamic_end_time);

        $start_date = new DateTime($start_date, new DateTimeZone($request['user_timezone']));
        $start_date->setTimeZone(new DateTimeZone('UTC'));
        $start_date = $start_date->format('Y-m-d H:i:s');
        $end_date = new DateTime($end_date, new DateTimeZone($request['user_timezone']));
        $end_date->setTimeZone(new DateTimeZone('UTC'));
        $end_date = $end_date->format('Y-m-d H:i:s');

        $appoint->start_date = $start_date;
        $appoint->end_date = $end_date;

        //Send notificaiton email to user upon update date/time appointmetn 

        $viewData['username'] = $f_name;
        $viewData['mr'] = 'Hey';
        $viewData['title'] = 'Appointment Changed';
        $viewData['para_one'] = 'Your appointment details have changed.';
        $viewData['para_one'] = 'To cancel or reschedule your appointment before the scheduled time, please click: <a href="' . url('user-profile') . '">here</a>';

        Mail::send('email.confirmation', $viewData, function ($m) use ($client_email) {
            $m->from(env('FROM_EMAIL', 'Appointment Changed'), 'Ebbsey');
            $m->to($client_email)->subject('Appointment Changed');
        });

        $appoint->save();

        $result = array('success' => '1', 'message' => 'Appointmetn changed successfully');
        return response()->json($result);
    }

    function getAvailableTimeSlots(Request $request) {
        $slots = TrainerTimetable::where(['trainer_id' => Auth::id(), 'day' => $request->day])->get();
        $occupiedSlots = Appointment::where(['trainer_id' => Auth::id(), 'date' => $request->date, 'status' => 'accepted'])
                        ->select('start_time', 'end_time', 'travelling_time')
                        ->get()->toArray();
        $myRequestedSlots = Appointment::where(['trainer_id' => Auth::id(), 'date' => $request->date, 'status' => 'pending', 'client_id' => $this->userId])
                        ->select('start_time', 'end_time', 'travelling_time')
                        ->get()->toArray();

        $occupiedSlots = array_merge($occupiedSlots, $myRequestedSlots);
        $hours_array = array();
        $morning = $afternoon = $evening = 0;
        $current_time = new DateTime(Carbon::now());
        $current_time->modify('+ 8 hour');
        foreach ($slots as $value) {
            $open_time = strtotime($value->start_time);
            $close_time = strtotime($value->end_time);
            if ($value->end_time == '11:59 PM') {
                $close_time = $close_time + 45;
            }
            while (($open_time + 2700) <= $close_time) {
                $time = date('g:i A', $open_time);
                $time = $request->date . ' ' . $time;
                $time = new DateTime($time, new DateTimeZone($request->timezone));
                $time->setTimeZone(new DateTimeZone('UTC'));
                if ($current_time < $time) {
                    if (strtotime('12 am') < $open_time && $open_time < strtotime('12 pm')) {
                        $slot_type = 'morning';
                    } else if (strtotime('11::59 am') < $open_time && $open_time < strtotime('5 pm')) {
                        $slot_type = 'afternoon';
                    } else if (strtotime('4:59 pm') < $open_time && $open_time < strtotime('11:59 pm')) {
                        $slot_type = 'evening';
                    }
                    $hours_array[] = ['slot' => date('g:i A', $open_time) . ' - ' . date('g:i A', $open_time + 2700), 'slot_type' => $slot_type];
                }
                $open_time = ($open_time + 2700);
            }
        }
        foreach ($occupiedSlots as $occupiedSlot) {
            $occupied_start_time = strtotime($occupiedSlot['start_time']) - (($occupiedSlot['travelling_time']) * 45);
            $occupied_end_time = strtotime($occupiedSlot['end_time']);
            foreach ($hours_array as $key => $time) {
                $time = explode(' - ', $time['slot']);
                $start_time = strtotime($time[0]);
                $end_time = strtotime($time[1]);
                if ($occupied_start_time == $start_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_end_time == $end_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_start_time < $start_time && $start_time < $occupied_end_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_start_time < $end_time && $end_time < $occupied_end_time) {
                    unset($hours_array[$key]);
                } else if ($start_time < $occupied_start_time && $occupied_start_time < $end_time) {
                    unset($hours_array[$key]);
                } else if ($start_time < $occupied_end_time && $occupied_end_time < $end_time) {
                    unset($hours_array[$key]);
                }
            }
        }
        $html = '';
        foreach ($hours_array as $arr) {
            $slot = $arr['slot'];
            $slot = explode(' - ', $slot);
            $time = $slot[0];

            $html .= '<span class="time">
                      <input type="radio" name="time" value="' . $time . '">
                      <span>' . $time . '</span>
                  </span>';
        }
        if (count($hours_array)) {
            return response()->json(['success' => 'success', 'html' => $html]);
        } else {
            return response()->json(['success' => 'success', 'html' => 'No time found']);
        }
    }

    function getAvailableTimeSlotsOfTrainer(Request $request) {
        $slots = TrainerTimetable::where(['trainer_id' => $request->trainer_id, 'day' => $request->day])->get();
        $occupiedSlots = Appointment::where(['trainer_id' => $request->trainer_id, 'date' => $request->date, 'status' => 'accepted'])
                        ->select('start_time', 'end_time', 'travelling_time')
                        ->get()->toArray();
        $myRequestedSlots = Appointment::where(['trainer_id' => $request->trainer_id, 'date' => $request->date, 'status' => 'pending', 'client_id' => $this->userId])
                        ->select('start_time', 'end_time', 'travelling_time')
                        ->get()->toArray();
        $occupiedSlots = array_merge($occupiedSlots, $myRequestedSlots);
        $hours_array = array();
        $morning = $afternoon = $evening = 0;
        $current_time = new DateTime(Carbon::now());
        $current_time->modify('+ 8 hour');
        foreach ($slots as $value) {
            $open_time = strtotime($value->start_time);
            $close_time = strtotime($value->end_time);
            if ($value->end_time == '11:59 PM') {
                $close_time = $close_time + 60;
            }
            while (($open_time + 3600) <= $close_time) {
                $time = date('g:i A', $open_time);
                $time = $request->date . ' ' . $time;
                $time = new DateTime($time, new DateTimeZone($request->timezone));
                $time->setTimeZone(new DateTimeZone('UTC'));

                if ($current_time < $time) {
                    if (strtotime('12 am') < $open_time && $open_time < strtotime('12 pm')) {
                        $slot_type = 'morning';
                    } else if (strtotime('11::59 am') < $open_time && $open_time < strtotime('5 pm')) {
                        $slot_type = 'afternoon';
                    } else if (strtotime('4:59 pm') < $open_time && $open_time < strtotime('11:59 pm')) {
                        $slot_type = 'evening';
                    }
                    $hours_array[] = ['slot' => date('g:i A', $open_time) . ' - ' . date('g:i A', $open_time + 3600), 'slot_type' => $slot_type];
                }
                $open_time = ($open_time + 3600);
            }
        }
        foreach ($occupiedSlots as $occupiedSlot) {
            $occupied_start_time = strtotime($occupiedSlot['start_time']) - (($occupiedSlot['travelling_time']) * 60);
            $occupied_end_time = strtotime($occupiedSlot['end_time']);
            foreach ($hours_array as $key => $time) {
                $time = explode(' - ', $time['slot']);
                $start_time = strtotime($time[0]);
                $end_time = strtotime($time[1]);
                if ($occupied_start_time == $start_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_end_time == $end_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_start_time < $start_time && $start_time < $occupied_end_time) {
                    unset($hours_array[$key]);
                } else if ($occupied_start_time < $end_time && $end_time < $occupied_end_time) {
                    unset($hours_array[$key]);
                } else if ($start_time < $occupied_start_time && $occupied_start_time < $end_time) {
                    unset($hours_array[$key]);
                } else if ($start_time < $occupied_end_time && $occupied_end_time < $end_time) {
                    unset($hours_array[$key]);
                }
            }
        }
        $data = array();
        foreach ($hours_array as $arr) {
            $slot = $arr['slot'];
            $slot = explode(' - ', $slot);
            $arr['slot'] = $slot[0];
            $data[] = $arr;
            if ($arr['slot_type'] == 'morning') {
                $morning = 1;
            } else if ($arr['slot_type'] == 'afternoon') {
                $afternoon = 1;
            } else if ($arr['slot_type'] == 'evening') {
                $evening = 1;
            }
        }
        if (count($hours_array)) {
            return response()->json(['success' => 'success', 'data' => $data, 'morning' => $morning, 'afternoon' => $afternoon, 'evening' => $evening]);
        } else {
            return response()->json(['error' => 'error']);
        }
    }

    function checkForDistanceRange(Request $request) {

        $trainer = User::find($request->trainer_id);
        $trainer_lat = $trainer->lat;
        $trainer_lng = $trainer->lng;
        $client_lat = $request->lat;
        $client_lng = $request->lng;
        if (!$trainer_lat && !$trainer_lng) {
            return response()->json(['error' => 'Trainer\'s address is not valid!']);
        }
//        echo $trainer_lat.'<br>';
//        echo $trainer_lng.'<br>';
//        echo $client_lat.'<br>';
//        echo $client_lng.'<br>';
        if ($trainer_lat && $trainer_lng && $client_lat && $client_lng) {
            $calculated_distance = distance($trainer_lat, $trainer_lng, $client_lat, $client_lng);
            if ($calculated_distance['status'] == 'OK') {
                if ($calculated_distance['distance'] <= $trainer->distance) {
                    return response()->json(['success' => '1', 'distance' => $calculated_distance['distance']]);
                }
            }
        }
        return response()->json(['error' => 'Please change session location, because trainer\'s service is not available in this area!']);
    }

    function getAvailableTimeSlotsOfClass(Request $request) {

        $class = Classes::find($request->class_id);
        $slots = ClassTimetable::where(['class_id' => $request->class_id, 'day' => $request->day])->get();
        $total_spots = $class->spot;
        $duration = $class->duration;
        $hours_array = array();

        $morning = $afternoon = $evening = 0;

        foreach ($slots as $value) {
            $open_time = strtotime($value->start_time);
            $close_time = strtotime($value->end_time);
            if ($value->end_time == '11:59 PM') {
                $close_time = $close_time + $duration;
            }
            while (($open_time + ($duration * 60)) <= $close_time) {

                $utc_open_time = date('g:i A', $open_time);
                $utc_open_time = $request->date . ' ' . $utc_open_time;
                $utc_open_time = new DateTime($utc_open_time, new DateTimeZone($request->timezone));
                $utc_open_time->setTimeZone(new DateTimeZone('UTC'));

                $utc_close_time = date('g:i A', ($open_time + ($duration * 60)));
                $utc_close_time = $request->date . ' ' . $utc_close_time;
                $utc_close_time = new DateTime($utc_close_time, new DateTimeZone($request->timezone));
                $utc_close_time->setTimeZone(new DateTimeZone('UTC'));

                if (Carbon::now() < $utc_open_time) {
                    $sessions = Appointment::where(['trainer_id' => $class->trainer_id, 'type' => 'session', 'date' => $request->date, 'status' => 'accepted',
                                'start_date' => $utc_open_time, 'end_date' => $utc_close_time])->get();
                    if ($sessions->isEmpty()) {
                        $occupiedSpots = Appointment::where(['class_id' => $request->class_id, 'type' => 'class', 'date' => $request->date, 'status' => 'accepted',
                                    'start_date' => $utc_open_time, 'end_date' => $utc_close_time])->sum('number_of_passes');
                        if ($occupiedSpots < $total_spots) {
                            if (strtotime('12 am') < $open_time && $open_time < strtotime('12 pm')) {
                                $slot_type = 'morning';
                            } else if (strtotime('11::59 am') < $open_time && $open_time < strtotime('5 pm')) {
                                $slot_type = 'afternoon';
                            } else if (strtotime('4:59 pm') < $open_time && $open_time < strtotime('11:59 pm')) {
                                $slot_type = 'evening';
                            }
                            $remaining_spots = $total_spots - $occupiedSpots;
                            $hours_array[] = ['slot' => date('g:i A', $open_time) . ' - ' . date('g:i A', $open_time + ($duration * 60)), 'slot_type' => $slot_type, 'remaining_spots' => $remaining_spots];
                        }
                    }
                }
                $open_time = ($open_time + ($duration * 60));
            }
        }

        $data = array();
        foreach ($hours_array as $arr) {
            $slot = $arr['slot'];
            $slot = explode(' - ', $slot);
            $arr['slot'] = $slot[0];
            $data[] = $arr;
            if ($arr['slot_type'] == 'morning') {
                $morning = 1;
            } else if ($arr['slot_type'] == 'afternoon') {
                $afternoon = 1;
            } else if ($arr['slot_type'] == 'evening') {
                $evening = 1;
            }
        }
        if (count($hours_array) > 0) {
            return response()->json(['success' => 'success', 'data' => $data, 'morning' => $morning, 'afternoon' => $afternoon, 'evening' => $evening]);
        } else {
            return response()->json(['error' => 'No slot found']);
        }
    }

    function saveResponse(Request $request) {
        $card = str_replace('-', '', $request->card_number);
        $expiry_date = $request->expiry_date;
        $package_name = $request->package_name;
        $expiry_date = explode('/', $expiry_date);
        $month = $expiry_date[0];
        $year = $expiry_date[1];

        $user = User::with('usedPass')->find(Auth::id());
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $error = '';
        $coupon_code_discount = '';
        $refferal_code_discount = '';

        try {
            $tokenResponse = \Stripe\Token::create(array(
                        "card" => array(
                            "number" => $card,
                            "exp_month" => $month,
                            "exp_year" => $year,
            )));
            $token = $tokenResponse->id;

            Charge::create([
                "amount" => $request->amount * 100,
                "currency" => "usd",
                "source" => $token,
                "description" => "Charge for " . $user->email
            ]);

            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
//                $coupon->passes_count = $coupon->passes_count - $request->passes_count;
                $coupon->save();
                if ($coupon) {
                    $checkUsedCoupon = UsedCoupon::where(['coupon_id' => $coupon->id, 'user_id' => Auth::id()])->first();
                    if (!$checkUsedCoupon) {
                        $coupon_code_discount = $coupon->discount;
                    }
                }
            }
            if ($request->referral_code) {
                $trainer = User::where('referral_code', $request->referral_code)->first();
                if ($trainer) {
                    $checkReferral = Referral::where(['referral_code' => $request->referral_code, 'user_id' => Auth::id()])->first();
                    if (!$checkReferral) {
                        $refferal_code_discount = '$5';
                    }
                }
            }
            $viewData['type'] = 'purchase_pass';
            $viewData['title'] = 'Purchase Receipt';
            $viewData['full_name'] = $user->first_name;
            $viewData['paclage_name'] = $package_name;
            $viewData['no_of_pass'] = $request->passes_count;
            $viewData['coupon_code_discount'] = $coupon_code_discount;
            $viewData['refferal_code_discount'] = $refferal_code_discount;
            $viewData['amount'] = $request->amount;
            $user_email = $user->email;
            Mail::send('email.booking_confirmation', $viewData, function ($m) use ($user_email) {
                $m->from(env('FROM_EMAIL', 'Purchase Receipt'), 'Ebbsey');
                $m->to($user_email)->subject('Purchase Receipt');
            });
        } catch (\Stripe\Error\Card $e) {
            $error = $e->getMessage();
        } catch (\Stripe\Error\RateLimit $e) {
            $error = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $error = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $error = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            $error = $e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        if ($error) {
            echo json_encode(array('error' => $error));
            return;
        }

        $total_pass = ($user->passes_count + $request->passes_count);
        $user->passes_count = $total_pass;
        $user->save();
        $dropdown = '<option disabled selected>NO OF PASSES</option>';
        $count = 1;

        if ($request->trainer_id) {
            $trainer_data = User::find($request->trainer_id);
            $isPersonalTrainer = 0;
            $isGroupTrainer = 0;
            $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $trainer_data->id)->get();
            if (!$trainerTrainingTypes->isEmpty()) {
                foreach ($trainerTrainingTypes as $trainerTrainingType) {
                    if ($trainerTrainingType->trainingTypes->title == 'Certified Personal Trainer') {
                        $isPersonalTrainer = 1;
                    }
                    if ($trainerTrainingType->trainingTypes->title == 'Group Fitness Instructor') {
                        $isGroupTrainer = 1;
                    }
                }
            }

            if ($isPersonalTrainer && (!$isGroupTrainer)) {
                if ($total_pass > 2) {
                    $total_pass = 2;
                }
            }
        }

        while ($count <= $total_pass) {
            $dropdown .= '<option value="' . $count . '">' . $count . '</option>';
            $count++;
        }

        $payments = new Payment();
        $payments->user_id = Auth::id();
        $payments->email = $request->email;
        $payments->stripe_id = $request->id;
        $payments->purchased_pass = $request->passes_count;
        $payments->pay_amount = $request->amount;
        $payments->save();

//        if ($request->coupon_code) {
//            $coupon = Coupon::where('code', $request->coupon_code)->first();
//            if ($coupon) {
//                $checkUsedCoupon = UsedCoupon::where(['coupon_id' => $coupon->id, 'user_id' => Auth::id()])->first();
//                if (!$checkUsedCoupon) {
//                    $usedCoupon = new UsedCoupon();
//                    $usedCoupon->user_id = Auth::id();
//                    $usedCoupon->coupon_id = $coupon->id;
//                    $usedCoupon->save();
//                }
//            }
//        }

        if ($coupon_code_discount != '') {
            $usedCoupon = new UsedCoupon();
            $usedCoupon->user_id = Auth::id();
            $usedCoupon->coupon_id = $coupon->id;
            $usedCoupon->save();
        }
        if ($refferal_code_discount != '') {
            $referral = new Referral();
            $referral->user_id = Auth::id();
            $referral->trainer_id = $trainer->id;
            $referral->referral_code = $request->referral_code;
            $referral->passes_count = $request->passes_count;
            $referral->save();
        }
//        if ($request->referral_code) {
//            $trainer = User::where('referral_code', $request->referral_code)->first();
//            if ($trainer) {
//                $checkReferral = Referral::where(['referral_code' => $request->referral_code, 'user_id' => Auth::id()])->first();
//                if (!$checkReferral) {
//                    $referral = new Referral();
//                    $referral->user_id = Auth::id();
//                    $referral->trainer_id = $trainer->id;
//                    $referral->referral_code = $request->referral_code;
//                    $referral->passes_count = $request->purchased_pass;
//                    $referral->save();
//                }
//            }
//        }

        echo json_encode(array('success' => 1, 'total' => $total_pass, 'html' => $dropdown));
    }

    function orderCardView() {
        $data['title'] = 'Partners Busniess Card';
        $current_user = User::with('trainerTrainingTypes.trainingTypes')->find(Auth::id());
        $trainer_type = '';
        if (isset($current_user->trainerTrainingTypes)) {
            foreach ($current_user->trainerTrainingTypes as $type) {
                $trainer_type .= $type->trainingTypes->title . ',';
            }
        }

        $data['trainer_type'] = rtrim($trainer_type, ',');
        $data['current_user'] = $current_user;
        $token = md5(uniqid(rand(), true));
        $data['code'] = substr($token, 27);
        $data['url'] = url('trainer-profile');

        return view('user.order-form', $data);
    }

    function postOrderCard(Request $request) {
//        dd($request->all());
//        if ($request->simple_order && $request->custom_order) {
//            $custom_val = 359;
//            if ($request->shot_location == 1) {
//                $custom_val = 139;
//            }
//            $amount = (14.85 + 4.99 + $custom_val);
//        } else if ($request->simple_order) {
//            $amount = 14.85 + 4.99;
//        } else if ($request->custom_order) {
//            $amount = 359;
//            if ($request->shot_location == 1) {
//                $amount = 139;
//            }
//        }
        $amount = 19.85;
        if ($request->payment == '1') {
            $amount = (14.85 + 4.99);
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $card = str_replace('-', '', $request->card_number);
            $expiry_date = $request->card_expiry_date;
            $expiry_date = explode('/', $expiry_date);
            $month = $expiry_date[0];
            $year = $expiry_date[1];

            $error = '';
            try {
                $tokenResponse = \Stripe\Token::create(array(
                            "card" => array(
                                "number" => $card,
                                "exp_month" => $month,
                                "exp_year" => $year,
                                "name" => $request->card_first_name . ' ' . $request->card_last_name,
                                "address_line1" => $request->card_address,
                                "address_city" => $request->card_city,
                                "address_state" => $request->card_state,
                                "address_zip" => $request->card_zip_code,
                                "address_country" => $request->card_country
                )));
                $token = $tokenResponse->id;
                Charge::create([
                    "amount" => ($amount * 100),
                    "currency" => "usd",
                    "source" => $token,
                    "description" => "Charge for " . Auth::user()->email
                ]);
            } catch (\Stripe\Error\Card $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Error\RateLimit $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Error\InvalidRequest $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Error\Authentication $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Error\ApiConnection $e) {
                $error = $e->getMessage();
            } catch (\Stripe\Error\Base $e) {
                $error = $e->getMessage();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            if ($error) {
                echo json_encode(array('error' => $error, 'card_error' => true));
                return;
            }
            $paylater = 0;
        } else {
            $amount = $request->payment;
            $paylater = 1;
        }
        $order = new BusinessCardOrder();
        if ($request->simple_order && $request->custom_order) {
            $order->type = 'both';
        } else if ($request->simple_order) {
            $order->type = 'simple';
        } else if ($request->custom_order) {
            $order->type = 'custom';
        }

        //Basic
        $order->ordered_by = Auth::id();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->email = $request->email;

        $order->address = $request->address;
        $order->trainer_type = $request->trainer_type;
        $order->pay_later = $paylater;

        $order->referral_code = $request->referral_code;
        $order->url = ($request->url) ? $request->url : '';

        //Customized
        $order->ordered_by = Auth::id();
        $time = $request->time;
        $order->shot_date = $request->set_date;
        $order->referral_code = $request->referral_code;
        $order->url = ($request->url) ? $request->url : '';

        $order->order_time = $request->time;
        $order->address = $request->address;
        $order->price = $amount;

        if ($request->shot_location == 1) {
            $order->admin_location = $request->admin_location;
        } else {
            $order->client_location = $request->client_location;
        }

        $order->save();
        echo json_encode(array('success' => 1, 'message' => 'Form has been submitted.'));
    }

    function makeAppointmentsSeenForTrainer() {
        Appointment::where(array('is_seen_by_trainer' => 0, 'trainer_id' => $this->userId))->update(['is_seen_by_trainer' => 1]);
        echo TRUE;
    }

    function syncGoogleCalendar(Request $request) {
        if (isset($request['value'])) {
            $client = new Google_Client();
            $client->setAuthConfig('client_secret.json');
            $client->setAccessType("offline");
            $client->setApprovalPrompt("force");
            $client->setIncludeGrantedScopes(true);   // incremental auth
            $client->addScope(Google_Service_Calendar::CALENDAR);
            $client->setRedirectUri(asset('save_google_access_token'));
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
            die;
        } else {
            $user = $this->user;
            $user->google_access_token = null;
            $user->google_refresh_token = null;
            $user->google_token_type = null;
            $user->google_token_expires_in = null;
            $user->google_token_created = null;
            $user->save();
            Session::flash('success', 'Google calendar unsynchronized successfully!');
        }
        return Redirect::to(URL::previous());
    }

    function saveGoogleAccessToken() {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->setAccessType("offline");
        $client->setApprovalPrompt("force");
        $client->setIncludeGrantedScopes(true);   // incremental auth
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->authenticate($_GET['code']);
        $access_token = $client->getAccessToken();
        $client->setAccessToken($access_token);
        $user = $this->user;
        $user->google_access_token = $access_token['access_token'];
        $user->google_refresh_token = $access_token['refresh_token'];
        $user->google_token_type = $access_token['token_type'];
        $user->google_token_expires_in = $access_token['expires_in'];
        $user->google_token_created = $access_token['created'];
        $user->save();
        Session::flash('success', 'Google calendar synchronized successfully!');
        return Redirect::to('edit-trainer-profile');
    }

    function validateCouponCode(Request $request) {
        $code = $request->code;
        $coupon = Coupon::where('code', $code)
                ->whereDate('valid_till', '>=', Carbon::now())
                ->first();
        if ($coupon && $coupon->passes_count == $request->passes_count) {
            $checkUserCoupon = UsedCoupon::where(['user_id' => $this->userId, 'coupon_id' => $coupon->id])->first();
            if ($checkUserCoupon) {
                return response()->json(['error' => 'You have already availed this coupon code']);
            }
            return response()->json(['success' => 'Congrats! You will get ' . $coupon->discount . '% discount by using this coupon code', 'discount' => $coupon->discount]);
        } else {
            return response()->json(['error' => 'This is not valid coupon code']);
        }
    }

    function validateReferralCode(Request $request) {
        $code = $request->code;
        $referal_code = User::where('referral_code', $code)->first();
        if ($referal_code) {
            $checkUserReferral = Referral::where(['user_id' => $this->userId, 'referral_code' => $referal_code->referral_code])->first();
            if ($checkUserReferral) {
                return response()->json(['error' => 'You have already used this referral code']);
            }
            return response()->json(['success' => 'Congrats! You have received $5 off.']);
        } else {
            return response()->json(['error' => 'This is not valid referral code']);
        }
    }

    function checkMorningTime(Request $request) {
        $time = $request->time;
        $selected_time = strtotime(date('d-m-Y') . ' ' . $time);
        $lower_limit = strtotime(date('d-m-Y') . ' 5:30 AM');
        $higher_limit = strtotime(date('d-m-Y') . ' 8:30 AM');
        if ($lower_limit < $selected_time && $selected_time < $higher_limit) {
            return response()->json(['success' => '1']);
        }
        if ($lower_limit == $selected_time) {
            return response()->json(['success' => '1']);
        }
        if ($higher_limit == $selected_time) {
            return response()->json(['success' => '1']);
        }
        return response()->json(['error' => '1']);
    }

}
