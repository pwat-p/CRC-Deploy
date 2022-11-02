@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">REPAIR ORDER CREATE</div>
    <div class="flex justify-center">
        <div class="border-2 rounded-xl p-4 w-4/5">
            <div class="text-xl font-kanit ">
                <i class="fa-solid fa-circle-plus"></i>
                สร้างรายการซ่อมรถยนต์
            </div>

            <form action="{{ route('repairOrder.store') }}" method="POST" enctype="multipart/form-data"
                  class="w-2/5 mx-auto items-center text-lg font-kanit space-y-2">
                @csrf
                <label for="car_registration" class="block font-bold">ทะเบียนรถ</label>
                <div class="flex space-x-2">
                    <input type="text" name="registration" placeholder="ทะเบียนรถ" value="{{ old('registration') }}"
                           autocomplete="off" class="my-input-focus w-full">
                    <select name="province" id="province" class="my-input-focus w-1/2 hidden">
                        @foreach($provinces as $province)
                            <option value="{{$province->name_th}}" {{ ( old('province') == $province->name_th) ? 'selected' : '' }}>{{$province->name_th}}</option>
                        @endforeach
                    </select>
                </div>
                @error("registration")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="color" class="block font-bold pt-2">สี</label>
                <select name="color" id="color" class="my-input-focus w-full">
                    @foreach($colors as $color)
                        <option value="{{$color->name}}" {{ ( old('color') == $color->name) ? 'selected' : '' }}>{{$color->name}}</option>
                    @endforeach
                </select>
                @error("color")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="model" class="block font-bold pt-2">รุ่น</label>
                <select name="model" id="model" class="my-input-focus w-full">
                    @foreach($models as $model)
                        <option value="{{$model->name}}" {{ ( old('model') == $model->name) ? 'selected' : '' }}>{{$model->name}}</option>
                    @endforeach
                </select>
                @error("model")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="vin" class="block font-bold pt-2">หมายเลขถัง (VIN)</label>
                <input type="text" name="vin" placeholder="หมายเลขถัง" value="{{ old('vin') }}" autocomplete="off"
                       class="my-input-focus w-full">
                @error("vin")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="current_distance" class="block font-bold pt-2">ระยะทางปัจจุบัน</label>
                <input type="text" name="current_distance" placeholder="ระยะทางปัจจุบัน"
                       value="{{ old('current_distance') }}" autocomplete="off"
                       class="my-input-focus w-full">
                @error("current_distance")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="latest_distance" class="block font-bold pt-2">ระยะทางล่าสุด</label>
                <input type="text" name="latest_distance" placeholder="ระยะทางล่าสุด"
                       value="{{ old('latest_distance') }}" autocomplete="off"
                       class="my-input-focus w-full">
                @error("latest_distance")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror

                <label for="image" class="block font-bold pt-2">รูปภาพรถยนต์</label>
                @error("car_image")
                <div class="ml-4 text-red-500 text-sm">
                    {{$message}}
                </div>
                @enderror
                <div id="upload" class="flex justify-center items-center w-full">
                    <label for="input_image"
                           class="flex flex-col relative overflow-hidden justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer hover:bg-gray-100">
                        <img id="preview_image" alt="preview image"
                             class="hidden w-full hover:opacity-30 absolute">
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
                    <button type="reset" class="my-button-cancel text-xl font-bold font-kanit">ยกเลิก</button>
                    <button type="submit" class="my-button-confirm text-xl font-bold font-kanit">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
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
    </script>
@endsection
