<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\User;
use App\Qualification;
use App\ClassType;
use App\State;
use Carbon\Carbon;

class SearchController extends Controller {

    function search(Request $request) {
        if ($request->ajax()) {
            $this->ajaxSearch($request);
        } else {
//            dd('asd');
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
                $checkStateCode = State::where('state_code', $state)->first();
                if ($checkStateCode) {
                    array_push($new_states, $checkStateCode->state);
                } else {
                    array_push($new_states, $state);
                }
            }
            $new_states = array_unique($new_states);
            $data['trainers_states'] = $new_states;

            $states_array = array();
            $states_array = Classes::select('state')->get()->toArray();
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
                $checkStateCode = State::where('state_code', $state)->first();
                if ($checkStateCode) {
                    array_push($new_states, $checkStateCode->state);
                } else {
                    array_push($new_states, $state);
                }
            }
            $new_states = array_unique($new_states);
            $data['classes_states'] = $new_states;

            $data['title'] = 'Ebbsey | Search';
            $data['qualifications'] = Qualification::orderBy('title')->get();
            $data['class_types'] = ClassType::get();

            if ($request->search_type == 'class') {
                $state = $request->class_search_location;
                $check = State::where('state', $request->class_search_location)->first();
                if ($check) {
                    $state = $check->state_code;
                }
                $data['type'] = 'class';
                $data['records'] = Classes::with('getImage')
                        ->where('class_name', 'like', "%$request->keyword%")
                        ->when($request->difficulty_level, function ($query) use($request) {
                            return $query->where('difficulty_level', $request->difficulty_level);
                        })
                        ->when($request->class_search_location, function ($query) use($request) {
                            return $query->where('state', 'like', '%' . $request->class_search_location . '%');
                        })
                        ->when($request->class_type, function ($query) use($request) {
                            return $query->where('class_type', $request->class_type);
                        })
                        ->when($request->postal_code, function ($query) use($request) {
                            return $query->where('postal_code', $request->postal_code);
                        })
                        ->when($request->class_date, function ($query) use($request) {
                            return $query->where('start_date', date('Y-m-d', strtotime($request->class_date)));
                        })
                        ->when($request->duration, function ($query) use($request) {
                            return $query->where('duration', $request->duration);
                        })
                        ->where('status', 'open')
                        ->paginate(10);

                $data['total'] = Classes::with('getImage')->where('class_name', 'like', "%$request->keyword%")
                        ->when($request->difficulty_level, function ($query) use($request) {
                            return $query->where('difficulty_level', $request->difficulty_level);
                        })
                        ->when($request->class_search_location, function ($query) use($request) {
                            return $query->where('state', 'like', '%' . $request->class_search_location . '%');
                        })
                        ->when($request->class_type, function ($query) use($request) {
                            return $query->where('class_type', $request->class_type);
                        })
                        ->when($request->postal_code, function ($query) use($request) {
                            return $query->where('postal_code', $request->postal_code);
                        })
                        ->when($request->class_date, function ($query) use($request) {
                            return $query->where('start_date', date('Y-m-d', strtotime($request->class_date)));
                        })
                        ->when($request->duration, function ($query) use($request) {
                            return $query->where('duration', $request->duration);
                        })
                        ->where('status', 'open')
                        ->count();
                //$data['append'] = view('public.keyword_data', $query_data)->render();
            } else {
                if($request->experience == '10'){
                    $request->experience = '10+';
                }
                $state = $request->trainer_search_location;
                $check = State::where('state', $request->trainer_search_location)->first();
                if ($check) {
                    $state = $check->state_code;
                }
                
                $male = ($request->gender_male) ? $request->gender_male : '';
                $female = ($request->gender_female) ? $request->gender_female : '';
                $data['type'] = 'trainer';
                $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
                $lat = '37.0902';
                $lng = '95.7129';
                if (isset($location->latitude) && $location->longitude) {
                    $lat = $location->latitude;
                    $lng = $location->longitude;
                }
                $data['records'] = User::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                            ->where('user_type', 'trainer')
                            ->where(function($like_query) use($request) {
                                $like_query->where('first_name', 'like', "%$request->keyword%")
                                ->orwhere('last_name', 'like', "%$request->keyword%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$request->keyword%' ");
                            })
                            ->where('is_verified', 1)
                            ->where('is_image_approved_by_admin', 1)
                            ->where('is_approved_by_admin', '!=', '2')
                            ->whereDoesntHave('trainerDocuments', function($query) {
                                $query->where('is_approved_by_admin', 0);
                            })
                            ->when($request->experience, function ($query) use($request) {
                                return $query->where('years_of_experience', $request->experience);
                            })
                            ->when($request->postal_code, function ($query) use($request) {
                                return $query->where('postal_code', $request->postal_code);
                            })
                            ->where(function($query) use($male, $female) {
                                if ($male != '' && $female != '') {
                                    //Show all
                                } else if ($male != '') {
                                    $query->where('gender', 'male');
                                } else if ($female != '') {
                                    $query->where('gender', 'female');
                                }
                            })
                            ->when($state, function ($query) use($request, $state) {
                                return $query->where('state', 'like', '%' . $state . '%')
                                        ->orWhere('state', 'like', '%' . $request->trainer_search_location . '%');
                            })->paginate(10);

                $data['total'] = User::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                            ->where('user_type', 'trainer')
                            ->where(function($like_query) use($request) {
                                $like_query->where('first_name', 'like', "%$request->keyword%")
                                ->orwhere('last_name', 'like', "%$request->keyword%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$request->keyword%' ");
                            })
                            ->where('is_verified', 1)
                            ->where('is_image_approved_by_admin', 1)
                            ->where('is_approved_by_admin', '!=', '2')
                            ->whereDoesntHave('trainerDocuments', function($query) {
                                $query->where('is_approved_by_admin', 0);
                            })
                            ->when($request->experience, function ($query) use($request) {
                                return $query->where('years_of_experience', $request->experience);
                            })
                            ->when($request->postal_code, function ($query) use($request) {
                                return $query->where('postal_code', $request->postal_code);
                            })
                            ->where(function($query) use($male, $female) {
                                if ($male != '' && $female != '') {
                                    //Show all
                                } else if ($male != '') {
                                    $query->where('gender', 'male');
                                } else if ($female != '') {
                                    $query->where('gender', 'female');
                                }
                            })
                            ->when($state, function ($query) use($request, $state) {
                                return $query->where('state', 'like', '%' . $state . '%')
                                        ->orWhere('state', 'like', '%' . $request->trainer_search_location . '%');
                            })
                            ->count();
            }

            return view('public.search', $data);
        }
    }

    function ajaxSearch($request) {
        $skip = $request->skip * 10;
        if ($request->search_type == 'class') {
            $state = $request->class_search_location;
            $check = State::where('state', $request->class_search_location)->first();
            if ($check) {
                $state = $check->state_code;
            }
            $query_data['type'] = 'class';
            $query_data['records'] = Classes::with('getImage')->where('class_name', 'like', "%$request->keyword%")
                    ->when($request->difficulty_level, function ($query) use($request) {
                        return $query->where('difficulty_level', $request->difficulty_level);
                    })
                    ->when($state, function ($query) use($request, $state) {
                        return $query->where('state', 'like', '%' . $state . '%')
                                ->orWhere('state', 'like', '%' . $request->class_search_location . '%');
                    })
                    ->when($request->class_date, function ($query) use($request) {
                        return $query->where('start_date', date('Y-m-d', strtotime($request->class_date)));
                    })
                    ->when($request->class_type, function ($query) use($request) {
                        return $query->where('class_type', $request->class_type);
                    })
                    ->when($request->postal_code, function ($query) use($request) {
                        return $query->where('postal_code', $request->postal_code);
                    })
                    ->when($request->duration, function ($query) use($request) {
                        return $query->where('duration', $request->duration);
                    })
                    ->where('status', 'open')
                    ->paginate(10);

            $data['append'] = view('public.search_data', $query_data)->render();
            $data['total_record'] = Classes::with('getImage')->where('class_name', 'like', "%$request->keyword%")
                    ->when($request->difficulty_level, function ($query) use($request) {
                        return $query->where('difficulty_level', $request->difficulty_level);
                    })
                    ->when($state, function ($query) use($request, $state) {
                        return $query->where('state', 'like', '%' . $state . '%')
                                ->orWhere('state', 'like', '%' . $request->class_search_location . '%');
                    })
                    ->when($request->class_date, function ($query) use($request) {
                        return $query->where('start_date', date('Y-m-d', strtotime($request->class_date)));
                    })
                    ->when($request->class_type, function ($query) use($request) {
                        return $query->where('class_type', $request->class_type);
                    })
                    ->when($request->postal_code, function ($query) use($request) {
                        return $query->where('postal_code', $request->postal_code);
                    })
                    ->when($request->duration, function ($query) use($request) {
                        return $query->where('duration', $request->duration);
                    })
                    ->where('status', 'open')
                    ->count();
        } else {
            if($request->experience == '10'){
                $request->experience = '10+';
            }
            $male = ($request->gender_male) ? $request->gender_male : '';
            $female = ($request->gender_female) ? $request->gender_female : '';
            $query_data['type'] = 'trainer';
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=' . env('IP_STACK_KEY')));
            $lat = '37.0902';
            $lng = '95.7129';
            if (isset($location->latitude) && $location->longitude) {
                $lat = $location->latitude;
                $lng = $location->longitude;
            }
            $state = $request->trainer_search_location;
            $check = State::where('state', $request->trainer_search_location)->first();
            if ($check) {
                $state = $check->state_code;
            }
            $query_data['records'] = User::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                            ->where('user_type', 'trainer')
                            ->where(function($like_query) use($request) {
                                $like_query->where('first_name', 'like', "%$request->keyword%")
                                ->orwhere('last_name', 'like', "%$request->keyword%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$request->keyword%' ");
                            })
                            ->where('is_verified', 1)
                            ->where('is_image_approved_by_admin', 1)
                            ->where('is_approved_by_admin', '!=', '2')
                            ->whereDoesntHave('trainerDocuments', function($query) {
                                $query->where('is_approved_by_admin', 0);
                            })
                            ->when($request->experience, function ($query) use($request) {
                                return $query->where('years_of_experience', $request->experience);
                            })
                            ->when($request->postal_code, function ($query) use($request) {
                                return $query->where('postal_code', $request->postal_code);
                            })
                            ->where(function($query) use($male, $female) {
                                if ($male != '' && $female != '') {
                                    //Show all
                                } else if ($male != '') {
                                    $query->where('gender', 'male');
                                } else if ($female != '') {
                                    $query->where('gender', 'female');
                                }
                            })
                            ->when($state, function ($query) use($request, $state) {
                                return $query->where('state', 'like', '%' . $state . '%')
                                        ->orWhere('state', 'like', '%' . $request->trainer_search_location . '%');
                            })->paginate(10);

            $data['append'] = view('public.search_data', $query_data)->render();

            $data['total_record'] = User::selectRaw("*,
                            ( 6371 * acos( cos( radians($lat) ) *
                            cos( radians(lat) ) *
                            cos( radians(lng) - radians($lng) ) + 
                            sin( radians($lat) ) *
                            sin( radians(lat) ) ) ) 
                            AS distance")
                            ->where('user_type', 'trainer')
                            ->where(function($like_query) use($request) {
                                $like_query->where('first_name', 'like', "%$request->keyword%")
                                ->orwhere('last_name', 'like', "%$request->keyword%")
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$request->keyword%' ");
                            })
                            ->where('is_verified', 1)
                            ->where('is_image_approved_by_admin', 1)
                            ->where('is_approved_by_admin', '!=', '2')
                            ->whereDoesntHave('trainerDocuments', function($query) {
                                $query->where('is_approved_by_admin', 0);
                            })
                            ->when($request->experience, function ($query) use($request) {
                                return $query->where('years_of_experience', $request->experience);
                            })
                            ->when($request->postal_code, function ($query) use($request) {
                                return $query->where('postal_code', $request->postal_code);
                            })
                            ->where(function($query) use($male, $female) {
                                if ($male != '' && $female != '') {
                                    //Show all
                                } else if ($male != '') {
                                    $query->where('gender', 'male');
                                } else if ($female != '') {
                                    $query->where('gender', 'female');
                                }
                            })
                            ->when($state, function ($query) use($request, $state) {
                                return $query->where('state', 'like', '%' . $state . '%')
                                        ->orWhere('state', 'like', '%' . $request->trainer_search_location . '%');
                            })
                            ->count();
        }
        echo json_encode($data);
    }

}
