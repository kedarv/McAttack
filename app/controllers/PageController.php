<?php
use Metzli\Encoder\Encoder;
use Metzli\Renderer\PngRenderer;
use GuzzleHttp\Client;
use Carbon\Carbon;

class PageController extends BaseController {
	// Generate base64 encoded Aztec QR code given a string
	public function generateAztecImage($string) {
		$code = Encoder::encode($string);
		$renderer = new PngRenderer();
		return "data:png;base64,". base64_encode($renderer->render($code));
	}
	// Mark current account as used
	public function setUsedAccount() {
		$account = Account::where('used', '!=', 1)->first();
		$account->used = 1;
		$account->save();
	}
	// Get current account
	public function getAccount() {
		$account = Account::where('used', '!=', 1)->first()->toArray();
		return $account;
	}

	public function generateCoupon() {
		$email = Input::get('email');
		$id = Input::get('id');
	
		$client = new \GuzzleHttp\Client();
		$body = '{"marketId":"US","application":"MOT","languageName":"en-US","platform":"iphone","offersIds":["'.$id.'"],"storeId":26511,"userName":"'.$email.'"}';
		$r = $client->request('POST', 'https://api.mcd.com//v3//customer/offer/redemption', [
			'headers' => [
	        	'Content-Type' => 'application/json',
	        	'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
	        	'Token'      => $this->getSignInSessionToken($email),
	        	'MarketId' => 'US'
	    	],
	    	'verify' => false,
	    	'body' => $body
		]);

		$arr = json_decode((string) $r->getBody(), true);
		$data['barcodeData'] = $arr['Data']['BarCodeContent'];
		$data['aztec'] = $this->generateAztecImage($data['barcodeData']);
		$data['code'] = $arr['Data']['RandomCode'];
		return $data;
	}
	public function home() {
		$account = Account::where('used', '!=', 1)->first()->toArray();
		$account['email'];
		$arr = $this->getAvailableOffers($account['email']);
		$data['email'] = $arr['email'];
		return View::make('home', compact('data', 'arr'));
	}
	public function getAvailableOffers($email) {
		$formatted_email = str_replace("@", "%40", $email);
		$url = 'https://api.mcd.com/v3//customer/offer?marketId=US&application=MOT&languageName=en-US&platform=iphone&userName='.$formatted_email.'';
		$client = new \GuzzleHttp\Client();
		$r = $client->request('GET', $url, [
			'headers' => [
	     		'mcd_apikey' => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
	     		'Token' => $this->getSignInSessionToken($email),
	     		'MarketId' => 'US'
	    	],
	    	'verify' => false,
		]);
		$arr = json_decode((string) $r->getBody(), true);
		$arr['email'] = $email;
		foreach($arr['Data'] as $item) {
			if (strpos($item['Name'],'Free Breakfast or Regular') !== false) {
				return $arr;
			}
		}
		$this->setUsedAccount();
		return $this->getAvailableOffers($this->getAccount()['email']);
	}
	public function getSessionToken() {
		if (Cache::has('sessionToken')) {
			$token = Cache::get('sessionToken');
		}
		else {	
			$client = new \GuzzleHttp\Client();
			$r = $client->request('POST', 'https://api.mcd.com/v3//customer/session', [
				'headers' => [
	        		'Content-Type' => 'application/json',
	        		'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
	        		'MarketId' => 'US'
	    		],
	    		'verify' => false,
	    		'body' => '{"marketId":"US","application":"MOT","languageName":"en-US","platform":"iphone","versionId":"0.0.1.I","nonce":"happybaby","hash":"ODUwNjEzMmY3MGRkM2ZlMTQzMjE0YmJlYzllNWNjZjI\u003d"}'
			]);
			$arr = json_decode((string) $r->getBody(), true);
			$expiresAt = Carbon::now()->addMinutes(180);
			$token = $arr['Data']['AccessData']['Token'];
			Cache::put('sessionToken', $token, $expiresAt);
		}
		return $token;
	}
	public function getSignInSessionToken($email) {
		if (Cache::has($email)) {
			$token = Cache::get($email);
		}
		else {	
			$client = new \GuzzleHttp\Client();
			$r = $client->request('POST', 'https://api.mcd.com/v3//customer/session/sign-in-and-authenticate', [
				'headers' => [
	        		'Content-Type' => 'application/json',
	        		'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
	        		'MarketId' => 'US'
	    		],
	    		'verify' => false,
	    		'body' => '{"marketId":"US","application":"MOT","languageName":"en-US","platform":"iphone","versionId":"0.0.1.I","nonce":"happybaby","hash":"ODUwNjEzMmY3MGRkM2ZlMTQzMjE0YmJlYzllNWNjZjI\u003d","userName":"'.$email.'","password":"helloworlD1","newPassword":null}'
			]);
			$arr = json_decode((string) $r->getBody(), true);
			$expiresAt = Carbon::now()->addMinutes(5);
			$token = $arr['Data']['AccessData']['Token'];
			Cache::put($email, $token, $expiresAt);
		}
		return $token;
	}
	public function doRegisterAuto($string) {
	    $client = new \GuzzleHttp\Client();

	    $body = '{
			"marketId": "US",
			"application": "MOT",
			"languageName": "en-US",
			"platform": "iphone",
			"userName": "'.$string.'",
			"password": "helloworlD1",
			"firstName": "TestFirst",
			"lastName": "TestLast",
			"nickName": null,
			"mobileNumber": "",
			"emailAddress": "'.$string.'",
			"isPrivacyPolicyAccepted": true,
			"preferredNotification": 1,
			"receivePromotions": true,
			"cardItems": [],
			"accountItems": [],
			"zipCode": "49706",
			"optInForCommunicationChannel": false,
			"optInForSurveys": false,
			"optInForProgramChanges": false,
			"optInForContests": false,
			"optInForOtherMarketingMessages": false,
			"notificationPreferences": {
				"AppNotificationPreferences_OfferExpirationOption": 0,
				"EmailNotificationPreferences_LimitedTimeOffers": false,
				"AppNotificationPreferences_Enabled": false,
				"EmailNotificationPreferences_EverydayOffers": false,
				"EmailNotificationPreferences_YourOffers": false,
				"AppNotificationPreferences_YourOffers": false,
				"AppNotificationPreferences_PunchcardOffers": false,
				"AppNotificationPreferences_LimitedTimeOffers": false,
				"EmailNotificationPreferences_OfferExpirationOption": 0,
				"EmailNotificationPreferences_Enabled": false,
				"EmailNotificationPreferences_PunchcardOffers": false,
				"AppNotificationPreferences_EverydayOffers": false
			},
			"preferredOfferCategories": [],
			"subscribedToOffer": true,
			"isActive": true
		}';

		$r = $client->request('POST', 'https://api.mcd.com/v3/customer/registration', [
			'headers' => [
				'Content-Type' => 'application/json',
		  		'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
		  		'Token'      => $this->getSessionToken(),
		  		'MarketId' => 'US'
		 	],
			'verify' => false,
			'body' => $body
		]);

		$arr = json_decode((string) $r->getBody(), true);
		if($arr['ResultCode'] == 1) {
			$account = new Account;
			$account->firstname = "TestFirst";
			$account->lastname = "TestLast";
			$account->zipcode = "47906";
			$account->email = $string;
			$account->password = "helloworlD1";
			$account->save();
	    	$response = array('status' => 'success', 'text' => 'Success');
	    }
	    else {
	    	$response = array('status' => 'danger', 'text' => 'MCD API error');
	    }
		
		return Response::json($response); 
		exit();	
	}
	
	public function doRegisterManual() {
		if (Request::ajax()) {
			$validator = Validator::make(
		    	array(
		        	'firstname' => Input::get('firstname'),
		        	'lastname' => Input::get('lastname'),
		        	'zipcode' => Input::get('zip'),
		        	'email' => Input::get('email'),
		        	'password' => Input::get('password'),
		        	'confirmpassword' => Input::get('confirmpassword'),
		    	),
		    	array(
		        	'firstname' => 'required',
		        	'lastname' => 'required',
		        	'zipcode' => 'required|numeric',
		        	'email' => 'required|email',
		        	'password' => 'required|min:6|max:12',
		        	'confirmpassword' => 'required|same:password',    	
		    	)
			);
			if ($validator->fails()) {
	    		$response = array('status' => 'danger', 'text' => $validator->messages());
	    	}
	    	else {
	    		$client = new \GuzzleHttp\Client();

	    		$body = '{
					"marketId": "US",
					"application": "MOT",
					"languageName": "en-US",
					"platform": "iphone",
					"userName": "'.Input::get('email').'",
					"password": "helloworlD1",
					"firstName": "'.Input::get('firstname').'",
					"lastName": "'.Input::get('lastname').'",
					"nickName": null,
					"mobileNumber": "",
					"emailAddress": "'.Input::get('email').'",
					"isPrivacyPolicyAccepted": true,
					"preferredNotification": 1,
					"receivePromotions": true,
					"cardItems": [],
					"accountItems": [],
					"zipCode": "'.Input::get('zipcode').'",
					"optInForCommunicationChannel": false,
					"optInForSurveys": false,
					"optInForProgramChanges": false,
					"optInForContests": false,
					"optInForOtherMarketingMessages": false,
					"notificationPreferences": {
						"AppNotificationPreferences_OfferExpirationOption": 0,
						"EmailNotificationPreferences_LimitedTimeOffers": false,
						"AppNotificationPreferences_Enabled": false,
						"EmailNotificationPreferences_EverydayOffers": false,
						"EmailNotificationPreferences_YourOffers": false,
						"AppNotificationPreferences_YourOffers": false,
						"AppNotificationPreferences_PunchcardOffers": false,
						"AppNotificationPreferences_LimitedTimeOffers": false,
						"EmailNotificationPreferences_OfferExpirationOption": 0,
						"EmailNotificationPreferences_Enabled": false,
						"EmailNotificationPreferences_PunchcardOffers": false,
						"AppNotificationPreferences_EverydayOffers": false
					},
					"preferredOfferCategories": [],
					"subscribedToOffer": true,
					"isActive": true
				}';

				$r = $client->request('POST', 'https://api.mcd.com/v3/customer/registration', [
					'headers' => [
		        		'Content-Type' => 'application/json',
		        		'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
		        		'Token'      => '9efcc6dc92eb4fdf9eb6e8803deceffd',
		        		'MarketId' => 'US'
		    		],
		    		'verify' => false,
		    		'body' => $body
				]);

				$arr = json_decode((string) $r->getBody(), true);
				if($arr['ResultCode'] == 1) {
					$account = new Account;
		    		$account->firstname = Input::get('firstname');
		    		$account->lastname = Input::get('lastname');
		    		$account->zipcode = Input::get('zip');
		    		$account->email = Input::get('email');
		    		$account->password = Input::get('password');
		    		$account->save();
	    			$response = array('status' => 'success', 'text' => 'Success');
	    		}
	    		else {
	    			$response = array('status' => 'danger', 'text' => 'MCD API error');
	    		}
	    	}
	    	return Response::json($response); 
	    	exit();
    	}
	}
	public function generateAccounts() {
		$user = str_random(2);
		$domain = str_random(2) . ".com";
		$email = $user . "@" . $domain;
		return $this->doRegisterAuto($email);
	}

	public function register() {
		$data['title'] = "Register";
		return View::make('user.register', compact('data'));
	}
	public function login() {
		$data['title'] = "Login";
		return View::make('user.login', compact('data'));
	}
}