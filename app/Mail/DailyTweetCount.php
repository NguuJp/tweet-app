<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyTweetCount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $toUser;
    public int $tweetCount;

    /**
     * Create a new message instance.
     */
    public function __construct(User $toUser, int $tweetCount)
    {
        $this->toUser = $toUser;
        $this->tweetCount = $tweetCount;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("昨日は{$this->tweetCount}件のつぶやきが投稿されました！")
            ->markdown('emails.daily_tweet_count');
    }
}
