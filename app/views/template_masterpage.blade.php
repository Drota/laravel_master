<!DOCTYPE html>
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
                {{HTML::image('img/logo.png')}}
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
    {{HTML::script('http://code.jquery.com/jquery-2.1.1.min.js')}}
    {{HTML::script('js/script.js')}}
    @yield('footer_assets')
    @if(Sentry::check() && (Route::currentRouteName() ==
    'index' || Route::currentRouteName() == 'tagged' || 
    Route::currentRouteName() == 'question_details'))
    <script type="text/javascript">
        $('.questions .arrowbox .like, .questions . arrowbox\n\
        .dislike').click(function(e){
        e.preventDefault();
        var $this = $(this);
        $.get($(this).attr('href'),function($data){
            $this.parent('.arrowbox').next('.cntbox').find
            ('.cntcount').text($data);
        }).fail(function(){
            alert('Pojavila se greska, pokusajte ponovo');
            });
        });
    </script>
    @endif
</body>
</html>