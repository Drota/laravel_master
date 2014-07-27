@extends('template_masterpage')

@section('content')
{{--Glasanje i boje--}}
<h1 id="replyh">{{$question->title}}</h1>
<div class="qwrap questions">
    <div id="rcount">Pogledano {{$question->viewed}}
    time{{$question->viewed>0?'s':''}}.</div>
    @if(Sentry::check())
    <div class="arrowbox">
        {{HTML::linkRoute('vote',''array('up',$question->id)
            ,array('class'=>'like', 'title'=>'Upvote'))}}
        {{HTML::linkRoute('vote','',array('down',
            $question->id),array('class'=>'dislike','title'=>
            'Downvote'))}}
    </div>
    @endif
    
    @if($question->votes > 0)
    <div class="cntbox cntgreeen">
    @elseif($question->votes == 0)
    <div class="cntbox">
    @else
    <div class="cntbox cntred">
    @endif
    <div class="cntcount">{{$question->votes}}</div>
    <div class="cnttext">vote</div>
    </div>
    <div class="rblock">
        <p>{{n12br($question->question)}}</p>
    </div>
         <div class="qinfo">Pitanje od <a href="#">
        {{$question->users->first_name.' '.$question->
        users->last_name}}</a> oko {{date('d/m/Y \n\
        H:i:s' ,strtotime($question->created_at))}}</div>
    @if($question->tags!=null)
    <ul class="gtagul">
        @foreach($question->tags as $tag)
        <li>{{HTML::linkRoute('tagged', $tag->tag, 
            $tag->tagFriendly)}}</li>
        @endforeach
    </ul>
    @endif
    
    {{--ako je admin ulogovan imacemo dugmice za 
        odgovore i brisanje--}}
    @if(Sentry::check())
    <div class="qwrap">
        <ul class="fastbar">
            @if(Sentry::getUser()->hasAccess('admin'))
            <li class="close">{{HTML::linkRoute(
                'delete_question', 'delete', $question->id)}}
            </li>
            @endif
            <li class="answer"><a href="#">odgovor</a></li>
        </ul>
    </div>
    @endif
    </div>
    <div id="rreplycount">{{count($question->answers)}}odgovori</div>
    
    {{--ako je korisnik ulogovan imacemo blok za odgovore--}}
    @if(Sentry::check())
    <div class="rrepol" id="replyarea" style="margin-bottom:10px">
        {{Form::open(array('route'=>array(
        'question_reply', $question->id, 
        Str::slug($question->title))))}}
        <p class="minihead">Napisi svoj odgovor:</p>
        {{Form::textarea('answer', Input::old('answer'),
            array('class'=>'fullinput'))}}
        {{Form::submit('Zavrsi odgovor!')}}
        {{Form::close()}}
    </div>
    @endif
    @if(count($question->answers))
        @foreach($question->answers as $answer)
            @if ($answer->correct==1)
            <div class="rrepol correct">
            @else
            <div class="rrepol">
            @endif
        @if(Sentry::check())
        <div class="arrowbox">
            {{HTML::linkRoute('vote_answer','',
                array('up', $answer->id), array('class'=>
                'like', 'title'=>Upvote))}}
            {{HTML::linkRoute('vote_answer','',
                array('down', $answer->id), array('class'=>
                'dislike', 'title'=>'Downvote'))}}
        </div>
        @endif
        <div class="cntbox">
            <div class="cntcount">{{$answer->votes}}</div>
            <div class="cntext">Glasanje</div>
        </div>
    @if(@answer->correct==1)
    <div class="bestanswer">Najbolji odgovor</div>
    @else
        {{--ako je ulogovan admin ili vlasnik pitanja, pokazi
            dugme za najbolji odgovor--}}
        @if(Sentry::check())
            @if(Sentry::getUser()->hasAccess('admin') ||
                Sentry::getUser()->id == $question->userID)
                <a class="chooseme" href="{{URL::route
                    ('choose_answer', $answer->id)}}">
                    <div class="choosebestanswer">choose</div></a>
            @endif
        @endif
    @endif
    <div class="rblock">
        <div class="rbox">
            <p>{{n12br($answer->answer)}}</p>
        </div>
        <div class="rrepolinf">
            <p>Odgovor od <a href="#">{{$answer->
                users->first_name.' '.$answer->users->
                last_name}}</a> oko {{datum('d/m/Y/ H:i:s',
                strtotime($answer->created_at))}}</p>
            
            {{--odgovor mogu obrisati samo admini i vlasnik o.--}}
            @if(Sentry::check())
            <div class="qwrap">
                <ul class="fastbar">
                    @if(Sentry::getUser()->hasAccess('admin')||
                    Sentry::getUser()->id == @answer->userID)
                    <li class="close">{{HTML::linkRoute(
                    'delete_answer', 'delete', $answer->id)}}</li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
    </div>
    </div>
    @endforeach
    @endif
            </div>
            
    </div>
    @stop
    
    @Section('footer_assets')
    {{--Ako je korisnik, sakrij i prikazi odgovore--}}
    @if(Sentry::check())
    <script type="text/javascript">
        var replyarea = $('div#replyarea');
        $replyarea.hide();
        $('li.answer a').click(function(e){
            e.preventDefault();
            if($replyarea.is(':hidden')){
                $replyarea.fadeIn('fast');
            }else{
                $replyarea.fadeOut('fast');
            }
        });
    </script>
    @endif
    
    {{--Ako je admin ulogovan, napravi potvrdu
        za brisanje--}}
    @if(Sentry::check())
        @if(Sentry::getUser()->hasAccess('admin'))
        <script type="text/javascript">
        $('li.close a').click(function(){
            return confirm('Da li ste sigurni da zelite\n\
            da izbrisete?');
        });
        </script>
        @endif
    @endif
    
    {{--za admine i vlasnike pitanja--}}
    @if(Sentry::check())
        @if(Sentry::getUser()->hasAccess('admin') ||
        Sentry::getUser()->id == $question->userID)
        <script type="text/javascript">
            $('a.chooseme').click(function(){
                return confirm('Da li ste sigurni da \n\
                zelite da odaberete ovaj odgovor kao najbolji?');
            });
        </script>
        @endif
    @endif
            
</div>
@stop
            
        
