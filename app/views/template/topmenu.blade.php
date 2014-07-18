@if(Session::has('topError'))
<div class="centerfix" id="infobar">
    <div class="centercontent">{{Session::get('topError')}}    
    </div>
</div>
@endif
@if(!Sentry::check())
<div class="centerfix" id="login">
    <div class="centercontent">
        {{Form::open(array('route'=>'login_post'))}}
        {{Form::email('email', Input::old('email'), 
                    array('placeholder'=>'Password'))}}
        {{Form::submit('Log in!')}}
        {{Form::close()}}
        {{HTML::link('signup_form', 'Register', array(), 
            array('class'=>'wybutton'))}}
    </div>
</div>
@else
<div class="centerfix" id="login">
    <div class="centercontent">
        <div id="userblock">Hello again,
            {{HTML::link('#',Sentry::getUser()->first_name. '
                        ' .Sentry::getUser()->last_name)}}
        </div>
            {{HTML::linkRoute('logout', 'Logout', array(), 
                array('class'=>'wybutton'))}}
    </div>
</div>
@endif