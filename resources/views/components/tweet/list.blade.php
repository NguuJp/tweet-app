@props([
'tweets' => []
])

<div class="bg-white rounded-md shadow-lg mt-5 mb-5">
    <ul>
        @foreach ( $tweets as $tweet )
        <li class="border-b last:border-b-0 border-gray-200 p-4">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-block rounded-full text-gray-600 bg-gray-100 px-2 py-1 text-xs mb-2">
                        {{ $tweet->user->name }}
                    </span>
                    <p class="">
                        {!! nl2br(e($tweet->body)) !!}
                    </p>
                    <x-tweet.images :images="$tweet->images" />
                </div>
                <div>
                    <x-tweet.options :tweetId="$tweet->id" :userId="$tweet->user_id" />
                </div>
            </div>

            @if ($tweet->original_tweet_id)
            <div class="mt-2 p-2 border border-gray-600 rounded-md">

                <span class="inline-block rounded-full text-gray-600 bg-gray-100 px-2 py-1 text-xs mb-2">
                    {{ $tweet->originalTweet->user->name }}
                </span>
                <p class="text-xs">
                {!! nl2br(e($tweet->originalTweet->body)) !!}
                </p>
            </div>

            @endif

            <div class="mt-2">

                <div x-data="{ showRetweetForm: false }">

                    <div class="flex flex-row items-center gap-2">

                        <x-tweet.show-retweet :tweet="$tweet" />

                        <x-tweet.form.likes :tweet="$tweet" />
                    </div>

                    <x-tweet.form.post-retweet :originalTweetId="$tweet->id" />

                </div>

            </div>

            <div class="mt-2">

                <x-tweet.list-retweet :tweet="$tweet" />

            </div>

        </li>
        @endforeach
    </ul>
</div>