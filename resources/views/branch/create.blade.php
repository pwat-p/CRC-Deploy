@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">Branches</div>
    <div class="flex w-full mx-auto p-6">

        <div class="border-2 rounded-xl p-6   w-full  mx-auto my-6">
            <div class="w-full flex text-right justify-end">
                {{-- <x-label for="name" :value="__('Add branch')" /> --}}

                <form action="{{ route('branch.store') }}" method="POST">
                    @csrf
                    <div class="flex ">
                        {{-- <input id="name" class=" mt-1 w-full rounded-sm" type="password" name="name"
                        required autofocus /> --}}
                        <input type="text"  placeholder="Add branch" name="name"
                         class="outline-none ring-2 ring-gray-100 ring-offset-2 ring-offset-gray-300 rounded-tl-xl rounded-bl-xl px-3 py-1" required autofocus/>

                        {{-- <button class="p-2 px-4 bg-blue-400 rounded-full text-white">Add</button>
                         --}}
                         <button class="bg-gray-100 py-2 px-3 rounded-tr-xl rounded-br-xl hover:bg-gray-300"
                                    type="submit">
                                <i class="fa-solid fa-plus"></i>
                    </div>
                </form>
            </div>
            <table class="w-full mt-5">
                <thead>
                    <tr class="font-kanit text-lg text-center bg-gray-300">
                        <th class="py-3 px-2 border-r-2 w-40">Branch</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($branches as $branch)
                        <tr class="text-center hover:bg-gray-100 hover:opacity-90">
                            <td>{{ $branch->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('script')
    <script>

    </script>
@endsection
