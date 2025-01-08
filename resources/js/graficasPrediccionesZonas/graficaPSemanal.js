document.addEventListener('DOMContentLoaded', function () {
    const zonaSelect = document.getElementById('zonaSelect');
    const chartContainer = document.getElementById('semanal-chart');
    let chart;

    function fetchPredictions(zonaId) {
        fetch(`/prediccionesZonas/obtenerPredicciones?zona_id=${zonaId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.length) {
                    alert('No hay datos disponibles para esta zona.');
                    if (chart) chart.destroy();
                    return;
                }

                const fechas = data.map(item => item.fecha);
                const valores = data.map(item => item.total_kg);

                const options = {
                    chart: { height: 350, type: "line", fontFamily: "Inter, sans-serif" },
                    series: [{ name: "Predicción de residuos (Kg)", data: valores, color: "#008FFB" }],
                    xaxis: { categories: fechas },
                    yaxis: { title: { text: 'Kg de residuos' } }
                };

                if (chart) chart.destroy();
                chart = new ApexCharts(chartContainer, options);
                chart.render();
            })
            .catch(error => {
                console.error('Error al obtener las predicciones:', error);
                alert('Hubo un error al cargar los datos. Inténtalo nuevamente.');
            });
    }

    zonaSelect.addEventListener('change', function () {
        const zonaId = this.value;
        if (zonaId) {
            fetchPredictions(zonaId);
        }
    });

    if (zonaSelect.value) {
        fetchPredictions(zonaSelect.value);
    }
});
