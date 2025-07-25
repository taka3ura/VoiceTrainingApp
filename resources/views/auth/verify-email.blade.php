<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        ご登録ありがとうございます！利用を開始する前に、ご登録いただいたメールアドレスに送られた認証リンクをクリックして、メールアドレスを確認してください。もしメールが届かない場合は、再送信できます。
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
        新しい認証リンクを、ご登録いただいたメールアドレスに送信しました。
    </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    認証メールを再送信
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                ログアウト
            </button>
        </form>
    </div>
</x-guest-layout>