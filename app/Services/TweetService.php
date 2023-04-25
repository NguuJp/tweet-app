<?php

namespace App\Services;

use App\Models\Tweet;
use Carbon\Carbon;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TweetService
{
    // つぶやきを取得
    public function getTweets()
    {
        return Tweet::with('images') // つぶやきに紐づく画像を取得
            ->orderBy('created_at', 'desc') // つぶやきを作成した日時の降順で取得
            ->get(); // つぶやきを取得
    }

    // 自分のつぶやきかどうかを判定するメソッド
    public function checkOwnTweet(int $userId, int $tweetId): bool
    {
        $tweet = Tweet::where('id', $tweetId)->first(); // つぶやきを取得
        if (!$tweet) {
            return false;
        }
        return $tweet->user_id === $userId; // つぶやきのユーザーIDとログインしているユーザーのIDが一致するかどうかを返す
    }

    // 前日のつぶやき数を取得するメソッド
    public function countYesterdayTweets(): int
    {
        return Tweet::whereDate('created_at', '>=', Carbon::yesterday()->toDateTimeString()) // 前日の日付を取得
            ->whereDate('created_at', '<', Carbon::today()->toDateTimeString()) // 今日の日付を取得
            ->count(); // つぶやき数を取得
    }

    // つぶやきと画像を一緒に保存するメソッド
    public function saveTweet(int $userId, string $body, array $images): void
    {
        DB::transaction(function () use ($userId, $body, $images) {
            $tweet = new Tweet(); // つぶやきモデルのインスタンスを作成
            $tweet->user_id = $userId; // ユーザーIDをセット
            $tweet->body = $body; // つぶやきをセット
            $tweet->save(); // つぶやきを保存
            foreach ($images as $image) {
                Storage::putFile('public/images', $image); // 画像を保存
                $imageModel = new Image(); // 画像モデルのインスタンスを作成
                $imageModel->name = $image->hashName(); // 画像のハッシュ名をセット
                $imageModel->save(); // 画像を保存
                $tweet->images()->attach($imageModel->id); // つぶやきと画像を紐づける
            }
        });
    }
    // つぶやきと画像を一緒に保存するメソッド
    public function saveReTweet(int $userId, string $body, int $originalTweetId, array $images): void
    {
        DB::transaction(function () use ($userId, $body, $originalTweetId, $images) {
            $tweet = new Tweet(); // つぶやきモデルのインスタンスを作成
            $tweet->user_id = $userId; // ユーザーIDをセット
            $tweet->body = $body; // つぶやきをセット
            $tweet->original_tweet_id = $originalTweetId;
            $tweet->save(); // つぶやきを保存
            foreach ($images as $image) {
                Storage::putFile('public/images', $image); // 画像を保存
                $imageModel = new Image(); // 画像モデルのインスタンスを作成
                $imageModel->name = $image->hashName(); // 画像のハッシュ名をセット
                $imageModel->save(); // 画像を保存
                $tweet->images()->attach($imageModel->id); // つぶやきと画像を紐づける
            }
        });
    }

    // つぶやきを削除時に画像も削除するメソッド
    public function deleteTweet(int $tweetId): void
    {
        DB::transaction(function () use ($tweetId) {
            $tweet = Tweet::where('id', $tweetId)->firstOrFail(); // つぶやきを取得
            $tweet->images()->each(function ($image) use ($tweet) {
                $filePath = 'public/images/' . $image->name; // 画像のパスを取得
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath); // 画像を削除
                }
                $tweet->images()->detach($image->id); // つぶやきと画像の紐づけを解除
                $image->delete(); // 画像を削除
            });
            $tweet->delete(); // つぶやきを削除
        });
    }
}
