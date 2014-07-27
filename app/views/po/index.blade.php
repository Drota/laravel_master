@extends('template_masterpage')

@section('content')
<h1>{{$title}}</h1>
    @if(count($questions))
        @foreach($questions as $question)
        <?php
            $ascer = $question->users;
            $tags = $question->tags;
        ?>
        <div class="qwrap questions">
            @if(Sentry::check())
            <div class="arrowbox">
                {{HTML::linkRoute('vote','',array('up',
                $question->id), array('class'=>'like',
                'title'=>'Upvote'))}}
                {{HTML::linkRoute('vote','',array('down',
                $question->id),array('class'=>'dislike',
                'title'=>'Downvote'))}}
            </div>
            @endif
        
            @if($question->votes > 0)
                <div class="cntbox cntgreen">
            @elseif($question->votes == 0)
                <div class="cntbox">
            @else 
                <div class="cntbox cntred">
            @endif
            <div class="cntcount">{{$question->votes}}</div>
            <div class="cnttext">vote</div>
                        </div>
            <?php
            $answers = $question->answers;
            $accepted = false;
            if($question->answers!=null) {
                foreach ($answers as $answer) {
                    if($answer->correct==1){
                    $accepted=true;
                    break;
                    }
                }
            }
            ?>
            @if($accepted)
            <div class="cntbox cntgreen">
                @else
                <div class="cntbox cntred">
                @endif
                <div class="cntcount">{{count($answers)}}</div>
                <div class="cnttext">odgovor</div>
            </div>
            
            <div class="cntbox">
                <div class="cntcount">0</div>
                <div class="cnttext">answer</div>
            </div>
            <div class="qtext">
                <div class="qhead">
                    {{HTML::linkRoute('question_details', 
                    $question->title, array($question->id,
                    Str::slug($question->title)))}}                             
                </div>
                    <div class="qinfo">Pitan od <a href="#">
                    {{$asker->first_name.' '.$asker->lastname}}</a>
                    oko {{date('d/m/Y H:i:s', 
                        strtotime($question->created_at))}}
                    </div>
            @if($tags!=null)
            <ul class="qtagul">
                @foreach($tags as $tag)
                <li>{{HTML::linkRoute('tagged', $tag->tag,
                    $tag->tagFriendly)}}</li>
                @endforeach
            </ul>
            @endif
                    </div>
                </div>
            @endforeach
            {{$question->links()}}
        @else
        Nema pronadjenih pitanja {{HTML::linkRoute('ask',
            'Postavi pitanje?')}}
        @endif   
       {{-- </div> --}}
@stop