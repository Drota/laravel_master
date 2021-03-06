<?php

class Answer extends Eloquent {
    
    protected $fillable = array('questionID', 'userID', 
        'answer', 'correct', 'votes');
    
    public function users() {
        return $this->belogsTo('User', 'userID');
    }
    
    public function questions() {
        return $this->belongsTo('Question', 'questionID');
    }
    
    public static $add_rules = array(
        'answer' => 'required|min:10'
    );
    
    
}