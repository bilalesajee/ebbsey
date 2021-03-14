<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Classes;
use App\User;
use App\Appointment;
use App\ContactUsFeedback;
use Illuminate\Support\Facades\Mail;
use App\Rating;
use App\Blog;
use App\Pages;
use App\PassPrice;
use App\Payment;
use App\TrainerEarningHistory;
use App\PaymentHistory;
use App\BusinessCardOrder;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Refund;
use Illuminate\Support\Facades\Log;
use Twilio\Twiml;
use Twilio\Rest\Client;

class PublicController extends Controller {

    function index() {
        $data['title'] = 'Ebbsey | Home';
        $data['featured_classes'] = Classes::with('getImage')->where('is_featured_by_admin', 1)->orderBy('created_at', 'desc')->take(4)->get();
        $data['featured_trainers'] = User::where(['user_type' => 'trainer', 'is_featured_by_admin' => 1])->orderBy('created_at', 'desc')->take(4)->get();
        $data['indvidual_classes_count'] = Classes::where('class_type', 'individual')->count();
        $data['groups_classes_count'] = Classes::where('class_type', 'groups')->count();
        $data['yoga_classes_count'] = Classes::where('class_name', 'LIKE', '%yoga%')->count();
        $data['youth_classes_count'] = Classes::where('class_name', 'youth classes')->count();

        $fix_states = [
                ['state' => 'Maryland'],
                ['state' => 'Virginia'],
                ['state' => 'Washington D.C.']
        ];

        $states_array = array();
        $states_array = User::where(['user_type' => 'trainer', 'is_verified' => 1, 'is_approved_by_admin' => 1])->select('state')->get()->toArray();
        $states_array = array_merge($states_array, $fix_states);
        $states = array();
        foreach ($states_array as $state) {
            if ($state['state']) {
                array_push($states, $state['state']);
            }
        }
        $states = array_unique($states);
        $new_states = array();
        foreach ($states as $state) {
            $checkStateCode = \App\State::where('state_code', $state)->first();
            if ($checkStateCode) {
                array_push($new_states, $checkStateCode->state);
            } else {
                array_push($new_states, $state);
            }
        }
        $new_states = array_unique($new_states);
        $data['trainers_states'] = $new_states;

        return view('public.index', $data);
    }

    function addContactUs(Request $request) {
        $add_contact_feed = new ContactUsFeedback;
        $add_contact_feed->name = $request->name;
        $add_contact_feed->email = $request->email;
        $add_contact_feed->message = $request->message;

        $viewData['contact_name'] = $request->name;
        $viewData['contact_email'] = $request->email;
        $viewData['contact_content'] = $request->message;
        $add_contact_feed->save();

        $email = 'info@ebbsey.com';
        Mail::send('email.contact_us', $viewData, function ($m) use ($email) {
            $m->from(env('FROM_EMAIL', 'Contact us email'));
            $m->to($email)->subject('Contact us email');
        });

        Session::flash('success', 'Thank You! We will get back to you shortly.');
        return Redirect::to(URL::previous());
    }

    function trainerPublicProfile($id) {
        $data['title'] = 'Ebbsey | Trainer Profile';
        $trainer_data = User::with('trainerRating')->find($id);
        if(!$trainer_data){
            return Redirect::to(URL::previous());
        }
        $isPersonalTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $trainer_data->id)->get();
        
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Certified Personal Trainer') {
                    $isPersonalTrainer = 1;
                    break;
                }
            }
        }
        $data['isPersonalTrainer'] = $isPersonalTrainer;

        $isGroupTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $trainer_data->id)->get();
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Group Fitness Instructor') {
                    $isGroupTrainer = 1;
                    break;
                }
            }
        }
        $data['isGroupTrainer'] = $isGroupTrainer;

        $total_rating = $trainer_data->trainerRating->count();
        $average_rating = 4.9;
        $data['average_rating'] = $average_rating;
        if ($total_rating) {
            $total_sum = $trainer_data->trainerRating->sum('rating');
            $average_rating = $total_sum / ($total_rating * 5) * 100;
            $data['average_rating'] = $average_rating * 5 / 100;
        }

        $data['trainerData'] = $trainer_data;

        if (isset($trainer_data) && $trainer_data->user_type == 'trainer') {

            $data['age'] = date_diff(date_create($trainer_data->dob), date_create('today'))->y;
            return view('user.trainer-public-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function profile($parameter) {
        $pos = strpos($parameter, '_');
        if ($pos === false) {
            return redirect()->back();
        }
        $parameter = explode('_', $parameter);
        $id = end($parameter);
        $data['title'] = 'Ebbsey | Profile';
        $trainer_data = User::with('trainerRating')->find($id);
        if (!$trainer_data) {
            return redirect()->back();
        }
        $isPersonalTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $trainer_data->id)->get();
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Certified Personal Trainer') {
                    $isPersonalTrainer = 1;
                    break;
                }
            }
        }
        $data['isPersonalTrainer'] = $isPersonalTrainer;

        $isGroupTrainer = 0;
        $trainerTrainingTypes = \App\TrainerTrainingType::where('trainer_id', $trainer_data->id)->get();
        if (!$trainerTrainingTypes->isEmpty()) {
            foreach ($trainerTrainingTypes as $trainerTrainingType) {
                if ($trainerTrainingType->trainingTypes->title == 'Group Fitness Instructor') {
                    $isGroupTrainer = 1;
                    break;
                }
            }
        }
        $data['isGroupTrainer'] = $isGroupTrainer;

        $total_rating = $trainer_data->trainerRating->count();
        $average_rating = 4.9;
        $data['average_rating'] = $average_rating;
        if ($total_rating) {
            $total_sum = $trainer_data->trainerRating->sum('rating');
            $average_rating = $total_sum / ($total_rating * 5) * 100;
            $data['average_rating'] = $average_rating * 5 / 100;
        }

        $data['trainerData'] = $trainer_data;

        if (isset($trainer_data) && $trainer_data->user_type == 'trainer') {

            $data['age'] = date_diff(date_create($trainer_data->dob), date_create('today'))->y;
            return view('user.trainer-public-profile', $data);
        } else {
            return redirect('/');
        }
    }

    function feedbackView($appoint_id) {
        if (!isset($appoint_id)) {
            return redirect(url('/'));
        }

        $app = Appointment::find($appoint_id);

        $data['title'] = 'Ebssey | Home';
        $data['appoint_id'] = $appoint_id;
        $appointment = Appointment::find($appoint_id);
        $data['rated_by'] = $appointment->client_id;
        $data['user_id'] = $appointment->trainer_id;
        $data['appointment_id'] = $appointment->id;

        return view('public.feedback', $data);
    }

    function feedback(Request $request) {
        $stars = $request->stars;
        $comments = $request->comments;
        $appointment_id = $request->appointment_id;

        $already_rated = Rating::where('appointment_id', $appointment_id)->count();

        if ($already_rated && $already_rated != 0) {
            return redirect()->back()->with('error', 'Sorry! You already rated.');
        }
        $rating = new Rating();
        $rating->appointment_id = $appointment_id;
        $rating->user_id = $request->user_id;
        $rating->rated_by = $request->rated_by;
        $rating->rating = $request->rating;
        $rating->reviews = $request->reviews;
        $rating->save();
        $data['title'] = 'Ebssey | Home';
        $request->session()->flash('success', 'Success! Thank you. Feedback submit successfully');
        return redirect()->back();
    }

    function getShotTime(Request $request) {
        $date = $request->date;
        $html = '<div class="form_section mb-3">
                                <h5><strong>- Select Time Slot for Photoshoot</strong></h5>
                            </div>';
        $date_array = array('08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM');
        $booked_times = BusinessCardOrder::where('shot_date', $date)->where('is_order_completed', '0')->get();
        foreach ($date_array as $val) {
            $total = $booked_times->where('order_time', $val)->count();
            if ($total >= 1) {
                continue;
            }
            $html .= '<span class="time">
                                    <input type="radio" name="time" value="' . $val . '">
                                    <span>' . $val . '</span>
                                </span>';
        }
        echo json_encode(array('success' => '1', 'html' => $html));
    }

    function postOrderCard(Request $request) {

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
            $paylater = 0;
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
                    "description" => "Charge for " . $request->card_email
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

        $order->ordered_by = $request->user_id;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->trainer_type = $request->trainer_type;

        $order->referral_code = $request->referral_code;
        $order->url = ($request->url) ? $request->url : '';

        $time = $request->time;
        $order->shot_date = $request->set_date;

        $order->order_time = $request->time;
        $order->price = $amount;

       $order->pay_later = $paylater;
        if ($request->shot_location == 1) {
            $order->admin_location = $request->admin_location;
        } else {
            $order->client_location = $request->client_location;
        }
        $order->save();
        echo json_encode(array('success' => 1, 'message' => 'Form has been submitted.'));
    }

    function blog() {
        $data['result'] = Blog::where('status', 1)->paginate(6);
        $data['title'] = 'Ebssey | Blog';
        return view('public.blog', $data);
    }

    function blogDetail($id) {
        if (!$id) {
            return redirect(url('/'));
        }
        $data['result'] = Blog::find($id);
        $data['title'] = 'Ebssey | Blog Detail';
        return view('public.blog_detail', $data);
    }

    function getPage($slug) {
        if (!$slug) {
            return redirect()->back();
        }

        $page_detail = Pages::where('slug', $slug)->first();
        if (!$page_detail) {
            return redirect()->back();
        }
        $data['title'] = $page_detail->title;
        $data['result'] = $page_detail;
        return view('public.page_detail', $data);
    }

    function expirePendingAppointmentsCron() {
        $pendingAppointments = Appointment::where('status', 'pending')->where('start_date', '<=', date('Y-m-d H:i:s'))->get();
        foreach ($pendingAppointments as $appointment) {
            $appointment->status = 'expired';
            $appointment->save();
        }
    }

    function weeklyPayoutCron() {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $trainers = User::where(['user_type' => 'trainer', 'is_bank_account_verified' => 1])
                ->where('stripe_payout_account_id', '!=', '')
                ->where('total_cash', '>', '1.5')
                ->get();
        $pay_later = BusinessCardOrder::where(['is_payout' => 0, 'pay_later' => 1])->get();
        foreach ($pay_later as $order) {
            $trainer = $order->cardsOrderBy;
            $trainer->total_cash = round(($trainer->total_cash - $order->price), 2);
            $trainer->save();
            $order->is_payout = 1;
            $order->save();
        }
        foreach ($trainers as $trainer) {
            try {
                $account = $trainer->stripe_payout_account_id;
                $cash = round($trainer->total_cash - 1.5, 2) * 100;
                Transfer::create(array(
                    "amount" => $cash,
                    "currency" => "usd",
                    "destination" => $account
                ));
                $user = $trainer;
                $user->total_cash = 0;
                $user->save();
                PaymentHistory::where('trainer_id', $trainer->id)->update(['is_payout' => 1]);
            } catch (\Stripe\Error\Card $e) {
                $catchMessage = $e->getMessage();
            } catch (\Stripe\Error\RateLimit $e) {
                $catchMessage = $e->getMessage();
            } catch (\Stripe\Error\InvalidRequest $e) {
                $catchMessage = $e->getMessage();
            } catch (\Stripe\Error\Authentication $e) {
                $catchMessage = $e->getMessage();
            } catch (\Stripe\Error\ApiConnection $e) {
                $catchMessage = $e->getMessage();
            } catch (\Stripe\Error\Base $e) {
                $catchMessage = $e->getMessage();
            } catch (Exception $e) {
                $catchMessage = $e->getMessage();
            }
            
            $viewData['trainer_email'] = $trainer->email;
            $viewData['issue'] = $catchMessage;
            Mail::send('email.mail_to_admin', $viewData, function ($m) {
                $m->from(env('FROM_EMAIL', 'Payment Withdrawal Issue'));
                $m->to(env('MAIL_USERNAME'))->subject('Payment Withdrawal Issue');
            });
        }
    }

    function completeAppointmentsCron() {
        $acceptedAppointments = Appointment::with('appointmentClient', 'appointmentTrainer', 'classAppointment')->where('status', 'accepted')
                ->where('end_date', '<=', date('Y-m-d H:i:s'))
                ->get();
        foreach ($acceptedAppointments as $appointment) {
            $trainer = User::find($appointment->trainer_id);

            $time = $appointment->start_time;
            $selected_time = strtotime(date('d-m-Y') . ' ' . $time);
            $lower_limit = strtotime(date('d-m-Y') . ' 5:30 AM');
            $higher_limit = strtotime(date('d-m-Y') . ' 8:30 AM');

            $pricing = PassPrice::first();
            $passes_count = $appointment->number_of_passes;
//            $base_rate = $pricing->trainer_earning_base_rate * $passes_count;
            $base_rate = $pricing->trainer_earning_base_rate;

            $referral_fee = 0;
            if ($appointment->is_referral_enabled) {
                $referral_fee = 5;
            }

            $morning_fee = 0;
            if ($lower_limit < $selected_time && $selected_time < $higher_limit) {
//                $morning_fee = 10 * $passes_count;
                $morning_fee = 10;
            }
            if ($lower_limit == $selected_time) {
//                $morning_fee = 10 * $passes_count;
                $morning_fee = 10;
            }
            if ($higher_limit == $selected_time) {
//                $morning_fee = 10 * $passes_count;
                $morning_fee = 10;
            }

            $distance_fee = 0;
            if ($appointment->distance) {
//                $distance_fee = 0.8 * $passes_count * $appointment->distance;
                $distance_fee = 0.8 * $appointment->distance;
            }
             
            $group_fee = 0;
            if ($appointment->number_of_passes > 1) {
                $group_fee = ($appointment->number_of_passes - 1) * 20;
            }

            $earning = $base_rate + $morning_fee + $referral_fee + $distance_fee + $group_fee;

            $eightyPercentOfAmount = round($earning * 0.8, 2);
            $total_cash = $trainer->total_cash + $eightyPercentOfAmount;
            $trainer->total_cash = $total_cash;
            $trainer->save();
            
            $appointment->status = 'completed';
            $appointment->amount_to_transfer = $eightyPercentOfAmount;
            $appointment->save();

            savePaymentHistory($appointment->client_id, $appointment->trainer_id, $appointment->class_id, $appointment->id, $eightyPercentOfAmount, $appointment->number_of_passes, null);

            $viewData['username'] = $appointment->appointmentClient->first_name ;
            $viewData['tranner_name'] = $appointment->appointmentTrainer->first_name;
            $viewData['appointment_id'] = $appointment->id;
            $client_email = $appointment->appointmentClient->email;
            $trainee_email = $appointment->appointmentTrainer->email;
             
            
            Mail::send('email.complete_session', $viewData, function ($m) use ($client_email) {
                $m->from(env('FROM_EMAIL', 'Session Completed'), 'Ebbsey');
                $m->to($client_email)->subject('Session Completed');
            });
            //Send Summery Email to Client  
            $summeryClientData['tranner_name'] = $appointment->appointmentTrainer->first_name . ' ' . $appointment->appointmentTrainer->last_name;
            $summeryClientData['full_name'] = $appointment->appointmentClient->first_name . ' ' . $appointment->appointmentClient->last_name;
            $summeryClientData['title'] = 'Session Summary';
            $summeryClientData['session_type'] = $appointment->type;
            $summeryClientData['passes'] = $appointment->number_of_passes;
            $summeryClientData['remaining_passes'] = $appointment->appointmentClient->passes_count;
            $summeryClientData['location'] = $appointment->client_location;
            $summeryClientData['session_date'] = $appointment->date;

            //Not need to send email to client . please get rid of this for the time being
//            Mail::send('email.session_summery', $summeryClientData, function ($m) use ($client_email) {
//                $m->from(env('FROM_EMAIL', 'Session Summery'), 'Ebbsey');
//                $m->to($client_email)->subject('Session Summery');
//            });

            //Send Summery Email to Tranner  
            $summeryData['full_name'] = $appointment->appointmentTrainer->first_name;
            $summeryData['client_name'] = $appointment->appointmentClient->first_name;
            $summeryData['base_rate'] = $base_rate;
            $summeryData['morning_fee'] = $morning_fee;
            $summeryData['earnings'] = $eightyPercentOfAmount;
            $summeryData['group_sale'] = $group_fee;
            $summeryData['distance'] = $distance_fee;
            $summeryData['referral_fee'] = $referral_fee; 

            $summeryData['title'] = 'Earning Summary';

            if ($appointment->type == 'class') {
                $summeryData['session_type'] = isset($appointment->classAppointment->class_type)?$appointment->classAppointment->class_type:'Class';
            } else {
                $type = 'Group';
                if($appointment->number_of_passes == 1){
                    $type = 'Individual';
                } else if($appointment->number_of_passes == 2){
                    $type = 'Couple';
                }
                $summeryData['session_type'] = $type;
            }
            
            $summeryData['passes'] = $appointment->number_of_passes;
            $summeryData['location'] = $appointment->client_location;
            $summeryData['session_date'] = date('M d, Y', strtotime($appointment->date)); 
            Mail::send('email.session_summery', $summeryData, function ($m) use ($trainee_email) {
                $m->from(env('FROM_EMAIL', 'Session Summery'), 'Ebbsey');
                $m->to($trainee_email)->subject('Session Summery');
            });
        }
    }
  
    function sessionReminderCron() {
        $selectedAppointments = collect(new Appointment);
        $appointments = Appointment::where(['type' => 'session', 'status' => 'accepted'])
                ->where('start_date', '>', date('Y-m-d H:i:s'))
                ->where('date', date('d-m-Y'))
                ->where('is_reminder_sent', 0)
                ->get();
        foreach ($appointments as $appointment) {
            $diff = (int) ( ( strtotime($appointment->start_date) - strtotime(date('Y-m-d H:i:s')) ) / 60 );
            if ($diff <= $appointment->travelling_time) {
                $selectedAppointments->push($appointment);
                $appointment->is_reminder_sent = 1;
                $appointment->save();
            }
        }
        $data['appointments'] = $selectedAppointments;
        return view('public.reminder', $data);
    }

    function chargePendingReferredSessionsCron() {
        $appointments = Appointment::where('referred_by', '!=', '')
                ->where('start_date', '<', date('Y-m-d H:i:s'))
                ->where('status', 'pending')
//                ->where('is_referred_after_allowed_time', 1)
                ->get();
        foreach ($appointments as $appointment) {
            $trainer = User::find($appointment->referred_by);
//            $amount = 35 * 0.8;
            $amount = 35;
            $amount = round($amount, 2);
//            $trainer->total_cash = $trainer->total_cash - (35 * $appointment->number_of_passes);
            $trainer->total_cash = $trainer->total_cash - $amount;
            $trainer->save();
            $appointment->referred_by = '';
//            $appointment->is_referred_after_allowed_time = 0;
            $appointment->save();
        }
    }

    function expirePassesCron() {
        $Time45DaysOld = date_create(date('Y-m-d H:i:s'));
        date_sub($Time45DaysOld, date_interval_create_from_date_string('45 days'));
        $all_users = User::where('user_type', 'user')->get();
        foreach ($all_users as $user) {
            $checkPurchaseRecordForLast45Days = Payment::where('user_id', $user->id)
                    ->where('created_at', '>=', $Time45DaysOld)
                    ->get();
            if (!$checkPurchaseRecordForLast45Days->count()) {
                $user->passes_count = 0;
                $user->save();
            }
        }
    } 
 

}
