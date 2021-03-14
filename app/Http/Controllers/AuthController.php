<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Twilio\Rest\Client;
use DateTime;
use DateTimeZone;
use Exception;
use Validator;
use Carbon\Carbon;
use App\User;
use App\LastLogin;
use App\FitnessGoal;
use App\UserFitnessGoal;
use App\QuestionAnswer;
use App\UserQualification;
use App\Qualification;
use App\TrainerTrainingType;
use App\UserSpecialization;
use App\Specialization;
use App\TrainerDocument;
use App\TrainerTimetable;
use App\TrainerImage;
use Stripe\Stripe;
use Stripe\Account;

class AuthController extends Controller {

    function userRegisterView() {

        $data['title'] = 'Ebbsey | Signup User';
        return view('public.useraccount', $data);
    }

    function userRegisterBasic(Request $request) {
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required|max:191',
                    'last_name' => 'required|max:191',
                    'email' => 'required|email|max:191|unique:users',
                    'password' => 'required | min:6 | confirmed',
                    'password_confirmation' => 'required',
//                    'dob' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $data['title'] = 'Ebbsey | Signup User';
            $data['first_name'] = $request->first_name;
            $data['last_name'] = $request->last_name;
            $data['email'] = $request->email;
            $data['password'] = $request->password;
            $data['dob'] = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
            $data['address'] = $request->address;
            $data['lat'] = $request->lat;
            $data['lng'] = $request->lng;
            $data['city'] = $request->city;
            $data['state'] = $request->state;
            $data['country'] = $request->country;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
            $data['tab'] = 2;
            $data['profile_pic'] = $request->profile_pic;

            return view('public.useraccount', $data);
        }
    }

    function userRegisterFitnessGoals(Request $request) {
        if ($request->fitness_goals) {
            $data['selected_fitness_goals'] = $request->fitness_goals;
            $data['tab'] = 3;
        } else {
            Session::flash('fitness_goal_error', 'You have to select at least one fitness goal !');
            $data['title'] = 'Ebbsey | Signup User';
            $data['tab'] = 2;
        }
        if ($request->other_fitnessgoal) {
            $data['other_fitnessgoal'] = $request->other_fitnessgoal;
        }
        $data['title'] = 'Ebbsey | Signup User';
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['dob'] = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
        $data['address'] = $request->address;
        $data['lat'] = $request->lat;
        $data['lng'] = $request->lng;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['country'] = $request->country;
        $data['postal_code'] = $request->postal_code;
        $data['phone'] = $request->phone;
        $data['profile_pic'] = $request->profile_pic;
        return view('public.useraccount', $data);
    }

    function userRegister(Request $request) {
//        dd($request->all());
        $user = New User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $email = $request->email;
        $password = $request->password;
        $user->email = $email;
        $user->dob = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
        $user->address = $request->address;
        $user->lat = $request->lat;
        $user->lng = $request->lng;
        if ($request->lat && $request->lng) {
            $user->timezone = get_nearest_timezone($request->lat, $request->lng);
        } else {
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            if ($location->latitude && $location->longitude) {
                $user->timezone = get_nearest_timezone($location->latitude, $location->longitude, $location->country_code);
            }
        }
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;
        if ($request->profile_pic) {
            $user->image = $request->profile_pic;
        }
        if ($request->original_image) {
            $user->original_image = $request->original_image;
        }
        $user->user_type = 'user';
        $user->is_approved_by_admin = 1;
        $activate_code = Str::random(15);
        $user->activation_code = $activate_code;
        $user->password = bcrypt($password);
        $user->save();
        if ($request->fitness_goals) {
            $selected_fitness_goals = $request->fitness_goals;
            foreach ($selected_fitness_goals as $key => $fitness_goal) {
                $user_fitness_goals = new UserFitnessGoal;
                $user_fitness_goals->fitness_goal_id = $key;
                $user_fitness_goals->user_id = $user->id;
                $user_fitness_goals->save();
            }
        }
        if ($request->other_fitnessgoal) {
            $goal_other = FitnessGoal::where('title', $request->other_fitnessgoal)->first();

            if ($goal_other) {
                $user_goals = new UserFitnessGoal;
                $user_goals->fitness_goal_id = $goal_other->id;
                $user_goals->user_id = $user->id;
                $user_goals->save();
            } else {
                $goal_other = new FitnessGoal();
                $goal_other->title = $request->other_fitnessgoal;
                $goal_other->is_approved_by_admin = 0;
                $goal_other->save();
                $user_goals = new UserFitnessGoal;
                $user_goals->fitness_goal_id = $goal_other->id;
                $user_goals->user_id = $user->id;
                $user_goals->save();
            }
        }
        if (isset($request->choice1)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question1';
            $QuestionAnswer->choice = $request->choice1;
            $QuestionAnswer->save();
        }
        if (isset($request->choice2)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question2';
            $QuestionAnswer->choice = $request->choice2;
            $QuestionAnswer->save();
        }
        if (isset($request->choice3)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question3';
            $QuestionAnswer->choice = $request->choice3;
            $QuestionAnswer->save();
        }
        if (isset($request->choice4)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question4';
            $QuestionAnswer->choice = $request->choice4;
            $QuestionAnswer->save();
        }
        if (isset($request->choice5)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question5';
            $QuestionAnswer->choice = $request->choice5;
            if ($request->choice5 == 'yes') {
                $QuestionAnswer->answer_detail = $request->medical_detail;
            }
            $QuestionAnswer->save();
        }
        if (isset($request->choice6)) {
            $QuestionAnswer = new QuestionAnswer;
            $QuestionAnswer->user_id = $user->id;
            $QuestionAnswer->question = 'user_question6';
            $QuestionAnswer->choice = $request->choice6;
            $QuestionAnswer->save();
        }

        //Send Confirmation Email
        $viewData['title'] = 'Ebbsey Account Confirmation';
        $viewData['link'] = url('verify_email') . '/' . $activate_code;
        $viewData['full_name'] = $request->first_name;
        $viewData['user_email'] = $email;
        $viewData['activate_code'] = $activate_code;
        $viewData['message_text'] = "Thank you for signing up for your new account at Ebbsey. Follow the link below to confirm your account";

        Mail::send('email.email_verification_success', $viewData, function ($m) use ($email) {
            $m->from(env('FROM_EMAIL'), 'Ebbsey');
            $m->to($email)->subject('Confirm your account registration');
        });

        //Send Welcome Email
        $templateData['username'] = $request->first_name;
        Mail::send('email.welcomeToUser', $templateData, function ($m) use ($email) {
            $m->from(env('FROM_EMAIL'), 'Ebbsey');
            $m->to($email)->subject('Congratulations');
        });

        Session::flash('success', 'Account created successfully, check your email to verify your account!');
        echo True;
    }

    function checkEmail(Request $request) {
        $email = $request->email;
        $checkEmail = User::where('email', $email)->first();
        if ($checkEmail) {
            echo False;
        } else {
            echo True;
        }
    }

    function trainerRegisterView(Request $request) {
        if (Auth::guard('user')->check()) {
            return redirect('/');
        }
        $data['title'] = 'Ebbsey | Signup Trainer';

        $token = md5(uniqid(rand(), true));
        $data['code'] = substr($token, 27);
        $data['url'] = url('trainer-profile');
        return view('public.traineraccount', $data);
    }

    function trainerRegisterBasic(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'first_name' => 'required|max:191',
                        'last_name' => 'required|max:191',
                        'email' => 'required|email|max:191|unique:users',
                        'password' => 'required | min:6 | confirmed',
                        'password_confirmation' => 'required',
//                        'dob' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(array('status' => '0', 'errors' => $validator->errors()));
            } else {
                $trainer = new User();
                $trainer->first_name = $request->first_name;
                $trainer->last_name = $request->last_name;
                $email = $request->email;
                $trainer->email = $email;
                $password = $request->password;
                $trainer->password = bcrypt($password);
                $trainer->dob = $request->dob_year . '-' . $request->dob_month . '-' . $request->dob_day;
                $trainer->gender = $request->gender;
                $trainer->address = $request->address;
                $trainer->lat = $request->lat;
                $trainer->lng = $request->lng;
                if ($request->lat && $request->lng) {
                    $trainer->timezone = get_nearest_timezone($request->lat, $request->lng);
                } else {
                    try {
                        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                        if ($location->latitude && $location->longitude) {
                            $trainer->timezone = get_nearest_timezone($location->latitude, $location->longitude, $location->country_code);
                        }
                    } catch (Exception $exc) {
                        
                    }
                }
                $trainer->city = $request->city;
                $trainer->state = $request->state;
                $trainer->country = $request->country;
                $trainer->postal_code = $request->postal_code;
                $trainer->phone = $request->phone;
                $trainer->user_type = 'trainer';
                if ($request->profile_pic) {
                    $trainer->image = str_replace('public/images/', '', $request->profile_pic);
                }
                if ($request->original_image) {
                    $trainer->original_image = str_replace('public/images/', '', $request->original_image);
                }
                $activate_code = Str::random(15);
                $trainer->activation_code = $activate_code;
                $trainer->fb_url = $request->fb_link;
                $trainer->insta_url = $request->insta_link;
                $trainer->save();
                if ($request->gallery_images) {
                    $galleryImages = explode(',', $request->gallery_images);
                    foreach ($galleryImages as $image) {
                        $trainerImage = new TrainerImage();
                        $trainerImage->trainer_id = $trainer->id;
                        $trainerImage->path = str_replace('public/images/', '', $image);
                        $trainerImage->save();
                    }
                }
                return Response::json(array('status' => 'success', 'user_id' => $trainer->id, 'first_name' => $trainer->first_name, 'last_name' => $trainer->last_name, 'title' => 'Ebbsey | Trainer Signup'));
            }
        } catch (\Exception $e) {
            return Response::json(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    function trainerRegisterQualifications(Request $request) {

        $user_id = $request->user_id;
        $trainer = User::where('id', $user_id)->first();
        $trainer->years_of_experience = $request->trainer_experience;
        if ($request->qualifications) {
            $selected_qualifications = $request->qualifications;
            foreach ($selected_qualifications as $qualificationskey => $qualifications) {
                $qualifications_id = $qualificationskey;
                $user_qualifications = new UserQualification;
                $user_qualifications->qualification_id = $qualifications_id;
                $user_qualifications->user_id = $trainer->id;
                $user_qualifications->save();
            }
        }
        if ($request->qualification_other) {

            $qualification_other = Qualification::where('title', $request->qualification_other)->first();

            if ($qualification_other) {
                $user_qualifications = new UserQualification;
                $user_qualifications->qualification_id = $qualification_other->id;
                $user_qualifications->user_id = $trainer->id;
                $user_qualifications->save();
            } else {
                $qualification_other = new Qualification();
                $qualification_other->title = $request->qualification_other;
                $qualification_other->is_approved_by_admin = 0;
                $qualification_other->save();
                $user_qualifications = new UserQualification;
                $user_qualifications->qualification_id = $qualification_other->id;
                $user_qualifications->user_id = $trainer->id;
                $user_qualifications->save();
            }
        }
        $trainer->license_expire_date = $request->license_expire_date;
        $trainer_types = $request->trainer_type;
        if ($trainer_types) {
            foreach ($trainer_types as $key => $trainer_type) {
                $trainer_type_id = $trainer_type;
                $TrainerTrainingType = new TrainerTrainingType;
                $TrainerTrainingType->training_type_id = $trainer_type_id;
                $TrainerTrainingType->trainer_id = $trainer->id;
                $TrainerTrainingType->save();
            }
        }

        if ($request->certificates) {
            $trainer_certificates = $request->certificates;
            foreach ($trainer_certificates as $key => $certificates) {
                if ($certificates) {
                    if (array_search($key, $trainer_types)) {
                        $certificates = explode(',', $certificates);
                        foreach ($certificates as $file) {
                            $trainer_type_id = $key;
                            $TrainerTrainingType = new TrainerDocument;
                            $TrainerTrainingType->trainer_id = $trainer->id;
                            $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
                            $TrainerTrainingType->document_type = 'certification';
                            $TrainerTrainingType->type_id = $trainer_type_id;
                            $TrainerTrainingType->is_approved_by_admin = 0;
                            $TrainerTrainingType->save();
                        }
                    }
                }
            }
        }
        if ($request->cv) {
            $trainer_cv = $request->cv;
            foreach ($trainer_cv as $key => $cvs) {
                if ($cvs) {
                    if (array_search($key, $trainer_types)) {
                        $cvs = explode(',', $cvs);
                        foreach ($cvs as $file) {
                            $trainer_type_id = $key;
                            $TrainerTrainingType = new TrainerDocument;
                            $TrainerTrainingType->trainer_id = $trainer->id;
                            $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
                            $TrainerTrainingType->document_type = 'cv';
                            $TrainerTrainingType->type_id = $trainer_type_id;
                            $TrainerTrainingType->is_approved_by_admin = 0;
                            $TrainerTrainingType->save();
                        }
                    }
                }
            }
        }
        $trainer->save();
        $last_id = $trainer->id;
        Session::flash('success', 'Account created successfully, check your email to verify your account before login!');
        return Response::json(array('status' => '1', 'message' => 'Submitted Successfully', 'user_id' => $last_id));
    }

    function trainerRegister(Request $request) {
        try {
            $user_id = $request->user_id;
            $trainer = User::where('id', $user_id)->first();

            $trainer->distance = $request->distance;

            $code = substr(md5(uniqid(mt_rand(), true)), 0, 5);
            $codeCheck = User::where('referral_code', $code)->first();
            while ($codeCheck) {
                $code = substr(md5(uniqid(mt_rand(), true)), 0, 5);
                $codeCheck = User::where('referral_code', $code)->first();
            }

            $trainer->referral_code = $code;

            $activate_code = $trainer->activation_code;
            $email = $trainer->email;
            if ($request->specializations) {
                $selected_specializations = $request->specializations;
                foreach ($selected_specializations as $specializations) {
                    $specializations_id = $specializations;
                    $UserSpecialization = new UserSpecialization;
                    $UserSpecialization->specialization_id = $specializations_id;
                    $UserSpecialization->user_id = $trainer->id;
                    $UserSpecialization->save();
                }
            }
            if ($request->other_specialization) {
                $specialization_other = new Specialization();
                $specialization_other->title = $request->other_specialization;
                $specialization_other->is_approved_by_admin = 0;
                $specialization_other->save();
                $user_specialization = new UserSpecialization;
                $user_specialization->specialization_id = $specialization_other->id;
                $user_specialization->user_id = $trainer->id;
                $user_specialization->save();
            }
            if (isset($request->trainer_question1)) {
                $QuestionAnswer = new QuestionAnswer;
                $QuestionAnswer->user_id = $trainer->id;
                $QuestionAnswer->question = 'question1';
                $QuestionAnswer->choice = $request->trainer_question1;
                $QuestionAnswer->save();
            }
            if (isset($request->trainer_question2)) {
                $QuestionAnswer = new QuestionAnswer;
                $QuestionAnswer->user_id = $trainer->id;
                $QuestionAnswer->question = 'question2';
                $QuestionAnswer->choice = $request->trainer_question2;
                $QuestionAnswer->save();
            }
            if (isset($request->trainer_question3)) {
                $QuestionAnswer = new QuestionAnswer;
                $QuestionAnswer->user_id = $trainer->id;
                $QuestionAnswer->question = 'question3';
                $QuestionAnswer->choice = $request->trainer_question3;
                $QuestionAnswer->save();
            }

            if ($request->monday) {
                foreach ($request->monday as $time) {
                    if ($time) {
                        $time = explode('-', $time);
                        $start_time = $time[0];
                        $end_time = $time[1];

                        $timetable = new TrainerTimetable();
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
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
                        $timetable->trainer_id = $trainer->id;
                        $timetable->day = 'sunday';
                        $timetable->start_time = $start_time;
                        $timetable->end_time = $end_time;
                        $timetable->save();
                    }
                }
            }

            $trainer->save();

            $viewData['title'] = 'Ebbsey Account Confirmation';
            $viewData['link'] = url('verify_email') . '/' . $activate_code;
            $viewData['full_name'] = $trainer->first_name;
            $viewData['user_email'] = $trainer->email;
            $viewData['activate_code'] = $activate_code;
            $viewData['message_text'] = "Thank you for signing up for your new account at Ebbsey. Follow the link below to confirm your account";

            Mail::send('email.email_verification_success', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL'), 'Ebbsey');
                $m->to($email)->subject('Confirm your account registration');
            });

            $message = 'Account created successfully,check your email to verify your account!';
            return Response::json(array('status' => 'success', 'user_id' => $trainer->id, 'title' => 'Ebbsey | Trainer Signup', 'message' => $message));
        } catch (\Exception $e) {
            return Response::json(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    public function verifyEmail($key) {

        $user_record = User::where('activation_code', $key)->first();
        if ($user_record) {
            $data = array('is_verified' => 1, 'activation_code' => '');
            if (User::where('activation_code', $key)->update($data)) {
                $data['message_text'] = 'Your account has been successfully verified.';
                $data['full_name'] = $user_record->first_name;
                return view('email/email_verification_success', $data);
            }
            $data['message_text'] = 'Sorry ! there are some errors please try again later';
            return view('email/email_verification_success', $data);
        }
        $data['message_text'] = 'Sorry activation link has expired';
        $data['title'] = 'Ebbsey Account Confirmation';
        return view('email/email_verification_success', $data);
    }

    function postLogin(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:191',
                    'password' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $remember_password = FALSE;
        if ($request->remember_password) {
            $remember_password = TRUE;
        }
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember_password)) {
            $user = Auth::User();

            if ($user && $user->is_verified == 0) {
                $error_message = 'Please verify your account from your email !';
                Session::flash('error', $error_message);
                Auth::guard('user')->logout();
                return Redirect::to('/login')->withInput();
            }

            if ($user && $user->is_approved_by_admin == 0) {

                if ($user->user_type == 'trainer') {

                    $documents = $user->trainerDocuments;

                    $is_image_not_responded_by_admin = 0;
                    if ($user->is_image_approved_by_admin == 0) {
                        $is_image_not_responded_by_admin = 1;
                    }
                    $are_documents_not_responded_by_admin = $documents->filter(function ($item, $key) {
                        return $item->is_approved_by_admin == 0;
                    });

                    if ($is_image_not_responded_by_admin || $are_documents_not_responded_by_admin->count()) {
                        $error_message = 'Your account in not activated';
                        Session::flash('error', $error_message);
                        Auth::guard('user')->logout();
                        return Redirect::to('/login')->withInput();
                    }

                    $is_image_disapproved = 0;
                    if ($user->is_image_approved_by_admin == 2) {
                        $is_image_disapproved = 1;
                    }

                    $dispproved_documents = $documents->filter(function ($item, $key) {
                        return $item->is_approved_by_admin == 2;
                    });
                    if ($is_image_disapproved || $dispproved_documents->count()) {
                        return Redirect::to('update_image_and_documents');
                    }
                }

                $error_message = 'You Account is not activated!';
                Session::flash('error', $error_message);
                Auth::guard('user')->logout();
                return Redirect::to('/login')->withInput();
            }

            if ($user && $user->is_approved_by_admin == 2) {
                $error_message = 'You Account has been blocked for 1 month!';
                Session::flash('error', $error_message);
                Auth::guard('user')->logout();
                return Redirect::to('/login')->withInput();
            }

            $last_login = new LastLogin();
            $last_login->user_id = Auth::id();
            $last_login->login_time = date('Y-m-d H:i:s');
            $last_login->login_date = date('Y-m-d');
            $last_login->save();
            $request->session()->put('last_login_id', $last_login->id);
            $user->last_login = Carbon::now();
            $user->save();
            if ($user->user_type == 'user') {
                return Redirect::to('/user-profile');
            } else {
                return Redirect::to('/trainer-profile');
            }
        } else {
            $error_message = 'Invalid Email Or Password!';
            Session::flash('error', $error_message);
            return Redirect::to('/login')->withInput();
        }
    }

    function updateImageAndDocumentsView() {
        $data['title'] = 'Ebbsey | Update Image and Documents';
        $user = Auth::User();
        $is_image_disapproved = 0;
        if ($user->is_image_approved_by_admin == 2) {
            $is_image_disapproved = 1;
        }
        $data['is_image_disapproved'] = $is_image_disapproved;
        $documents = $user->trainerDocuments;
        $dispproved_documents = $documents->filter(function ($item, $key) {
            return $item->is_approved_by_admin == 2;
        });
        $data['dispproved_documents'] = $dispproved_documents;
        $documents = [];
        $data['training_type_ids'] = array_unique($dispproved_documents->pluck('type_id')->toArray());
        $data['disapproved_documents_names'] = $dispproved_documents->pluck('file')->toArray();
        foreach ($data['training_type_ids'] as $id) {
            $arr[$id]['cvs'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'cv', 'type_id' => $id])
                            ->pluck('file')->implode(',');
            $arr[$id]['certificates'] = TrainerDocument::where(['trainer_id' => $user->id, 'document_type' => 'certification', 'type_id' => $id])
                            ->pluck('file')->implode(',');
            $documents = $documents + $arr;
        }
        $data['documents'] = $documents;
        return view('user.update_image_and_documents', $data);
    }

    function updateImageAndDocuments(Request $request) {
//        dd($request->all());
        $user = Auth::User();
        $is_image_updated = 0;
        $is_document_updated = 0;
        if ($request->profile_pic) {
            $is_image_updated = 1;
            $user->image = $request->profile_pic;
            $user->original_image = $request->original_image;
            $user->is_image_approved_by_admin = 0;
        }
        $trainer_types = $request->trainer_type;
        if (!empty($request->disapproved_document_ids)) {
            TrainerDocument::whereIn('id', $request->disapproved_document_ids)->where('is_approved_by_admin', 2)->delete();
        }
        if ($request->certificates) {
            $is_document_updated = 1;
            $trainer_certificates = $request->certificates;
            foreach ($trainer_certificates as $key => $certificates) {
                if ($certificates) {
                    if (array_search($key, $trainer_types)) {
                        $certificates = explode(',', $certificates);
                        foreach ($certificates as $file) {
                            if (!TrainerDocument::where('file', $file)->first()) {
                                $trainer_type_id = $key;
                                $TrainerTrainingType = new TrainerDocument;
                                $TrainerTrainingType->trainer_id = $user->id;
                                $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
                                $TrainerTrainingType->document_type = 'certification';
                                $TrainerTrainingType->type_id = $trainer_type_id;
                                $TrainerTrainingType->is_approved_by_admin = 0;
                                $TrainerTrainingType->save();
                            }
                        }
                    }
                }
            }
        }
        if ($request->cv) {
            $is_document_updated = 1;
            $trainer_cv = $request->cv;
            foreach ($trainer_cv as $key => $cvs) {
                if ($cvs) {
                    if (array_search($key, $trainer_types)) {
                        $cvs = explode(',', $cvs);
                        foreach ($cvs as $file) {
                            if (!TrainerDocument::where('file', $file)->first()) {
                                $trainer_type_id = $key;
                                $TrainerTrainingType = new TrainerDocument;
                                $TrainerTrainingType->trainer_id = $user->id;
                                $TrainerTrainingType->file = str_replace('public/documents/', '', $file);
                                $TrainerTrainingType->document_type = 'cv';
                                $TrainerTrainingType->type_id = $trainer_type_id;
                                $TrainerTrainingType->is_approved_by_admin = 0;
                                $TrainerTrainingType->save();
                            }
                        }
                    }
                }
            }
        }

        //Notification to admin on changed image 
        $cu_user =User::find(Auth::id());
        $viewData['mr'] = 'Hello';
        $viewData['username'] = 'Team Ebbsey';
        $viewData['title'] = 'Profile Update'; 
        $viewData['para_one'] = $cu_user->first_name.' Update his profile Please Review it.';
        $email_to = 'info@ebbsey.com';
//        $email_to = 'codingpixel.test3@gmail.com';
        Mail::send('email.confirmation', $viewData, function ($m) use ($email_to) {
            $m->from(env('FROM_EMAIL', 'Profile Update'), 'Ebbsey');
            $m->to($email_to)->subject('Profile Update');
        });
        
        if (!empty($trainer_types)) {
            TrainerTrainingType::where('trainer_id', $user->id)->whereNotIn('training_type_id', $trainer_types)->delete();
        }
        $user->save();
        $msg = 'Image and documents are updated';
        if ($is_image_updated && $is_document_updated) {
            $msg = 'Image and documents are updated';
        } else if ($is_image_updated && !$is_document_updated) {
            $msg = 'Image is updated';
        } else if (!$is_image_updated && $is_document_updated) {
            $msg = 'Documents are updated';
        }
        Session::flash('success', $msg);
        Auth::guard('user')->logout();
        return Redirect::to('/login')->withInput();
    }

    function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|exists:users|max:191',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $random_number = rand(1000, 9999);
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user->phone) {
                $phone = $user->phone;
                $message_body = $random_number . " is your Ebbsey password reset code.";
                sendSms($phone, $message_body);
                $last_digits = substr($phone, -4);
                $data['title'] = 'Ebbsey | Forgot Password';
                $data['last_digits'] = $last_digits;
                $data['email'] = $email;
                $data['code'] = $random_number;
                $data['code_sent'] = 1;
                $user->reset_password_code = $random_number;
                $user->save();
                return view('public.forgetpassword', $data);
            } else {
                return Redirect::back()->with('number_error', 'This account doesn\'t have any phone number');
            }
        }
    }

    function checkCode(Request $request) {
        $email = $request->email;
        $code = $request->code;
        $user_entered_code = $request->code;
        $user = User::where('email', $email)->first();
        $password_reset_code = $user->reset_password_code;
        if ($user_entered_code == $password_reset_code) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'code changed'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'error message'
            ));
        }
    }

    function confirmCode(Request $request) {
        $email = $request->email;
        $user_entered_code = $request->password_code;
        $user = User::where('email', $email)->first();
        $password_reset_code = $user->reset_password_code;
        if ($user_entered_code == $password_reset_code) {
            $data['this_user_id'] = $user->id;
            $data['title'] = 'Ebbsey | Forgot Password';
            return redirect('/change-password')->with($data);
        } else {
            return Redirect::back()->with('code_error', 'Wrong code input!');
        }
    }

    function changePasswordView() {
        $data['user_id'] = Session::get('this_user_id');
        $data['title'] = 'Ebbsey | Set Password';
        return view('public.change-password', $data);
    }

    function changePassword(Request $request) {
        if (isset($request->user_id)) {
            $validator = Validator::make($request->all(), [
                        'password' => 'required|min:6|confirmed',
                        'password_confirmation' => 'required|min:6'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                        'email' => 'required|email|exists:users|max:191',
                        'password' => 'required|min:6|confirmed',
                        'password_confirmation' => 'required|min:6'
            ]);
        }
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $user_id = $request->user_id;
            if ($user_id) {
                $user = User::where('id', $user_id)->first();
            } else {
                $user = User::where('email', $request->email)->first();
            }
            $old_password = $user->password;
            $new_password = bcrypt($request->password);
            if ($old_password == $new_password) {
                $error_message = 'New password should be different!';
                Session::flash('error', $error_message);
                return Redirect::back();
            }

            $password = $request->password;
            $user->password = bcrypt($password);
            $user->save();
            Session::flash('success', 'Password changed successfully!');
            return Redirect::to('/login');
        }
    }

    function userLogout(Request $request) {
        if (Auth::user()) {
            $user = Auth::User();

//             $timezone = new DateTimeZone('UTC');
//                $end_date = new DateTime($end_date, new DateTimeZone($request['user_timezone']));
//                $end_date->setTimeZone(new DateTimeZone('UTC'));
//                $end_date = $end_date->format('Y-m-d H:i:s');

            if ($request->session()->get('last_login_id')) {
                $last_login_id = $request->session()->get('last_login_id');
                $last_login = LastLogin::find($last_login_id);
                $last_login->logout_time = date('Y-m-d H:i:s');
                $last_login->save();
            }

            Auth::guard('user')->logout();
        }
        return Redirect::to('/');
    }

    function validateTimeTableSlots(Request $request) {
        $type = $request->type;
        $allowedDuration = '60';
        if ($type && $type == 'class') {
            $allowedDuration = $request->class_duration;
        }
        $selected_time = explode('-', $request->selected_value);
        $start_time = $selected_time[0];
        $end_time = $selected_time[1];

        $start_time_backup = $start_time;
        $end_time_backup = $end_time;

        $start_time = DateTime::createFromFormat('g:i A', $start_time);
        $end_time = DateTime::createFromFormat('g:i A', $end_time);

        $start_time_limit = DateTime::createFromFormat('g:i A', '5:30 AM');
        $end_time_limit = DateTime::createFromFormat('g:i A', '9:30 PM');

        $day_name = $request->day_name;

        if ($day_name == 'saturday' || $day_name == 'sunday') {
            $start_time_limit = DateTime::createFromFormat('g:i A', '7:00 AM');
            $end_time_limit = DateTime::createFromFormat('g:i A', '10:30 PM');

            if ($start_time < $start_time_limit || $end_time_limit < $end_time) {
                return response()->json(array('error' => 'Time slot must be between 7:00 AM - 10:30 PM'));
            }
        }

        if ($start_time < $start_time_limit || $end_time_limit < $end_time) {
            return response()->json(array('error' => 'Time slot must be between 5:30 AM - 9:30 PM'));
        }

        if ($start_time > $end_time) {
            return response()->json(array('error' => 'Start time must be less than end time'));
        }

//        $difference = $start_time->diff($end_time)->format('%H:%I:%S');
        $difference = (strtotime($end_time_backup) - strtotime($start_time_backup)) / 60;

        if ($difference < $allowedDuration) {
            return response()->json(array('error' => 'The difference between start time and end time must be atleast ' . $allowedDuration . ' minutes'));
        }
        if ($request->times) {
            foreach ($request->times as $time) {
                $time = explode('-', $time);

                $start_time_other = $time[0];
                $end_time_other = $time[1];

                $start_time_other = DateTime::createFromFormat('g:i A', $start_time_other);
                $end_time_other = DateTime::createFromFormat('g:i A', $end_time_other);

                if ($start_time == $start_time_other || $start_time == $end_time_other) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($start_time > $start_time_other && $start_time < $end_time_other) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($end_time == $start_time_other || $end_time == $end_time_other) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($end_time > $start_time_other && $end_time < $end_time_other) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($start_time_other == $start_time || $start_time_other == $end_time) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($start_time_other > $start_time && $start_time_other < $end_time) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($end_time_other == $start_time || $end_time_other == $end_time) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                } else if ($end_time_other > $start_time && $end_time_other < $end_time) {
                    return response()->json(array('error' => 'This slot time is conflicting with another slot\'s time'));
                }
            }
        }
        return response()->json(array('success' => 'success'));
    }

    function addGalleryImages(Request $request) {
//        $validator = Validator::make($request->all(), [
//                        'gallery_images' => 'dimensions:min_width=700,min_height=700,ratio=1/1'
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['error' => 'Image must have 700x700 resolution at minumum and must be a square image.']);
//        }
        $images = $request['gallery_images'];
        $check = $this->addGalleryImage($images, $request->is_original_image_required);
        if ($check) {
            return json_encode($check);
        }
    }

    function addGalleryImage($file, $is_original_image_required = null) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png') {
                    $destination_path = 'public/images/users'; // upload path
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $resizedFileName = 'trainer_gallery_' . uniqid() . '.' . $extension; // renameing image
                    $img = Image::make($file->getRealPath());
                    $img->orientate();
                    $size = $img->filesize();
                    if ($size > 2000) {
                        $height = $img->height();
                        $get_width = $img->width() / 720;
                        $new_height = $height / $get_width;
                        $img->resize(720, $new_height)->save($destination_path . '/' . $resizedFileName);
                    }
                    if ($is_original_image_required) {
                        $fileName = 'trainer_gallery_' . uniqid() . '.' . $extension; // renameing image
                        $file->move($destination_path, $fileName);
                        $data['original_image_path'] = 'users/' . $fileName;
                    }
                    $data['complete_path'] = asset('public/images/users/' . $resizedFileName);
                    $data['path'] = 'users/' . $resizedFileName;
                    return $data;
                }
            }
        }
    }

    function addDocuments(Request $request) {
        $documents = $request['documents'];
        $file_category = $request['file_category'];
        $check = $this->addDocument($documents, $file_category);
        if ($check) {
            return json_encode($check);
        }
    }

    function addDocument($file, $file_category) {
        if ($file) {
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();
                if ($type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    $type = 'application/docx';
                }
                if ($file_category == 'certificates') {

                    if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'application/pdf' || $type == 'application/docx') {
                        $destination_path = 'public/documents/certificates'; // upload path
                        $extension = $file->getClientOriginalExtension(); // getting image extension
                        $fileName = 'certificate_' . Str::random(15) . '.' . $extension; // renameing image
                        $file->move($destination_path, $fileName);
                        $file_type = explode('/', $type);

                        if ($file_type[0] == 'image') {
                            $data['file_type'] = $file_type[0];
                        } else {
                            $data['file_type'] = $file_type[1];
                        }
                        $data['complete_path'] = asset('public/documents/certificates/' . $fileName);
                        $data['path'] = 'public/documents/certificates/' . $fileName;
                        return $data;
                    }
                } else if ($file_category == 'cvs') {

                    if ($type == 'application/pdf' || $type == 'application/docx') {
                        $destination_path = 'public/documents/cv'; // upload path
                        $extension = $file->getClientOriginalExtension(); // getting image extension
                        $fileName = 'cv_' . Str::random(15) . '.' . $extension; // renameing image
                        $file->move($destination_path, $fileName);
                        $file_type = explode('/', $type);
                        $data['file_type'] = $file_type[1];
                        $data['complete_path'] = asset('public/documents/cv/' . $fileName);
                        $data['path'] = 'public/documents/cv/' . $fileName;
                        return $data;
                    }
                }
            }
        }
    }

    function deleteDocument(Request $request) {
        $file = $request['path'];
        TrainerDocument::where('file', $file)->delete();
        if (unlink(base_path($file))) {
            return Response::json(array('status' => 'success'));
        } else {
            return Response::json(array('status' => 'error'));
        }
    }

    function deleteTrainerPic(Request $request) {
        $file = $request['path'];
        TrainerImage::where('path', $file)->delete();
        if (unlink(base_path('public/images/' . $file))) {
            return Response::json(array('status' => 'success'));
        } else {
            return Response::json(array('status' => 'error'));
        }
    }

    function resendVerificationEmailView() {
        $data['title'] = 'Ebbsey | Resend Verification Email';
        return view('public.resend_verification_email', $data);
    }

    function resendVerificationEmail(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return Redirect::back()->withInput()->withErrors(['email' => 'Invalid Email']);
        }
        if ($user->is_verified) {
            return Redirect::back()->withInput()->withErrors(['email' => 'Email is already verified']);
        }
        $viewData['title'] = 'Ebbsey Account Confirmation';
        $activate_code = Str::random(15);
        $viewData['link'] = url('verify_email') . '/' . $activate_code;
        $viewData['full_name'] = $user->first_name;
        $viewData['user_email'] = $user->email;
        $viewData['activate_code'] = $activate_code;
        $viewData['message_text'] = "Thank you for signing up for your new account at Ebbsey. Follow the link below to confirm your account";

        $email = $user->email;
        $user->activation_code = $activate_code;
        $user->save();
        Mail::send('email.email_verification_success', $viewData, function ($m) use ($email) {
            $m->from(env('FROM_EMAIL'), 'Ebbsey');
            $m->to($email)->subject('Confirm your account registration');
        });
        Session::flash('success', 'Verification email sent again, check your email to verify your account!');
        return Redirect::back();
    }

}
