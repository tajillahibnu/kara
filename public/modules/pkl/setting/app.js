var targetID = '';

$(() => {
    onLoadFirst()
})


onLoadFirst = () => {
    APP.axiosRequest({
        url: `${BASE_API_MENU}/read`,
    }).then(data => {
        Array.from(data['data']).forEach(element => {
            // $(`[name="${element['config_name']}"]`).val(element.config_value).trigger('change');
            $(`[name="${element['config_name']}"]`).each(function () {
                if ($(this).is(':checkbox')) {
                    // Jika elemen adalah checkbox
                    $(this).prop('checked', element.config_value === true || element.config_value === 1 || element.config_value === "1");
                } else {
                    // Jika elemen bukan checkbox (default)
                    $(this).val(element.config_value).trigger('change');
                }
            });
        })
    }).catch(error => {
        console.error("Fetch error:", error);
    });
}


onSaveApp = (name) => {
    var form = $(`#${name}`)[0];
    var formData = new FormData(form);

    // formData.append('sekolah_tipe', $('[name="sekolah_tipe"]').val());
    // formData.append('sekolah_tlpn', $('[name="sekolah_tlpn"]').val());
    // formData.append('sekolah_email', $('[name="sekolah_email"]').val());
    // formData.append('sekolah_is_smk', $('[name="sekolah_is_smk"]').is(':checked') ? 1 : 0);

    APP.axiosRequest({
        url: `${BASE_API_MENU}/update`,
        data: formData,
    }).then(data => {
        APP.showToast({
            type: data.status,
            message: data.message,
        })
    }).catch(error => {
        console.error("Fetch error:", error);
    });
}