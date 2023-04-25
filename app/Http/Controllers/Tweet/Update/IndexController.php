<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Http\Controllers\Controller;
use App\Models\Tweet; // つぶやきモデル
use App\Services\TweetService; // つぶやきサービス

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException; // 403エラー

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TweetService $tweetService)
    {
        $tweetId = (int) $request->route('tweetId'); // つぶやきID
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) { // 自分のつぶやきかどうかをチェック
            throw new AccessDeniedHttpException(); // 403エラー
        }

        $tweet = Tweet::where('id', $tweetId) // つぶやきIDで検索
            ->firstOrFail(); // 1件を取得し見つからない場合は404エラー
        return view('tweet.update') // ビューを返す
            ->with('tweet', $tweet); // つぶやきをビューに渡す
    }
}
