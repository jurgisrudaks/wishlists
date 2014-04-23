<?php

class AuthController extends \BaseController {

	public function __construct() {
		parent::__construct();
	}

	public function getIndex()
	{
		if (Sentry::check())
		{
			return Redirect::to('/' . Sentry::getUser()->slug);
		}
		return View::make('users.signin');
	}

	// lietotaju pieslegsana
	public function postIndex() {
		// dabujam lietotaja ievaditos datus
		$input = array(
			'email' => \Input::get('email'),
			'password' => \Input::get('password'),
		);

		// Definejam ievades validacijas noteikumus
		$rules = array (
			'email' => 'required|email',
			'password' => 'required'
		);

		// Izveidojam jaunu validatoru
		$validator = Validator::make($input, $rules);	
		// Ja validacijas laika rodas kludas	
		if ( $validator->fails() )
		{
			// Ja ienakosais vaicajums ir AJAX
			if(Request::ajax())
			{
				// Atgriezam lietotajam kludas izmantojot AJAX
				return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			} else {
				// Vienkarsi novirzam lietotaju atpakal iar kludam
				return Redirect::back()->withInput()->withErrors($validator);
			}

		} else {
			// Validacija veiksmiga
			try
			{
				// Atrodam lietotaju pec ievadita e-pasta
				$user = Sentry::getUserProvider()->findByLogin(Input::get('email'));
				// Parbaudam vai lietotajs nav blokets
				$throttle = Sentry::getThrottleProvider()->findByUserId($user->id);
				$throttle->check();
				// Noradam lietotāja pieejas datus
				$credentials = ['email' => Input::get('email'), 'password' => Input::get('password')];
				// Meginam to autentificet
				$user = Sentry::authenticate($credentials);
			} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
				// Lietotajs nav atrasts
				return Response::json(['success' => false,'errors' => ['login' => ['Nepareizs epasts vai parole.']], 400]);
			} catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
				// Lietotajs nav aktivizets
				return Response::json(['success' => false,'errors' => ['login' => ['Lietotājs nav aktivizēts.']], 400]);
			}
			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
				// Lietotajs ir blokets uz noteiktu laiku
				$time = $throttle->getSuspensionTime();
				return Response::json(['success' => false,'errors' => ['login' => ['Lietotājs ir bloķēts. Mēģini vēlreiz pēc $time mintēm.']], 400]);
			} catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
				// Lietotajs blokets
				return Response::json(['success' => false,'errors' => ['login' => ['Lietotājs bloķēts.']], 400]);
			}
			// Pieslegsanas veiksmiga
			return Response::json(['success' => true], 200);
		}

	}

	// Lietotaju izlogosanas
	public function getLogout() {
		Sentry::logout();
		return Redirect::to('/');
	}

	// Lietotaju pieslegsana izmantojot FB
	// UZMANIBU! Nav lidz galam izstradata
	public function getFacebook() {

	    // get data from input
		$code = Input::get( 'code' );

	    // get fb service
		$fb = OAuth::consumer( 'Facebook' );

	    // check if code is valid

	    // if code is provided get user data and sign in
		if ( !empty( $code ) ) {

	        // This was a callback request from facebook, get the token
			$token = $fb->requestAccessToken( $code );

	        // Send a request with it
			$result = json_decode( $fb->request( '/me' ), true );

			$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
			echo $message. "<br/>";

	        //Var_dump
	        //display whole array().
			dd($result);

		}
	    // if not ask for permission first
		else {
	        // get fb authorization
			$url = $fb->getAuthorizationUri();

	        // return to facebook login url
			return Redirect::to( (string)$url );
		}

	}

}