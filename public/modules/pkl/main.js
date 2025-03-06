$(() => {
    $('#content-area').html('');
    APP.block();
})

axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let menuLinks = document.querySelectorAll('.main-menu_nav');
menuLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
        APP.block();
        e.preventDefault(); // Mencegah link melakukan navigasi

        // Ambil URL dari data-url attribute
        let url = this.getAttribute('data-url');
        let suburl = this.getAttribute('data-suburl');
        let params = this.getAttribute('data-params');
        let navTipe = this.getAttribute('data-tipe');

        document.querySelectorAll('.menu-item').forEach(function (item) {
            item.classList.remove('active', 'open');
        });
        document.querySelectorAll('.main-menu_nav').forEach(function (item) {
            item.classList.remove('active', 'open');
        });

        if (navTipe == 'main') {
            // Hapus class 'active' dari semua menu-item dan menu-link

            // Tambahkan class 'active' ke submenu yang diklik
            let submenuItem = this.closest('.menu-item');
            submenuItem.classList.add('active');

            $(`[data-url="${suburl}"]`).addClass('active open');
        }

        // let url = 'desk/content';
        $('#content-area').html('');
        // // Axios untuk mengambil konten dari server
        APP.axiosRequest({
            url: `${BASE_URL}/api/pkl/load-page`,
            data: {
                id: url,
                params: params
            },
        }).then(response => {
            var data = response.data;
            var nameMenu = data['name'];

            $('#page-menu-name').html(nameMenu)
            BASE_API_MENU = `${BASE_URL}/api/pkl/${data.url}`;

            var html = atob(data.html);
            var plugins = atob(data.plugins);
            $('#content-area').html(html);
            $('#content-plugins').html(plugins);
            // customcard.bindEvents(); // Memanggil ulang event listener
            $(`[data-url="${url}"]`).addClass('active');
            APP.unblock();
            // feather.replace();
        }).catch(error => {
            APP.unblock();
            console.error("Fetch error:", error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const observer = new MutationObserver(function (mutations) {
        const firstMenu = document.querySelector('.main-menu_nav');
        if (firstMenu) {
            firstMenu.click(); // Menjalankan klik pada menu pertama
            observer.disconnect(); // Hentikan observer setelah elemen ditemukan
            $('#template-customizer').remove();
        }
    });
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});


switchModule = (roleId) => {
    APP.block();
    APP.axiosRequest({
        url: `${BASE_URL}/api/pkl/switch/module`,
        data: {
            slug: roleId,
        },
    }).then(response => {
        if (response.success) {
            location.reload(true);
        }
        APP.unblock();
    }).catch(error => {
        console.error("Fetch error:", error);
        APP.unblock();
    });
}