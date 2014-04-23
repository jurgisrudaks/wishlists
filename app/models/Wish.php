<?php

class Wish extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'title' => 'sometimes|required',
		'description' => 'sometimes|required',
		'link' => 'url',
	];

	// Don't forget to fill this array
	protected $fillable = ['title','description','link','image','user_id','wishlist_id'];

	public function wishlist()
	{
	    return $this->belongsTo('Wishlist', 'wishlist_id');
	}

	public function author()
	{
	    return $this->belongsTo('User', 'user_id');
	}
}