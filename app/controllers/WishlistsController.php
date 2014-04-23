<?php

class WishlistsController extends BaseController {

	// Mainigais, kas uzglaba informaciju vai lietotajs ir piesledzies vai ne
	public $loggedIn = false;
	
	public function __construct() {
		parent::__construct();
		// parbaudam vai lietotajs ir piesledzies izpildot visas darbibas iznemot velmju attelosanas darbibas
        $this->beforeFilter('auth', array('except'=>array('index', 'show')));
    }

    // Velmju sarakstu attelosana
	public function index($slug)
	{
		// ja lietotajs piesledzies
		if (Sentry::check())
		{
			// iegustam ta datus
			$user = Sentry::getUser();
			// noradam ka lietotajs ir piesledzies
			$this->loggedIn = true;
			$loggedIn = $this->loggedIn;
		}
		// uzstadam, ka lietotajs nav piesledzies
		$loggedIn = $this->loggedIn;
		// iegustam attelojama profila informaciju un atgriezam skatu
		$profile = User::with('wishlists')->whereSlug($slug)->get()->first();
		return View::make('wishlists.index',compact('profile','user','loggedIn'));
	}

	// attelojam velmes izveides formu
	public function create()
	{
		return View::make('wishlists.create');
	}

	// izveidojam jaunu velmju sarakstu
	public function store()
	{
		// iegustam lietotaja datus
		$user = Sentry::getUser();
		// iegustam ievaditos datus
		$input = array(
			'title' => Input::get('title'),
			'description' => Input::get('description'),
			'user_id' => $user->id
		);

		// validejam ievaditos datus
		$validator = Validator::make($input, Wishlist::$rules);		
		if ( $validator->fails() )
		{
			// ja peiprasijums ir ajax vaicajums
			if(Request::ajax())
			{
				// atgriezam kludas ajax formata
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// ja pieprasijums nav ajax vaicajums atgriezam kludas parastaja metode
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
		// ja validacija izdevusies
			// izveidojas velmju sarakstu un atgriezam pazinojumus
			Wishlist::create($input);
			Session::flash('message', 'Saraksts veiksmīgi izveidots!'); 
			return Response::json(['success' => true], 200);
		}
	}

	// velmju sarakstu attelosana
	public function show($slug, $wishlistSlug)
	{
		// ja lietotajs piesledzies
		if (Sentry::check())
		{
			// iegustam ta datus un nordadam ka lietotajs ir piesledzies
			$user = Sentry::getUser();
			$this->loggedIn = true;
			$loggedIn = $this->loggedIn;
		}
		// noradam ka lietotajs nav piesledzies
		$loggedIn = $this->loggedIn;
		// Iegustam attelojamo velmju sarakstu ipasnieka profila datus
		$profile = User::whereSlug($slug)->get()->first();
		// izveidojam un atgriezam skatu velmju sarakstu attelosanai
		$wishlist = Wishlist::with('wishes')->whereSlug($wishlistSlug)->get()->first();
		return View::make('wishlists.show',compact('wishlist','profile','user','loggedIn'));
	}

	// attelojam velmju sarakstu redigesanas formu
	public function edit($id)
	{
		$wishlist = Wishlist::find($id);
		return View::make('wishlists.edit', compact('wishlist'));
	}

	// velmju sarakstu redigesana
	public function update($id)
	{
		// atrodam sarakstu pec ta id
		$wishlist = Wishlist::findOrFail($id);
		// ja lietotajs izvelejies rediget saraksta attelu
		if (Input::hasFile('wishlistImage')) {
			// iegustam failu
			$input = array(
				'image' => Input::file('wishlistImage')
			);
		} else {
		// ja lietotajs maina saraksta pamatinformaciju
			// iegustam ievaditos datus
			$input = array(
				'title' => Input::get('title'),
				'description' => Input::get('description'),
			);
		}
		
		// validejam datus
		$validator = Validator::make($input, Wishlist::$rules);
		if ( $validator->fails() )
		{
			// ja peiprasijums ir ajax vaicajums
			if(Request::ajax())
			{
				// atgriezam kludas ajax formata
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// ja nav ajax vaicajums atgriezam kludas ierastaja maniere
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
		// ja validacija veiksmiga
			// un lietotajs izvelejies mainit saraksta attelu
			if (Input::hasFile('wishlistImage')) {
				// iegustam lietotaja datus
				$user = Sentry::getUser();
				// ja velmju sarakstam jau ir attels
				if($wishlist->image) {
					// dzesam veco attelu
					File::deleteDirectory(public_path() . '/uploads/users/' . $user->id . '/wishlists/' . $wishlist->id, true);
				}
				// un pievienojam jauno attelu
				$wishlist->image = Image::upload(Input::file('wishlistImage'), 'users/' . $user->id . '/wishlists/' . $wishlist->id . '/', true);
	            $wishlist->save();
	            // saglabajam visu un pazinojam ka viss noritejis veiksmigi
	            Session::flash('message', 'Attēls veiksmīgi nomainīts!'); 
				return Response::json(['success' => true], 200);
			} else {
			// ja lietotajs izvelejies rediget saraksta pamatinformaciju
				// Saglabajam jauno informacju un pazinojam ka viss akrtiba
				$wishlist->update($input);
				Session::flash('message', 'Saraksts veiksmīgi rediģēts!');
				return Response::json(['success' => true], 200);
			}
			// Ja redigejot rodas kada nezinama kluda pazinot par to 
			return Response::json(['success' => false,'errors' => ['wishlist' => ['Radās kļuda. Mēģiniet vēlreiz.']], 400]);
		}
	}

	// saraksta dzesana
	public function destroy($id)
	{
		// atrodam lietotaja id
		$userId = Sentry::getUser()->id;
		// ja pieprasijums ir ajax vaicajums
		if(Request::ajax())
		{
			// izdzesam visus failus, kas saistiti ar so sarakstu
			File::deleteDirectory(public_path() . '/uploads/users/' . $userId . '/wishlists/' . $id);
			// izdzesam visas velmes, kas saistitas ar so sarakstu
			Wish::where('wishlist_id', $id)->delete();
			// izdzesam sarakstu
			Wishlist::destroy($id);
			// atgriezam ajax formata ka viss kartiba
			return Response::json(['success' => true]);
		} else {
		// ja pieprasijums nav ajax vaicajums
			// izdzesam visus failus, kas saistiti ar so sarakstu
			File::deleteDirectory(public_path() . '/uploads/users/' . $userId . '/wishlists/' . $id);
			// izdzesam visas velmes, kas saistitas ar so sarakstu
			Wish::where('wishlist_id', $id)->delete();
			// izdzesam sarakstu
			Wishlist::destroy($id);
			// parladejam lapu
			return Redirect::reload();
		}
	}

	// attelojam saraksta attela mainas formu
	public function changeImage($wishlistId) {
		return View::make('wishlists.changeImage', compact('wishlistId'));
	}

}