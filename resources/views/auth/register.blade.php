<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <div class=" mt-4">
        <p class="text-center">Login as user:</p>
        <form action="{{ route('auth.google.redirect') }}" method="GET" class="flex items-center justify-center mt-4">
            @csrf
            <button type="submit">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.0811 30.2156L9.34062 36.7128L2.97939 36.8474C1.07832 33.3213 0 29.2871 0 25C0 20.8543 1.0082 16.945 2.79531 13.5027H2.79668L8.45996 14.541L10.9408 20.1703C10.4216 21.684 10.1386 23.309 10.1386 25C10.1388 26.8351 10.4712 28.5934 11.0811 30.2156Z" fill="#FBBB00"></path>
                    <path d="M49.5631 20.3296C49.8502 21.8419 50 23.4037 50 24.9999C50 26.7897 49.8118 28.5356 49.4533 30.2197C48.2363 35.9505 45.0563 40.9546 40.6511 44.4958L40.6498 44.4944L33.5166 44.1305L32.507 37.8282C35.43 36.114 37.7144 33.4312 38.9177 30.2197H25.5496V20.3296H39.1127H49.5631Z" fill="#518EF8"></path>
                    <path d="M40.6498 44.4946L40.6512 44.496C36.3669 47.9396 30.9245 50.0001 25.0001 50.0001C15.4795 50.0001 7.20205 44.6787 2.97949 36.8477L11.0812 30.2158C13.1924 35.8504 18.6278 39.8614 25.0001 39.8614C27.7391 39.8614 30.3051 39.121 32.5069 37.8284L40.6498 44.4946Z" fill="#28B446"></path>
                    <path d="M40.9575 5.75547L32.8586 12.3859C30.5798 10.9615 27.886 10.1387 25.0001 10.1387C18.4836 10.1387 12.9465 14.3337 10.941 20.1703L2.79678 13.5027H2.79541C6.95615 5.48076 15.338 0 25.0001 0C31.066 0 36.6278 2.16074 40.9575 5.75547Z" fill="#F14336"></path>
                </svg>
            </button>
        </form>
    </div>
</x-guest-layout>
