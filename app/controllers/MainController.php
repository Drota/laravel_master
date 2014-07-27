<?php

class MainController extends \BaseController {
    public function getIndex(){
        return View::make('po.index')
            ->with('title', 'Aktuelna pitanja')
            ->with('questions', Question::with('users','tags','answers')-> 
                orderBy('id','desc')->paginate(2));
    }


}
