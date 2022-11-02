@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">ORIGINAL INFORMATION</div>
    <div class=" w-full mx-auto p-6">
        {{-- Branches table --}}
        <x-original-information-table-component :list="$branches" name='สาขา' :storeaction="route('branch.store')" :updateaction="url('edit-branch/')"
            destroyaction='branch.remove' />


        <div class="flex gap-6">
            {{-- Colors table --}}
            <x-original-information-table-component :list="$colors" name='สี' :storeaction="route('color.store')" :updateaction="url('edit-color/')"
                destroyaction='color.remove' style="height: fit-content" />

            {{-- Models table --}}
            {{-- <x-original-information-table-component  :list="$models" name='รุ่น' :storeaction="route('model.store')"
            :updateaction="url('edit-model/')" destroyaction='model.remove' /> --}}

            <div class="border-2 rounded-xl p-6   w-full  mx-auto my-6">
                <div class="w-full flex text-right justify-end">
                    <button class="bg-gray-100 py-2 px-3 rounded-xl hover:bg-gray-300"
                        onclick="openModelModal()" type="">เพิ่มรุ่น</button>
                </div>
                <table class="w-full mt-5">
                    <thead>
                        <tr class="font-kanit text-lg text-center bg-gray-300">
                            <th class="py-3 px-2 border-r-2 w-40">รูป</th>
                            <th class="py-3 px-2 border-r-2 w-40">รุ่น</th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($models as $model)
                            <tr class="text-center hover:bg-gray-100 hover:opacity-90" style="height: 80px">
                                <td class="w-1/5">
                                    @if ($model->model_image)
                                        <img src="{{ url($model->model_image) }}" alt="car"
                                            class="mx-auto mt-2 bg-center shadow-md rounded-full"
                                            style="width: 100px; height: 100px;">
                                    @endif
                                </td>
                                <td class="w-3/5"> {{ $model->name }} </td>
                                <td class="py-1 w-1/10">
                                    <button class="button open-button"
                                        onclick="openEditModelModal( {{ $model->id }} ,
                                        '{{ $model->name }}' , '{{ gettype($model->model_image) == 'string' ? url($model->model_image) : '' }}' ,
                                        '{{ route('model.update', ['id' => $model->id]) }}' )">
                                        <i class="fa-solid fa-pen-to-square"></i></button>
                                </td>
                                <td class="py-1 w-1/10">
                                    <form action="{{ route('model.remove', ['id' => $model->id]) }}" method="POST">
                                        @csrf
                                        <button class="delete_button" onclick="return confirm('Are you sure?')"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <dialog class="p-8 my-auto w-1/3 h-1/3 rounded-lg shadow-lg border-gray-300 border-2" id="modelModal">

                <div class="h-full">
                    <div class="h-full flex flex-col justify-between">
                        <h1 id="header" class="font-bold text-3xl">เพิ่มรุ่น</h1>
                        <hr>
                        <form method="POST" action="{{ route('model.store') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="">
                                <div id="upload" class="flex justify-center items-center w-full">

                                    <label for="input_model_image"
                                        class="mx-auto mb-4 rounded-full flex flex-col relative overflow-hidden justify-center items-center  bg-gray-50  border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-100"
                                        style="width: 100px;height: 100px;">
                                        <img id="model_preview_image" alt="preview image"
                                            class="hidden h-full w-full hover:opacity-30 absolute rounded-full">
                                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                            <p class="mb-2 text-sm text-center text-gray-500"><span
                                                    class="font-semibold">คลิกเพื่ออัพโหลด</span>
                                            </p>
                                        </div>
                                        <input id="input_model_image" type="file" name="model_image"
                                            accept="image/png, image/jpeg" class="hidden">
                                    </label>
                                </div>
                                <div class="flex gap-6">

                                    <label id="bodyText" class="text-2xl">รุ่น: </label>

                                    <x-input id="modelInput" class="mt-1 w-full flex-grow" type="text" name="name"
                                        required autofocus />
                                </div>

                            </div>
                            <div class="flex justify-end items-center gap-4 pt-2 ">

                                <button type="button"
                                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold bg-gray-500 text-gray-200 close-add-button w-1/4">ปิด</button>
                                <button id="saveModelButton"
                                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold my-button-confirm w-1/4"
                                    type="submit">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>

            </dialog>
            <dialog class="p-8 my-auto w-1/3 h-1/3 rounded-lg shadow-lg border-gray-300 border-2" id="editModelModal">

                <div class="h-full">
                    <div class="h-full flex flex-col justify-between">
                        <h1 id="header" class="font-bold text-3xl">แก้ไขรุ่น</h1>
                        <hr>
                        <form id="editModelForm">
                            @csrf
                            <div class="">
                                <div id="upload" class="flex justify-center items-center w-full">

                                    <label for="edit_input_model_image"
                                        class="mx-auto mb-4 rounded-full flex flex-col relative overflow-hidden justify-center items-center  bg-gray-50  border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-100"
                                        style="width: 100px;height: 100px;">
                                        <img id="edit_model_preview_image" alt="preview image"
                                            class="hidden h-full w-full hover:opacity-30 absolute rounded-full">
                                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                            <p class="mb-2 text-sm text-center text-gray-500"><span
                                                    class="font-semibold">คลิกเพื่ออัพโหลด</span>
                                            </p>
                                        </div>
                                        <input id="edit_input_model_image" type="file" name="model_image"
                                            accept="image/png, image/jpeg" class="hidden">
                                    </label>
                                </div>
                                <div class="flex gap-6">

                                    <label id="bodyText" class="text-2xl">รุ่น: </label>

                                    <x-input id="editModelInput" class="mt-1 w-full flex-grow" type="text"
                                        name="name" required autofocus />
                                </div>

                            </div>
                            <div class="flex justify-end items-center gap-4 pt-2 ">

                                <button type="button"
                                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold bg-gray-500 text-gray-200 close-edit-button w-1/4">ปิด</button>
                                <button id="editSaveModelButton"
                                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold my-button-confirm w-1/4"
                                    type="submit">บันทึก</button>
                            </div>
                    </div>
                    </form>

                </div>

            </dialog>

        </div>
    </div>
@endsection
