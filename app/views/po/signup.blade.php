@extends('template_masterpage')

@section('content')
    <h1 id="replyh">Uloguj se</h1>
    <p class="bluey">Molim vas, popunite ispravno polja da bi ste
se uspesno registrovali</p>

{{Form::open(array('route'=>'signup_form_post'))}}
    <p class="minihead">Ime:</p>
{{Form::text('first_name', Input::get('first_name'),
            array('class'=>'fullinput'))}}
    <p class="minihead">Prezime:</p>
{{Form::text('last_name', Input::get('last_name'),
    array('class'=>'fullinput'))}}
    <p class="minihead">E-mail adresa</p>
{{Form::email('email', Input::get('email'),
            array('class'=>'fullinput'))}}
    <p class="minihead">lozinka:</p>
{{Form::password('password','',
    array('class'=>'fullinput'))}}
    <p class="minihead">provera lozinke</p>
{{Form::password('re_password','',
    array('class'=>'fullinput'))}}
    <p class="minihead">Your personal info will not be 
    shared with any 3rd party companies</p>
{{Form::submit('Registruj se')}}
{{Form::close()}}
@stop