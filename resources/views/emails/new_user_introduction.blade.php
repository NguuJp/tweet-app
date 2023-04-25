@component('mail::message')

# 新しいユーザーが参加しました！

{{ $toUser->name }}さん、こんにちは！

@component('mail::panel')
新しく{{ $newUser->name }}さんが参加しました。
@endcomponent

@component('mail::button', ['url' => route('tweet.index')])
つぶやきを見に行く
@endcomponent

@endcomponent