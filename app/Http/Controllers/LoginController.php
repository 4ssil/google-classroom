<?php

namespace App\Http\Controllers;
use App\Http\Controllers\GoogleController;
use Storage;
use Illuminate\Http\Request;
class LoginController extends Controller
{
	public function login()
	{
		if (Storage::exists($this->google_token())) {
			return redirect('dashboard/list_courses');
		}else {
			$gcontroller = new GoogleController();
			$client = $gcontroller->client();
			$authUrl = $client->createAuthUrl();
			$return_data = array( 'authUrl' => $authUrl );
			return view('login', $return_data);
		}
	}
	public function googleouthcallback(Request $request)
	{
		$gcontroller = new GoogleController();
		$client = $gcontroller->client();
		$gcode = $request->input('code');
		if ($gcode) {
			$token = $client->fetchAccessTokenWithAuthCode($gcode);
			Storage::disk('local')->put($this->google_token(), json_encode($token));
		}
		return redirect('dashboard/list_courses');
	}
}
