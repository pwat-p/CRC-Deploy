@extends('layouts.sidebar')

@section('content')

<div class="text-center text-5xl py-3">Change password</div>
<div class="border-2 rounded-xl p-6 mt-4 w-3/5 h-3/5 mx-auto">

    <div class="flex justify-center ">
        <div class=" rounded-xl w-full   p-4 ">
            <div class="w-2/3 mx-auto h-full my-auto">
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="POST" action="{{ route('repassword.re') }}">
                    @csrf
                    <div>
                        <x-label for="password_old" :value="__('Old password')" />

                        <x-input id="password_old" class="block mt-1 w-full" type="password" name="password_old" :value="old('password_old')"
                            required autofocus />
                    </div>
                    <div>
                        <x-label for="password_new" :value="__('New password')" />

                        <x-input id="password_new" class="block mt-1 w-full" type="password" name="password_new" :value="old('password_new')"
                            required autofocus />
                    </div>
                    <div class="mt-4">
                        <x-label for="password_new_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_new_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_new_confirmation" required />
                    </div>
                    <div class="flex items-center justify-end mt-4">

                        <x-button class="ml-4">
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


