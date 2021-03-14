<?php

use App\FitnessGoal;
use App\Pages;
use App\TrainerTrainingType;
use App\PaymentHistory;
use Twilio\Rest\Client;
use Twilio\Twiml;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Support\Str;

function fitnessGoals() {
    $data['fitness_goals'] = FitnessGoal::where('is_approved_by_admin', '1')->get();
    return $data;
}

function trainerQualifications() {
    $data['qualifications'] = \App\Qualification::where('is_approved_by_admin', '1')->get();
    return $data;
}

function trainerSpecializations() {
    $data['specializations'] = \App\Specialization::where('is_approved_by_admin', '1')->get();
    return $data;
}

function trainingTypes() {
    $data['training_types'] = \App\TrainingType::where('is_enabled', 1)->get();
    return $data;
}

function getUnreadMessages() {
    return App\Message::where(array('is_read' => 0, 'receiver_id' => Auth::user()->id))->count();
}

function getUnseenAppointmentsForTrainer() {
    return App\Appointment::where(array('is_seen_by_trainer' => 0, 'trainer_id' => Auth::user()->id, 'type' => 'session'))->count();
}

function timeago($ptime) {
    $difference = time() - strtotime($ptime);
    if ($difference) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        for ($j = 0; $difference >= $lengths[$j]; $j++)
            $difference /= $lengths[$j];

        $difference = round($difference);
        if ($difference != 1)
            $periods[$j] .= "s";

        $text = "$difference $periods[$j] ago";


        return $text;
    }else {
        return 'Just Now';
    }
}

function getUserImage($image) {
    if ($image) {
        return asset('public/images/' . $image);
    }
    return asset('public/images/users/default.jpg');
}

function getClassImage($image) {
    if ($image) {
        return asset('public/images/' . $image);
    }
    return asset('public/images/classes/placeholder.jpg');
}

function addFile($file, $path) {
    if ($file) {
        if ($file->getClientOriginalExtension() != 'exe') {
            $type = $file->getClientMimeType();
            if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                $destination_path = 'public/images/' . $path; // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = 'image_' . Str::random(15) . '.' . $extension; // renameing image
                $file->move($destination_path, $fileName);
                $file_path = $path . '/' . $fileName;
                return $file_path;
            } else {
                return False;
            }
        } else {
            return False;
        }
    } else {
        return False;
    }
}

function addVideo($video, $path) {
    $video_extension = $video->getClientOriginalExtension(); // getting image extension
    $video_extension = strtolower($video_extension);
    $allowedextentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
        "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
        "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
        "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
        "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
        "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
        "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
        "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
        "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
        "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
        "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
        "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
        "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
        "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
        "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
        "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
        "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"];
    if (in_array($video_extension, $allowedextentions)) {
        $video_destinationPath = base_path('public/videos/' . $path); // upload path
        $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
        $fileDestination = $video_destinationPath . '/' . $video_fileName;
        $filePath = $video->getRealPath();
        exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
        $info = getVideoInformation($result);
        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
        $poster = 'public/images/' . $path . '/posters/' . $poster_name;
        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
        $data['file'] = '/' . $path . '/' . $video_fileName;
        $data['poster'] = '/' . $path . '/posters/' . $poster_name;
    } else {
        $data['file'] = '';
        $data['poster'] = '';
    }
    return $data;
}

function getVideoInformation($video_information) {
    $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
    if (preg_match($regex_duration, implode(" ", $video_information), $regs)) {
        $hours = $regs [1] ? $regs [1] : null;
        $mins = $regs [2] ? $regs [2] : null;
        $secs = $regs [3] ? $regs [3] : null;
        $ms = $regs [4] ? $regs [4] : null;
        $random_duration = sprintf("%02d:%02d:%02d", rand(0, $hours), rand(0, $mins), rand(0, $secs));
        $original_duration = $hours . ":" . $mins . ":" . $secs;
        $parsed = date_parse($original_duration);
        $seconds = ($parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']) > 20 ? true : false;
        return [$original_duration, $random_duration, $seconds];
    }
}

function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 3959) {
    $obj = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=' . $latitudeFrom . ',' . $longitudeFrom . '&destinations=' . $latitudeTo . ',' . $longitudeTo . '&mode=driving&sensor=false&key=' . env('GOOGLE_API_KEY')));
    $data['status'] = $obj->status;
    if ($obj->status == 'OK') {
        $distance = $obj->rows[0]->elements[0]->distance;
        $data['distance'] = $distance->value / 1609.34;
        $duration = $obj->rows[0]->elements[0]->duration;
        $data['duration'] = $duration->value / 60;
    }
    return $data;
}

function hasRights($user_id, $right_id) {
    $traner_type_ids = TrainerTrainingType::where('trainer_id', $user_id)->pluck('training_type_id')->toArray();
    if (in_array($right_id, $traner_type_ids)) {
        return true;
    } else {
        return false;
    }
}

function getAddress($latitude, $longitude) {
    if (!empty($latitude) && !empty($longitude)) {
        //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=false');
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        //Get address from json data
        $address = ($status == "OK") ? $output->results[1]->formatted_address : '';
        //Return address of the given latitude and longitude
        if (!empty($address)) {
            return $address;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) : DateTimeZone::listIdentifiers();

    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

//only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach ($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat = $location['latitude'];
                $tz_long = $location['longitude'];

                $theta = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
// echo '<br />'.$timezone_id.' '.$distance; 

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }
        return $time_zone;
    }
    return 'unknown';
}

function getPage() {
    return Pages::where('status', 1)->orderBy('id', 'ASC')->limit(2)->get();
}

function savePaymentHistory($user_id, $trainer_id, $class_id = null, $appointment_id, $amount, $number_of_passes, $cancel_by = null) {
    $add_history = new PaymentHistory;
    $add_history->user_id = $user_id;
    $add_history->appointment_id = $appointment_id;
    $add_history->trainer_id = $trainer_id;
    $add_history->class_id = $class_id;
    $add_history->amount = $amount;
    $add_history->number_of_passes = $number_of_passes;
    $add_history->is_payout = 0;
    $add_history->cancel_by = $cancel_by;
    $add_history->save();
}

function sendSms($phone_number, $message_body) {
    $sid = "AC79bca7c2c197e5b3f1749db9d7c2f4af";
    $token = "b5278401f32055d452fcee8621b438ea";
    $phone_number = str_replace('(', '', $phone_number);
    $phone_number = str_replace(')', '', $phone_number);
    $phone_number = str_replace('-', '', $phone_number);
    $phone_number = '+1' . str_replace(' ', '', $phone_number);
    try {
        $client = new Client($sid, $token);
        $message = $client->messages->create(
                $phone_number, array(
            "from" => "+17032159142",
            "body" => $message_body,
            "provideFeedback" => True
                )
        );
        $message_sid = $message->sid;
    } catch (\Twilio\Exceptions\TwilioException $e) {
//  return Redirect::back()->with('number_error', 'The phone number associated with this email is not valid');
    }
}

function image_fix_orientation($filename) {
    $exif = @exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);

        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        imagejpeg($image, $filename, 90);
    }
    return $filename;
}
