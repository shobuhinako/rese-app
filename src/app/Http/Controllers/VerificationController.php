<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        // ユーザーを取得
        $user = User::findOrFail($id);

        // メールアドレスのハッシュを検証
        if (sha1($user->email) !== $hash) {
            abort(403);
        }

        // ユーザーのメールアドレスを認証済みに設定
        $user->markEmailAsVerified();

        // 本人確認完了メッセージとログインURLを含むビューを返す
        return view('emails.verification_complete');
    }
}
