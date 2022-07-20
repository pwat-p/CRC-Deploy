@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">Profile</div>
    <div class="border-2 rounded-xl p-6 mt-4 w-3/5 h-3/5 mx-auto">

        <div class="flex justify-center ">
            <div class=" rounded-xl w-full   p-4 ">
                {{-- <div class="w-2/3 mx-auto  my-auto grid grid-cols-2 gap-4  ">
                        <x-label for="name" :value="__('Name')" />
                        <x-label for="name" :value="__($me->name)" />



                        <x-label for="name" :value="__('Email')" />
                        <x-label for="name" :value="__($me->email)" />



                        <x-label for="name" :value="__('Position')" />
                        <x-label for="name" :value="__($me->position)" />



                        <x-label for="name" :value="__('Role')" />
                        <x-label for="name" :value="__($me->role)" />



                        <x-label for="name" :value="__('Branch')" />
                        <x-label for="name" :value="__($branch->name)" />



                </div> --}}
                <table style="width:100%">
                    <tr>
                      <th >Name:</th>
                      <td>{{$me->name}}</td>
                    </tr>
                    <tr>
                      <th>Email:</th>
                      <td>{{$me->email}}</td>
                    </tr>
                    <tr>
                      <th>Position:</th>
                      <td>{{$me->position}}</td>
                    </tr>
                    <tr>
                      <th>Role:</th>
                      <td>{{$me->role}}</td>
                    </tr>
                    <tr>
                      <th>Branch:</th>
                      <td>{{$branch->name}}</td>
                    </tr>
                  </table>
            </div>
        </div>
    </div>


@endsection


