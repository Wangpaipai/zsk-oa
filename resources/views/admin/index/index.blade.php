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




  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="{{ asset('/static/admin/js/html5shiv.js') }}"></script>
  <script src="{{ asset('/static/admin/js/respond.min.js') }}"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="{{ route('admin.index.main') }}" target="myIframe"><img src="{{ asset('/static/admin/images/logo.png') }}" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="{{ route('admin.index.main') }}" target="myIframe"><img src="{{ asset('/static/admin/images/logo_icon.png') }}" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">
            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active index-page"><a href="{{ route('admin.index.main') }}" target="myIframe"><i class="fa fa-home"></i> <span>首页</span></a></li>
                @foreach($admin_menu as $value)
                    <li class="menu-list"><a href="javascript:;"><i class="{{ $value->icon }}"></i> <span>{{ $value->name }}</span></a>
                        <ul class="sub-menu-list">
                            @foreach($value->child as $item)
                                <li><a href="{{ route($item->route) }}" target="myIframe"> {{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->

    <!-- header section start-->
    <div class="header-section">

        <!--toggle button start-->
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <!--toggle button end-->

        <!--notification menu start -->
        <div class="menu-right">
            <ul class="notification-menu">
                <li>
                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('/static/admin/images/photos/user-avatar.png') }}" alt="" />
                        {{ $admin_user->realname }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        <li><a href="{{ route('admin.data.update') }}" target="myIframe"><i class="fa fa-cog"></i>  修改资料</a></li>
                        <li><a href="{{ route('admin.login.out') }}"><i class="fa fa-sign-out"></i> 退出登录</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!--notification menu end -->

    </div>
    <!-- header section end-->

    <!-- main content start-->
    <div class="main-content" style="background: #eff0f4">
        <iframe frameborder="0" id="myIframe" name="myIframe" height="100%" width="100%" src="{{ route('admin.index.main') }}">
        </iframe>
    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ asset('/static/admin/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/jquery.nicescroll.js') }}"></script>

<!--common scripts for all pages-->
<script src="{{ asset('/static/admin/js/scripts.js') }}"></script>

<script>
    var height = $(window).height();
    $('.main-content').css('min-height',height + 'px').css('height',height + 'px');
    var frameHeight = height - 60;
    $('#myIframe').css('min-height',frameHeight + 'px').css('height',frameHeight + 'px');

    $('.index-page').click(function(){
        $(this).addClass('active');
        $('.menu-list').removeClass('nav-active');
    });
    $('.sub-menu-list li').click(function(){
        $('.index-page').removeClass('active');
        $('.sub-menu-list li').removeClass('active');
        $(this).addClass('active');
    })
</script>

</body>
</html>
