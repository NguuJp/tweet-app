<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tweet\UpdateRequest; // リクエストクラス
use App\Models\Tweet; // つぶやきモデル
use App\Services\TweetService; // つぶやきサービス

use Illuminate\Http\Request;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException; // 403エラー

class PutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, TweetService $tweetService)
    {
        // 自分のつぶやきかどうかをチェック
        if (!$tweetService->checkOwnTweet($request->user()->id, $request->tweetId())) {
            throw new AccessDeniedHttpException(); // 403エラー
        }
        // 編集内容の更新閭里
        $tweet = Tweet::where('id', $request->tweetId()) // つぶやきIDで検索
            ->firstOrFail(); // 1件を取得し見つからない場合は404エラー
        $tweet->body = $request->tweet(); // つぶやきを更新
        $tweet->save(); // DBに保存
        return redirect()->route('tweet.update.index', ['tweetId' => $tweet->id]) // リダイレクト
            ->with('feedback.success', 'つぶやきを編集しました'); // フィードバックメッセージをセッションに保存
    }
}
