<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Thread;
use App\User;
use App\Appointment;

class ChatController extends Controller {

    private $user;
    private $userId;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userId = Auth::user()->id;
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function readMessages() {
        Message::where(array('is_read' => 0, 'receiver_id' => $this->userId))->update(['is_read' => 1]);
        echo TRUE;
    }

    function getMessages() {
        $user_id = $this->userId;
        $data['title'] = 'Ebbsey | Messages';

        $data['chats'] = Thread::with('receiver', 'sender', 'lastMessage')
                        ->whereHas('messages', function($get_messages) use($user_id) {
                            $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                        })
                        ->with(['messages' => function ($get_messages) use($user_id) {
                                $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                            }])
                        ->withCount(['messages' => function ($q) {
                                $q->where('is_read', 0);
                            }])
                        ->where(function ($q) use($user_id) {
                            $q->where('sender_id', $user_id);
                            $q->orWhere('receiver_id', $user_id);
                        })
                        ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                        ->orderBy('updated_at', 'desc')->get();
        $data['chat_single'] = Thread::with('receiver', 'sender', 'lastMessage')
                        ->whereHas('messages', function($get_messages) use($user_id) {
                            $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                        })
                        ->with(['messages' => function ($get_messages) use($user_id) {
                                $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                            }])
                        ->withCount(['messages' => function ($q) {
                                $q->where('is_read', 0);
                            }])
                        ->where(function ($q) use($user_id) {
                            $q->where('sender_id', $user_id);
                            $q->orWhere('receiver_id', $user_id);
                        })
                        ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                        ->orderBy('updated_at', 'desc')->first();             
        return view('user.messages', $data);
    }

    function getChatData(Request $request) {
        $user_id = $this->userId;
        $data['current_id'] = $user_id;
        $data['chat_single'] = Thread::with('receiver', 'sender', 'lastMessage')
                        ->whereHas('messages', function($get_messages) use($user_id) {
                            $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                        })
                        ->with(['messages' => function ($get_messages) use($user_id) {
                                $get_messages->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0");
                            }])
                        ->withCount(['messages' => function ($q) {
                                $q->where('is_read', 0);
                            }])
                        ->where(function ($q) use($user_id) {
                            $q->where('sender_id', $user_id);
                            $q->orWhere('receiver_id', $user_id);
                        })
                        ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                        ->orderBy('updated_at', 'desc')->where('id', $request->chat_id)->first();
        return view('user.messages_ajax', $data);
    }

    function addMessage(Request $request) {
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
        }
        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $chat_user = Thread::where(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                        })
                        ->orwhere(function($q) use($receiver_id, $sender_id) {
                            $q->where('sender_id', $receiver_id);
                            $q->where('receiver_id', $sender_id);
                        })->first();
        if ($chat_user) {
            if ($chat_user->receiver_id == $sender_id) {
                $chat_user->receiver_deleted = 0;
                $chat_user->sender_deleted = 0;
                $chat_user->save();
            }
            if ($chat_user->sender_id == $sender_id) {
                $chat_user->sender_deleted = 0;
                $chat_user->receiver_deleted = 0;
                $chat_user->save();
            }
        }
        if (!$chat_user) {
            $chat_user = new Thread;
            $chat_user->sender_id = $sender_id;
            $chat_user->receiver_id = $receiver_id;
            $chat_user->save();
        }

        $message = new Message;
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->thread_id = $chat_user->id;
        $message->is_read = 0;
        if ($request['message']) {
            $message->message = $request['message'];
        }
        if ($request['file']) {
            if (substr($file_type, 0, 5) == 'image') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'image';
            }
            if (substr($file_type, 0, 5) == 'video') {
                $video = $request['file'];
                $video_data = addVideo($video, 'chat');
                $message->file_path = $video_data['file'];
                $message->poster = $video_data['poster'];
                $message->file_type = 'video';
            }
        }

        $message->save();

        Thread::where(function($q) use($receiver_id, $sender_id) {
                    $q->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id);
                })
                ->orwhere(function($q) use($receiver_id, $sender_id) {
                    $q->where('sender_id', $receiver_id);
                    $q->where('receiver_id', $sender_id);
                })->update(['last_message_id' => $message->id]);
        $mesage = Message::find($message->id);

        $mesage->image_base = asset('public/images');
        $mesage->append = view('user.single_messages_ajax', array('chat_messages' => $mesage, 'current_id' => $this->userId))->render();
        $mesage->video_base = asset('public/videos');
        $data['message'] = $mesage;
        $data['unread_counter'] = Message::where(['receiver_id' => $receiver_id, 'is_read' => 0])->count();
        echo json_encode($data);
    }

    function verifyMessageRequest(Request $request) {
        $current_user = $this->user;
        $user = User::find($request->id);
        if ($user) {
            if ($current_user->user_type == 'user') {
                if ($user->user_type == 'trainer') {
                    $appointment = Appointment::where(['client_id' => $current_user->id, 'trainer_id' => $user->id, 'status' => 'accepted'])
//                            ->whereDate('end_date', ">=", Carbon::now())
                            ->get();
                    if (!$appointment->isEmpty()) {
                        return response()->json(['success' => 'success']);
                    } else {
                        return response()->json(['error' => 'Sorry, you cannot send message to this trainer unless you have a scheduled appointment.']);
                    }
                } else {
                    return response()->json(['error' => 'You cannot send message to another client!']);
                }
            } else if ($current_user->user_type == 'trainer') {
                if ($user->user_type == 'user') {
                    $appointment = Appointment::where(['client_id' => $user->id, 'trainer_id' => $current_user->id, 'status' => 'accepted'])
//                            ->whereDate('end_date', ">=", Carbon::now())
                            ->get();
                    if (!$appointment->isEmpty()) {
                        return response()->json(['success' => 'success']);
                    } else {
                        return response()->json(['error' => 'Sorry, you cannot send message to this trainer unless you have a scheduled appointment.']);
                    }
                } else {
                    return response()->json(['error' => 'Sorry, you cannot send message to this trainer unless you have a scheduled appointment.']);
                }
            }
        } else {
            return response()->json(['error' => 'User Not Found!']);
        }
    }

}
