$(() => {
    initDasboard();
})


initDasboard = () => {
    APP.block();
    APP.axiosRequest({
        url: `${BASE_API_MENU}/info`,
    }).then(res => {
        console.log(res)
        $.each(res.data, (i, v) => {
            $(`.info-${i}`).html(v)
        })
        APP.unblock();
    }).catch(error => {
        console.error("Fetch error:", error);
        APP.unblock();
    });
}