<div x-data="{ showRetweetThread: false }">

    @if ($tweet->retweets->isNotEmpty())

    <p class="cursor-pointer hover:underline text-blue-500 text-xs" @click="showRetweetThread = !showRetweetThread">
        このスレッドを表示する</p>
    @endif


    @if ($tweet->retweets->isNotEmpty())

    <template x-if="showRetweetThread" class="transition">
        <div class="ml-5 mt-2">
            <ul>
                @foreach ($tweet->retweets as $retweet)
                <li class="border-b last:border-b-0 border-gray-200 p-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="inline-block rounded-full text-gray-600 bg-gray-100 px-2 py-1 text-xs mb-2">
                                {{ $retweet->user->name }}
                            </span>
                            <p class="text-xs">
                                {!! nl2br(e($retweet->body)) !!}
                            </p>
                            <x-tweet.images :images="$retweet->images" />
                        </div>
                        <div>
                            <x-tweet.options :tweetId="$retweet->id" :userId="$retweet->user_id" />
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </template>
    @endif
</div>