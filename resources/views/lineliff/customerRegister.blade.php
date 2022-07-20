@extends('layouts.liff')

@section('content')
    <section id="form" hidden>
        <form action="{{ route('customer.register') }}"
                method="POST">
            @csrf
            <input id="name" name="name" type="text" value="" placeholder="Full name...">
            <textarea id="address" name="address" rows="5" cols="33" value="" placeholder="Address..."></textarea>
            <input id="tel" name="tel" type="text" value="" placeholder="Phone Number...">
            <input id="email" name="email" type="text" value="" placeholder="Email...">
            <input id="line_id" name="line_id" type="text" value="" placeholder="Line ID...">

            <input id="lui_input" name="lui" type="text" value="" hidden>
            <input id="profileUrl_input" name="profileUrl" type="text" value="" hidden>

            <div class="text-lg font-kanit text-center">
                <button id="confirm" class="my-button-info">Register</button>
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        async function main() {
            await liff.init({
                liffId: '{{config("liff.register_id")}}',
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
                }
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
            }).then(response => response.text())
            .then(data => {
                if (data !== "404") {
                    alert("You are already registered.");
                    liff.closeWindow();
                } else {
                    document.getElementById("lui_input").value = profile.userId;
                    document.getElementById('profileUrl_input').value = profile.pictureUrl;
                    document.getElementById('form').hidden = false;
                }
            })   
        }

        async function getFriend() {
            let friend = await liff.getFriendship();
            return friend.friendFlag;
        }
    </script>
@endsection