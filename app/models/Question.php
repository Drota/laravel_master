<?php

class Question extends Eloquent {
    
    protected $fillable = array('title', 'userID', 'question', 
        'viewed', 'answered', 'votes');
    
    public function users() {
        return $this->belongsTo('User', 'userID');
    }
    
    public function tags() {
        return $this->belongsToMany('Tag', 'question_tags');
                           
    }
    
    public function answers() {
        return $this->hasMany('Answer', 'questionID');
    }
    
    public static $add_rules = array(
        'title'=>'required|min:5',
        'question'=>'required|min:10'
    );
}