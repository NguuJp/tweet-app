<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tweet\CreateRequest;
use App\Services\TweetService;
use App\Models\Tweet;

class RetweetCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request, TweetService $tweetService)
    {
        // フォームから送信されたデータをDBに反映
        $tweetService->saveReTweet(
            $request->userId(), // ユーザーID
            $request->tweet(), // つぶやき
            $request->originalTweetId(), // つぶやき
            $request->images() // 画像
        );
        return redirect()->route('tweet.index'); // 一覧画面にリダイレクト
    }
}
