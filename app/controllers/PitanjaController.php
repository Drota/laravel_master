<?php

class PitanjaController extends \BaseController {

    public function getNew() {
        return View::make('po.ask')
                ->with('title', 'Novo pitanje');
    }
    
    public function postNew() {
        $validation = Validator::make(Input::all(),
                Question::$add_rules);
        
        if($validation->passes()) {
            $create = Question::create(array(
                'userID'=>Sentry::getUser()->id,
                'title'=>Input::get('title'),
                'question'=>Input::get('question')
            ));
            $insert_id = $create->id;
            $question = Question::find($insert_id);
            
            if(Str::length(Input::get('tags'))) {
                $tags_array = explode(',', Input::get('tags'));
                if(count($tags_array)) {
                    foreach ($tags_array as $tag) {
                        $tag = trim($tag);
                        if(Str::length(Str::slug($tag))) {
                            $tag_friendly = Str::slug($tag);
                            $tag_check = Tag::where('tagFriendly',
                                    $tag_friendly);
                            if($tag_check->count()==0) {
                                $tag_info = Tag::create(array(
                                    'tag'=>$tag,
                                    'tagFriendly'=>$tag_friendly
                                ));
                            }else{
                                $tag_info = $tag_check->first();
                            }
                        }
                        $question->tags()->attach($tag_info->id);
                    }
                }
            }
            return Redirect::route('ask')
              ->with('success', 'Vase pitanje je uspesno kreirano!'.HTML::linkRoute('question_details',
                            'Kliknite ovde da vidite svoje pitanje' ,
                            array('id'=>$insert_id, 'title'=>Str::slug($question->title))));
        }else{
            return Redirect::route('ask')
                ->withInput()
                ->with('error', $validation->errors()->first());
        }                   
    }
    
    public function getVote($direction,$id) {
        if(Request::ajax()) {
            $question = Question::find($id);
            if($question) {
                if($direction == 'up') {
                    $newVote = $question->votes+1;
                }else{
                    $newVote = $question->votes-1;
                }
            
                $update = $question->update(array(
                    'votes'=> $newVote
                ));
                return $newVote;
            }else{
                Response::make("Greska", 400);
            }
        }else{
            return Redirect::route('index');
        }
    }
    
    public function getDetails($id, $title) {
        $question = Question::with('users','tags','answers')->find($id);
        if($question) {
            $question->update(array(
                'viewed'=>$question->viewed+1));
            
            return View::make('po.details')
                    ->with('title', $question->title)
                    ->with('question' ,$question);
        }else{
            return Redirect::route('index')
                    ->with('error','Pitanje nije nadjeno');
        }
    }
    
    public function getDelete($id) {
        $question = Question::find($id);
        if($question) {
            Question::delete();
        return Redirect::route('index')
            ->with('success','Pitanje je uspesno obrisano!');
        }else{
            return Redirect::route('index')
            ->with('error','Nema pitanja za brisanje!');
        }
    }
    
    public function getTaggedWith($tag) {
        $tag = Tag::where('tagFriendly', $tag)->first();
        
        if($tag) {
            return View::make('po.index')
            ->with('title', 'Pitanja tagovana sa: '.$tag->tag)
            ->with('questions', $tag->questions() 
            ->with('users', 'tags', 'answers')->paginate(2));
        }else{
            return Redirect::route('index')
            ->with('error', 'Tag nije pronadjen');
        }
    }

}
