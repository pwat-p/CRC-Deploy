@extends('layouts.liff')

@section('content')
    <section>
        <img id="pictureUrl" width="200" />
        <p id="userId"></p>
        <p id="displayName"></p>
        <p id="statusMessage"></p>
        <p id="email"></p>
    </section>
    <section id="selectCars" hidden>
        <label for="cars">Choose a car:</label>
        <select id="cars">
        </select>
    </section>
    <section id="selectDates" hidden>
        <label for="dates">Choose a date:</label>
        <select id="dates">
        </select>
    </section>
    <section id="car">
        <p id="vin"></p>
        <p id="carRegis"></p>
        <p id="date"></p>
    </section>
    <section id="repair_list" hidden>
        <div class="mt-4">
            <div class="border-2 rounded-xl p-6 w-full h-full">
                <div class="text-xl font-kanit">
                    <i class="fa-solid fa-list-check"></i>
                    รายการตรวจเช็ค
                </div>
                <table class="w-4/5 mt-3 mx-auto"  id="list">
                    <thead>
                        <tr class="font-kanit text-lg text-center bg-gray-300">
                            <th class="py-3 border-r-2">รายละเอียด</th>
                            <th class="py-3 ">รหัสอะไหล่</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
                liffId: '{{config("liff.repair_info_id")}}',
            })

            if (liff.isLoggedIn()) {
                let isFriend = await getFriend();

                if (!isFriend) {
                    alert("Please add our chatbot first");
                    window.location = "https://line.me/R/ti/p/" + "{{config('line.bot_basic_id')}}";
                } else {
                    await getRepairInfo();
                }
            } else {
                liff.login();
            }
        }
        main();

        async function getRepairInfo() {
            const profile = await liff.getProfile();
            const lui = profile.userId;
            const fetchUrl = "{{config('line.endpoint_url')}}" + "/api/line/repairInfo?lui=" + lui;
            fetch(fetchUrl, {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                pictureUrl.src = profile.pictureUrl;
                userId.innerHTML = '<b>userId:</b> ' + profile.userId;
                displayName.innerHTML = '<b>displayName:</b> ' + profile.displayName;
                statusMessage.innerHTML = '<b>statusMessage:</b> ' + profile.statusMessage;
                const regis = Object.keys(data.car_list)[0];
                carRegis.innerHTML = '<b>Car Registration:</b> ' + regis;
                vin.innerHTML = '<b>Vin:</b> ' + data.car_list[regis].vin;

                setCarOption(data);

                document.getElementById('selectCars').addEventListener('change', function(event) {
                    carRegis.innerHTML = '<b>Car Registration:</b> ' + event.target.value;
                    vin.innerHTML = '<b>Vin:</b> ' + data.car_list[event.target.value].vin;
                    date.innerHTML = '';
                    document.getElementById('repair_list').hidden = true;
                    setDateOption(data);
                });

                document.getElementById('selectDates').addEventListener('change', function(event) {
                    setRepairInfo(data);
                    date.innerHTML = '<b>Date:</b> ' + formatDate(new Date(event.target.value));
                });
            })
        }
        
        function setCarOption(data) {
            const select = document.getElementById('cars');
            const key_list = Object.keys(data.car_list);

            for (const regis of key_list) {
                const option = document.createElement("option");
                option.value = regis;
                option.text = regis;
                select.add(option);
            }

            document.getElementById('selectCars').hidden = false;
            setDateOption(data);
        }

        function setDateOption(data) {
            const regis = document.getElementById("cars").value;
            const select = document.getElementById('dates');
            select.innerHTML = "<option></option>";

            const key_list = Object.keys(data.car_list[regis].repair_list);
            const format = {};

            for (const date of key_list) {
                const option = document.createElement("option");
                option.value = date;
                option.text = formatDate(new Date(date));
                select.add(option);
            }
            document.getElementById('selectDates').hidden = false;
        }

        function setRepairInfo(data) {
            const regis = document.getElementById("cars").value;
            const date = document.getElementById("dates").value;

            const entry = Object.entries(data.car_list[regis].repair_list[date]);
            const tbodyRef = document.getElementById('list').getElementsByTagName('tbody')[0];
            tbodyRef.innerHTML = "";

            for (const [key, value] of entry) {
                const tr = document.createElement('tr');
                const tdKey = document.createElement('td');
                const tdValue = document.createElement('td');

                tr.setAttribute('class', 'text-lg font-kanit text-center hover:bg-gray-100');
                tdKey.setAttribute('class', 'border-2');
                tdValue.setAttribute('class', 'border-2');

                tdKey.innerHTML = key;
                tdValue.innerHTML = value;

                tr.appendChild(tdKey);
                tr.appendChild(tdValue);

                tbodyRef.appendChild(tr);
            }
            document.getElementById('repair_list').hidden = false;
        }

        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return [
                padTo2Digits(date.getDate()),
                padTo2Digits(date.getMonth() + 1),
                date.getFullYear(),
            ].join('/');
        }

        async function getFriend() {
            let friend = await liff.getFriendship();
            return friend.friendFlag;
        }

    </script>
@endsection