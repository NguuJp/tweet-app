<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Services\TweetService; // つぶやきサービス

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException; // 403エラー

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TweetService $tweetService)
    {
        // つぶやきの削除
        $tweetId = (int) $request->route('tweetId'); // つぶやきIDをリクエストから取得
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) { // 自分のつぶやきかどうかをチェック
            throw new AccessDeniedHttpException(); // 403エラー
        }

        $tweetService->deleteTweet($tweetId); // つぶやきを削除

        return redirect()->route('tweet.index') // リダイレクト
            ->with('feedback.success', 'つぶやきを削除しました'); // フィードバックメッセージをセッションに保存
    }
}
