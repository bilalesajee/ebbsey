<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use DateTime;
use App\User;
use App\PaymentHistory;
use Stripe\Stripe;
use Stripe\Transfer;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Refund;

class PaymentController extends Controller {

    private $userId;
    private $user;
    private $userName;

    public function __construct() {
        $this->middleware('auth');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        set_time_limit(0);
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function saveBankAccountLegalDetails(Request $request) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = User::where('id', $this->userId)->first();
        $account = \Stripe\Account::retrieve($this->user->stripe_payout_account_id);
        $account->tos_acceptance->date = time();

        $dob = new DateTime($request['dob']);
        $dob = $dob->format('Y-m-d');
        $dob = explode('/', $dob);
        $year = $dob[0];
        $month = $dob[1];
        $day = $dob[2];
        $account->legal_entity->dob->year = $year;
        $account->legal_entity->dob->month = $month;
        $account->legal_entity->dob->day = $day;
        $account->tos_acceptance->ip = \Request::ip();
        $account->legal_entity->first_name = $request['first_name'];
        $account->legal_entity->last_name = $request['last_name'];

        $account->legal_entity->type = 'individual';
        $account->legal_entity->address->state = $request['state'];
        $account->legal_entity->address->city = $request['city'];
        $account->legal_entity->address->line1 = $request['address'];
        $account->legal_entity->address->postal_code = $request['postal_code'];
        $account->legal_entity->ssn_last_4 = $request['ssn_last_4'];
        $account->legal_entity->personal_id_number = $request['ssn'];

        if ($request->hasFile('legal_personal_id_image')) {
            $file = Input::file('legal_personal_id_image');
            $ver_fileName = '';
            if ($file->getClientOriginalExtension() != 'exe') {
                $type = $file->getClientMimeType();

                if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp') {
                    $ver_destinationPath = 'public/images/verification'; // upload path
                    $ver_extension = $file->getClientOriginalExtension(); // getting image extension
                    $ver_fileName = 'profile_' . Str::random(15) . '.' . $ver_extension; // renameing image
                    $img = Image::make($file->getRealPath());
                    $size = $img->filesize();
                    if ($size > 2000) {
                        $height = $img->height();
                        $get_width = $img->width() / 720;
                        $new_height = $height / $get_width;
                        $img->resize(720, $new_height)->save($ver_destinationPath . '/' . $ver_fileName);
                    } else {
                        Input::file('legal_personal_id_image')->move($ver_destinationPath, $ver_fileName);
                    }
                }
//                    echo $_SERVER['DOCUMENT_ROOT'];exit;
                if ($ver_fileName) {
                    $filename = $_SERVER['DOCUMENT_ROOT'] . '/ebbsey/public/images/verification/' . $ver_fileName;
                } else {
                    Session::flash('error', 'Please enter a valid image file');
                    return Redirect::to(URL::previous())->withInput();
                }
//
//            $chmod = 0644;
//            chmod($filename, $chmod);
                $fp = fopen($filename, 'r');

                $stripe_file = \Stripe\FileUpload::create(array(
                            'purpose' => 'identity_document',
                            'file' => $fp
                ));
                $account->legal_entity->verification->document = $stripe_file->id;
            }
        }
        $catchMessage = '';
        try {
            $account->save();
//            Session::flash('error', 'Verification request sent to stripe');
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
        if ($catchMessage) {
            $catchMessage = str_replace('_', ' ', $catchMessage);
            $catchMessage = str_replace('personal id number', 'personal id', $catchMessage);
            Session::flash('error', $catchMessage);
            return Redirect::to(URL::previous())->withInput();
        }

        $updated_status = \Stripe\Account::retrieve($user->stripe_payout_account_id);
        $user->stripe_payout_account_info = json_encode($updated_status);
        $user->save();
        Session::flash('success', 'Your details has been send for verification');
        return Redirect::to('edit-trainer-profile');
    }

    function saveBankAccount(Request $request) {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_payout_account_id);


        $account->external_accounts->create(array(
            "external_account" => $request['stripeToken'],
            "default_for_currency" => true,
        ));
        $updatedaccount = \Stripe\Account::retrieve($user->stripe_payout_account_id);
        $user->stripe_payout_account_info = json_encode($updatedaccount);
        $user->is_bank_account_verified = 1;
        $user->save();
        Session::flash('success', 'Account has been saved');
        return Redirect::to('edit-trainer-profile');
    }

    function withDrawCash() {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            if ($this->user->is_bank_account_verified) {
                $account = $this->user->stripe_payout_account_id;
                if ($account) {
                    $cash = round($this->user->total_cash - 10, 2) * 100;
                    Transfer::create(array(
                        "amount" => $cash,
                        "currency" => "usd",
                        "destination" => $account
                    ));
                    $user = $this->user;
                    $user->total_cash = 0;
                    $user->save();
                    PaymentHistory::where('trainer_id', $this->userId)->update(['is_payout' => 1]);
                    return response()->json(['success' => 'Amount withdrawn successfully!']);
                } else {
                    return response()->json(['error' => 'Please add your bank account before proceeding further!']);
                }
            } else {
                return response()->json(['error' => 'Please verify your bank account before proceeding further!']);
            }
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
        $viewData['trainer_email'] = $this->user->email;
        $viewData['issue'] = $catchMessage;
        Mail::send('email.mail_to_admin', $viewData, function ($m) {
            $m->from(env('FROM_EMAIL', 'Payment Withdrawal Issue'));
            $m->to(env('MAIL_USERNAME'))->subject('Payment Withdrawal Issue');
        });
        return response()->json(['error' => 'Sorry, the amount was not transferred due to some issues. Please contact us for further assistance!']);
    }

    function stripeRedirectUri(Request $request) {
        $code = $request->code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'client_secret' => env('STRIPE_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = json_decode(curl_exec($ch));
        curl_close($ch);

        $account = \Stripe\Account::retrieve($server_output->stripe_user_id);
        $url = $account->login_links->create();

        $user = $this->user;
        $user->stripe_payout_account_id = $server_output->stripe_user_id;
        $user->stripe_express_dashboard_url = $url->url;
        $user->is_bank_account_verified = 1;
        $user->save();

        Session::flash('success', 'You are connected to stripe now!');
        return Redirect::to('edit-trainer-profile');
    }

}
