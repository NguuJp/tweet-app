<?php

namespace Tests\Feature\Tweet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

class DeleteTest extends TestCase
{

    use RefreshDatabase; // テスト実行前にマイグレーションを実行

    /**
     * ツイート削除のテスト
     */

    public function test_delete_successed(): void
    {
        $user = User::factory()->create(); // ユーザーを作成
        $tweet = Tweet::factory()->create(['user_id' => $user->id]); // ツイートを作成

        $this->actingAs($user); // ログイン状態にする

        $response = $this->delete(route('tweet.delete', $tweet->id)); // ツイート削除

        $response->assertRedirect(route('tweet.index')); // リダイレクト先が正しいか
    }
}
