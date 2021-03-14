<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
Route::get('/', 'PublicController@index');

Route::get('check_stripe_balance', function(){
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    dd(\Stripe\Balance::retrieve());
});

Route::get('/email_test', function () {

    $viewData = [];
    $email = 'codingpixel1716@gmail.com';
    $viewData['price'] = 1212;
    $viewData['contact_content'] = '121212';
    $viewData['contact_name'] = '121212';
    $viewData['contact_email'] = '121212';
    $email = 'codingpixel1716@gmail.com';

    Mail::send('email.contact_us', $viewData, function ($m) use ($email) {
        $m->from('info@ebbsey.com', 'Ebbsey');
        $m->to($email)->subject('Class Summery');
    });
    if (Mail::failures()) {
        echo "failed";
    }
});

Route::get('google_matrix_api_testing', function() {
    $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
    dd($location);
    dd(get_nearest_timezone($location->latitude, $location->longitude, $location->country_code));
    $obj = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=Washington,DC&destinations=New+York+City,NY&&mode=driving&sensor=false&key=' . env('GOOGLE_API_KEY')));
    $status = $obj->status;
    $distance = $obj->rows[0]->elements[0]->distance;
    $duration = $obj->rows[0]->elements[0]->duration;
    dd($status);
});

Route::get('expire_pending_appointments_cron', 'PublicController@expirePendingAppointmentsCron');
Route::get('complete_appointments_cron', 'PublicController@completeAppointmentsCron');
Route::get('complete_class_cron', 'PublicController@completeClassCron');
Route::get('session_reminder_cron', 'PublicController@sessionReminderCron');
Route::get('classSummery', 'PublicController@classSummery');
Route::get('weekly_payout_cron', 'PublicController@weeklyPayoutCron');
Route::get('charge_pending_referred_sessions_cron', 'PublicController@chargePendingReferredSessionsCron');
Route::get('expire_passes_cron', 'PublicController@expirePassesCron');

Route::get('/join-now', function () {
    if (Auth::guard('user')->check()) {
        return redirect('/');
    }
    $data['title'] = 'Ebbsey | Welcome';
    return view('public.welcome', $data);
});
Route::get('thank_you', function () {
    $data['title'] = 'Ebbsey | Thank You';
    return view('public.thank_you', $data);
});

Route::get('/page/{slug}', 'PublicController@getPage');

//Register Section start
//for clients/user
Route::get('/user-register', 'AuthController@userRegisterView');
Route::post('/user-register-basic', 'AuthController@userRegisterBasic');
Route::post('/user-register-fitnessgoals', 'AuthController@userRegisterFitnessGoals');
Route::get('/user-register-fitnessgoals', 'AuthController@userRegisterFitnessGoals');

Route::post('/user-register-full', 'AuthController@userRegister');
Route::get('/user-register-full', 'AuthController@userRegister');

//for trainers
Route::get('/check_email', 'AuthController@checkEmail');
Route::get('/trainer-register', 'AuthController@trainerRegisterView');
Route::post('/trainer-register-basic', 'AuthController@trainerRegisterBasic');
Route::post('/trainer-register-qualifications', 'AuthController@trainerRegisterQualifications');
Route::post('/trainer-register-full', 'AuthController@trainerRegister');
Route::get('/verify_email/{key}', 'AuthController@verifyEmail');
//Register Section end
//Login Section start
Route::get('/login', function () {
    if (Auth::guard('user')->check()) {
        return redirect('/');
    }
    $data['title'] = 'Ebbsey | Login';
    return view('public.login', $data);
});
Route::post('/login', 'AuthController@postLogin');
//Login Section end
//Logout 
Route::get('user-logout', 'AuthController@userLogout');

//Forget password start
Route::get('/forgot-password', function () {
    if (Auth::guard('user')->check()) {
        return redirect('/');
    }
    $data['title'] = 'Ebbsey | Forgot Password';
    return view('public.forgetpassword', $data);
});
Route::get('resend_verification_email', 'AuthController@resendVerificationEmailView');
Route::post('resend_verification_email', 'AuthController@resendVerificationEmail');
Route::post('forgot-password', 'AuthController@forgotPassword');
Route::post('check-code', 'AuthController@checkCode');
Route::post('confirm-code', 'AuthController@confirmCode');
Route::get('/change-password', 'AuthController@changePasswordView');
Route::post('/change-password', 'AuthController@changePassword');
//Forget password end

Route::get('profile/{id}', 'PublicController@profile');
Route::get('/trainer-public-profile/{id}', 'PublicController@trainerPublicProfile');
Route::post('validate_timetable_slot', 'AuthController@validateTimeTableSlots');
Route::post('add_gallery_images', 'AuthController@addGalleryImages');
Route::post('add_documents', 'AuthController@addDocuments');
Route::post('delete_document', 'AuthController@deleteDocument');
Route::post('delete_trainer_pic', 'AuthController@deleteTrainerPic');

Route::get('ajax_search', 'SearchController@ajaxSearch');

Route::group(['middleware' => ['nocache']], function () {
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    $date = time();
    header("Expires: $date");

    Route::get('/login', function () {
        if (Auth::guard('user')->check()) {
            return redirect('/');
        }
        $data['title'] = 'Ebbsey | Login';
        return view('public.login', $data);
    });

    Route::get('search', 'SearchController@search');
});
//    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

Route::group(['middleware' => ['nocache', 'auth']], function () {

    Route::get('update_image_and_documents', 'AuthController@updateImageAndDocumentsView');
    Route::post('update_image_and_documents', 'AuthController@updateImageAndDocuments');

    Route::group(['middleware' => ['checkIfApproved']], function () {
        Route::post('getAvailableTimeSlots', 'UserController@getAvailableTimeSlots');
        Route::post('update_appointment_schedule', 'UserController@updateAppointmentSchedule');

        Route::group(['middleware' => ['checkUser']], function () {

            Route::get('user-profile', 'UserController@userProfileView');
            Route::get('/edit-user-profile', 'UserController@editUserView');
            Route::post('/edit-user-profile', 'UserController@editUser');

            //  Booking routes
            Route::get('/booking/{id}', 'UserController@booking');
            Route::post('/create_booking', 'UserController@createBooking');

//        Route::get('get_passes', 'UserController@getPassesView');
            Route::post('get_passes', 'UserController@getPasses');
            Route::post('save_response', 'UserController@saveResponse');


            Route::post('/delete_appointment', 'UserController@responseAppointment');
            Route::post('/cancel_class_request', 'UserController@cancelAppointmentClass');

            Route::post('get_available_time_slots_of_trainer', 'UserController@getAvailableTimeSlotsOfTrainer');
            Route::post('get_available_time_slots_of_class', 'UserController@getAvailableTimeSlotsOfClass');

            Route::post('check_morning_time', 'UserController@checkMorningTime');

            Route::post('/cancel_before_time', 'UserController@cancelBeforeTime');
            Route::post('/cancel_in_due_time', 'UserController@cancelInDueTime');

            Route::post('validate_coupon_code', 'UserController@validateCouponCode');
            Route::post('deduct_passes_count_from_coupon', 'UserController@deductPassesCountFromCoupon');
            Route::post('validate_referral_code', 'UserController@validateReferralCode');
        });

        Route::group(['middleware' => ['checkTrainer']], function () {

            Route::get('/trainer-profile', 'UserController@trainerProfileView');
            Route::get('/edit-trainer-profile', 'UserController@editTrainerView');
            Route::post('/edit-trainer-profile', 'UserController@editTrainer');
            Route::get('bank_tab', 'UserController@openBankTab');
            
            Route::get('earning_history', 'UserController@earningHistoryView');

            Route::post('/calcute_distance_ajax', 'UserController@calcuteDistanceAjax');
            Route::post('/reffer_to', 'UserController@refferTo');
            Route::get('/appointments', 'UserController@appointments');
            Route::post('/confirm_appointment', 'UserController@confirmAppointment');

            //Classes route
            Route::group(['middleware' => ['checkBankVerification']], function () {
                Route::get('/create_class/{id?}', 'UserController@createClass');
                Route::post('/create_class', 'UserController@postCreateClass');
            });

            Route::get('/classes', 'UserController@classes');

            Route::post('save_bank_account_legal_details', 'PaymentController@saveBankAccountLegalDetails');
            Route::post('save_bank_account', 'PaymentController@saveBankAccount');

            Route::post('add_gallery_images_ajax', 'UserController@addGalleryImagesAjax');
            Route::post('add_trainer_profile_pic_ajax', 'UserController@addTrainerProfilePicAjax');
            Route::post('delete_trainer_pic_ajax', 'UserController@deleteTrainerPicAjax');
            Route::post('add_documents_ajax', 'UserController@addDocumentsAjax');
            Route::post('search_tranner_ajax', 'UserController@searchTrannerAjax');

            Route::get('withdraw_cash', 'PaymentController@withDrawCash');

            Route::get('stripe_redirect_uri', 'PaymentController@stripeRedirectUri');
        });

        Route::post('check_for_distance_range', 'UserController@checkForDistanceRange');

        Route::get('/session_detail/{id}', 'UserController@sessionDetail');

        Route::post('/delete_item', 'UserController@deleteItem');

        Route::get('/class-view/{id}', 'UserController@classView');

//Booking Session Routes
        Route::get('booked_session/{id?}', 'UserController@bookedSession');
        Route::get('booking-session/{id?}', 'UserController@bookingSession');
        Route::post('book_session', 'UserController@bookSession');


//Messages Section
        Route::get('/read_messages', 'ChatController@readMessages');
        Route::get('make_appointments_seen_for_trainer', 'UserController@makeAppointmentsSeenForTrainer');

        Route::get('/messages', 'ChatController@getMessages');
        Route::get('/get_chat_data', 'ChatController@getChatData');
        Route::post('/add_message', 'ChatController@addMessage');
        Route::post('verify_message_request', 'ChatController@verifyMessageRequest');

        Route::post('change_password', 'UserController@changePassword');
        Route::post('/response_appointment', 'UserController@responseAppointment');

        Route::get('/order_card', 'UserController@orderCardView');
        Route::post('/order_card_ajax', 'UserController@postOrderCard');

        //Google Calendar Sync
        Route::post('sync_google_calendar', 'UserController@syncGoogleCalendar');
        Route::get('save_google_access_token', 'UserController@saveGoogleAccessToken');
    }); //End auth MiddleWare
}); //End auth MiddleWare

Route::post('/get_shot_time', 'PublicController@getShotTime');
Route::post('/order_card_signup_ajax', 'PublicController@postOrderCard');
//Feedback routes
Route::get('feedback/{id}', 'PublicController@feedbackView');
Route::post('feedback', 'PublicController@feedback');

//Route::get('get_message_reply', 'PublicController@getMessageReply');
Route::post('message_reply', 'PublicController@messageReply');
Route::post('message_fail', 'PublicController@messageFail');


//Admin section
Route::get('admin_login', 'Admin\AuthController@loginView');
Route::post('admin_login', 'Admin\AuthController@login');


Route::group(['middleware' => ['checkAdmin', 'nocache']], function () {

    Route::get('admin_dashboard', 'Admin\AdminController@dashboard');

    //Blogs
    Route::get('delete_blog_admin/{id}', 'Admin\AdminController@delete_blogs');
    Route::get('blog_admin', 'Admin\AdminController@blogs');
    Route::get('add_blog_admin/{id?}', 'Admin\AdminController@addBlog');
    Route::post('postBlog', 'Admin\AdminController@postBlog');

    Route::get('users_admin', 'Admin\AdminController@users');
    Route::get('trainers_admin', 'Admin\AdminController@trainers');
    Route::post('feature_trainer', 'Admin\AdminController@featureTrainer');
    Route::post('delete_user_admin', 'Admin\AdminController@deleteUser');
    Route::get('class_detail_admin/{user_id}', 'Admin\AdminController@classDetailView');
    Route::get('user_detail_admin/{user_id}', 'Admin\AdminController@userDetail');
    Route::get('activateTranner/{user_id}', 'Admin\AdminController@activateTranner');
    Route::post('change_status', 'Admin\AdminController@changeStatus');

    Route::get('all_session', 'Admin\AdminController@allSessions');
    Route::get('all_classes', 'Admin\AdminController@allClasses');
    Route::get('all_classes_appointments', 'Admin\AdminController@allClassesAppointments');
    Route::post('feature_class', 'Admin\AdminController@featureClass');
    
    Route::post('refund_appointment_admin', 'Admin\AdminController@refundAppointment');

    Route::get('trainer_approvals', 'Admin\AdminController@trainerApprovalRequests');
    Route::post('deny_trainer_request', 'Admin\AdminController@denyTrainer');
    Route::post('approve_trainer', 'Admin\AdminController@approveTrainer');

    Route::get('admin_approve_image/{trainer_id}', 'Admin\AdminController@trainerImageApproval');
    Route::get('admin_approve_cv/{trainer_id}', 'Admin\AdminController@trainerCVApproval');
    Route::get('admin_approve_certificates/{trainer_id}', 'Admin\AdminController@trainerCertificatesApproval');

    Route::get('admin_deny_image/{trainer_id}', 'Admin\AdminController@trainerImageDenial');
    Route::get('admin_deny_cv/{trainer_id}', 'Admin\AdminController@trainerCVDenial');
    Route::get('admin_deny_certificates/{trainer_id}', 'Admin\AdminController@trainerCertificatesDenial');

    Route::get('class_types', 'Admin\AdminController@addClassTypeView');
    Route::post('add_class_type', 'Admin\AdminController@addClassType');
    Route::get('edit_class_type/{id}', 'Admin\AdminController@editClassTypeView');
    Route::post('edit_class_type', 'Admin\AdminController@editClassType');
    Route::post('delete_class_type', 'Admin\AdminController@deleteClassType');

    Route::get('fitness_goals_admin', 'Admin\AdminController@fitnessGoalView');
    Route::post('add_fitness_goal', 'Admin\AdminController@addFitnessGoal');
    Route::get('edit_fitness_goal/{id}', 'Admin\AdminController@editFitnessGoalView');
    Route::post('edit_fitness_goal', 'Admin\AdminController@editFitnessGoal');
    Route::post('delete_fitness_goal', 'Admin\AdminController@deleteFitnessGoal');

    Route::get('view_order_detail/{id}', 'Admin\AdminController@view_order_detail');
    Route::post('deleteOrder', 'Admin\AdminController@deleteOrder');
    Route::post('fitness_goal_approval', 'Admin\AdminController@fitnessGoalApproval');

    Route::get('specializations_admin', 'Admin\AdminController@specializationsView');
    Route::post('add_specialization', 'Admin\AdminController@addSpecialization');
    Route::get('edit_specialization/{id}', 'Admin\AdminController@editSpecializationView');
    Route::post('edit_specialization', 'Admin\AdminController@editSpecialization');
    Route::post('delete_specialization', 'Admin\AdminController@deleteSpecialization');
    Route::post('specializations_admin_approval', 'Admin\AdminController@specializationApproval');

    Route::get('training_types_admin', 'Admin\AdminController@trainingTypesView');
    Route::post('add_training_type', 'Admin\AdminController@addTrainingType');
    Route::get('edit_training_type/{id}', 'Admin\AdminController@editTrainingTypeView');
    Route::post('edit_training_type', 'Admin\AdminController@editTrainingType');
    Route::post('delete_training_type', 'Admin\AdminController@deleteTrainingType');
    Route::post('/change_training_type_status', 'Admin\AdminController@changeTrainingTypeStatus');

    Route::get('qualifications_admin', 'Admin\AdminController@qualificationsView');
    Route::post('add_qualification', 'Admin\AdminController@addQualification');
    Route::get('edit_qualification/{id}', 'Admin\AdminController@editQualificationView');
    Route::post('edit_qualification', 'Admin\AdminController@editQualification');
    Route::post('delete_qualification', 'Admin\AdminController@deleteQualification');
    Route::post('qualification_admin_approval', 'Admin\AdminController@qualificationApproval');

    Route::get('business_cards_orders', 'Admin\AdminController@bsinessCardsOrdersView');
    Route::post('cards_order_status', 'Admin\AdminController@bsinessCardsOrderStatus');

    Route::get('pass_price', 'Admin\AdminController@passPriceView');
    Route::post('pass_price', 'Admin\AdminController@passPriceUpdate');

    Route::get('reviews', 'Admin\AdminController@reviewsView');

    Route::get('feedbacks', 'Admin\AdminController@feedbacksView');

    Route::get('class_gallery', 'Admin\AdminController@classGalleryView');
    Route::post('add_image', 'Admin\AdminController@uploadGalleryImage');
//    Route::delete('class-gallery/{id}', 'Admin\AdminController@destroy');
    Route::post('delete_image', 'Admin\AdminController@deleteGalleryImage');

    Route::get('change_password_admin', 'Admin\AdminController@changePasswordView');
    Route::post('change_password_admin', 'Admin\AdminController@changePassword');

    Route::get('logout_admin', 'Admin\AdminController@logout');

    Route::get('/add_pages/{edit_id?}', 'Admin\AdminController@addPage');
    Route::post('/add_pages', 'Admin\AdminController@postPage');
    Route::get('manage_pages', 'Admin\AdminController@managePage');

    Route::get('coupons', 'Admin\AdminController@coupons');
    Route::get('coupons_discount', 'Admin\AdminController@couponsDiscount');
    Route::get('delete_coupon/{id}', 'Admin\AdminController@deleteCoupon');
    Route::get('delete_coupon_discount/{id}', 'Admin\AdminController@deleteCouponDiscount');
    Route::post('edit_coupon_discount', 'Admin\AdminController@editCouponDiscount');
    Route::get('add_coupon_admin', 'Admin\AdminController@addCouponView');
    Route::post('add_coupon_admin', 'Admin\AdminController@addCoupon');
    Route::post('add_coupon_discount_admin', 'Admin\AdminController@addCouponDsicount');
});

//Route::get('/',  function() { return view('public/index'); });
//Route::get('welcome',  function() { return view('public/welcome');  });
//Route::get('forgetpassword',  function() { return view('public/forgetpassword');  });
//Route::get('user_login',  function() { return view('public/useraccount');  });

Route::get('/assets', function () {
    $data['title'] = 'Ebbsey | Assets';
    return view('public.assets', $data);
});
Route::get('/custom-orderform1', function () {
    $data['title'] = 'Ebbsey | Custom Order Form 1';
    return view('user.customorderform1', $data);
});
Route::get('/custom-orderform2', function () {
    $data['title'] = 'Ebbsey | Custom Order Form 2';
    return view('user.customorderform2', $data);
});
Route::get('/custom-orderform3', function () {
    $data['title'] = 'Ebbsey | Custom Order Form 3';
    return view('user.customorderform3', $data);
});
Route::get('/classdetail', function () {
    $data['title'] = 'Ebbsey | Class Detail';
    return view('user.classdetail', $data);
});
Route::get('/contact', function () {
    $data['title'] = 'Ebssey | Contact';
    return view('public.contact', $data);
});
Route::post('contact', 'PublicController@addContactUs');
Route::get('/about', function () {
    $data['title'] = 'Ebbsey | About';
    return view('public.about', $data);
});
Route::get('/blog', 'PublicController@blog');
Route::get('/blog_detail/{id}', 'PublicController@blogDetail');

Route::get('/custompakage', function () {
    $data['title'] = 'Ebssey | Custom Package';
    return view('public.custompakage', $data);
});

Route::get('/session_summery', function () {
    $data['title'] = 'Ebssey | Custom Package';
    return view('email.welcomeToUser-Copy', $data);
});