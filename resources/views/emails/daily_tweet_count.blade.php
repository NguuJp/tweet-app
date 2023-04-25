@component('mail::message')

# 昨日は{{ $tweetCount }}件のつぶやきがありました！

{{ $toUser->name }}さん、こんにちは！

昨日は{{ $tweetCount }}件のつぶやきがありました。最新のつぶやきを見に行きましょう。

@component('mail::button', ['url' => route('tweet.index')])
つぶやきを見に行く
@endcomponent

@endcomponent