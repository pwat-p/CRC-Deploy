<div class="border-2 rounded-xl p-6   w-full  mx-auto my-6">
    <div class="w-full flex text-right justify-end">
        <form action="{{$storeaction}}" method="POST">
            @csrf
            <div class="flex ">
                <input type="text"  placeholder="เพิ่ม{{$name}}" name="name"
                 class="outline-none ring-2 ring-gray-100 ring-offset-2 ring-offset-gray-300 rounded-tl-xl rounded-bl-xl px-3 py-1" required autofocus/>
                 <button class="bg-gray-100 py-2 px-3 rounded-tr-xl rounded-br-xl hover:bg-gray-300"
                            type="submit">
                        <i class="fa-solid fa-plus"></i>
            </div>
        </form>
    </div>
    <table class="w-full mt-5">
        <thead>
            <tr class="font-kanit text-lg text-center bg-gray-300">
                <th class="py-3 px-2 border-r-2 w-40">{{$name}}</th>
                <th></th>
                <th></th>
            </tr>

        </thead>
        <tbody>
            @foreach ($list as $item)
                <tr class="text-center hover:bg-gray-100 hover:opacity-90">
                    <td class="w-4/5">{{ $item->name }}</td>
                    <td class="py-1 w-1/10" >
                            <button class="button open-button" onclick="openModal( {{$item->id}}, '{{$item->name}}' , '{{$updateaction}}' , '{{$name}}')"><i class="fa-solid fa-pen-to-square"></i></button>
                    </td>
                    <td class="py-1 w-1/10" >
                        <form action="{{ route("$destroyaction", ['id' => $item->id ]) }}" method="POST">
                            @csrf
                            <button class="delete_button" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<x-original-information-dialog :typename="$name" />
