@extends('layouts.liff')

@section('content')
    <section id="loading" class="fixed w-full h-screen bg-gray-100">
        <div class="flex justify-center items-center h-full">
            <div class="animate-spin">
                <i class="fa-solid fa-spinner text-5xl"></i>
            </div>
        </div>
    </section>
    <section  id="profile" hidden class="mt-5">
        <div class="p-3 container mx-auto w-10/12 bg-gray-100 rounded-lg drop-shadow-lg overflow-hidden">
            <div class="flex justify-center">
                <img id="pictureUrl" alt="profile" class="w-48 rounded-full border-2 border-gray-200 drop-shadow-md"/>
            </div>
            <div class="space-y-2">
                <div>
                    <div class="font-kanit text-base font-bold">Name</div>
                    <div id="displayName" class="indent-3 font-kanit text-base font-base"></div>
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">Email</div>
                    <div id="email" class="indent-3 font-kanit text-base font-base"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="text-center mt-3">
        <button class="my-button-info" id="scanQr" onclick="window.location='https://line.me/R/nv/QRCodeReader'"></button>
        <form action="{{ route('carRegistered.connect') }}"
                method="POST">
            @csrf
            <input id="id_input" name="id" type="text" value="" hidden>
            <input id="lui_input" name="lui" type="text" value="" hidden>
            <div class="text-lg font-kanit text-center">
                <button id="confirm" class="my-button-info" hidden>Connect</button>
            </div>
        </form>
    </section>
    <section id="carInfo" hidden class="mt-5">
        <div class="p-3 container mx-auto w-10/12 bg-gray-100 rounded-lg drop-shadow-lg overflow-hidden">
            <div class="space-y-2">
                <div>
                    <div class="font-kanit text-base font-bold">ทะเบียนรถ</div>
                    <div id="carRegis" class="indent-3 font-kanit text-base font-base"></div>
                </div>
                <div>
                    <div class="font-kanit text-base font-bold">เลขตัวถัง</div>
                    <div id="vin" class="indent-3 font-kanit text-base font-base"></div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        const profile = document.getElementById('profile');
        const pictureUrl = document.getElementById('pictureUrl');
        const displayName = document.getElementById('displayName');
        const btnRedirectURL = document.getElementById('redirectURL');

        async function main() {
            await liff.init({
                liffId: '{{config("liff.car_register_id")}}',
            })
            const queryString = decodeURIComponent(window.location.search);
            const params = new URLSearchParams(queryString);

            if (params.get("success") !== null) {
                liff.closeWindow();
            }

            if (liff.isLoggedIn()) {
                let isFriend = await getFriend();

                if (!isFriend) {
                    alert("Please add our chatbot first");
                    window.location = "https://line.me/R/ti/p/" + "{{config('line.bot_basic_id')}}";
                } else {
                    await getUserProfile();

                    if (params.get("carId") !== null) {
                        cid = params.get("carId");
                        scanQr.hidden = true;

                        await getCarData(cid);
                    }
                }
            } else {
                liff.login();
            }
        }
        main();

        async function getUserProfile() {
            const profile = await liff.getProfile();
            const lui = profile.userId;

            const fetchUrl = "{{config('line.endpoint_url')}}" + "/api/line/customer/profile?lui=" + lui;
            fetch(fetchUrl, {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.text())
            .then(data => {
                if (data == "404") {
                    alert("Please register first");
                    window.location = "https://liff.line.me/" + "{{config('liff.register_id')}}";
                } else {
                    data =  JSON.parse(data);
                    pictureUrl.src = profile.pictureUrl;
                    displayName.innerHTML = data.name;
                    email.innerHTML = data.email;
                    scanQr.innerHTML = 'Scan QR';
                    document.getElementById("lui_input").value = profile.userId;
                    document.getElementById("profile").hidden = false;
                    document.getElementById('loading').hidden = true;
                }
            })
        }

        async function getCarData(cid) {
            let fetchUrl = "{{config('line.endpoint_url')}}" + "/api/line/carInfo?cid=" + cid;
            fetch(fetchUrl, {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                carRegis.innerHTML = '<b>Car Registration:</b> ' + data.car_registration;
                vin.innerHTML = '<b>Vin:</b> ' + data.vin;
                document.getElementById("id_input").value = cid;
                document.getElementById("confirm").hidden = false;
                document.getElementById("profile").hidden = false;
                document.getElementById("carInfo").hidden = false;
                    document.getElementById('loading').hidden = true;
            })
        }

        async function getFriend() {
            let friend = await liff.getFriendship();
            return friend.friendFlag;
        }

    </script>
@endsection
