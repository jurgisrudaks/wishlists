<?php

class WishesController extends \BaseController {

	public function __construct() {
		parent::__construct();
		// Pirms veicam kadas darbiba parbaudam vai lietotajs ir piesledzies
        $this->beforeFilter('auth');
    }

    // Attelojam velju izveidosanas formu
	public function create($wishlistId)
	{
		return View::make('wishes.create', array('wishlistId' => $wishlistId));
	}

	// Attelojam veljum redigesanas formu
	public function edit($id)
	{
		$wish = Wish::find($id);
		return View::make('wishes.edit', compact('wish'));
	}

	// Velju izveidosana
	public function store()
	{
		// iegustam lietotaja ievaditos datus
		$input = array(
			'title' => Input::get('title'),
			'description' => Input::get('description'),
			'link' => Input::get('link'),
			'wishlist_id' => Input::get('wishlistId'),
			'user_id' => Sentry::getUser()->id
		);
		
		// validejam ievaditos datus
		$validator = Validator::make($input, Wish::$rules);
		// ja validejot datus rodas kludas
		if ( $validator->fails() )
		{
			// un pieprasijums ir AJAX vaicajums
			if(Request::ajax())
			{
				// Atgriezam kludas izmantojot AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// ja peiprasijums nav AJAX vaicajums atgriezam kludas parastaja veida
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
			// Izveidojam velmi un pazinojam lietotajam ka viss kartiba
			Wish::create($input);
			Session::flash('message', 'Vēlme veiksmīgi pievienota!'); 
			return Response::json(['success' => true], 200);
		}
	}

	// Velmju redigesana
	public function update($id)
	{
		// Atrodam velmi pec tas id
		$wish = Wish::findOrFail($id);
		// Ja lietotajs izvelejies mainit velmes bildi
		if (Input::hasFile('wishImage')) {
			// dabujam failu
			$input = array(
				'image' => Input::file('wishImage')
			);
		} else {
		// ja lietotajs izvelejies rediget velmes pamatinformaciju
			// savacam ievaditos datus
			$input = array(
				'title' => Input::get('title'),
				'description' => Input::get('description'),
				'link' => Input::get('link'),
				'wishlist_id' => Input::get('wishlistId'),
				'user_id' => Sentry::getUser()->id
			);
		}
		
		// Validejam ievaditos datus
		$validator = Validator::make($input, Wish::$rules);		
		if ( $validator->fails() )
		{
			// ja pieprasijums ir AJAX vaicajums
			if(Request::ajax())
			{
				// Atgriezam kludas ar AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// Ja pieprasijums nav ajax vaicajums atgriezam kludas parastaja veida
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
		// Ja validacija veiksmiga
			// Un lietotajs izvelejies mainit velmes attelu
			if (Input::hasFile('wishImage')) {
				// Iegustam lietotaja datus
				$user = Sentry::getUser();
				// Ja velmes attels jau pastav
				if($wish->image) {
					// Nodzesam veco velmes attelu
					File::deleteDirectory(public_path() . '/upedads/users' . $user->id . '/wishlists/' . $wish->wishlist_id . '/wishes/' . $wish->id, true);
				}
				// Ieladejam jauno velmes attelu un saglabajam
				$wish->image = Image::upload(Input::file('wishImage'), 'users/' . $user->id . '/wishlists/' . $wish->wishlist_id . '/wishes/' . $wish->id . '/', true);
	            $wish->save();
	            Session::flash('message', 'Attēls veiksmīgi nomainīts!'); 
				return Response::json(['success' => true], 200);
			} else {
			// Ja lietotajs izvelejies mainit velmes pamatinformaciju
				// Atjaunojam velmes informaciju
				$wish->update($input);
				Session::flash('message', 'Vēlme veiksmīgi rediģēta!'); 
				return Response::json(['success' => true], 200);
			}
		}
	}

	// Velmes dzesana
	public function destroy($id)
	{
		// Ja pieprasijums ir AJAX vaicajums
		if(Request::ajax())
		{
			// Dzesam velmi un atgriezam ka viss kartiba AJAX formata
			Wish::destroy($id);
			return Response::json(['success' => true]);
		} else {
			// ja pieprasijums nav ajax dat vienkarsi dzesam velmi un parladejam lapu
			Wish::destroy($id);
			return Redirect::reload();
		}
	}

	// Attelojam velmes attela mainas formu
	public function changeImage($wishId) {
		return View::make('wishes.changeImage', compact('wishId'));
	}

}