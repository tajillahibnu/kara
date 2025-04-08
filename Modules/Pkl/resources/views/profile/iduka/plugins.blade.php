<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    var nama_industri = '';
    var latitude = '';
    var longitude = '';
    var lokasiData = [];
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

            lokasiData.push({
                id: res.data.id, // Ganti dengan id yang sesuai
                nama: res.data.name,
                latitude: res.data.latitude, // Ganti dengan latitude yang sesuai
                longitude: res.data.longitude, // Ganti dengan longitude yang sesuai
                // latitude: -7.9797, // Ganti dengan latitude yang sesuai
                // longitude: 112.6304 // Ganti dengan longitude yang sesuai
            });

            // Inisialisasi peta, fokus ke Malang
            // var map = L.map('map').setView([-7.9797, 112.6304], 13);
            var map = L.map('map').setView([res.data.latitude, res.data.longitude], 13);

            // Tile layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Data lokasi dari Laravel sebagai array JS manual
            // var lokasiData = [{
            //     id: 'cccv',
            //     nama: nama_industri,
            //     latitude: '-7.9797',
            //     longitude: '112.6304',
            // }];

            // Tambahkan marker ke map
            lokasiData.forEach(function(lokasi) {
                L.marker([lokasi.latitude, lokasi.longitude])
                    .addTo(map)
                    .bindPopup("<strong>" + lokasi.nama + "</strong>");
            });

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