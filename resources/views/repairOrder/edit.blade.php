@extends('layouts.sidebar')
@section('content')
    <div class="text-center text-5xl py-3">REPAIR ORDER
        <span class="text-gray-600">
            {{$repairOrder->car_registration}}
        </span>
    </div>

    <div class="flex justify-center">
        <div class="border-2 rounded-xl p-4 w-4/5">
            <div class="text-xl font-kanit ">
                <i class="fa-solid fa-file-pen"></i>
                แก้ไขรายการซ่อมรถยนต์
            </div>
            <form action="{{ route('repairOrder.update', ['repairOrder' => $repairOrder->id ]) }}" method="POST" enctype="multipart/form-data"
                  class="w-2/5 mx-auto items-center text-lg font-kanit space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="car_registration" class="font-bold">ทะเบียนรถ</label>
                    @error("registration")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                    <div class="flex space-x-2">
                        <input type="text" name="registration" placeholder="ทะเบียนรถ" value="{{ old('registration', $repairOrder->car_registration) }}"
                               autocomplete="off" class=" w-full @if($errors->has("registration")) my-input-danger @else my-input-focus @endif">
                        <select name="province" id="province" class="my-input-focus w-1/2 hidden">
                            @foreach($provinces as $province)
                                <option value="{{$province->name_th}}" {{ ($repairOrder->province == $province->name_th) ? 'selected' : '' }}>{{$province->name_th}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="color" class="font-bold pt-2">สี</label>
                    @error("color")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                    <select name="color" id="color" class="@if($errors->has("color")) my-input-danger @else my-input-focus @endif w-full">
                        @foreach($colors as $color)
                            <option value="{{$color->name}}" {{ ( old('color') == $color->name) ? 'selected' : '' }}>{{$color->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="model" class="font-bold pt-2">รุ่น</label>
                    @error("model")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                    <select name="model" id="model" class="@if($errors->has("model")) my-input-danger @else my-input-focus @endif w-full">
                        @foreach($models as $model)
                            <option value="{{$model->name}}" {{ ( old('model') == $model->name) ? 'selected' : '' }}>{{$model->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="vin" class="font-bold pt-2">หมายเลขถัง (VIN)</label>
                    @error("vin")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                <input type="text" name="vin" placeholder="หมายเลขถัง" value="{{ old('vin', $repairOrder->vin) }}" autocomplete="off"
                       class="@if($errors->has("vin")) my-input-danger @else my-input-focus @endif w-full">
                </div>

                <div>
                    <label for="current_distance" class="font-bold pt-2">ระยะทางปัจจุบัน</label>
                    @error("current_distance")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                    <input type="text" name="current_distance" placeholder="ระยะทางปัจจุบัน"
                           value="{{ old('current_distance',$repairOrder->current_distance) }}" autocomplete="off"
                           class="@if($errors->has("current_distance")) my-input-danger @else my-input-focus @endif w-full">
                </div>

                <div>
                    <label for="latest_distance" class="font-bold pt-2">ระยะทางล่าสุด</label>
                    @error("latest_distance")<span class="ml-4 text-red-500 text-sm">{{$message}}</span>@enderror
                    <input type="text" name="latest_distance" placeholder="ระยะทางล่าสุด"
                           value="{{ old('latest_distance', $repairOrder->latest_distance) }}" autocomplete="off"
                           class="@if($errors->has("latest_distance")) my-input-danger @else my-input-focus @endif w-full">
                </div>

                <label for="image" class="block font-bold pt-2">รูปภาพรถยนต์</label>
                @error("car_image")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <div id="upload" class="flex justify-center items-center w-full">
                    <label for="input_image"
                           class="flex flex-col relative overflow-hidden justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 @if($errors->has("car_image")) border-red-500 @else border-gray-300 @endif border-dashed cursor-pointer hover:bg-gray-100">
                        <img id="preview_image" alt="preview image" @if($repairOrder->image_path) src="{{url($repairOrder->image_path)}}" @endif
                             class=" w-full hover:opacity-30 absolute @if(!$repairOrder->image_path) hidden @endif">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">คลิกเพื่ออัพโหลด</span>
                            </p>
                            <p class="text-xs text-gray-500">PNG หรือ JPG (สูงสุด. 8MB)</p>
                        </div>
                        <input id="input_image" type="file" name="car_image" accept="image/png, image/jpeg"
                               class="hidden">
                    </label>
                </div>

                <div class="flex justify-center col-start-2 space-x-4">
                    <button type="reset" class="my-button-cancel text-xl font-bold font-kanit" onclick="window.location='{{route('repairOrder.show', ['repairOrder' => $repairOrder->id ])}}'">ยกเลิก</button>
                    <button type="submit" class="my-button-confirm text-xl font-bold font-kanit">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-4 flex justify-center">
        <div class="border-2 rounded-xl p-6 w-4/5 h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-list-check"></i>
                รายการตรวจเช็ค
            </div>
            <form action="{{ route('repairOrder.updateCheckList', ['repairList' => $repairOrder->id ]) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="w-1/2 mt-3 mx-auto">
                <thead>
                    <tr class="font-kanit text-lg text-center bg-gray-300">
                        <th class="py-3 border-r-2">รายละเอียด</th>
                        <th class="py-3 ">รหัสอะไหล่</th>
                    </tr>
                </thead>
                <tbody id="bodyList">
                    @if($repairOrder->repair_list != null)
                        @foreach($repairOrder->repair_list as $key=>$value)
                            <tr class="text-lg font-kanit text-center hover:bg-gray-100">
                                <td><input type="text" class="my-input-focus my-2" placeholder="รายละเอียด" name="key[]" value="{{$key}}"></td>
                                <td><input type="text" class="my-input-focus my-2" placeholder="รหัสอะไหล่" name="value[]" value="{{$value}}"></td>
                                <td onclick="delete_input(this.parentNode)"><span class="my-button-cancel">
                                        <i class="fa-solid fa-square-xmark text-xl"></i>
                                    </span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="flex justify-center">
                <button type="submit" class="my-button-confirm text-xl font-bold font-kanit">บันทึก</button>
            </div>
            </form>
            <button id="add-form" class="my-button-info text-lg font-kanit" onclick="addInput()">เพิ่มรายการ</button>
        </div>
    </div>
    <div class="flex justify-center mt-3">
        <div class="border-2 border-red-400 rounded-xl p-4 w-4/5 text-red-500">
            <div class="text-xl font-kanit ">
                <i class="fa-solid fa-file-pen"></i>
                ลบรายการซ่อมรถยนต์
            </div>
            <form action="{{ route('repairOrder.destroy', ['repairOrder' => $repairOrder->id]) }}" method="POST" class="p-4 space-y-4">
                @method('DELETE')
                @csrf
                <label for="destroy" class="text-xl block">การลบรายการซ่อมรถยนต์ หากดำเนินการลบนี้จะมีผลทำให้ไม่สามารถเข้าถึงข้อมูลรายการนี้ได้อีก คุณต้องการที่จะลบหรือไม่ ?</label>
                <div> โปรดใส่รหัสผ่านเพื่อทำการยืนยันการลบรายการซ่อมรถยนต์</div>
                <input type="password" placeholder="password" name="password" class="text-black w-3/5 px-2 py-2 my-input-danger" autocomplete="off">
                <button type="submit" class="my-button-cancel">delete</button>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function addInput() {
            var table = document.getElementById("bodyList")
            var row = table.insertRow(-1);
            row.classList.add('text-lg', 'font-kanit', 'text-center', 'hover:bg-gray-100');
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = "<input type='text' class='my-input-focus my-2' placeholder='รายละเอียด' name='key[]' value='{{old('new_key')}}'>";
            cell2.innerHTML = "<input type='text' class='my-input-focus my-2' placeholder='รหัสอะไหล่' name='value[]' value='{{old('new_value')}}'>";

            const cell3 = document.createElement('td')
            cell3.innerHTML = `<td><span class="my-button-cancel">
                                        <i class="fa-solid fa-square-xmark text-xl"></i>
                                    </span></td>`
            cell3.addEventListener('click', function() {delete_input(this.parentNode)})
            row.append(cell3);
        }

        function delete_input(item){
            item.remove();
            console.log(item);
        }
    </script>
    <script>
        input_image.onchange = evt => {
            let [image] = input_image.files
            if (image) {
                preview_image.src = window.URL.createObjectURL(image);
                preview_image.classList.remove("hidden")
            }
        }
    </script>

    {{--    search province filler--}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $("#province").select2({
            placeholder: "Select a Name",
        });
        let element = document.getElementsByClassName("select2");
        console.log(element);
    </script>
@endsection
