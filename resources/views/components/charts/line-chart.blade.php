<div class="card">
    <?php $id = 'line-chart-' . rand(); ?>
    <div class="card-body">
        <div id="{{ $id }}"></div>
    </div>
</div>

@push('js')
<script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<script>
    var options = {
		series: [{
			name: 'Likes',
			data: {!! json_encode($data) !!}
		}],
		chart: {
			foreColor: '#9ba7b2',
			height: 360,
			type: 'line',
			zoom: {
				enabled: false
			},
			toolbar: {
				show: true
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 14,
				blur: 4,
				opacity: 0.10,
			}
		},
		stroke: {
			width: 5,
			curve: 'smooth'
		},
		xaxis: {
			categories: {!! json_encode($labels) !!}
		},
		title: {
			text: 'Доходы',
			align: 'left',
			style: {
				fontSize: "16px",
				color: '#666'
			}
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				gradientToColors: ['#8833ff'],
				shadeIntensity: 1,
				type: 'horizontal',
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100, 100, 100]
			},
		},
		markers: {
			size: 4,
			colors: ["#8833ff"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7,
			}
		},
		colors: ["#8833ff"],
		yaxis: {
			title: {
				text: 'Engagement',
			},
		}
	};
	var chart = new ApexCharts(document.querySelector("#{{ $id }}"), options);
	chart.render();
</script>
@endpush
