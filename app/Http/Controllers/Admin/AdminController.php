<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Admin;
use App\User;
use \App\Appointment;
use \App\Classes;
use \App\ClassType;
use \App\FitnessGoal;
use \App\Specialization;
use \App\TrainingType;
use \App\Qualification;
use \App\BusinessCardOrder;
use \App\PassPrice;
use \App\Rating;
use \App\ContactUsFeedback;
use \App\Images;
use App\ClassImage;
use App\TrainerDocument;
use App\TrainerImage;
use App\Coupon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use App\Blog;
use App\Pages;
use App\CouponDiscount;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller {

    private $adminId;
    private $admin;

    function __construct() {
        $this->middleware(function ($request, $next) {
            $this->adminId = Auth::guard('admin')->user()->id;
            $this->admin = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    function dashboard() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
        ];
        $data['title'] = 'Admin Dashboard';
        $data['count_trainers'] = User::where('user_type', 'trainer')->count();
        $data['count_users'] = User::where('user_type', 'user')->count();
        $data['latest_users'] = User::where('user_type', 'user')->orderBy('id', 'desc')->paginate(8);
        $data['latest_trainers'] = User::where('user_type', 'trainer')->orderBy('id', 'desc')->paginate(8);

        $data['trainer_account_requests'] = User::where(['user_type' => 'trainer'])
                        ->where(function($q) {
                            $q->whereHas('trainerDocuments', function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orwhere('is_approved_by_admin', 2);
                            })
                            ->orWhere('is_image_approved_by_admin', '!=', 1);
                        })->count();
        $data['feedbacks_count'] = ContactUsFeedback::all()->count();
        return view('admin/dashboard', $data);
    }

    function users() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "", "name" => "Users"],
        ];
        $data['title'] = 'Users';
        $data['users'] = User::where('user_type', 'user')->orderBy('id', 'desc')->get();
        $data['userType'] = 'user';
        return view('admin/users', $data);
    }

    function blogs() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "", "name" => "Blogs"],
        ];
        $data['title'] = 'Blogs';
        $data['result'] = Blog::orderBy('id', 'desc')->get();

        return view('admin/blogs', $data);
    }

    function addBlog($id = '') {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "", "name" => "Blogs"],
        ];
        $data['title'] = 'Add Blogs';
        if ($id) {
            $data['title'] = 'Edit Blogs';
            $data['result'] = Blog::find($id);
            $data['id'] = $id;
        }
        return view('admin/add_blogs', $data);
    }

    function postBlog(Request $request) {
        $edit_id = $request->edit_id;
        if ($edit_id) {
            $blog = Pages::find($edit_id);
            $message = 'Blog updated successfully';
        } else {
            $blog = new Blog();
            $message = 'Blog added successfully';
        }
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = 'image_' . Str::random(15) . '.' . $extension; // renameing image

            $file_path = 'public/images/blogs/';
            $image->move($file_path, $filename);
            $blog->image = 'blogs/' . $filename;
        }
        $blog->save();
        return redirect(url('blog_admin'))->with('success', $message);
    }

    function delete_blogs($id) {
        Blog::find($id)->delete();
        return redirect(url('blog_admin'))->with('success', 'Blog deleted successfully');
    }

    function trainers() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "trainers_admin", "name" => "Trainers"],
        ];
        $data['title'] = 'Trainers';
        $users = User::where('user_type', 'trainer')
                        ->where('is_image_approved_by_admin', 1)
                        ->whereHas('trainerDocuments', function($q) {
                            $q->where('is_approved_by_admin', 1);
                        })->orderBy('id', 'desc')->get();
        $users->each(function ($item, $key) use($users) {
            $check = User::where('id', $item->id)
                            ->whereHas('trainerDocuments', function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orWhere('is_approved_by_admin', 2);
                            })->first();
            if ($check) {
                $users->forget($key);
            }
        });
        $data['users'] = $users;
        $data['userType'] = 'trainer';
        return view('admin/users', $data);
    }

    function featureTrainer(Request $request) {
        $TrainerID = $request->trainer_id;
        $Trainer = User::find($TrainerID);
        if ($Trainer->is_featured_by_admin == 0) {
            $is_featured = 1;
            $countTrainers = User::where('is_featured_by_admin', 1)->count();
            if ($countTrainers >= 4) {
                return response()->json(['error' => 'Maximum 4 trainers can be featured']);
            }
        }
        if ($Trainer->is_featured_by_admin == 1) {
            $is_featured = 0;
        }
        $Trainer->is_featured_by_admin = $is_featured;
        $Trainer->save();
        return response()->json(['success' => 'success']);
    }

    function allSessions() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "all_session", "name" => "Sessions"],
        ];
        $data['title'] = 'Sessions';
        $data['sessions'] = Appointment::where('type', 'session')->orderBy('id', 'desc')->get();
        $data['dataType'] = 'session';
        return view('admin/session_detail', $data);
    }

    function allClassesAppointments() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "all_classes_appointments", "name" => "Classes Appointments"],
        ];
        $data['title'] = 'Classes Appointments';
        $data['sessions'] = Appointment::where('type', 'class')->orderBy('id', 'desc')->get();
        $data['dataType'] = 'session';
        return view('admin/all_classes_appointments', $data);
    }

    function allClasses() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "all_classes", "name" => "Classes"],
        ];
        $data['title'] = 'Classes';
        $data['classes'] = Classes::orderBy('id', 'desc')->get();
        $data['dataType'] = 'class';
        return view('admin/appointments_detail', $data);
    }

    function featureClass(Request $request) {
        $ClassID = $request->class_id;
        $Class = Classes::find($ClassID);
        if ($Class->is_featured_by_admin == 0) {
            $is_featured = 1;
            $countClasses = Classes::where('is_featured_by_admin', 1)->count();
            if ($countClasses >= 4) {
                return response()->json(['error' => 'Maximum 4 classes can be featured']);
            }
        }
        if ($Class->is_featured_by_admin == 1) {
            $is_featured = 0;
        }
        $Class->is_featured_by_admin = $is_featured;
        $Class->save();
        return response()->json(['success' => 'success']);
    }

    function trainerApprovalRequests() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "trainer_approvals", "name" => "Trainer Account Approval Requests"],
        ];
        $data['title'] = 'Trainer Account Approval Requests';
        $data['users'] = User::where('user_type', 'trainer')
                        ->where(function($q) {
                            $q->whereHas('trainerDocuments', function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orwhere('is_approved_by_admin', 2);
                            })
                            ->orWhere('is_image_approved_by_admin', '!=', 1);
                        })
                        ->orderBy('id', 'desc')->get();
        return view('admin/trainers_approvals', $data);
    }

    function approveTrainer(Request $request) {
        $trainerID = $request->trainer_id;
        $trainer = User::find($trainerID);
        if ($trainer) {
            
            $trainer->is_approved_by_admin = 1;
            $trainer->save();
            $this->welcomeToTranner($trainer->id);
            Session::flash('success', 'Trainer account has been approved Successfully!');
            return Redirect::to(URL::previous());
        }
    }

    function denyTrainer(Request $request) {
        $trainerID = $request->trainer_id;
//        $trainer = User::find($trainerID);
        User::where('id', $request->trainer_id)->delete();
        Session::flash('success', 'Trainer account has been denied Successfully!');
        return Redirect::to(URL::previous());
    }

    function trainerImageApproval($trainer_id) {
        $trainerID = $trainer_id;
        $trainer = User::where('id', $trainerID)->first();
        if ($trainer) {
            
            $trainer->is_image_approved_by_admin = 1;
            $checkIfThereIsUnverifiedDoc = TrainerDocument::where('trainer_id', $trainer->id)
                            ->where(function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orWhere('is_approved_by_admin', 2);
                            })->first();
            if (!$checkIfThereIsUnverifiedDoc) {
                $trainer->is_approved_by_admin = 1;
            }
            $trainer->save();
            $this->welcomeToTranner($trainer->id);
            Session::flash('success', 'Trainer Image has been approved Successfully!');
            return Redirect::to(URL::previous());
        }
    }

    function trainerCVApproval($trainer_document_id) {
        $trainer_doc_ID = $trainer_document_id;
        $trainerDoc = TrainerDocument::with('getUser')->where(['id' => $trainer_doc_ID, 'document_type' => 'cv'])->first();
        if ($trainerDoc) {
            $trainerDoc->is_approved_by_admin = 1;
            $trainerDoc->save();
            $trainer = User::find($trainerDoc->trainer_id);
            $checkIfThereIsUnverifiedDoc = TrainerDocument::where('trainer_id', $trainer->id)
                            ->where(function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orWhere('is_approved_by_admin', 2);
                            })->first();
            if (!$checkIfThereIsUnverifiedDoc && $trainer->is_image_approved_by_admin == 1) {
                $trainer->is_approved_by_admin = 1;
                $trainer->save();
            }
            Session::flash('success', 'Trainer CV has been approved Successfully!');
            $this->welcomeToTranner($trainer->id);
            return Redirect::to(URL::previous());
        }
    }

    function welcomeToTranner($tranner_id) {

        $is_not_approved = TrainerDocument::with('getUser')->where('trainer_id', $tranner_id)
                        ->where(function($q) {
                            $q->where('is_approved_by_admin', 0);
                            $q->orWhere('is_approved_by_admin', 2);
                        })->count();
        $is_approved = User::where('id', $tranner_id)
                ->where(function($q){
                    $q->where('is_image_approved_by_admin', 0);
                    $q->orWhere('is_image_approved_by_admin', 2);
                })->find($tranner_id);
        
if(isset($is_approved) && $is_approved->count() > 0){
    
}else  if ($is_not_approved < 1) {
            $tranner = User::find($tranner_id);
            $email = $tranner->email; 
            $viewData['title'] = $tranner->first_name;
            $viewData['referral_code'] = $tranner->referral_code;
            Mail::send('email.welcomeToTranner', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Welcome'), 'Ebbsey');
                $m->to($email)->subject('Welcome');
            });
        }
    }

    function trainerCertificatesApproval($trainer_document_id) {
        $trainer_doc_ID = $trainer_document_id;
        $trainers_document = TrainerDocument::with('getUser')->where(['id' => $trainer_doc_ID, 'document_type' => 'certification'])->first();
        $trainer_id = $trainers_document->trainer_id;
        if ($trainers_document) {
            $trainers_document->is_approved_by_admin = 1;
            $trainers_document->save();
            $trainer = User::find($trainers_document->trainer_id);
            $checkIfThereIsUnverifiedDoc = TrainerDocument::where('trainer_id', $trainer->id)
                            ->where(function($q) {
                                $q->where('is_approved_by_admin', 0)
                                ->orWhere('is_approved_by_admin', 2);
                            })->first();
            if (!$checkIfThereIsUnverifiedDoc && $trainer->is_image_approved_by_admin == 1) {
                $trainer->is_approved_by_admin = 1;
                $trainer->save();
            }
            Session::flash('success', 'Trainer Certificate has been approved Successfully!');
            $this->welcomeToTranner($trainer_id);
        }
        return Redirect::to(URL::previous());
    }

    function trainerImageDenial($trainer_id) {
        $trainerID = $trainer_id;
        $trainer = User::where('id', $trainerID)->first();
        if ($trainer) {
            $email = $trainer->email;
            $f_name = $trainer->first_name;

            $trainer->is_image_approved_by_admin = 2;
            $trainer->is_approved_by_admin = 0;
            $trainer->save();

            //Send email to user on deny image approval
            $viewData['title'] = 'Sorry! Profile Picture Rejected';
            $viewData['description'] = 'Hi ' . $f_name . ', your image was not approved. Please, login to reload another picture. Thanks!';

            Mail::send('email.deny_document_template', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Profile Picture Rejected'), 'Ebbsey');
                $m->to($email)->subject('Profile Picture Rejected');
            });
            Session::flash('success', 'Trainer Image has been Denied Successfully!');
            return Redirect::to(URL::previous());
        }
    }

    function trainerCVDenial($trainer_document_id) {
        $trainer_doc_ID = $trainer_document_id;
        $trainers_document = TrainerDocument::with('getUser')->where(['id' => $trainer_doc_ID, 'document_type' => 'cv'])->first();
        if ($trainers_document) {
            $trainer = User::where('id', $trainers_document->trainer_id)->first();
            $email = $trainers_document->getUser->email;
            $f_name = $trainers_document->getUser->first_name;

            $trainers_document->is_approved_by_admin = 2;
            $trainers_document->save();
            
            $trainer->is_approved_by_admin = 0;
            $trainer->save();
            
            //Send email to user on deny Rejected approval
            $viewData['title'] = 'Sorry! CV rejected';
            $viewData['description'] = 'Hi ' . $f_name . ', your CV was not approved. Please, login to reload another CV. Thanks!';
            //$viewData['description'] = 'We are sorry. Your cv is not fulfill our standard. please contact us for more details, Thanks';
            Mail::send('email.deny_document_template', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'CV Rejected'), 'Ebbsey');
                $m->to($email)->subject('CV Rejected');
            });

            Session::flash('success', 'Trainer Certificate has been denied Successfully!');
        }
        return Redirect::to(URL::previous());
    }

    function trainerCertificatesDenial($trainer_document_id) {
        $trainer_doc_ID = $trainer_document_id;
        $trainers_document = TrainerDocument::with('getUser')->where(['id' => $trainer_doc_ID, 'document_type' => 'certification'])->first();
        if ($trainers_document) {
            $trainer = User::where('id', $trainers_document->trainer_id)->first();
            $email = $trainers_document->getUser->email;
            $f_name = $trainers_document->getUser->first_name;
            $trainers_document->is_approved_by_admin = 2;
            $trainers_document->save();
            
            $trainer->is_approved_by_admin = 0;
            $trainer->save();

            //Send email to user on deny Certificates approval
            $viewData['title'] = 'Sorry! certificate rejected';
            $viewData['description'] = 'Hi ' . $f_name . ', your Certificates was not approved. Please, login to reload another Certificates. Thanks!';
//            $viewData['description'] = 'We are sorry. Your Certificates is rejected. please contact us for more details, Thanks';

            Mail::send('email.deny_document_template', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL', 'Certificates Rejected'), 'Ebbsey');
                $m->to($email)->subject('Certificates Rejected');
            });
            Session::flash('success', 'Trainer Certificate has been denied Successfully!');
        }
        return Redirect::to(URL::previous());
    }

    function classDetailView($class_id) {
        $data['title'] = 'Class Detail';
        $data['class'] = Classes::find($class_id);
//        $data_class_image = ClassImage::where('class_id', $class_id)->get();
//        if (!$data_class_image->isEmpty()) {
//            $data['class_image'] = $data_class_image;
//        }
        if (!$data['class']) {
            return Redirect::to(URL::previous());
        }
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_detail_admin", "name" => "Class Detail"],
        ];
        return view('admin/class_detail', $data);
    }

    function userDetail($user_id) {
        $data['title'] = 'User Detail';
        $data['user'] = User::find($user_id);
        $data['images'] = TrainerImage::where('trainer_id', $user_id)->get();
        $data['certificates'] = TrainerDocument::where(['trainer_id' => $user_id, 'document_type' => 'certification'])->get();
        $data['cvs'] = TrainerDocument::where(['trainer_id' => $user_id, 'document_type' => 'cv'])->get();
        if (!$data['user']) {
            return Redirect::to(URL::previous());
        }
        $data['userType'] = $data['user']->user_type;
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => ($data['userType'] == 'user' ? 'users_admin' : 'trainers_admin'), "name" => ($data['userType'] == 'user' ? 'Users' : 'Trainers')],
                ["href" => "user_detail_admin/$user_id", "name" => ($data['userType'] == 'user' ? 'Users Detail' : 'Trainer Detail')],
        ];
        return view('admin/user_detail', $data);
    }

    function deleteUser(Request $request) {
        User::where('id', $request->user_id)->delete();
        return Response::json(['message' => 'User successfully deleted.'], 200);
    }

    function addClassTypeView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_types", "name" => "Class Types"],
        ];
        $data['title'] = 'Class Types';
        $data['class_types'] = ClassType::orderBy('id', 'desc')->get();
        return view('admin.class_types', $data);
    }

    function addClassType(Request $request) {
        if (!$request->title == null) {
            $ClassType = New ClassType;
            $ClassType->title = $request->title;
            $ClassType->save();
            Session::flash('success', 'New Class Type Added Successfully!');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Please add some text in the field!');
            return Redirect::to(URL::previous());
        }
    }

    function editClassTypeView($id) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_types", "name" => "Class Types"],
                ["href" => "class_types", "name" => "Edit Class Types"],
        ];
        $data['title'] = 'Edit Class Type';
        $data['class_types'] = ClassType::orderBy('id', 'desc')->get();
        $data['class_type'] = ClassType::find($id);
        return view('admin.class_types', $data);
    }

    function editClassType(Request $request) {
        $ClassTypeID = $request->class_type_id;
        $ClassType = ClassType::find($ClassTypeID);
        $ClassType->title = $request->title;
        $ClassType->save();
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_types", "name" => "Class Types"],
        ];
        $data['title'] = 'Class Types';
        $data['class_types'] = ClassType::orderBy('id', 'desc')->get();
        return redirect('class_types');
//        return Redirect::to(URL::previous());
    }

    function deleteClassType(Request $request) {
        ClassType::where('id', $request->class_type_id)->delete();
        return Response::json(['message' => 'class type successfully deleted.'], 200);
    }

    function fitnessGoalView(Request $request) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "fitness_goals_admin", "name" => "Fitness Goals"],
        ];
        $data['title'] = 'Fitness Goals';
        $data['fitness_goals'] = FitnessGoal::orderBy('id', 'desc')->get();
        return view('admin.fitness_goals', $data);
    }

    function addFitnessGoal(Request $request) {
        if ($request->title == null) {
            Session::flash('error', 'Please add some text in the field!');
            return Redirect::to(URL::previous());
        } else {
            $FitnessGoal = New FitnessGoal;
            $FitnessGoal->title = $request->title;
            $FitnessGoal->is_approved_by_admin = 1;
            $FitnessGoal->save();
            Session::flash('success', 'New Fitness Goal Added Successfully!');
            return Redirect::to(URL::previous());
        }
    }

    function activateTranner(Request $request, $id) {
        if (!$id) {
            return redirect()->back();
        }
        $user = User::find($id);
        $user->is_approved_by_admin = 1;
        $user->save();
        Session::flash('success', 'Trainner Activated successfully!');
        return Redirect::to(URL::previous());
    }

    function changeStatus(Request $request) {
        $id = $request->user_id;
        $status = $request->status;
        $type = $request->user_type;
        $typ_user = ucfirst($type);
        if ($status == 1) {
            $status = 1;
            $msg = $typ_user . ' Activated Successfully';
        } else {
            $status = 0;
            $msg = $typ_user . ' Inactivated Successfully';
        }
        $user = User::find($id);
        $user->is_approved_by_admin = $status;
        $user->save();
        $result = array('success' => 1, 'msg' => $msg);
        echo json_encode($result);
    }

    function editFitnessGoalView($id) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "fitness_goals_admin", "name" => "Fitness Goals"],
                ["href" => "fitness_goals_admin", "name" => "Edit Fitness Goal"],
        ];
        $data['title'] = 'Edit Fitness Goal';
        $data['fitness_goals'] = FitnessGoal::orderBy('id', 'desc')->get();
        $data['fitness_goal'] = FitnessGoal::find($id);
        return view('admin.fitness_goals', $data);
    }

    function editFitnessGoal(Request $request) {
        $FitnessGoalID = $request->fitness_goal_id;
        $FitnessGoal = FitnessGoal::find($FitnessGoalID);
        $FitnessGoal->title = $request->title;
        $FitnessGoal->save();
//        Session::flash('success', 'Fitness Goal Updated Successfully!');
//        return Redirect::to(URL::previous());
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "fitness_goals_admin", "name" => "Fitness Goals"],
        ];
        $data['title'] = 'Fitness Goals';
        $data['fitness_goals'] = FitnessGoal::orderBy('id', 'desc')->get();
        return redirect('fitness_goals_admin');
    }

    function deleteFitnessGoal(Request $request) {
        FitnessGoal::where('id', $request->fitness_goal_id)->delete();
        return Response::json(['message' => 'fitness goal successfully deleted.'], 200);
    }

    function deleteOrder(Request $request) {
        BusinessCardOrder::where('id', $request->id)->delete();
        return Response::json(['message' => 'Order successfully deleted.'], 200);
    }

    function view_order_detail($id) {
        $data['result'] = BusinessCardOrder::with('cardsOrderBy')->where('id', $id)->first();

        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "specializations_admin", "name" => "Order Form "],
        ];
        $data['title'] = 'order view ';
        return view('admin.view_order_detail', $data);
    }

    function fitnessGoalApproval(Request $request) {
        $FitnessGoalID = $request->fitness_goal_id;
        $FitnessGoal = FitnessGoal::find($FitnessGoalID);
        if ($FitnessGoal->is_approved_by_admin == 0) {
            $is_approved = 1;
        }
        if ($FitnessGoal->is_approved_by_admin == 1) {
            $is_approved = 0;
        }
        $FitnessGoal->is_approved_by_admin = $is_approved;
        $FitnessGoal->save();
        return Response::json(['message' => 'fitness goal approval status chenged successfully.'], 200);
    }

    function specializationsView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "specializations_admin", "name" => "Discipline "],
        ];
        $data['title'] = 'Discipline ';
        $data['specializations'] = Specialization::orderBy('id', 'desc')->get();
        return view('admin.specializations', $data);
    }

    function addSpecialization(Request $request) {
        if (!$request->title == null) {
            $Specialization = New Specialization;
            $Specialization->title = $request->title;
            $Specialization->is_approved_by_admin = 1;
            $Specialization->save();
            Session::flash('success', 'New Discipline Added Successfully!');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Please add some text in the field!');
            return Redirect::to(URL::previous());
        }
    }

    function editSpecializationView($id) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "specializations_admin", "name" => "Discipline"],
                ["href" => "specializations_admin", "name" => "Edit Discipline"],
        ];
        $data['title'] = 'Edit Discipline';
        $data['specializations'] = Specialization::orderBy('id', 'desc')->get();
        $data['specialization'] = Specialization::find($id);
        return view('admin.specializations', $data);
    }

    function editSpecialization(Request $request) {
        $SpecializationID = $request->specialization_id;
        $Specialization = Specialization::find($SpecializationID);
        $Specialization->title = $request->title;
        $Specialization->save();
//        Session::flash('success', 'Specialization Updated Successfully!');
//        return Redirect::to(URL::previous());
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "specialization_admin", "name" => "Discipline"],
        ];
        $data['title'] = 'Discipline';
        $data['specializations'] = Specialization::orderBy('id', 'desc')->get();
        return redirect('specializations_admin');
    }

    function deleteSpecialization(Request $request) {
        Specialization::where('id', $request->specialization_id)->delete();
        return Response::json(['message' => 'Discipline successfully deleted.'], 200);
    }

    function specializationApproval(Request $request) {
        $specialization_id = $request->specialization_id;
        $Specialization = Specialization::find($specialization_id);
        if ($Specialization->is_approved_by_admin == 0) {
            $is_approved = 1;
        }
        if ($Specialization->is_approved_by_admin == 1) {
            $is_approved = 0;
        }
        $Specialization->is_approved_by_admin = $is_approved;
        $Specialization->save();
        return Response::json(['message' => 'Discipline approval status changed successfully.'], 200);
    }

    function trainingTypesView(Request $request) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "training_types_admin", "name" => "Training Types"],
        ];
        $data['title'] = 'Training Types';
        $data['training_types'] = TrainingType::orderBy('id', 'desc')->get();
        return view('admin.training_types', $data);
    }

    function addTrainingType(Request $request) {
        if (!$request->title == null) {
            $training_type = New TrainingType;
            $training_type->title = $request->title;
            $image = $request->file('image');
            if ($image) {
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'public/images/trainer_types';
                $image->move($destinationPath, $imagename);
                $training_type->image = 'trainer_types/' . $imagename;
            }
            $training_type->save();
            Session::flash('success', 'New Training Type Added Successfully!');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Please add some text in the field!');
            return Redirect::to(URL::previous());
        }
    }

    function editTrainingTypeView($id) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "training_types_admin", "name" => "Training Types"],
                ["href" => "training_types_admin", "name" => "Edit Training Type"],
        ];
        $data['title'] = 'Edit Training Type';
        $data['training_types'] = TrainingType::orderBy('id', 'desc')->get();
        $data['training_type'] = TrainingType::find($id);
        return view('admin.training_types', $data);
    }

    function editTrainingType(Request $request) {
        $training_typeID = $request->training_type_id;
        $training_type = TrainingType::find($training_typeID);
        $training_type->title = $request->title;
        $image = $request->file('image');
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = 'public/images/trainer_types';
            $image->move($destinationPath, $imagename);
            $training_type->image = 'trainer_types/' . $imagename;
        }
        $training_type->save();
//        Session::flash('success', 'Training Type Updated Successfully!');
//        return Redirect::to(URL::previous());
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "specialization_admin", "name" => "Training Types"],
        ];
        $data['title'] = 'Training Types';
        $data['training_types'] = TrainingType::orderBy('id', 'desc')->get();
        return redirect('training_types_admin');
    }

    function deleteTrainingType(Request $request) {
        TrainingType::where('id', $request->training_type_id)->delete();
        return Response::json(['message' => 'Training type successfully deleted.'], 200);
    }

    public function changeTrainingTypeStatus(Request $request) {
        $training_type__id = $request->type_id;
        $TrainingType = TrainingType::where('id', $training_type__id)->first();
        $TrainingType->is_enabled = $request->status;
        $TrainingType->save();
        return Response::json(['message' => 'Training type status successfully changed.'], 200);
    }

    function qualificationsView(Request $request) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "qualifications_admin", "name" => "Qualifications"],
        ];
        $data['title'] = 'Qualifications';
        $data['qualifications'] = Qualification::orderBy('id', 'desc')->get();
        return view('admin.qualifications', $data);
    }

    function addQualification(Request $request) {
        if (!$request->title == null) {
            $Qualification = New Qualification;
            $Qualification->title = $request->title;
            $Qualification->is_approved_by_admin = 1;
            $Qualification->save();
            Session::flash('success', 'New Qualification Added Successfully!');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Please add some text in the field!');
            return Redirect::to(URL::previous());
        }
    }

    function editQualificationView($id) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "qualifications_admin", "name" => "Qualifications"],
                ["href" => "qualifications_admin", "name" => "Edit Qualification"],
        ];
        $data['title'] = 'Edit Qualification';
        $data['qualifications'] = Qualification::orderBy('id', 'desc')->get();
        $data['qualification'] = Qualification::find($id);
        return view('admin.qualifications', $data);
    }

    function editQualification(Request $request) {
        $QualificationID = $request->qualification_id;
        $Qualification = Qualification::find($QualificationID);
        $Qualification->title = $request->title;
        $Qualification->save();
//        Session::flash('success', 'Qualification Updated Successfully!');
//        return Redirect::to(URL::previous());
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "qualifications_admin", "name" => "Qualifications"],
        ];
        $data['title'] = 'Qualifications';
        $data['qualifications'] = Qualification::orderBy('id', 'desc')->get();
        return redirect('qualifications_admin');
    }

    function deleteQualification(Request $request) {
        Qualification::where('id', $request->qualification_id)->delete();
        return Response::json(['message' => 'Qualification successfully deleted.'], 200);
    }

    function qualificationApproval(Request $request) {
        $qualification_id = $request->qualification_id;
        $Qualification = Qualification::find($qualification_id);
        if ($Qualification->is_approved_by_admin == 0) {
            $is_approved = 1;
        }
        if ($Qualification->is_approved_by_admin == 1) {
            $is_approved = 0;
        }
        $Qualification->is_approved_by_admin = $is_approved;
        $Qualification->save();
        return Response::json(['message' => 'Qualification approval status chenged successfully.'], 200);
    }

    function bsinessCardsOrderStatus(Request $request) {
        $order_id = $request->order_id;
        $order = BusinessCardOrder::find($order_id);
        if ($order->is_order_completed == 0) {
            $is_order_completed = 1;
        }
        if ($order->is_order_completed == 1) {
            $is_order_completed = 0;
        }
        $order->is_order_completed = $is_order_completed;
        $order->save();
        return Response::json(['message' => 'order status chenged successfully.'], 200);
    }

    function bsinessCardsOrdersView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "business_cards_orders", "name" => "Branding"],
        ];
        $data['title'] = 'Branding';
        $data['card_orders'] = BusinessCardOrder::orderBy('id', 'desc')->get();
        return view('admin.business_cards', $data);
    }

    function passPriceView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "pass_price", "name" => "Change Pass Price"],
        ];
        $data['title'] = 'Change Pass Price';
        $data['pass_price'] = PassPrice::first();
        return view('admin.change_pass_price', $data);
    }

    function passPriceUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
                    'new_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Please enter numeric pass price to update');
            return Redirect::to(URL::previous());
        } else {
            $pass_price = PassPrice::all();
//            dd($pass_price);
            if (!$pass_price->isEmpty()) {
                $pass_new_price = $request->new_price;
                $pass_id = $request->pass_id;
                $PassPrice = PassPrice::find($pass_id);
                $PassPrice->price = $pass_new_price;
                $PassPrice->save();
            } else {
                $new_price = new PassPrice;
                $new_price->price = $request->new_price;
                $new_price->save();
            }
            Session::flash('success', 'Price Updated successfully');
            return Redirect::to(URL::previous());
        }
    }

    function reviewsView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "reviews", "name" => "Ratings"],
        ];
        $data['title'] = 'Reviews';
        $data['reviews'] = Rating::all();
        return view('admin.rating', $data);
    }

    function feedbacksView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "feedbacks", "name" => "Feedbacks"],
        ];
        $data['title'] = 'Feedbacks';
        $data['feedbacks'] = ContactUsFeedback::all();
        return view('admin.feedback', $data);
    }

    function classGalleryView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_gallery", "name" => "Gallery"],
        ];
        $data['title'] = 'Gallery';
        $data['gallery_images'] = Images::all();
        return view('admin.class_gallery', $data);
    }

    function uploadGalleryImage(Request $request) {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "class_gallery", "name" => "Gallery"],
        ];
        $data['title'] = 'Gallery';
        if ($request->hasFile('mediafiles')) {
            foreach ($request->file('mediafiles') as $file) {
                $name = str_random(5) . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'adminassets/images/class_gallery/';

                //Create thumbnail 
                $real_path = $file->getRealPath();
                $image_resize = Image::make($real_path);
                $image_resize->resize(150, 150);
                $image_resize->save($destinationPath . 'thumb_' . $name);

                $file->move($destinationPath, $name);
                $media = new Images;
                $media->path = 'class_gallery/' . $name;
                $media->thumbnail_path = 'class_gallery/thumb_' . $name;
                $media->save();
            }
            Session::flash('success', 'Gallery Updated Successfully');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'error ! No Files uploaded...');
            return Redirect::to(URL::previous());
        }
    }

    function deleteGalleryImage(Request $request) {
        $media_id = $request->id;
        $media_name = $request->image_name;
        $mediaDeleted = asset('adminassets/images/' . $media_name);
        File::delete($mediaDeleted);
        Images::where('id', $media_id)->delete();
    }

    function changePasswordView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "change_password_admin", "name" => "Change Password"],
        ];
        $data['title'] = 'Change Password';
        return view('admin/change_password', $data);
    }

    function changePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $password = $this->admin->password;
        if (Hash::check($request['current_password'], $password)) {
            $newpass = Hash::make($request['password']);
            Admin::where('id', $this->adminId)->update(['password' => $newpass]);
            User::where('email', $this->admin->email)->update(['password' => $newpass]);
            Session::flash('success', 'Password Updated successfully');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Invalid Old Password');
            return Redirect::to(URL::previous());
        }
    }

    //Mange CMS pages
    public function addPage($id = '') {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "", "name" => "Pages"],
        ];

        $data['title'] = 'Add Pages';
        if ($id) {
            $data['title'] = 'Edit Pages';
            $data['result'] = Pages::find($id);
            $data['id'] = $id;
        }
        return view('admin/add_pages', $data);
    }

    public function postPage(Request $request) {

        $edit_id = $request->edit_id;
        $rules = [
            'title' => 'required|max:50|unique:pages',
            'description' => 'required'
        ];
        if ($edit_id) {
            $rules = [
                'title' => 'required|max:50|unique:pages,title,' . $edit_id,
                'description' => 'required'
            ];
        }
        $request->validate($rules);

        if ($edit_id) {
            $page = Pages::find($edit_id);
        } else {
            $page = New Pages();
            $page->slug = str_slug($request->title);
        }
        $page->title = $request->title;
        $page->content = $request->description;
        $page->status = $request->status;
        $page->save();
        $request->session()->flash('success', 'Record saved successfully.');
        return redirect('manage_pages');
    }

    public function managePage() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "mange_pages", "name" => "Manage Pages"],
        ];
        $data['title'] = 'Manage Pages';

        $data['result'] = Pages::get();
        return view('admin/mange_pages', $data);
    }

    function coupons() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "coupons", "name" => "Coupons"],
        ];
        $data['title'] = 'Coupons';
        $data['result'] = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin/coupons', $data);
    }

    function couponsDiscount() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "coupons", "name" => "Coupons Discount"],
        ];
        $data['title'] = 'Coupons Discount';
        $data['result'] = CouponDiscount::orderBy('created_at', 'desc')->get();
        return view('admin/add_coupon_discount', $data);
    }

    function addCouponView() {
        $data['breadCrumbs'] = [
                ["href" => "admin_dashboard", "name" => "Dashboard"],
                ["href" => "coupons", "name" => "Coupons"],
        ];
        $data['title'] = 'Add Coupon';
        return view('admin/add_coupon', $data);
    }

    function deleteCoupon($id) {
        Coupon::where('id', $id)->delete();
        Session::flash('success', 'Coupon Deleted Successfully.');
        return Redirect::to(URL::previous());
    }

    function deleteCouponDiscount($id) {
        CouponDiscount::where('id', $id)->delete();
        Session::flash('success', 'Coupon Discount Deleted Successfully.');
        return Redirect::to(URL::previous());
    }

    function editCouponDiscount(Request $request) {
        $coupon = CouponDiscount::where('id', $request->id)->first();
        if ($coupon) {
            $coupon->no_of_coupons = $request->passes;
            $coupon->discount = $request->discount;
            $coupon->save();
            Session::flash('success', 'Coupon Discount Updated Successfully.');
        } else {
            Session::flash('error', 'Coupon Discount not updated .');
        }
    }

    function addCoupon(Request $request) {
        $request->validate([
            'title' => 'required',
            'valid_till' => 'required',
            'discount' => 'required',
            'passes_count' => 'required',
        ]);
        $code = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        $couponCheck = Coupon::where('code', $code)->first();
        while ($couponCheck) {
            $code = substr(md5(uniqid(mt_rand(), true)), 0, 6);
            $couponCheck = Coupon::where('code', $code)->first();
        }
        $coupon = new Coupon();
        $coupon->title = $request['title'];
        $coupon->valid_till = date('Y-m-d', strtotime($request['valid_till']));
        $coupon->discount = $request['discount'];
        $coupon->passes_count = $request['passes_count'];
        $coupon->code = $code;
        $coupon->save();
        Session::flash('success', 'Coupon added successfully');
        return Redirect::to(URL::previous());
    }

    function refundAppointment(Request $request) {
        $id = $request->id;
        $appointment = Appointment::find($id);
        $trainer = User::find($appointment->trainer_id);
        $client = User::find($appointment->client_id);
        $client_f_name = $client->first_name;
        $client_full_name = $client->first_name . ' ' . $client->last_name;
        $client_email = $client->email;

        $trainer_f_name = $trainer->first_name;
        $trainer_full_name = $trainer->first_name . ' ' . $trainer->last_name;
        $trainer_email = $trainer->email;

        $amount = $appointment->amount_to_transfer;
        $passes_count = $appointment->number_of_passes;

        $client->passes_count = $client->passes_count + $passes_count;
        $client->save();

        $trainer->total_cash = $trainer->total_cash - $amount;
        $trainer->save();
        $session_date = date('M d, Y', strtotime($appointment->start_date));
        $session_time = $appointment->start_time;
        $location = $appointment->client_location;

        savePaymentHistory($appointment->client_id, $appointment->trainer_id, $appointment->class_id, $appointment->id, (-1) * $amount, $appointment->number_of_passes, 'refund');

        $appointment->is_refunded = 1;
        $appointment->save();
    }

    function addCouponDsicount(Request $request) {
        $request->validate([
            'discount' => 'required',
            'passes_count' => 'required',
        ]);
        $coupon = new CouponDiscount();
        $coupon->discount = $request['discount'];
        $coupon->no_of_coupons = $request['passes_count'];
        $coupon->save();
        Session::flash('success', 'Coupon Discount Added successfully');
        return Redirect::to(URL::previous());
    }

    function logout() {
        Auth::guard('admin')->logout();
        return redirect('admin_login');
    }

}
