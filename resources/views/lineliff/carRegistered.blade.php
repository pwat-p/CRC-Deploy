@extends('layouts.liff')

@section('content')
    <section>
        <img id="pictureUrl" width="200" />
        <p id="userId"></p>
        <p id="displayName"></p>
        <p id="statusMessage"></p>
        <p id="email"></p>
    </section>
    <section>
        <p id="carId"></p>
        <p id="carRegis"></p>
        <p id="vin"></p>
    </section>
    <section>
        <button id="scanQr" onclick="window.location='https://line.me/R/nv/QRCodeReader'"></button>
    </section>
    
    <form action="{{ route('carRegistered.connect') }}"
            method="POST">
        @csrf
        <input id="id_input" name="id" type="text" value="" hidden>
        <input id="lui_input" name="lui" type="text" value="" hidden>
        <div class="text-lg font-kanit text-center">
            <button id="confirm" class="my-button-info" hidden>Connect</button>
        </div>
    </form>
    
@endsection

@section('script')
    <script>
        const profile = document.getElementById('profile');
        const userId = document.getElementById('userId');
        const pictureUrl = document.getElementById('pictureUrl');
        const displayName = document.getElementById('displayName');
        const statusMessage = document.getElementById('statusMessage');
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
                    pictureUrl.src = profile.pictureUrl;
                    userId.innerHTML = '<b>userId:</b> ' + profile.userId;
                    displayName.innerHTML = '<b>displayName:</b> ' + profile.displayName;
                    statusMessage.innerHTML = '<b>statusMessage:</b> ' + profile.statusMessage;
                    scanQr.innerHTML = 'Scan QR';
                    document.getElementById("lui_input").value = profile.userId;
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
                carId.innerHTML = '<b>Car ID:</b> ' + cid;
                carRegis.innerHTML = '<b>Car Registration:</b> ' + data.car_registration;
                vin.innerHTML = '<b>Vin:</b> ' + data.vin;
                document.getElementById("id_input").value = cid;
                document.getElementById("confirm").hidden = false;
            })
        }

        async function getFriend() {
            let friend = await liff.getFriendship();
            return friend.friendFlag;
        }

    </script>
@endsection