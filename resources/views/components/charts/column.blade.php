<div class="card">
    <div class="card-body">
        <?php $id = 'column-chart-' . rand(); ?>
        <div id="{{$id}}"></div>
    </div>
</div>

@push('js')
    <script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script>
        var options = {
            series: [{
                data: {!! json_encode($data) !!}
            }],
            chart: {
                foreColor: '#9ba7b2',
                type: 'bar',
                height: 350
            },
            colors: ["#8833ff"],
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: '35%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: {!! json_encode($labels) !!}
            },
            title: {
                text: "{{ $title }}",
                align: 'left',
                style: {
                    fontSize: "16px",
                    color: '#666'
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#{{$id}}"), options);
        chart.render();
    </script>
@endpush
