<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    $(() => {
        initDasboard();
    })


    initDasboard = () => {
        APP.block();
        APP.axiosRequest({
            url: `${BASE_API_MENU}/info`,
        }).then(res => {
            // console.log(res)
            $.each(res.data, (i, v) => {
                if (i == 'total') {
                    Object.entries(v).forEach(([key, value]) => {
                        $(`.info-total_${key}`).html(value);
                    });
                } else {
                    $(`.info-${i}`).html(v)
                }
            })
            APP.unblock();
        }).catch(error => {
            APP.unblock();
        });
    }
</script>