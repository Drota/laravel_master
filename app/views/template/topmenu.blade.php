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
                    array('placeholder'=>'E-mail adresa'))}}
        {{Form::password('password', 
                    array('placeholder'=>'lozinka'))}}
        {{Form::submit('Uloguj se!')}}
        {{Form::close()}}
        {{HTML::linkRoute('signup_form', 'Registruj se', array(), 
            array('class'=>'wybutton'))}}
    </div>
</div>
@else
<div class="centerfix" id="login">
    <div class="centercontent">
        <div id="userblock">Zdravo,
            {{HTML::link('#',Sentry::getUser()->first_name. '
                        ' .Sentry::getUser()->last_name)}}
        </div>
            {{HTML::linkRoute('logout', 'Izloguj se', array(), 
                array('class'=>'wybutton'))}}
            {{HTML::linkRoute('ask', 'Postavi pitanje!', array(),
                array('class'=>'wybutton'))}}
    </div>
</div>
@endif