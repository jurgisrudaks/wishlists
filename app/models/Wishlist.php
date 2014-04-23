<?php

class Wishlist extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'sometimes|required|min:4',
		'description' => 'sometimes|required|min:4',
	];

	public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

	// Don't forget to fill this array
	protected $fillable = ['title','description','image', 'user_id', 'slug'];

	public function author() {
		return $this->belongsTo('User');
	}

	public function wishes()
	{
	    return $this->hasMany('Wish');
	}
}