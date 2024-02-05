<div class="card">
    <?php $id = 'multi-line-chart-' . rand(); ?>
    <div class="card-body">
        <div id="{{ $id }}"></div>
    </div>
</div>

@push('js')
<script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<script>

    series = {!! json_encode($series) !!};

    console.log(series);

    new_series = [];

    Object.keys(series).forEach(function(key) {
        new_series.push({
            name: key,
            data: series[key]
        });
    });

    console.log(new_series);

    var optionsLine = {
		chart: {
			foreColor: '#9ba7b2',
			height: 360,
			type: 'line',
			zoom: {
				enabled: false
			},
			dropShadow: {
				enabled: true,
				top: 3,
				left: 2,
				blur: 4,
				opacity: 0.1,
			}
		},
		stroke: {
			curve: 'smooth',
			width: 5
		},
		colors: ["#8833ff", '#29cc39'],
		series: new_series,
		title: {
			text: "{{$title}}",
			align: 'left',
			offsetY: 25,
			offsetX: 20
		},
		subtitle: {
			text: "Статистика",
			offsetY: 55,
			offsetX: 20
		},
		markers: {
			size: 4,
			strokeWidth: 0,
			hover: {
				size: 7
			}
		},
		grid: {
			show: true,
			padding: {
				bottom: 0
			}
		},
		labels: {!! json_encode($labels) !!},
		xaxis: {
			tooltip: {
				enabled: false
			}
		},
		legend: {
			position: 'top',
			horizontalAlign: 'right',
			offsetY: -20
		}
	}
	var chartLine = new ApexCharts(document.querySelector('#{{$id}}'), optionsLine);
	chartLine.render();
</script>
@endpush
