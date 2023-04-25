<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * ログインテスト
     */
    public function testSuccessfulLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(); // ユーザーを作成
            $browser->visit('/login') // ログインページにアクセス
                ->type('email', $user->email) // メールアドレスを入力
                ->type('password', 'password') // パスワードを入力
                ->press('ログイン') // 「ログイン」ボタンをクリック
                ->assertPathIs('/tweet') // ログイン後のページに遷移していることを確認
                ->assertSee('つぶやきアプリ'); // ログイン後のページに「つぶやきアプリ」という文字列があることを確認
        });
    }
}
