@extends('layouts.sidebar')

@section('content')
    <div>
        @if (Auth::user()->role == 'ADMIN')
            @foreach ($dataBybranch['data'] as $datum)
                <div class="border-2 rounded-xl p-6 w-full lg:w-4/5  h-full mx-auto my-6">
                    <div class="text-xl font-kanit">
                        <i class="fa-solid fa-calendar-check"></i>
                        Branch : {{ $datum['branch_name'] }}
                    </div>
                    <table class="w-full mt-5">
                        <thead>
                            <tr class="font-kanit text-lg text-center bg-gray-300">
                                <th class="py-3 px-2 border-r-2 w-40">name</th>
                                <th class="py-3 px-2 border-r-2 w-40">email</th>
                                <th class="py-3 px-2 border-r-2 w-40">position</th>
                                <th class="py-3 px-2 border-r-2 w-40">role</th>
                                <th class="py-3 px-2 border-r-2 w-40"></th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($datum['users'] as $user)
                                <tr class="text-center hover:bg-gray-100 hover:opacity-90">


                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->position }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="py-1">
                                        <form action="{{ route("user.delete", ['id' => $user->id ]) }}" method="POST">
                                            @csrf
                                            <button class="delete_button" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endif
        @if (Auth::user()->role != 'ADMIN')

                <div class="border-2 rounded-xl p-6 w-full lg:w-4/5  h-full mx-auto my-6">
                    <div class="text-xl font-kanit">
                        <i class="fa-solid fa-calendar-check"></i>
                        Branch : {{ $dataBybranch['branch_name']->name }}
                    </div>
                    <table class="w-full mt-5">
                        <thead>
                            <tr class="font-kanit text-lg text-center bg-gray-300">
                                <th class="py-3 px-2 border-r-2 w-40">name</th>
                                <th class="py-3 px-2 border-r-2 w-40">email</th>
                                <th class="py-3 px-2 border-r-2 w-40">position</th>
                                <th class="py-3 px-2 border-r-2 w-40">role</th>
                                <th class="py-3 px-2 border-r-2 w-40"></th>

                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($dataBybranch['users'] as $user)
                                <tr class="text-center hover:bg-gray-100 hover:opacity-90">


                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->position }}</td>
                                    <td>{{ $user->role }}</td>
                                    @if ($user->role == 'EMPLOYEE' && Auth::user()->role != 'EMPLOYEE')
                                    <td class="py-1">
                                        <form action="{{ route("user.delete", ['id' => $user->id ]) }}" method="POST">
                                            @csrf
                                            <button class="delete_button" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                </div>
        @endif

        <dialog class="modal" id="modal">
            <h2>modal title</h2>
            <p>modal modal modal</p>
            <button>close button</button>
        </dialog>
    </div>


@endsection


