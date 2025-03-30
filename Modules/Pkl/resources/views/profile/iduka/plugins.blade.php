<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    $(() => {
        initSetting();
    })


    initSetting = () => {
        APP.block();
        APP.axiosRequest({
            url: `${BASE_API_MENU}/info`,
        }).then(res => {
            $.each(res.data, (i, v) => {
                $(`#info-${i}`).val(v);
                // $(`[name="${i}"]`).val(v);
                let inputElement = $(`[name="${i}"]`);
                inputElement.val(v).trigger('change');

                // Jika elemen memiliki Flatpickr, atur tanggalnya dengan setDate
                if (inputElement.hasClass('flatpickr-input')) {
                    // Konversi format YYYY-MM-DD ke DD-MM-YYYY jika perlu
                    let formattedDate = v.split('-').reverse().join('-');

                    console.log("Setting date:", formattedDate); // Debugging
                    inputElement[0]._flatpickr.setDate(formattedDate, true);
                }
            })

            $.each(res.data, (i, v) => {
                $(`.detail-${i}`).html(v);
            })
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }

    onSaveIt = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'save';

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            initSetting();
            APP.showToast({
                type: data.status,
                message: data.message,
            });
            APP.unblock();
        }).catch(error => {
            console.error("Fetch error:", error);
            APP.unblock();
        });
    }
</script>