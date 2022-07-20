@extends('layouts.sidebar')

@section('content')
    <div>
        @if (Auth::user()->role == 'ADMIN')
            <div class="text-center text-5xl py-3">BRANCH OWNER REGISTER</div>
        @endif
        @if (Auth::user()->role == 'BRANCH-OWNER')
            <div class="text-center text-5xl py-3">EMPLOYEE REGISTER</div>
        @endif
        <div class="border-2 rounded-xl p-6 w-3/5 h-full mx-auto">
            {{-- <div class="text-xl font-kanit">
                <i class="fa-solid fa-calendar-check"></i>
                สถานะรถยนต์
            </div> --}}
            <div class="flex justify-center">
                <div class=" rounded-xl w-full p-4 ">
                    <div class="w-2/3 mx-auto">

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('bo.register.create') }}">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-label for="name" :value="__('Name')" />

                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                    required autofocus />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" :value="__('Email')" />

                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                    required />
                            </div>

                            <!-- Position -->
                            <div class="mt-4">
                                <x-label for="position" :value="__('Position')" />

                                <x-input id="position" class="block mt-1 w-full" type="text" name="position"
                                    :value="old('position')" required />
                            </div>

                            @if (Auth::user()->role == 'ADMIN')
                                <div class="mt-4">
                                    <x-label for="branch_id" :value="__('Branch')" />

                                    <select name="branch_id" id="branch_id"
                                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach ($branches as $branch)
                                            <option value='{{ $branch->id }}'>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif


                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Password')" />

                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                    autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required />
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-button class="ml-4">
                                    {{ __('Register') }}
                                </x-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
