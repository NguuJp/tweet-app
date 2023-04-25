<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tweet\CreateRequest;
use App\Models\Tweet;
use App\Services\TweetService;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request, TweetService $tweetService)
    {
        // フォームから送信されたデータをDBに反映
        $tweetService->saveTweet(
            $request->userId(), // ユーザーID
            $request->tweet(), // つぶやき
            $request->images() // 画像
        );
        return redirect()->route('tweet.index'); // 一覧画面にリダイレクト
    }
}
