<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\PostNotifaction;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
         $post = new PostNotifaction;
         $post->title =$request->get('title');
         $post->description =$request->get('description');
         $post->save();
        $users = User::all();

        if($post){
             foreach ($users as $key => $value) {
                 $this->notification($value->firebase_token, $request->get('title'),$request->get('description'));
             }
         }

        return redirect()->route('home');
    }

    public function notification($token, $title,$description)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$token;

        $notification = [
            'title' => $title,
            'text'=> $description,
            'sound' => true,
        ];

        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AAAAW0Ispeg:APA91bHbcZRc_mbzDwy1-rrqvUMJckL58hAYe8erEaA_JqCiFpCa8sJMn0csQpuVztmoqLLSgsVg-KAjjzFjOuXKfhsuBNw8ccxLPbxf8T2wTA9DVkU1tXpOQB-AJSyO4F9gtgVfeWsb',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }
}
