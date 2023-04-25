<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\DailyTweetCount;
use App\Services\TweetService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;

class SendDailyTweetCountMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-daily-tweet-count-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '前日のつぶやき数を集計してつぶやきを促すメールを送信';

    private TweetService $tweetService;
    private Mailer $mailer;

    /**
     * Create a new command instance.
     */

    public function __construct(TweetService $tweetService, Mailer $mailer)
    {
        parent::__construct();
        $this->tweetService = $tweetService;
        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tweetCount = $this->tweetService->countYesterdayTweets(); // 前日のつぶやき数を取得

        $users = User::get();

        foreach ($users as $user) {
            $this->mailer->to($user->email)->send(new DailyTweetCount($user, $tweetCount)); // メールを送信
        }

        return 0; // 0を返すとコマンドが成功したことを示す
    }
}
