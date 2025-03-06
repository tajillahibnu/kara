<!-- <script src="{{asset('/')}}modules/pkl/xx/xx.js"></script> -->
<script>
    doSave = (name) => {
        APP.block();
        var form = $(`#${name}`)[0];
        var formData = new FormData(form);
        var action = 'upload';

        APP.axiosRequest({
            url: `${BASE_API_MENU}/${action}`,
            data: formData,
        }).then(data => {
            APP.reloadTable();
            $('#mainModal').modal('hide');
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