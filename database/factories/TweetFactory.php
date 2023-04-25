<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tweet>
 */
class TweetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // ユーザーIDを指定、デフォルトは1
            'original_tweet_id' => null, // リツイート元のツイートIDを指定、デフォルトはnull
            'body' => $this->faker->realText(100), // ツイート内容を指定
            'created_at' => Carbon::now()->yesterday(), // つぶやきを作成した日時を指定
        ];
    }
}
