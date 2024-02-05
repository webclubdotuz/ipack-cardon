<div class="card">
    <div class="card-body">
        <?php $id = 'pie-chart-' . rand(1000, 9999); ?>
        <div id="{{$id}}"></div>
    </div>
</div>


@push('js')
    <script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script>
        var options = {
            series: [44, 55, 13, 43, 22],
            chart: {
                foreColor: '#9ba7b2',
                height: 330,
                type: 'pie',
            },
            colors: ["#8833ff", "#6c757d", "#17a00e", "#f41127", "#ffc107"],
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 360
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#{{$id}}"), options);
        chart.render();
    </script>
@endpush
