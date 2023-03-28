@extends('admin.layout.template')

@section('content')
    <div id="bar-chart"></div>
    <hr>
    <div id="pie-chart"></div>
@endsection

@section('scripts')
    <script>
        const categories = @json($categories);
        $(document).ready(function() {
            let options, chart;

            options = {
                series: [{
                    data: categories.map(category => category.products_count)
                }],
                chart: {
                    type: 'bar',
                    height: 380
                },
                plotOptions: {
                    bar: {
                        barHeight: '100%',
                        distributed: true,
                        horizontal: true,
                        dataLabels: {
                            position: 'bottom'
                        },
                    }
                },
                colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
                    '#f48024', '#69d2e7'
                ],
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['#fff']
                    },
                    formatter: function(val, opt) {
                        return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
                    },
                    offsetX: 0,
                    dropShadow: {
                        enabled: true
                    }
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                xaxis: {
                    categories: categories.map(category => category.name),
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                title: {
                    text: 'category names and number of associated products',
                    align: 'center',
                    floating: true
                },
                tooltip: {
                    theme: 'dark',
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function() {
                                return ''
                            }
                        }
                    }
                }
            };

            chart = new ApexCharts(document.querySelector("#bar-chart"), options);
            chart.render();


            options = {
                series: categories.map(category => category.products_sum_price ?? 0),
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: categories.map(category => category.name),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                title: {
                    text: 'category names and total prices of associated products',
                    align: 'center',
                    floating: true
                },
            };

            chart = new ApexCharts(document.querySelector("#pie-chart"), options);
            chart.render();
        });
    </script>
@endsection
