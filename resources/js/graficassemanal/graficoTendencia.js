document.addEventListener('DOMContentLoaded', function () {

	const currentURL = window.location.href;

	// Verificamos is la URL de la pagina actual coincide con la pagina de las graficas
	if (!currentURL.includes('/graficassemanal')) {
		return;
	}

	// Función para renderizar el gráfico de tendencia de generación por día
	function renderTrendChart(residuosData) {
		const subproductos = [];
		const valoresPorSubproducto = {};
		let fechas = [];

		// Agrupar los datos por subproducto y fecha
		residuosData.forEach((item) => {
			if (!subproductos.includes(item.nombre)) {
				subproductos.push(item.nombre);
			}

			if (!valoresPorSubproducto[item.nombre]) {
				valoresPorSubproducto[item.nombre] = {};
			}

			if (!fechas.includes(item.fecha)) {
				fechas.push(item.fecha);
			}

			if (!valoresPorSubproducto[item.nombre][item.fecha]) {
				valoresPorSubproducto[item.nombre][item.fecha] = 0;
			}

			valoresPorSubproducto[item.nombre][item.fecha] += item.total_kg;
		});

		// Ordenar las fechas de forma ascendente
		fechas = fechas.sort((a, b) => new Date(a) - new Date(b));

		// Preparar los datos para el gráfico
		const seriesData = subproductos.map((subproducto) => {
			const datos = [];
			fechas.forEach((fecha) => {
				datos.push(valoresPorSubproducto[subproducto][fecha] || 0);
			});
			return {
				name: subproducto,
				data: datos,
			};
		});

		const options = {
			series: seriesData,
			chart: {
				type: 'area',
				height: 450,
			},
			xaxis: {
				categories: fechas.map((fecha) => {
					const date = new Date(fecha + 'T00:00:00Z');
					return `${date.getUTCDate()} ${date.toLocaleString('default', { month: 'short' })}`;
				}),
			},
			yaxis: {
				labels: {
					formatter: function (value) {
						return `${value} kg`;
					},
				},
			},
			tooltip: {
				y: {
					formatter: function (value, { seriesIndex, dataPointIndex }) {
						const subproducto = subproductos[seriesIndex];
						return `${subproducto}: ${value} kg`;
					},
				},
			},
		};

		// Verificar si el gráfico ya está renderizado
		if (typeof window.trendChart !== 'undefined') {
			window.trendChart.destroy();
		}

		const trendChartContainer = document.getElementById('data-labels-chart');
		if (trendChartContainer && typeof ApexCharts !== 'undefined') {
			window.trendChart = new ApexCharts(trendChartContainer, options);
			window.trendChart.render();
		}
	}

	// Función para obtener los datos del gráfico desde el servidor
	function fetchTrendData(periodo = 'Todo', startDate = null, endDate = null) {
		let url = `/graficassemanal/data?tipoGrafico=lineChart&periodo=${periodo}`;
		if (startDate && endDate) {
			url = `/graficassemanal/data?tipoGrafico=lineChart&startDate=${startDate}&endDate=${endDate}`;
		}

		fetch(url, {
			method: 'GET',
			headers: {
				Accept: 'application/json',
				'X-Requested-With': 'XMLHttpRequest',
			},
		})
			.then((response) => {
				if (!response.ok) {
					throw new Error('Error en la solicitud');
				}
				return response.json();
			})
			.then((residuosData) => {
				renderTrendChart(residuosData);
			})
			.catch((error) => {
				console.error('Error en la solicitud AJAX:', error);
			});
	}

	// Función de debounce para evitar múltiples solicitudes rápidas
	function debounce(func, wait) {
		let timeout;
		return function (...args) {
			const later = () => {
				clearTimeout(timeout);
				func(...args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}

	const fetchDataDebounced = debounce(function (periodo, startDate, endDate) {
		fetchTrendData(periodo, startDate, endDate);
	}, 300);

	// Manejo de eventos para botones de periodo
	const dropdownOptions = document.querySelectorAll('.dropdown-option2');
	dropdownOptions.forEach((option) => {
		option.addEventListener('click', function () {
			const periodo = this.getAttribute('data-time-range');
			fetchDataDebounced(periodo);
		});
	});

	// Escuchar evento global para rango de fechas
	document.addEventListener('updateCharts', function (e) {
		const { lineChart } = e.detail; // Asegúrate de que el backend envíe los datos correctamente
		renderTrendChart(lineChart);
	});

	// Escuchar evento para limpiar rango de fechas
	document.addEventListener('clearDateRange', function () {
		fetchTrendData('Todo');
	});

	// Cargar datos iniciales
	fetchTrendData('Todo');
});
