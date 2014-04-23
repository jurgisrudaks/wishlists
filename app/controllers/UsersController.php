<?php

class UsersController extends BaseController {
	
	public $loggedIn = false;

	public function __construct() {
		// Ieklaujam CSRF filtru no BaseController
		parent::__construct();
		// Pieprasam autentifikaciju
        $this->beforeFilter('auth', array('except'=>array('store','register', 'resetPassword','requestPasswordReset','showPasswordReset','activateUser')));
    }

    // Jaunu lietotaju registracija
	public function store()
	{
		// Iegustam lietotaja ievaditos datus
		$input = array(
			'first_name' => Input::get('first_name'),
			'last_name' => Input::get('last_name'),
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
		);

		// Izveidojam jaunu validatoru
		$validator = Validator::make($input, User::$rules);	
		// Ja rodas validacijas kludas	
		if ( $validator->fails() )
		{
			// Ja vaicajums ir AJAX
			if(Request::ajax())
			{
				// Atgriezam lietotajam kludas izmantojot AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// Ja vaicajums nav AJAX atgriezam vienkarsi kludas
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
			// Validacija veiksmiga
			try
			{
				// Registrejam lietotaju ar ievaditajiem lietotaja datiem
				$user = Sentry::register(array(
					'first_name' => Input::get('first_name'),
					'last_name' => Input::get('last_name'),
					'email' => Input::get('email'),
					'password' => Input::get('password'),
				));

				// Iegustam lietotaja aktivizacijas kodu
			    $activationCode = $user->getActivationCode();

			    // Nosutam lietotajam e-pastu ar aktivizacijas noradijumiem
			    Mail::queue('emails.user.activation', array('activationCode' => $activationCode), function($message) use ($user)
				{
					$message->from( 'jurgis.rudaks@gmail.com', 'es.velos' );
				    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Lietotāja aktivizācija');
				});
			} catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
				// E-pasts netika noradits
				return Response::json(['success' => false,'errors' => ['register' => ['Netika norādīta e-pasta adrese']], 400]);
			} catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
				// Parole netika noradita
				return Response::json(['success' => false,'errors' => ['register' => ['Netika norādīta parole']], 400]);
			} catch (Cartalyst\Sentry\Users\UserExistsException $e) {
				// Lietotajs ar sadu e-pastu jau eksiste
				return Response::json(['success' => false,'errors' => ['register' => ['Lietotājs ar šādu epastu jau eksistē']], 400]);
			}
			// Atrodam lietotaju pec ta aktivizacijas koda
			$user = Sentry::findUserByActivationCode($activationCode);
			// Pievienojai grupai ar id 1 ('Users')
			$user->addGroup(Sentry::findGroupById(1));
			// Izveidojam unikalo lietotaja profila saiti
			$user = User::find($user->id);
			Sluggable::make($user, true);
			// Saglabajam
			$user->save();
			// Atgriezam lietotajam pazinojumu ka rikoties talak
			Session::flash('message', 'Pārbaudi savu e-pastu tur atradīsi turpmākos norādījumus!'); 
			return Response::json(['success' => true], 200);
		}
	}

	// Lietotaja informacijas atjaunosana
	public function update($id)
	{
		// Atrodam lietotaju pec ID
		$user = Sentry::findUserById($id);

		// Ja lietotajs uzstadijumu sadala ir izvelejies mainit paroli
		if(Input::get('password')) {
			// Ja lietotajs ir ievadijis nepareizu pasreizejo paroli
			if(!$user->checkPassword(Input::get('old_password')))
		    {
		    	// Atgriezam kludu
		    	return Response::json(['success' => false,'errors' => ['userInfo' => ['Ievadīta nepareiza pašreizējā parole']], 400]);
		    }
		    // Iegustam lietotaja ievaditos datus
			$input = array(
				'old_password' => Input::get('old_password'),
				'password' => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation')
			);
		// Ja lietotajs izvelejies mainit profila bildi
		} elseif (Input::hasfile('profilePic')) {
			// Iegustam lietotaja ievaditos datus - bildi
			$input = array(
				'photo' => Input::file('profilePic'),
			);
		} else {
		// Ja lietotajs izvelejies mainit pamatinformaciju
			// Iegustam lietotaja ievaditos datus
			$input = array(
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'email' => Input::get('email')
			);
		}
		
		// Izveidojam jaunu validatoru
		$validator = Validator::make($input, User::$rules);
		// Ja validacija neizdodas
		if ( $validator->fails() )
		{
			// Ja peirpasijums ir AJAX vaicajums
			if(Request::ajax())
			{
				// Atgriezam kludas ar AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// Ja nav AJAX vaicajums - atgriezam kludas parastaja veida
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
		// Validacija veiksmiga
			try
			{
				// Ja lietotajs izvelejies mainit paroli
				if(Input::get('password')) {
					$changed = "Parole";
					// Iegustam lietotaja ievadito paroli
					$user->password = Input::get('password');
				// Ja lietotajs izveliejies mainit profila bildi
				} elseif (Input::hasfile('profilePic')) {
					$changed = "Profila bilde";
					// Ja lietotajam jau ir profila bilde
					if($user->photo) {
						// Dzesam vecas bildes failus
						File::deleteDirectory(public_path() . '/uploads/users/' . $user->id . '/profilePic', true);
					}
					// Ieladejam profila bildi
					$user->photo = Image::upload(Input::file('profilePic'), 'users/' . $user->id . '/profilePic/', true);
				} else {
					// Lietotajs izvelejies mainit pamatinformaciju
					$changed = "Pamatinformācija";
					// Uzstadam jaunos lietotaja datus
		    		$user->first_name = Input::get('first_name');
		    		$user->last_name = Input::get('last_name');
		    		$user->email = Input::get('email');
				}
				// Saglabajam lietotaju
	    		$user->save();
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
				// Lietotajs ar ievadito e-pasta adresi jau eksiste
				return Response::json(['success' => false,'errors' => ['userInfo' => ['Lietotājs ar šādu epastu jau eksistē']], 400]);
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				// Lietotajs netika atrasts
				return Response::json(['success' => false,'errors' => ['userInfo' => ['Lietotājs netika atrasts']], 400]);
			}
			// Darbiba izpildita veiksmigi
			Session::flash('message', $changed . ' veiksmīgi nomainīta!'); 
			return Response::json(['success' => true], 200);
		}
	}

	// Atgriezam lietotajam uzstadijumu skatu
	public function settings() {
		// Parbaudam vai ielogojies
		if (Sentry::check()) {
			// Ielogojies - uzstadam mainigos ko sutit skatam
			$this->loggedIn = true;
			$loggedIn = $this->loggedIn;
			$user = Sentry::getUser(); // Lietotajs kurs paslaik ir ielogojies
			$profile = $user;
			// Izveidojam skatu
			return View::make('users.settings', compact('profile','user','loggedIn'));
		}
		// Nav ielogojies - novirzam uz galveno lapu
		return Redirect::to('/');
	}

	// Attelojam registracijas formu/skatu
	public function register() {
		// Ja jau piesledzies
		if (Sentry::check())
		{
			// Novirzam uz profila adresi
			return Redirect::to('/' . Sentry::getUser()->slug);
		}
		// Izveidojam reigstracijas skatu
		return View::make('users.register');
	}

	// Lietotaju aktivizacija
	public function activateUser($activationCode) {
		try
		{
		    // Atrodam lietotaju pec vina aktivizacijas koda
		    $user = Sentry::findUserByActivationCode($activationCode);

		    // Meginam aktivizet lietotaju
		    if ($user->attemptActivation($activationCode))
		    {
		    	// Ja izdevas aktivizet novirzam uz pieslegsanas lapu un pazinojam ka viss kartiba
		        Session::flash('message', 'Lietotājs veiksmīgi aktivizēts!');
		        return Redirect::to('/signin');
		    }
		    else
		    {
		    	// Ja neizdevas aktivizet novirzam uz pieslegsanas lapu un pasakam, ka radas kluda
		        Session::flash('error', 'Radās kļūda aktivizējot lietotāju!');
		        return Redirect::to('/signin');
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Ja neizdevas atrast lietotaju novirzam uz pieslegsanas lapu un pazinojam par kludu
		    Session::flash('error', 'Lietotājs netika atrasts!');
		    return Redirect::to('/signin');
		}
		catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
		{
			// Ja lietotajs jau ir aktivizets novirzam uz pieslegsanas lapu un pazinojam par to
		    Session::flash('error', 'Lietotājs jau ir aktivizēts!');
		    return Redirect::to('/signin');
		}
	}

	// Attelo paroles atjaunosanas formu
	public function showPasswordReset() {
		return View::make('users.reset');
	}

	// Paroles atjaunosanas pieprasisana
	public function requestPasswordReset() {
		// Savacam  ievaditos datus
		$input = array(
			'email' => Input::get('email')
		);

		// Izveidojam jaunu validatoru
		$validator = Validator::make($input, User::$rules);
		// Ja validacija neizdodas
		if ( $validator->fails() )
		{
			// Un ja pieprasijums ir AJAX vaicajums
			if(Request::ajax())
			{
				// Atgriezam validacijas kludas ar AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// JA vaicajums nav AJAX atgriezam vienkarsi kludas
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
		// Ja validacija veiksmiga
			try
			{
				// Atrodam lietotaju pec ta e-pasta
			    $user = Sentry::findUserByLogin(Input::get('email'));
			    // iegustam ta paroles atjaunosanas kodu kodu
			    $resetCode = $user->getResetPasswordCode();
			    // Nosutam lietotajam uz e-pastu paroles atjaunosanas kodu un turpmakos noradijumus
			    Mail::queue('emails.user.reset', array('resetCode' => $resetCode,'userId' => $user->id), function($message) use ($user)
				{
					$message->from( 'jurgis.rudaks@gmail.com', 'es.velos' );
				    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Paroles maiņa');
				});
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				// Ja lietotajs netiek atrasts pazinojam par to
			    return Response::json(['success' => false,'errors' => ['userInfo' => ['Lietotājs netika atrasts']], 400]);
			}
			// Viss kartiba
			Session::flash('message', 'Ieskaties savā e-pastā - tur atradīsi tālākos norādījumus lai atgutu savu paroli!');
			return Response::json(['success' => true], 200);
		}
	}

	// Parole atjaunosana
	public function resetPassword($resetCode) {
		try
		{
			// Atrodam lietotaju pec ta paroles atjaunosanas koda
		    $user = Sentry::findUserByResetPasswordCode($resetCode);

		    // Uzgenerejam jaunu paroli
		    $newPassword = str_random(8);

		    // Parbaudam vai paroles atjaunosanas kods ir derigs
		    if ($user->checkResetPasswordCode($resetCode))
		    {
		    	// Meginam nomainit lietotaja paroli uz jauno uzhenereto
		        if ($user->attemptResetPassword($resetCode, $newPassword))
		        {
		        	// Ja viss kartiba nosutam lietotajam uz e-pastu jauno lietotaja paroli
		            Mail::queue('emails.user.newPassword', array('newPassword' => $newPassword), function($message) use ($user)
					{
						$message->from( 'jurgis.rudaks@gmail.com', 'es.velos' );
					    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Paroles maiņa');
					});
					// Pazinojam par to un novirzam uz pieslegsanas lapu
					Session::flash('message', 'Ieskaties e-pasta tur atradīsi savu jauno paroli, kad pieslēdzies nomaini to.');
					return Redirect::to('/signin');
		        }
		        else
		        {
		        	// Ja radas kluda pazinojam par to un novirzam uz pieslegsanas lapu
		        	Session::flash('error', 'Paroli neizdevas atjaunot.');
					return Redirect::to('/signin');
		        }
		    }
		    else
		    {
		    	// ja paroles atjaunosanas kods nav derigs - pazinojam un novirzam
		    	Session::flash('error', 'Paroles atjaunošanas kods nederīgs.');
		        return Redirect::to('/signin');
		    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// ja lietotajs netika atrasts - pazinojam un novrizam uz pieslegsanas lapu
			Session::flash('error', 'Lietotājs netika atrasts.');
		    return Redirect::to('/signin');
		}
	}

	// Attelojam vaka attela nomainas formu
	public function showChangeCover() {
		return View::make('users.changeCover');
	}

	// Vaka attela maina
	public function changeCover() {
		// Atrodam lietotaju
		$user = Sentry::getUser();
		// ja ievaditie dati ir bilde
		if (Input::hasFile('cover')) {
			// savacam ievaditos datus
			$input = array(
				'cover_image' => Input::file('cover')
			);
			// Izveidojam jaunu validatoru
			$validator = Validator::make($input, User::$rules);
			// ja validators atgriez kludas
			if ( $validator->fails() )
			{
				// Un pieprasijums ir AJAX vaicajums
				if(Request::ajax())
				{
					// Atgriezam kludas ar AJAX
					return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
				} else {
					// Ja nav AJAX atgriezam kludas parastaja veida
					return Redirect::back()->withInput()->withErrors($validator);
				}

			} else {
			// Ja validators neatgrieza kludas
				// lietotaja vaka attels jau eksiste
				if($user->cover_image) {
					// dzesam to
					File::deleteDirectory(public_path() . '/uploads/users/' . $user->id . '/cover', true);
				}
				// un ieladejam jauno vaka attelu
	            $user->cover_image = Image::upload(Input::file('cover'), 'users/' . $user->id . '/cover/', true);
	            $user->save();
	            // Viss kartiba - pazinojam par to
	            Session::flash('message', 'Vāka attēls veiksmīgi nomainīts!'); 
				return Response::json(['success' => true], 200);
			}
		} else {
			// ja ievaditie dati nebija fails
			Session::flash('error', 'Mainot vāka attēlu radās kļda. Mēģiniet vēlreiz!');
			return Response::json(['success' => false,'errors' => ['userInfo' => ['Neizdevās pievienot']], 400]);
		}
	}

	// attelojam profila bildes mainas formu
	public function changeProfilePic() {
		return View::make('users.changeProfilePic');
	}
}