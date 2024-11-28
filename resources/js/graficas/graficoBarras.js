// Gráfico de barras de cuanto ha generado cada subproducto en kg

document.addEventListener('DOMContentLoaded', function () {
	const currentURL = window.location.href;

	// Verificar si la URL corresponde a la página de gráficos
	if (!currentURL.includes('/graficassubproductos')) {
		return;
	}

	// Función de debounce para evitar solicitudes repetidas
	function debounce(func, wait, immediate) {
		let timeout;
		return function () {
			const context = this, args = arguments;
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

	// Función para renderizar el gráfico de barras con los datos recibidos
	function renderBarChart(data) {
		const barChartContainer = document.getElementById('column-chart');
		if (!barChartContainer) {
			console.warn('El contenedor del gráfico no existe: #column-chart');
			return;
		}

		const chartOptions = {
			colors: ['#1A56DB'],
			series: [
				{
					name: 'Total',
					data: data.map(item => ({
						x: item.nombre,
						y: parseFloat(item.total_kg.toFixed(3)) // Limitar a 3 decimales
					}))
				}
			],
			chart: {
				type: 'bar',
				height: 320,
				fontFamily: 'Inter, sans-serif',
				toolbar: { show: true }
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '70%',
					borderRadius: 8
				}
			},
			tooltip: {
				shared: true,
				intersect: false
			},
			dataLabels: {
				enabled: true,
				formatter: function (val) {
					return `${val.toFixed(2)} kg`;
				}
			},
			legend: {
				show: true
			},
			xaxis: {
				labels: {
					style: {
						fontFamily: 'Inter, sans-serif',
						cssClass: 'text-xs font-normal fill-gray-500'
					}
				}
			},
			yaxis: { show: false },
			fill: { opacity: 1 }
		};

		if (barChartContainer.chart) {
			barChartContainer.chart.destroy();
		}

		const chart = new ApexCharts(barChartContainer, chartOptions);
		barChartContainer.chart = chart;
		chart.render();
	}

	// Función para obtener los datos de la API según el tipo de gráfico y período
	function fetchData(tipoGrafico, periodo = 'Todo') {
		const url = `/graficassubproductos/data?tipoGrafico=${tipoGrafico}&periodo=${periodo}`;

		fetch(url, {
			method: 'GET',
			headers: {
				Accept: 'application/json',
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
			.then(response => {
				if (!response.ok) {
					throw new Error('Error al obtener los datos');
				}
				return response.json();
			})
			.then(data => {
				renderBarChart(data);
			})
			.catch(error => {
				console.error('Error fetching data:', error);
			});
	}

	// Función debounced para manejar el cambio de período
	const fetchDataDebounced = debounce(function (periodo) {
		fetchData('barChart', periodo);
	}, 500);

	// Asignar eventos a las opciones del filtro de período
	document.querySelectorAll('.dropdown-option1').forEach(option => {
		option.addEventListener('click', function () {
			const periodo = this.getAttribute('data-time-range');
			fetchDataDebounced(periodo);
		});
	});

	// Escuchar el evento global para el rango de fechas
	document.addEventListener('updateCharts', function (e) {
		renderBarChart(e.detail.barChart); // Renderizar el gráfico de barras con los datos recibidos
	});

	// Cargar datos iniciales (por defecto: "Todo")
	fetchData('barChart', 'Todo');
});


