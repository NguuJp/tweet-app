<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    // TweetモデルからUserモデルを参照するためのメソッド
    public function user()
    {
        return $this->belongsTo(User::class); // Userモデルを参照
    }

    public function originalTweet()
    {
        return $this->belongsTo(Tweet::class, 'original_tweet_id');
    }

    // Tweetモデルから中間テーブルを経由してImageモデルを紐付けるためのメソッド
    public function images()
    {
        return $this->belongsToMany(Image::class, 'tweets_images') // 中間テーブルを経由してImageモデルを参照
            ->using(TweetImage::class); // 中間テーブルのモデルを指定
    }

    public function retweets()
    {
        return $this->hasMany(Tweet::class, 'original_tweet_id');
    }

    // TweetモデルからLikeモデルを参照するためのメソッド
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
}
