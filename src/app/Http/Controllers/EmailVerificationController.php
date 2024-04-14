<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    // メール確認の通知
    public function notification()
    {
        return view('auth.verify-email');
    }

    // メールリンク検証
    public function verification (EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/');
    }

    // 確認メール送信
    public function sendNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証用メールを送信しました');
    }

}
