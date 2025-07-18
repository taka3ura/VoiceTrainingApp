<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            ユーザー情報
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            ユーザー情報の変更ができます
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- 練習メニュー -->
        <div>
            <x-input-label for="practice_menu" value="練習メニュー" />
            <textarea
                id="practice_menu"
                name="practice_menu"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                rows="8">{{ old('practice_menu', $user->practice_menu) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('practice_menu')" />
        </div>
        <!-- 保存ボタン -->
        <div class="flex items-center gap-4">
            <x-primary-button>保存</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
        <!-- 名前 -->
        <div>
            <x-input-label for="name" value="名前" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <!-- プロフィール画像 -->
        <div>
            <x-input-label for="image" value="プロフィール画像" />
            <x-user-image /><!-- user-image.blade.phpの内容をインポート -->
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>
        <!-- プロフィール文 -->
        <div>
            <x-input-label for="profile_description" value="プロフィール文" />
            <textarea id="profile_description" name="profile_description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('profile_description', $user->profile_description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('profile_description')" />
        </div>
        <!-- メールアドレス -->
        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>保存</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>