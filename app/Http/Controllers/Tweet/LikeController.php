<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, Tweet $tweet)
    {
        // ログインユーザーがツイートをいいねする処理
        Auth::user()->likes()->attach($tweet->id);
        return redirect()->back();
    }

    public function destroy(Request $request, Tweet $tweet)
    {
        // ログインユーザーがツイートのいいねを解除する処理
        Auth::user()->likes()->detach($tweet->id);
        return redirect()->back();
    }
}
