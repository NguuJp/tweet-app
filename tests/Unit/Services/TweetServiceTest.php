<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\TweetService;
use Mockery;

class TweetServiceTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * 
     */
    public function test_check_own_tweet(): void
    {
        $tweetService = new TweetService(); // TweetServiceクラスのインスタンスを作成

        $mock = Mockery::mock('alias:App\Models\Tweet'); // Tweetモデルのモックを作成
        $mock->shouldReceive('where->first') // whereメソッドとfirstメソッドをモック化
            ->andReturn((object) ['id' => 1, 'user_id' => 1]); // モック化したメソッドの返り値を設定

        $result = $tweetService->checkOwnTweet(1, 1); // テスト対象のメソッドを実行
        $this->assertTrue($result); // テストが成功したことを示す

        $result = $tweetService->checkOwnTweet(2, 1); // テスト対象のメソッドを実行
        $this->assertFalse($result); // テストが失敗したことを示す
    }
}
