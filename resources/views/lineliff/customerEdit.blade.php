@extends('layouts.liff')

@section('content')
    <section id="loading" class="fixed w-full h-screen bg-gray-100">
        <div class="flex justify-center items-center h-full">
            <div class="animate-spin">
                <i class="fa-solid fa-spinner text-5xl"></i>
            </div>
        </div>
    </section>
    <section id="form" hidden class="container mx-auto w-10/12 space-y-4 my-5">
        <img src="{{ asset('css/images/logo.png')}}" alt="" class="w-1/2 p-3 mx-auto">
        <div class="bg-gray-100 p-2 rounded-xl drop-shadow-xl">
            <form action="{{ route('customer.update') }}" class="space-y-2"
                    method="POST">
                @csrf
                <div>
                    <div class="font-kanit text-base font-bold">Name</div>
                    @error('name')
                    <div class="font-kanit text-base text-red-500 indent-3">{{$message}}</div>
                    @enderror
                    <input class="font-kanit text-base w-full rounded-lg "
                           id="name" name="name" type="text" value="" placeholder="Full name...">
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">Address</div>
                    @error('address')
                    <div class="font-kanit text-base text-red-500 indent-3">{{$message}}</div>
                    @enderror
                    <textarea class="font-kanit text-base w-full rounded-lg " style="resize: none"
                              id="address" name="address" rows="5" cols="33" value="" placeholder="Address..."></textarea>
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">Phone number</div>
                    @error('tel')
                    <div class="font-kanit text-base text-red-500 indent-3">{{$message}}</div>
                    @enderror
                    <input class="font-kanit text-base w-full rounded-lg"
                           id="tel" name="tel" type="text" value="" placeholder="Phone Number...">
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">Email</div>
                    @error('email')
                    <div class="font-kanit text-base text-red-500 indent-3">{{$message}}</div>
                    @enderror
                    <input class="font-kanit text-base w-full rounded-lg"
                           id="email" name="email" type="text" value="" placeholder="Email...">
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">Line ID</div>
                    @error('line_id')
                    <div class="font-kanit text-base text-red-500 indent-3">{{$message}}</div>
                    @enderror
                    <input class="font-kanit text-base w-full rounded-lg"
                           id="line_id" name="line_id" type="text" value="" placeholder="Line ID...">
                </div>

                <input id="lui_input" name="lui" type="text" value="" hidden>
                <input id="profileUrl_input" name="profileUrl" type="text" value="" hidden>
                <input id="id_input" name="id" type="text" value="" hidden>

                <div class="text-lg font-kanit text-center">
                    <button id="confirm" class="my-button-info">Update</button>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script>
        async function main() {
            await liff.init({
                liffId: '{{config("liff.profile_edit_id")}}',
            })
            const queryString = decodeURIComponent(window.location.search);
            const params = new URLSearchParams(queryString);

            if (params.get("success") !== null) {
                liff.closeWindow();
            }

            if (liff.isLoggedIn()) {
                await getUserProfile();
            } else {
                liff.login();
            }

        }
        main();

        async function getUserProfile() {
            let profile = await liff.getProfile();
            const fetchUrl = "{{config('line.endpoint_url')}}" + "/api/line/customer/profile?lui=" + profile.userId;
            fetch(fetchUrl, {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (data == "404") {
                    alert("You are not registered.");
                    window.location = "https://liff.line.me/" + "{{config('liff.register_id')}}";
                } else {
                    document.getElementById("name").value = data.name;
                    document.getElementById("address").value = data.address;
                    document.getElementById("tel").value = data.phone_number;
                    document.getElementById("email").value = data.email;
                    document.getElementById("line_id").value = data.line_basic_id;
                    document.getElementById("id_input").value = data.id;
                    
                    document.getElementById("lui_input").value = profile.userId;
                    document.getElementById('profileUrl_input').value = profile.pictureUrl;
                    document.getElementById('form').hidden = false;
                    document.getElementById('loading').hidden = true;
                }
            })
        }
    </script>
@endsection
