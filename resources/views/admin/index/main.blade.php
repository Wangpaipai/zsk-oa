@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-6">
            <!--statistics start-->
            <div class="row state-overview">
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="panel purple">
                        <div class="symbol">
                            <i class="fa fa-gavel"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">230</div>
                            <div class="title">订单数量</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="panel red">
                        <div class="symbol">
                            <i class="fa fa-tags"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">3490</div>
                            <div class="title">直邮待发货</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row state-overview">
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="panel blue">
                        <div class="symbol">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">22014</div>
                            <div class="title">保税待发货</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="panel green">
                        <div class="symbol">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="state-value">
                            <div class="value">390</div>
                            <div class="title">完税待发货</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--statistics end-->
        </div>
        <div class="col-md-6">
            <!--more statistics box start-->
            <div class="panel deep-purple-box">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <div id="graph-donut" class="revenue-graph"></div>

                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <h3>本月订单数量统计</h3>
                            <ul class="bar-legend">
                                <li><span class="blue"></span>直邮</li>
                                <li><span class="green"></span>保税</li>
                                <li><span class="purple"></span>完税</li>
                                {{--<li><span class="red"></span> Unsubscribed rate</li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--more statistics box end-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row revenue-states">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h4>近10天订单明细</h4>
                            <div class="icheck">
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="clearfix">
                                <div id="main-chart-legend" class="pull-right">
                                </div>
                            </div>

                            <div id="main-chart">
                                <div id="main-chart-container" class="main-chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        $(function() {
            function sector(){
                // 扇形图
                Morris.Donut({
                    element: 'graph-donut',
                    data: [
                        {value: 40, label: '保税', formatted: '订单数40' },
                        {value: 30, label: '完税', formatted: '订单数30' },
                        {value: 0, label: '直邮', formatted: '订单数0' }
                        //{value: 10, label: 'Up Time', formatted: 'at most 99.99%' }
                    ],
                    backgroundColor: false,
                    labelColor: '#fff',
                    colors: [
                        '#4acacb','#6a8bc0','#5ab6df'/*,'#fe8676'*/
                    ],
                    formatter: function (x, data) { return data.formatted; }
                });
            }
            sector();
            //折线图
            function brokenLine(){
                var d1 = [
                    [1, 620],
                    [2, 437],
                    [3, 361],
                    [4, 549],
                    [5, 618],
                    [6, 570],
                    [7, 758],
                    [8, 658],
                    [9, 538],
                    [10, 488]
                ];
                var d2 = [
                    [1, 520],
                    [2, 337],
                    [3, 261],
                    [4, 0],
                    [5, 518],
                    [6, 470],
                    [7, 658],
                    [8, 558],
                    [9, 438],
                    [10, 388]
                ];
                var d3 = [
                    [1, 250],
                    [2, 337],
                    [3, 261],
                    [4, 449],
                    [5, 518],
                    [6, 780],
                    [7, 658],
                    [8, 999],
                    [9, 438],
                    [10, 234]
                ];

                var data = ([{
                    label: "直邮",
                    data: d1,
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: ["rgba(255,255,255,.4)", "rgba(183,236,240,.4)"]
                        }
                    }
                },
                    {
                        label: "保税",
                        data: d2,
                        lines: {
                            show: true,
                            fill: true,
                            fillColor: {
                                colors: ["rgba(255,255,255,.0)", "rgba(253,96,91,.7)"]
                            }
                        }
                    },
                    {
                        label: "完税",
                        data: d3,
                        lines: {
                            show: true,
                            fill: true,
                            fillColor: {
                                colors: ["rgba(255,255,255,.0)", "rgba(81,212,204,.7)"]
                            }
                        }
                    }
                ]);

                var options = {
                    grid: {
                        backgroundColor:
                        {
                            colors: ["#ffffff", "#f4f4f6"]
                        },
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eeeeee",
                        borderWidth: 1,
                        borderColor: "#eeeeee"
                    },
                    // Tooltip
                    tooltip: true,
                    tooltipOpts: {
                        content: "%s %x日产生%y笔订单",
                        shifts: {
                            x: -60,
                            y: 25
                        },
                        defaultTheme: false
                    },
                    legend: {
                        labelBoxBorderColor: "#000000",
                        container: $("#main-chart-legend"), //remove to show in the chart
                        noColumns: 0
                    },
                    series: {
                        stack: true,
                        shadowSize: 0,
                        highlightColor: 'rgba(000,000,000,.2)'
                    },
//        lines: {
//            show: true,
//            fill: true
//
//        },
                    points: {
                        show: true,
                        radius: 3,
                        symbol: "circle"
                    },
                    colors: ["#5abcdf", "#ff8673",'#51d4cc']
                };
                var plot = $.plot($("#main-chart #main-chart-container"), data, options);
            }
            brokenLine();
        });
    </script>
@endsection