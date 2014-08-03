@extends('template_masterpage')

@section('content')
<h1 id="rplyh">Postavi pitanje</h1>
<p class="bluey">obavestenje: Ako mislite da je na vase pitanje
tacno odgovoreno, molimo vas ne zaboravite da kliknete na ikonicu " "
da se odgovor oznaci kao "tacan/ispravan"</p>
{{Form::open(array('route'=>'ask_post'))}}
<p class="minihead">Naslov pitanja:</p>
{{Form::text('title', Input::old('title'), array('class'=>
            'fillinput'))}}
<p class="minihead">Definisi tvoje pitanje:</p>
{{Form::textarea('question', Input::old('question'), array('class'=>
            'fillinput'))}}    
<p class="minihead">Tagovi: Koristite zareze da odvojite tagove
 (tag1, tag2 ...). Da biste spojili dve reci u tagu koristite - izmedju
 reci (tag-ime, tag-ime-2...):</p>
{{Form::text('tags',Input::old('tags'), array('class'=>
            'fillinput'))}}
<p></p>
{{Form::submit('Postavi to pitanje')}}
{{Form::close()}}
@stop

@section('footer_assets')
<script type='text/javascript'>
$('input[name='tags']').keyup(function(){
    $(this).val($(this)).val().toLowerCase());
});</script>

@stop
