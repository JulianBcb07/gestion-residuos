// Grafica de porcentaje

document.addEventListener('DOMContentLoaded', function () {
    // Obtener la URL actual del navegador
    const currentURL = window.location.href;

    // Verificar si la URL coincide con la página deseada
    if (!currentURL.includes('/graficassemanal')) {
        return;
    }

    // Función de debounce para evitar solicitudes repetidas
    function debounce(func, wait, immediate) {
        let timeout;
        return function () {
            const context = this,
                args = arguments;
            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Función para renderizar la gráfica con los datos recibidos
    function renderChart(data) {
        const pieChartContainer = document.getElementById('pie-chart');

        // Verificar si el contenedor existe
        if (!pieChartContainer) {
            console.warn('El contenedor #pie-chart no está presente en el DOM');
            return;
        }

        const totalKg = data.reduce((sum, item) => sum + item.total_kg, 0);
        const labels = data.map((item) => item.nombre);
        const series = data.map((item) => parseFloat((item.total_kg / totalKg * 100).toFixed(2)));

        const chartOptions = {
            series: series,
            labels: labels,
            colors: [
                '#1C64F2',
                '#133E87',
                '#F87A53',
                '#608BC1',
                '#F95454',
                '#F3C623',
                '#00FF9C',
                '#4CC9FE',
                '#FADFA1',
                '#821131'
            ],
            chart: {
                height: 450,
                type: 'pie'
            },
            stroke: { colors: ['#fff'] },
            dataLabels: {
                enabled: true,
                formatter: function (value) {
                    return value.toFixed(2) + '%';
                }
            },
            legend: { position: 'bottom' }
        };

        if (pieChartContainer.chart) {
            pieChartContainer.chart.destroy(); // Destruir el gráfico anterior si existe
        }

        const chart = new ApexCharts(pieChartContainer, chartOptions);
        pieChartContainer.chart = chart; // Guardar referencia
        chart.render();
    }

    // Función para realizar la solicitud AJAX
    function fetchData(tipoGrafico, periodo = 'Todo') {
        const url = `/graficassemanal/data?tipoGrafico=${tipoGrafico}&periodo=${periodo}`;
        const pieChartContainer = document.getElementById('pie-chart');

        // Verificar si el contenedor existe antes de solicitar los datos
        if (!pieChartContainer) {
            console.warn('No se puede obtener datos porque el contenedor #pie-chart no está en el DOM.');
            return;
        }

        fetch(url, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos');
                }
                return response.json();
            })
            .then((data) => {
                renderChart(data); // Renderiza la gráfica
            })
            .catch((error) => {
                console.error('Error fetching data:', error);
            });
    }

    // Manejador de eventos para el filtro de período
    const fetchDataDebounced = debounce(function (periodo) {
        fetchData('pieChart', periodo); // Cambia el tipo de gráfico si es necesario
    }, 500);

    const dropdownOptions = document.querySelectorAll('.dropdown-option');

    // Deshabilitar botones de período
    function togglePeriodButtons(disabled) {
        dropdownOptions.forEach((option) => {
            option.disabled = disabled;
        });
    }

    // Agregar eventos a los botones de período
    dropdownOptions.forEach((option) => {
        option.addEventListener('click', function () {
            const periodo = this.getAttribute('data-time-range');
            fetchDataDebounced(periodo);
        });
    });

    // Escuchar evento global para rango de fechas
    document.addEventListener('updateCharts', function (e) {
        renderChart(e.detail.pieChart);
        togglePeriodButtons(true); // Deshabilitar botones de período
    });

    // Escuchar evento para limpiar rango de fechas
    document.addEventListener('clearDateRange', function () {
        togglePeriodButtons(false); // Reactivar botones de período
        fetchData('pieChart', 'Todo'); // Volver a cargar datos predeterminados
    });

    // Cargar los datos por defecto (ejemplo: "Todo")
    fetchData('pieChart', 'Todo');
});
