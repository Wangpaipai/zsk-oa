<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <title>张大伯跨境购-发货系统</title>

    <!--icheck-->
    <link href="{{ asset('/static/admin/js/iCheck/skins/minimal/minimal.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/js/iCheck/skins/square/square.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/js/iCheck/skins/square/red.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/js/iCheck/skins/square/blue.css') }}" rel="stylesheet">

    <!--dashboard calendar-->
    <link href="{{ asset('/static/admin/css/clndr.css') }}" rel="stylesheet">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/static/admin/js/morris-chart/morris.css') }}">

    <!--common-->
    <link href="{{ asset('/static/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/css/style-responsive.css') }}" rel="stylesheet">

    <!--启用按钮-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/static/admin/js/ios-switch/switchery.css') }}" />

    <!--单选、多选框-->
    <link href="{{ asset('/static/admin/js/iCheck/skins/minimal/green.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body class="sticky-header" style="background: #eff0f4">

<section>


    @yield('content')
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ asset('/static/admin/js/html5shiv.js') }}"></script>
<script src="{{ asset('/static/admin/js/respond.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery.nicescroll.js') }}"></script>

<!--easy pie chart-->
<script src="{{ asset('/static/admin/js/easypiechart/jquery.easypiechart.js') }}"></script>
<script src="{{ asset('/static/admin/js/easypiechart/easypiechart-init.js') }}"></script>

<!--Sparkline Chart-->
{{--<script src="{{ asset('/static/admin/js/sparkline/jquery.sparkline.js') }}"></script>--}}
{{--<script src="{{ asset('/static/admin/js/sparkline/sparkline-init.js') }}"></script>--}}

<!-- jQuery Flot Chart-->
<script src="{{ asset('/static/admin/js/flot-chart/jquery.flot.js') }}"></script>
<script src="{{ asset('/static/admin/js/flot-chart/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('/static/admin/js/flot-chart/jquery.flot.resize.js') }}"></script>


<!--Morris Chart-->
<script src="{{ asset('/static/admin/js/morris-chart/morris.js') }}"></script>
<script src="{{ asset('/static/admin/js/morris-chart/raphael-min.js') }}"></script>

<!--日历-->
{{--<script src="{{ asset('/static/admin/js/calendar/clndr.js') }}"></script>--}}
{{--<script src="{{ asset('/static/admin/js/calendar/evnt.calendar.init.js') }}"></script>--}}
{{--<script src="{{ asset('/static/admin/js/calendar/moment-2.2.1.js') }}"></script>--}}
{{--<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>--}}

<!--common scripts for all pages-->
<script src="{{ asset('/static/admin/js/scripts.js') }}"></script>
<script src="{{ asset('/static/admin/js/layer.js') }}"></script>

<!--Dashboard Charts-->
<script src="{{ asset('/static/admin/js/dashboard-chart-init.js') }}"></script>

<!--启用按钮-->
<script src="{{ asset('/static/admin/js/ios-switch/switchery.js') }}" ></script>
<script src="{{ asset('/static/admin/js/ios-switch/ios-init.js') }}" ></script>

<!--单选、多选框美化-->
<script src="{{ asset('/static/admin/js/iCheck/jquery.icheck.js') }}"></script>
<script src="{{ asset('/static/admin/js/icheck-init.js') }}"></script>

<script>
    $(document).bind("keydown", function(e) {//文档绑定键盘按下事件
        e = window.event || e;//解决浏览器兼容的问题
        if(e.keyCode == 116) {//F5按下
            e.keyCode = 0;
            location.reload();
            return false;
        }
    });
</script>
@yield('js')
</body>
</html>
