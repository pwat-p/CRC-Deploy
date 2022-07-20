<x-guest-layout>

    <div>

        <div class="h-screen flex justify-center items-center ">

            <div class="lg:grid grid-cols-3  w-4/5 mx-auto h-2/3 my-auto block">
                <div class="h-1/2 lg:h-4/5 lg:col-span-2 rounded-tl-lg rounded-bl-lg   flex justify-center items-center">
                    <div>

                        <img src="{{ asset('css/images/logo.png')}}" alt="" class="w-1/4 h-1/5 mx-auto">

                        <p class="  w-1/3 mx-auto font-bold text-xl">
                        Where Car can be repaired description  Car Repair Center description </p>
                    </div>
                </div>
                <div class="bg-white flex justify-center items-center rounded-tr-lg rounded-br-lg py-4">
                    <div class=" w-1/2">

                        {{-- <a href="/"> --}}
                            {{-- <img src="{{ asset('css/images/demo-logo.png')}}" alt="" class="w-20 h-20 mx-auto"> --}}

                            {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500 mx-auto" /> --}}
                        {{-- </a> --}}
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div>
                                <x-label for="email" :value="__('Email')" />

                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                    required autofocus />
                            </div>

                            <div class="mt-4">
                                <x-label for="password" :value="__('Password')" />

                                <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="current-password" />
                            </div>

                            <!-- Remember Me -->
                            <div class="block mt-4">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            <div class="flex items-center justify-end mt-4">

                                <button class="login-button">
                                    Log in
                                </button>
                            </div>

                            <div class="text-center mt-4 pt-4 border-t-2 border-slate-300">
                                สำนักงานซ่อมรถ ศูนย์ซ่อมรถ
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- <x-auth-card>
            <x-slot name="logo">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </x-slot>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <div class="flex items-center justify-end mt-4">

                    <button class="login-button">
                        Log in
                    </button>
                </div>
            </form>
        </x-auth-card> --}}

</x-guest-layout>
