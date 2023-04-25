@auth
<div x-data="{ tweetContent: '' }">
    <template x-if="showRetweetForm">
        <div class="p-4">
            <form action="{{ route('retweet.create', ['originalTweetId' => $originalTweetId]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="mt-1">
                    <textarea x-model="tweetContent" name="tweet" rows="3"
                        class="focus:ring-blue-400 focus:border-blue-400 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2"
                        placeholder="リツイートを入力"></textarea>
                </div>

                <p class="mt-2 text-sm text-gray-500">140文字まで</p>
                <x-tweet.form.images />

                <div x-show="tweetContent.trim() === ''" class="mt-2">
                    <x-alert.error>リツイートを入力してください</x-alert.error>
                </div>

                <div x-show="tweetContent.trim() !== ''" class="flex flex-wrap justify-end">
                    <x-element.button x-bind:disabled="tweetContent.trim() === ''">
                        リツイート
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </x-element.button>
                </div>
            </form>
        </div>
    </template>
</div>
@endauth
