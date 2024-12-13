document.addEventListener('DOMContentLoaded', function () {
    const options = {
        chart: {
            height: 350,
            type: "line",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 3,
                left: 2,
                blur: 4,
                opacity: 0.1
            },
            toolbar: {
                show: true,
            },
            zoom: {
                enabled: false,
            },
        },
        tooltip: {
            enabled: true,
            theme: 'dark',
            x: {
                show: true,
                format: 'dd MMM',
            },
            y: {
                formatter: (value) => `${value} Kg`,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 3,
            curve: 'smooth',
        },
        grid: {
            show: true,
            borderColor: '#e0e0e0',
            strokeDashArray: 4,
            padding: {
                left: 10,
                right: 10,
                top: 0
            },
        },
        series: [
            {
                name: "Semanal",
                data: [34.5, 45.3, 45.66, 43.3, 34.45, 67.56, 25.80],
                color: "#008FFB",
            },
            {
                name: "Mensual",
                data: [56.45, 56.56, 45.65, 67.58, 14.33, 79.54, 12.13],
                color: "#00E396",
            },
            {
                name: "Anual",
                data: [45.45, 67.56, 34.24, 45.54, 32.32, 45.36, 36.56],
                color: "#00E396",
            },
        ],
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'center',
            floating: true,
            offsetY: -25,
            offsetX: -5
        },
        xaxis: {
            categories: ['01 Feb', '02 Feb', '03 Feb', '04 Feb', '05 Feb', '06 Feb', '07 Feb'],
            labels: {
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: true,
                color: '#e0e0e0'
            },
            axisTicks: {
                show: true,
                color: '#e0e0e0'
            },
        },
        yaxis: {
            show: true,
            title: {
                text: 'Cantidad de Generacion',
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-sm font-normal fill-gray-700 dark:fill-gray-300'
                }
            },
            labels: {
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            }
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetY: 0,
                    },
                },
            },
        ],
    };

    if (document.getElementById("semanal-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("semanal-chart"), options);
        chart.render();
    }
});