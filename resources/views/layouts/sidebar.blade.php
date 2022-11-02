<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <title>@yield('title')</title>
</head>
<body >
<div class="min-h-screen flex">
    <div class="bg-blue-500 w-64 px-4 space-y-8">
        <div class="flex items-center justify-center space-x-2 py-8 border-b-2 border-blue-300">
            <img src="{{ asset('css/images/logo.png')}}" alt="logo" class="w-16">
            <div class="text-2xl font-bold text-gray-100 font-kanit">CRC</div>
        </div>
        <a href="{{ route('repairOrder.index') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100 {{ request()->is('repairOrder') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-chart-line"></i>
                <span>
                    Dashboard
                </span>
            </div>
            <i class="fa-solid fa-angle-right"></i>
        </a>
        @if (Auth::user()->role == 'ADMIN')

        <a href="{{ route('repairOrder.create') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100 {{ request()->is('repairOrder/create') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-circle-plus"></i>
                <span>
                    Create
                </span>
            </div>
            <i class="fa-solid fa-angle-right"></i>

        </a>
        <a href="{{ route('branch') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100 {{ request()->is('repairOrder/create') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-circle-plus"></i>
                <span>
                    ORIGINAL INFORMATION
                </span>
            </div>
            <i class="fa-solid fa-angle-right"></i>

        </a>
        @endif

        @if (Auth::user()->role != 'ADMIN')
        <a href="{{ route('repairOrder.create') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100 {{ request()->is('repairOrder/create') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-circle-plus"></i>
                <span>
                    Create
                </span>
            </div>
            <i class="fa-solid fa-angle-right"></i>

        </a>
        @endif

        @if (Auth::user()->role != 'EMPLOYEE')
            <a href="{{ route('bo.register') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
            hover:text-gray-100">
                <div class="space-x-2">
                    <i class="fa-solid fa-user-group"></i>
                    <span>
                        Register
                    </span>
                </div>

                <i class="fa-solid fa-angle-right"></i>
            </a>
        @endif
        <a href="{{ route('userlist') }}" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100">
            <div class="space-x-2">
                <i class="fa-solid fa-table-list"></i>
                <span>
                    User list
                </span>
            </div>
            <i class="fa-solid fa-angle-right"></i>
        </a>

        <div class="dropdown  text-xl text-gray-300 font-kanit flex justify-between items-center
        hover:text-gray-100 {{ request()->is('repairOrder/create') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-user"></i>
                <button >Profile</button>
            </div>

            <i class="fa-solid fa-angle-right"></i>

            <div class="dropdown-content rounded-md" >
                <a href="{{ route('profile') }}">Information</a>
                <a href="{{ route('repassword') }}">Change password</a>
              </div>
        </div>


        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="block text-xl text-gray-300 font-kanit flex justify-between items-center
            hover:text-gray-100 {{ request()->is('repairOrder/create') ? 'text-gray-100' : 'text-gray-300' }}">
            <div class="space-x-2">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>
                    {{ __('Log Out') }}

                </span>
            </div>
            </button>
        </form>

    </div>

    <div class="container mx-auto">
        @yield('content')
    </div>
</div>
</body>
    @yield('script')
</html>
