// Grafica del top 3 subproductos que mas generan
document.addEventListener('DOMContentLoaded', function() {
	if (window.subproductosData && window.subproductosData.length > 0) {
		// Datos de los subproductos (porcentaje de generación)
		const subproductos = window.subproductosData;
		const colores = [ '#1C64F2', '#31C48D', '#F05252' ];

		// Calcular el total de generación
		const total = subproductos.reduce((acc, item) => acc + item.total_kg, 0);

		// Generar los gráficos para cada subproducto
		subproductos.forEach((subproducto, index) => {
			const porcentaje = (subproducto.total_kg / total * 100).toFixed(3);

			// Mostrar el porcentaje en la vista
			document.querySelector(`#porcentaje-${index + 1}`).innerText = `${porcentaje}%`;

			// Configuración de cada gráfico radial
			const getChartOptions = () => {
				return {
					series: [ porcentaje ],
					colors: [ colores[index] ], // Color específico para cada subproducto
					chart: {
						height: 380,
						width: '100%',
						type: 'radialBar',
						sparkline: {
							enabled: true
						}
					},
					plotOptions: {
						radialBar: {
							track: {
								background: '#E5E7EB'
							},
							dataLabels: {
								show: false
							},
							hollow: {
								margin: 0,
								size: '40%'
							}
						}
					},
					grid: {
						show: false
					},
					labels: [ subproducto.nombre ], // Nombre del subproducto
					legend: {
						show: false
					},
					tooltip: {
						enabled: true,
						x: {
							show: false
						}
					},
					yaxis: {
						show: false,
						labels: {
							formatter: function(value) {
								return value + '%';
							}
						}
					}
				};
			};

			// Crear el gráfico
			const chart = new ApexCharts(document.querySelector(`#radial-chart-${index + 1}`), getChartOptions());
			chart.render();
		});
	}
});
