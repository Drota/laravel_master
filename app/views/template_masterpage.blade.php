<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>{{isset($title)?$title.' | ':''}} LARAVEL Q & A</title>
    {{HTML::style('css/style.css')}}
</head>
<body>
    @include('template.topmenu')   
    <div class="centerfix" id="header">
        <div class="centercontent">
            <a href="{{URL::route('index')}}">
                {{HTML::image('img/header/logo.png')}}
            </a>
        </div>
    </div>
    <div class="centerfix" id="main" role="main">
        <div class="centercontent clearfix">
            <div id="contentblock">
                @if(Session::has('error'))
                <div class="warningx wredy">
                    {{Session::get('error')}}
                </div>
                @endif
                @if(Session::has('success'))
                <div class="warningx wgreeeny">
                    {{Session::get('success')}}
                </div>
                @endif
                @yield('content')
            </div>
        </div>   
    </div>
    {{HTML::script('js/libs.js')}}
    {{HTML::script('js/plugins.js')}}
    {{HTML::script('js/script.js')}}
    @yield('footer_assets')
</body>
</html>