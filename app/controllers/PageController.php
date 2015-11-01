<?php
use Metzli\Encoder\Encoder;
use Metzli\Renderer\PngRenderer;
use GuzzleHttp\Client;

class PageController extends BaseController {
	public function generateAztec($string) {
		$code = Encoder::encode($string);
		$renderer = new PngRenderer();
		return "data:png;base64,". base64_encode($renderer->render($code));
	}
	public function home() {
		// for($i = 100; $i <= 100; $i++) {
		// 	$string = "test@api" . $i . ".com";
		// 	$this->doRegisterAuto($string);
		// }

		$data['barcodeData'] = "";
		$data['aztec'] = "";
		$data['code'] = "";
		$client = new \GuzzleHttp\Client();
		// $r = $client->request('POST', 'https://api.mcd.com//v3//customer/offer/redemption', [
		// 	'headers' => [
  //       		'Content-Type' => 'application/json',
  //       		'mcd_apikey'     => 'lvi2NZIVT42AytkqXm6E2BApBU369jpp',
  //       		'Token'      => 'a088010d8cd44509b3b745313f30b9cf',
  //       		'MarketId' => 'US'
  //   		],
  //   		'verify' => false,
  //   		'body' => '{"marketId":"US","application":"MOT","languageName":"en-US","platform":"iphone","offersIds":["41254827"],"storeId":26511,"userName":"test@testtt.com"}'
		// ]);
		// //var_dump( (string) $r->getBody());

		// $arr = json_decode((string) $r->getBody(), true);
		// $data['barcodeData'] = $arr['Data']['BarCodeContent'];
		// $data['aztec'] = $this->generateAztec($data['barcodeData']);
		// $data['code'] = $arr['Data']['RandomCode'];
		return View::make('home', compact('data'));
	}
	public function register() {
		$data['title'] = "Register";
		return View::make('user.register', compact('data'));
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
		        		'Token'      => '9efcc6dc92eb4fdf9eb6e8803deceffd',
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

	public function login() {
		$data['title'] = "Login";
		return View::make('user.login', compact('data'));
	}

}
