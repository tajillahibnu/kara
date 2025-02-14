var targetID = '';
BASE_API_MENU = `${BASE_URL}/api/panel/setting/sekolah`;

$(() => {
    APP.combov1({
        el: ['#tahun_pelajaran'],
        url: `${BASE_API_MENU}/combo/tahun-pelajaran`,
        fild_id: 'name',
        fild_name: 'name',
        callback: (response) => {
            if (response.error) {
                console.error("Error:", response.error);
            } else {
                // console.log("Data berhasil dimuat:", response.data);
                onLoadFirst()
            }
        }
    })
})


onLoadFirst = () => {
    APP.axiosRequest({
        url: `${BASE_API_MENU}/read`,
    }).then(data => {
        Array.from(data['data']).forEach(element => {
            $(`[name="${element['config_name']}"]`).each(function () {
                if ($(this).is(':checkbox')) {
                    // Jika elemen adalah checkbox
                    $(this).prop('checked', element.config_value);
                } else if ($(this).is(':radio')) {
                    $(`#${element['config_name']}_${element.config_value}`).prop('checked', element.config_value);
                } else {
                    // Jika elemen bukan checkbox (default)
                    $(this).val(element.config_value).trigger('change');
                }
            });
        })
    }).catch(error => {
        // console.error("Fetch error:", error);
    });
}


onSaveApp = (name) => {
    var form = $(`#${name}`)[0];
    var formData = new FormData(form);

    APP.axiosRequest({
        url: `${BASE_API_MENU}/update`,
        data: formData,
    }).then(data => {
        APP.notify({
            message: `<i class="fa-regular fa-bell"></i><strong class="text-uppercase">${data.status}</strong> ${data.message}.`
        })
        // toastr.success("Data berhasil disimpan!", "Sukses");
    }).catch(error => {
        console.error("Fetch error:", error);
    });
}