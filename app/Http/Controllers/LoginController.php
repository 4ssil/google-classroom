<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Classroom;

class LoginController extends Controller
{
	public function login()
	{
		$client = new Google_Client();
		$client->setScopes(Google_Service_Classroom::CLASSROOM_COURSES_READONLY);
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
		$authUrl = $client->createAuthUrl();
		print_r($authUrl);
		//sss

	}
}
