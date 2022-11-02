<dialog class="p-8 my-auto w-1/3 h-1/3 rounded-lg shadow-lg border-gray-300 border-2" id="modal">

    <div class="h-full">
        <div class="h-full flex flex-col justify-between">
            <h1 id="header" class="font-bold text-3xl">แก้ไข{{ $typename }}</h1>
            <hr>
            @csrf
            <div class="">
                <label id="bodyText" class="text-2xl">{{ $typename }}: </label>
                <x-input id="editTextInput" class="mt-1 w-full" type="text" name="name" required autofocus />
            </div>
            <div class="flex justify-end items-center gap-4 pt-2 ">

                <button
                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold bg-gray-500 text-gray-200 close-button w-1/4">ปิด</button>
                <button id="saveButton"
                    class="p-2 rounded-lg border-0 cursor-pointer font-weight-bold my-button-confirm w-1/4"
                    type="submit">บันทึก</button>
            </div>
        </div>
    </div>

</dialog>
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        function openModal(id, name, requestURL, typename) {
            const modal = document.querySelector("#modal");
            const header = document.getElementById("header");
            header.innerHTML = "แก้ไข" + typename;
            const bodyText = document.getElementById("bodyText");
            bodyText.innerHTML = typename + ": ";
            const closeModal = document.querySelector(".close-button");
            const saveButton = document.querySelector("#saveButton");
            modal.showModal();

            document.getElementById("editTextInput").value = name;

            closeModal.addEventListener("click", () => {
                modal.close();
            });
            saveButton.addEventListener("click", () => {
                req(id, requestURL);
                console.log("reuest", requestURL);
            });

        }

        function openModelModal() {
            console.log('clk');
            const modal = document.querySelector("#modelModal");
            const closeModal = document.querySelector(".close-add-button");
            const saveButton = document.querySelector("#saveModelButton");
            modal.showModal();

            closeModal.addEventListener("click", () => {
                modal.close();
            });
            saveButton.addEventListener("click", () => {

            });


        }

        function openEditModelModal(id, name, img, reqURL) {
            const modal = document.querySelector("#editModelModal");
            const closeModal = document.querySelector(".close-edit-button");
            const saveEditButton = document.querySelector("#editSaveModelButton");
            const previewImage = document.querySelector("#edit_model_preview_image");
            modal.showModal();

            document.getElementById("editModelInput").value = name;



            const form = document.getElementById('editModelForm');
            let editFormData = new FormData(form);

            edit_input_model_image.onchange = evt => {
            let [editImage] = edit_input_model_image.files
            if (editImage) {
                editFormData.append('model_image' , editImage);
                edit_model_preview_image.src = window.URL.createObjectURL(editImage);
                edit_model_preview_image.classList.remove("hidden")
            }
        }

            previewImage.src = img;
            if (img != '') {
                previewImage.classList.remove("hidden")
                fetch(previewImage.src)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], 'dot.png', blob)
                        console.log("gile", file)
                        const imageFile = file

                        // If you want to add an extra field for the FormData
                        editFormData.append('model_image', imageFile);

                        // console.log('editFormData', editFormData);

                    })

            }



            closeModal.addEventListener("click", () => {
                modal.close();
            });
            saveEditButton.addEventListener("click", () => {
                // var imageFile;
                // editFormData.delete('_token')
                for (const [key, value] of editFormData) {
                    console.log(`===> : ${key}: ${value.name}\n`);
                }
                var name = document.getElementById("editModelInput").value
                editFormData.append('name', name);
                // log(reqURL)
                $.ajax({
                    type: 'post',
                    url: reqURL,
                    enctype: 'multipart/form-data',
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    data: editFormData,
                    success: function(res) {
                        console.log(res.data);
                        // window.location.href = "";
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("ไม่สามารถแก้ไขข้อมูลได้!");
                    }
                });

            });


        }


        input_model_image.onchange = evt => {
            console.log(evt);
            let [image] = input_model_image.files
            console.log(image);
            if (image) {
                model_preview_image.src = window.URL.createObjectURL(image);
                model_preview_image.classList.remove("hidden")
            }
        }

        function req(id, requestURL) {
            console.log(requestURL);
            var name = document.getElementById("editTextInput").value
            $.ajax({
                type: 'post',
                url: requestURL + "/" + id,
                data: {
                    'name': name,
                },
                success: function(res) {
                    window.location.href = "";
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("ไม่สามารถแก้ไขข้อมูลได้!");
                }
            });
        }
    </script>
@endsection
