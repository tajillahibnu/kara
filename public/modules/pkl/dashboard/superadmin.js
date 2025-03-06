// var labelColorDashboard = '';
// var headingColorDashboard = '';
// var borderColorDashboard = '';

// if (isDarkStyle) {
//     labelColorDashboard = config.colors_dark.textMuted;
//     headingColorDashboard = config.colors_dark.headingColor;
//     borderColorDashboard = config.colors_dark.borderColor;
// } else {
//     labelColorDashboard = config.colors.textMuted;
//     headingColorDashboard = config.colors.headingColor;
//     borderColorDashboard = config.colors.borderColor;
// }

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
        renderHorizontalBarChart(res.data['totalSiswaJurusan']);
        grafikSiswaTahun(res.data['tahunMasuk']);
        APP.unblock();
    }).catch(error => {
        console.error("Fetch error:", error);
        APP.unblock();
    });
}

function renderHorizontalBarChart(apiData) {
    const horizontalBarChartEl = document.querySelector('#horizontalBarChart');
    if (!horizontalBarChartEl) return;

    var categories = [];
    var categoriesName = [];
    var seriesData = [];

    // Mengelompokkan data sesuai jurusan
    apiData.forEach(jurusan => {
        categories.push(jurusan.kode);
        categoriesName.push(jurusan.name);
        seriesData.push(jurusan.total);
    });

    const horizontalBarChartConfig = {
        chart: {
            type: 'bar',
            // height: window.innerHeight * 0.8, 
            width: '100%',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                borderRadius: 7
            }
        },
        grid: {
            strokeDashArray: 10,
            xaxis: { lines: { show: true } },
            yaxis: { lines: { show: false } },
            padding: { top: -35, bottom: -12 }
        },
        colors: [
            "#ff4560", "#008ffb", "#00e396", "#feb019", "#775dd0", "#ff66c3"
        ],
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff'],
                fontWeight: 400,
                fontSize: '13px',
                fontFamily: 'Public Sans'
            }
        },
        labels: categories,
        series: [{ data: seriesData }],
        xaxis: {
            categories: categories,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    fontSize: '13px',
                    fontFamily: 'Public Sans'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '13px',
                    fontFamily: 'Public Sans'
                }
            }
        },
        tooltip: {
            enabled: true,
            style: { fontSize: '12px' },
            custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                let namaJurusan = categoriesName[dataPointIndex]; // Nama jurusan dari categoriesName
                let totalSiswa = series[seriesIndex][dataPointIndex]; // Total siswa

                return `
                <div class="px-3 py-2 bg-white shadow-lg rounded-md text-gray-900 border border-gray-300">
                    <span class="font-semibold">${namaJurusan}</span> 
                    <br>
                    <span class="text-sm">Total: <strong>${totalSiswa}</strong></span>
                </div>`;
            }
        },
        legend: { show: false },
    };

    // Render chart
    var chart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
    chart.render();
}

grafikSiswaTahun = (dataSiswa) => {
    // Mengolah data untuk chart
    var categories = dataSiswa.map(item => item.tahun_masuk); // Tahun masuk sebagai kategori sumbu X
    var totalSiswa = dataSiswa.map(item => item.total); // Total siswa per tahun
    var totalLaki = dataSiswa.map(item => item.total_laki); // Total siswa laki-laki per tahun
    var totalPerempuan = dataSiswa.map(item => item.total_perempuan); // Total siswa perempuan per tahun

    var options = {
        series: [
            // {
            //     name: 'Total Siswa',
            //     data: totalSiswa
            // },
            {
                name: 'Siswa Laki-Laki',
                data: totalLaki
            },
            {
                name: 'Siswa Perempuan',
                data: totalPerempuan
            }
        ],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'last',
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        xaxis: {
            type: 'category', // Pakai kategori biasa, bukan datetime
            categories: categories, // Tahun masuk sebagai kategori
        },
        legend: {
            position: 'bottom', // Mengubah posisi legend ke bawah
            horizontalAlign: 'center', // Menjadikan legend rata tengah
            offsetY: 10
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val, opts) {
                    let index = opts.dataPointIndex;
                    let seriesIndex = opts.seriesIndex; // Index seri (0 = laki-laki, 1 = perempuan)
                    
                    let totalLaki = dataSiswa[index].total_laki;
                    let totalPerempuan = dataSiswa[index].total_perempuan;
                    let totalSiswa = parseInt(totalLaki) + parseInt(totalPerempuan); // Total siswa tahun tersebut

                    let jumlahYangDisorot = seriesIndex === 0 ? totalLaki : totalPerempuan;
                    let persenYangDisorot = ((jumlahYangDisorot / totalSiswa) * 100).toFixed(1);

                    return `${jumlahYangDisorot} / ${totalSiswa} (${persenYangDisorot}%)`;
                }

            }
        }
        // tooltip: {
        //     enabled: true,
        //     style: { fontSize: '12px' },
        //     custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        //         let totalSiswa = series[seriesIndex][dataPointIndex]; // Total siswa
        //         let namaJurusan = totalSiswa[seriesIndex]; // Nama jurusan dari categoriesName
        //         return `
        //         <div class="px-3 py-2 bg-white shadow-lg rounded-md text-gray-900 border border-gray-300">
        //             <span class="font-semibold">${namaJurusan}</span> 
        //             <br>
        //             <span class="text-sm">Total: <strong>${totalSiswa}</strong></span>
        //         </div>`;
        //     }
        // },
    };

    var chart = new ApexCharts(document.querySelector("#chartSiswaTahun"), options);
    chart.render();
};