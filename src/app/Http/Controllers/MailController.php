<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\InformationEmail;
use Illuminate\Http\Request;
use App\Models\User;

class MailController extends Controller
{
    public function email(){
        return view('send_email');
    }

    public function sendEmail(Request $request){
        $users = User::all();
        foreach($users as $user)
        $data = [
        'subject' => $request->input('subject'),
        'message' => $request->input('message'),
    ];
    Mail::to($user->email)->send(new InformationEmail($data));
    return redirect('/send_email')->with('result', 'メールが送信されました。');
    }
}
