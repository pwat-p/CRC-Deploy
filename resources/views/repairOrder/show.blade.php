@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">REPAIR ORDER
        <span class="text-gray-600">
            {{$repairOrder->car_registration}} {{$repairOrder->province}}
        </span>
    </div>
    <div class="flex justify-center space-x-4">
        <div class="border-2 rounded-xl p-4 w-3/5 h-full">
            <div class="text-xl font-kanit ">
                <i class="fa-solid fa-images"></i>
                รูปรถยนต์
            </div>
            <div class="flex justify-center items-center overflow-hidden relative h-96">
                @if($repairOrder->image_path)
                    <img src="{{url($repairOrder->image_path)}}" alt="car"
                         class="absolute mt-3 bg-center shadow-md" width="800px">
                @else
                    <div class="h-96 w-full rounded-lg bg-gray-300 flex justify-center items-center">
                        <span class="text-xl font-kanit">
                            <i class="fa-solid fa-images"></i>
                            ไม่พบรูปภาพ
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-2 rounded-xl p-4 w-2/5 h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-rectangle-list"></i>
                ข้อมูลรถยนต์
            </div>

            <div class="grid grid-cols-3 gap-x-6 gap-y-4 items-center mt-3 text-lg font-kanit">
                <label for="car_registration" class="text-right text-lg font-kanit">ทะเบียนรถ</label>
                <div class="col-span-2">{{$repairOrder->car_registration}}</div>

                <label for="province" class="text-right text-lg font-kanit">จังหวัด</label>
                <div class="col-span-2">{{$repairOrder->province}}</div>

                <label for="color" class="text-right text-lg font-kanit">สี</label>
                <div class="col-span-2">{{$repairOrder->color}}</div>

                <label for="model" class="text-right text-lg font-kanit">รุ่น</label>
                <div class="col-span-2">{{$repairOrder->model}}</div>

                <label for="vin" class="text-right text-lg font-kanit">หมายเลขถัง (VIN)</label>
                <div class="col-span-2">{{$repairOrder->vin}}</div>

                <label for="current_distance" class="text-right text-lg font-kanit">ระยะทางปัจจุบัน</label>
                <div class="col-span-2">{{$repairOrder->current_distance}}</div>

                <label for="latest_distance" class="text-right text-lg font-kanit">ระยะทางล่าสุด</label>
                <div class="col-span-2">{{$repairOrder->latest_distance}}</div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="border-2 rounded-xl p-6 w-full h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-calendar-check"></i>
                สถานะรถยนต์
            </div>
            <table class="w-full mt-3 border-2">
                <thead>
                <tr class="font-kanit text-lg text-center bg-gray-300">
                    @foreach($stages as $value)
                        <th class="py-3 border-r-2 w-1/6">{{$value["name"]}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    @foreach($stages as $key=>$value)
                        <td class="py-3 border-r-2 w-1/6 text-lg font-kanit">
                            <span id="{{$value["field"]}}">{{$value["stage"]}}</span>
                        </td>
                    @endforeach
                </tr>
                </tbody>
            </table>

            @if(!$repairOrder->returning)
                <div class="text-center mt-4 mb-2">
                    <button class="my-button-confirm" onclick="updateTimeStamp()">update</button>
                    <button class="my-button-confirm" onclick="reset()">reset</button>
                </div>
            @endif

            <form action="{{ route('repairList.timestampStatus', ['id' => $repairOrder->id]) }}"
                  method="POST">
                @csrf
                @method('PUT')
                @foreach($stages as $key=>$value)
                    <input id="{{$value["field"]}}_input" name="{{$value["field"]}}" type="text"
                           value="{{$value["stage"]}}" hidden>
                @endforeach
                <div class="text-lg font-kanit text-center">
                    <button id="confirm" class="my-button-info" hidden>แจ้งเตือนสถานะ</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-4">
        <div class="border-2 rounded-xl p-6 w-full h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-coins"></i>
                รายการชำระ
            </div>
            <form action="{{ route('repairList.setPayPrice', ['id' => $repairOrder->id]) }}" method="POST"
                  class="text-center">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="text-lg font-kanit font-bold" id="costText">
                        จำนวนเงินที่ต้องชำระ : {{number_format($repairOrder->cost, 2, '.', ',')}}
                    </div>
                    @error('cost')
                    <div class="font-kanit text-red-500">
                        {{ $errors->first('cost')}} บาท
                    </div>
                    @enderror
                    <div class="text-lg font-kanit">
                        <input id="cost" type="number" name="cost" placeholder="ระบุราคา"
                               value="{{ old(0, $repairOrder->cost) }}" autocomplete="off" step=".01"
                               oninput="setPrice()"
                               class="my-input-focus w-24 appearance-none">
                        <span>บาท</span>
                    </div>
                    <button id="updatePriceButton" class="my-button-confirm" hidden>update</button>
                    <button id="resetPriceButton" type="button" class="my-button-confirm" onclick="resetPrice()" hidden>reset</button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-4">
        <div class="border-2 rounded-xl p-6 w-full h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-list-check"></i>
                รายการตรวจเช็ค
            </div>
            <table class="w-1/2 mt-3 mx-auto">
                <thead>
                <tr class="font-kanit text-lg text-center bg-gray-300">
                    <th class="py-3 border-r-2">รายละเอียด</th>
                    <th class="py-3 ">รหัสอะไหล่</th>
                </tr>
                </thead>
                <tbody>
                @if($repairOrder->repair_list != null)
                    @foreach($repairOrder->repair_list as $key=>$value)
                        <tr class="text-lg font-kanit text-center hover:bg-gray-100">
                            <td class="border-2">{{$key}}</td>
                            <td class="border-2">{{$value}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <div class="border-2 rounded-xl p-6 w-full h-full">
            <div class="text-xl font-kanit">
                <i class="fa-solid fa-user"></i>
                ข้อมูลลูกค้า
            </div>
            @if($repairOrder->customer)
                <div class="mt-3 flex space-x-8 justify-center items-center">
                    @if($repairOrder->customer->profile)
                        <img src="{{$repairOrder->customer->profile}}" alt="profile"
                             class="w-1/5 h-64 mt-3 bg-center shadow-md">
                    @else
                        <div class="h-64 w-1/5 rounded-lg bg-gray-300 flex justify-center items-center">
                            <span class="text-xl font-kanit">
                                <i class="fa-solid fa-images"></i>
                                ไม่พบรูปภาพ
                            </span>
                        </div>
                    @endif
                    <div class="w-2/5">
                        <div class="grid grid-cols-6 items-center gap-y-2">
                            <label for="car_registration" class="text-lg font-kanit">ชื่อ</label>
                            <div class="col-span-5 text-lg font-kanit">{{$repairOrder->customer->name}}</div>

                            <label for="color" class="text-lg font-kanit">ที่อยู่</label>
                            <div class="col-span-5 text-lg font-kanit">{{$repairOrder->customer->address}}</div>

                            <label for="model" class="text-lg font-kanit">เบอร์โทร</label>
                            <div class="col-span-5 text-lg font-kanit">{{$repairOrder->customer->phone_number}}</div>

                            <label for="vin" class="text-lg font-kanit">email</label>
                            <div class="col-span-5 text-lg font-kanit">{{$repairOrder->customer->email}}</div>

                            <label for="current_distance" class="text-lg font-kanit">line_id</label>
                            <div class="col-span-5 text-lg font-kanit">{{$repairOrder->customer->line_basic_id}}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-3 flex space-x-8 justify-center items-center">
                    <div class="mb-3">
                        {!! DNS2D::getBarcodeHTML(url($link), 'QRCODE') !!}
                        <div class="text-center text-lg font-kanit pt-3">ให้ลูกค้าสแกนเพื่อเชื่อมข้อมูล</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="flex justify-center items-center mt-3 space-x-4">
        <a href="{{route('repairOrder.edit', ['repairOrder' => $repairOrder->id ])}}"
           class="my-button-info text-xl font-kanit font-bold">แก้ไขข้อมูลรถยนต์</a>
    </div>
@endsection
@section('script')
    <script>
        let dataList = {!! $stages !!};
        let list = dataList;

        function updateTimeStamp() {
            document.getElementById("confirm").hidden = false;
            for (let i = 0; i < list.length; i++) {
                if (!list[i].stage) {
                    let newDate = new Date(new Date().toLocaleString('en-US', {timeZone: 'Asia/Bangkok'}));
                    let dateString = newDate.getFullYear() + "-" + (newDate.getMonth() + 1) + "-" + newDate.getDate() + " " + newDate.getHours() + ":" + newDate.getMinutes() + ":" + newDate.getSeconds();
                    list[i].stage = dateString;

                    document.getElementById(list[i].field).innerHTML = dateString;
                    document.getElementById(list[i].field + "_input").value = dateString;
                    break;
                }
            }
        }

        function reset() {
            document.getElementById("confirm").hidden = true;
            list = {!! $stages !!};
            for (let i = 0; i < list.length; i++) {
                if (!list[i].stage) {
                    document.getElementById(list[i].field).innerHTML = null;
                    document.getElementById(list[i].field + "_input").value = null;
                }
            }
        }

        function setPrice() {
            document.getElementById("updatePriceButton").hidden = false;
            document.getElementById("resetPriceButton").hidden = false;
            cost = document.getElementById("cost").value;
            costText.innerHTML = "จำนวนเงินที่ต้องชำระ : " + cost.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function resetPrice() {
            document.getElementById("updatePriceButton").hidden = true;
            document.getElementById("resetPriceButton").hidden = true;
            document.getElementById("cost").value = {{$repairOrder->cost}};
            costText.innerHTML = "จำนวนเงินที่ต้องชำระ : {{number_format($repairOrder->cost, 2, '.', ',')}}";
        }

    </script>
@endsection
