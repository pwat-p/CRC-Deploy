@extends('layouts.sidebar')

@section('content')
    <div class="text-center text-5xl py-3">REPAIR ORDER LIST</div>
    <div class="sm:m-2 sm:w-full 2xl:mx-auto 2xl:w-5/6">

        <div class="flex justify-center items-center space-x-5">
            <div class="w-1/2 border-2 rounded-xl p-4 ">
                <div class="font-kanit text-xl">
                    <i class="fa-solid fa-chart-area"></i>
                    รายการซ่อม
                </div>
                <canvas id="lineChart" width="400" height="200"></canvas>
            </div>

            <div class="w-96 h-full border-2 rounded-xl p-4 ">
                <div class="font-kanit text-xl">
                    <i class="fa-solid fa-chart-pie"></i>
                    รายการซ่อม
                </div>
                <canvas id="circleChart" width="400" height="100"></canvas>
            </div>
        </div>

        <div class="border-2 rounded-xl p-4 my-4 h-min-screen">
            <div class="flex justify-between">
                <div class="font-kanit text-xl">
                    <i class="fa-solid fa-table"></i>
                    รายการซ่อม
                </div>
                <div>
                    <form action="{{ route('repairOrder.index') }}" method="GET">
                        <div class="flex items-center">
                            <div class="font-kanit text-center px-3 space-x-2">
                                <div>รายการสำเร็จแล้ว</div>
                                <input type="checkbox" name="complete" value="1" @if($complete) checked @endif class="outline-none ring-2 ring-gray-100 ring-offset-2 ring-offset-gray-300 rounded-xl px-3 py-1
                                focus:ring-gray-300 focus:ring-offset-gray-500">
                            </div>

                            <input type="text" name="search" placeholder="ค้นหาทะเบียนรถยนต์" value="{{ old('search', $search) }}" autocomplete="off"
                            class="outline-none ring-2 ring-gray-100 ring-offset-2 ring-offset-gray-300 rounded-tl-xl rounded-bl-xl px-3 py-1
                            focus:ring-gray-300 focus:ring-offset-gray-500 font-kanit">
                            <button class="bg-gray-100 py-2 px-3 rounded-tr-xl rounded-br-xl hover:bg-gray-300"
                                    type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @if($repairOrders->count() <= 0 )
                <div class="h-80 flex justify-center items-center">
                    <div class="text-center font-kanit space-y-8">
                        <i class="fa-solid fa-ban text-red-500 text-9xl"></i>
                        <div class="text-3xl">
                            ไม่พบข้อมูล ทะเบียนรถยนต์
                        </div>
                    </div>
                </div>
            @else
            <table class="w-full mt-5">
                <thead>
                    <tr class="font-kanit text-lg text-center bg-gray-300">
                        <th class="py-3 px-2 border-r-2 w-40">วันเข้ารับการซ่อม</th>
                        <th class="py-3 border-r-2 w-24">หมายเลขงานซ่อม</th>
                        <th class="py-3 border-r-2 w-64">ทะเบียน</th>
                        <th class="py-3 border-r-2 w-64">พนักงาน</th>
                        <th class="py-3 border-r-2 w-24">รถเข้าศูนย์</th>
                        <th class="py-3 border-r-2 w-24">รอคิว</th>
                        <th class="py-3 border-r-2 w-24">กำลังซ่อม</th>
                        <th class="py-3 border-r-2 w-24">ตรวจสอบครั้งสุดท้าย</th>
                        <th class="py-3 border-r-2 w-24">ล้างทำความสะอาด</th>
                        <th class="py-3 w-24">พร้อมรับรถ</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($repairOrders as $order)
                    <tr class="text-center hover:bg-gray-100 hover:opacity-90 {{ $loop->index % 2 == 0 ? 'bg-gray-50':'bg-white' }}"
                        onclick="window.location='{{route('repairOrder.show', ['repairOrder' => $order->id ])}}'">
                        <td class="">
                            {{ date('d/m/Y', strtotime($order->created_at)) }}
                        </td>
                        <td class="">
                            {{ $order->id }}
                        </td>
                        <td class="text-left pl-4">
                            {{ $order->car_registration }} {{$order->province}}
                        </td>
                        <td class="text-left pl-4">
                            {{ $order->user->name }}
                        </td>
                        <td class="p-2 @if($order->car_received) bg-green-400 @else bg-red-400 @endif">
                            @if($order->car_received)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                        <td class="p-2 @if($order->in_queued) bg-green-400 @else bg-red-400 @endif">
                            @if($order->in_queued)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                        <td class="p-2 @if($order->repairing) bg-green-400 @else bg-red-400 @endif">
                            @if($order->repairing)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                        <td class="p-2 @if($order->last_check) bg-green-400 @else bg-red-400 @endif">
                            @if($order->last_check)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                        <td class="p-2 @if($order->cleaning) bg-green-400 @else bg-red-400 @endif">
                            @if($order->cleaning)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                        <td class="p-2 @if($order->returning) bg-green-400 @else bg-red-400 @endif">
                            @if($order->returning)
                                <i class="fa-solid fa-check text-2xl text-white"></i>
                            @else
                                <i class="fa-solid fa-xmark text-2xl text-white"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
        {{ $repairOrders->links() }}
    </div>
@endsection
@section('script')
    <script>
        const data1 = {!! json_encode($chart_circle) !!};
        const config1 = {
            type: 'doughnut',
            data: {
                labels: ['กำลังดำเนินการ', 'พร้อมรับรถคืน'],
                datasets: [{
                    label: 'Count',
                    data: data1,
                    backgroundColor: [
                        'rgba(231,209,95,0.81)',
                        'rgba(115,201,10,0.83)'
                    ],
                    borderColor: [
                        'rgb(196,194,168)',
                        'rgba(125,199,48,0.52)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 4
                }]
            },
        }

        const data2 = {!! json_encode($chart_line) !!};
        let labelsArr = [];
        let countArr = [];
        for (var key in data2){
            labelsArr.push(key);
            countArr.push(data2[key].length);
        }
        const config2 = {
            type: 'bar',
            data: {
                labels: labelsArr,
                datasets: [{
                    label: 'จำนวนรายการ',
                    data: countArr,
                    fill: true,
                    backgroundColor: [
                        'rgba(231,209,95,0.81)',
                    ],
                    borderWidth: 1,
                }]
            },
        }
        const circleChart = new Chart(document.getElementById('circleChart'), config1);
        const lineChart = new Chart(document.getElementById('lineChart'), config2);
    </script>
@endsection
