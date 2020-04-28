<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Google_Client;
use Storage;
use Google_Service_Classroom;

class GoogleController extends Controller
{
	public function client()
	{
		$client = new Google_Client();
		$client->setApplicationName('Google Classroom API Test Mode');
		$client->setScopes([
			Google_Service_Classroom::CLASSROOM_COURSES,
			Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,
			Google_Service_Classroom::CLASSROOM_ROSTERS
		]);
		$client->setAuthConfig('storage/app/google/auth/credentials.json');
		$client->setAccessType('offline');
		$client->setPrompt('select_account consent');
		return $client;
	}
	public function authtoken()
	{
		if (Storage::exists($this->google_token($this->google_token()))) {
			$client = $this->client();
			$accessToken = json_decode(Storage::get($this->google_token()), true);
			$client->setAccessToken($accessToken);
		}
		if ($client->isAccessTokenExpired()) {
			if ($client->getRefreshToken()) {
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			} else {
				return redirect();
			}
			Storage::disk('local')->put($this->google_token(), json_encode($client->getAccessToken()));
		}
		return $client;
	}
	public function google_classroom()
	{
		$client = $this->authtoken();
		return new Google_Service_Classroom($client);
	}
	public function gc_list_courses()
	{
		$g_services = $this->google_classroom();
		$optParams = array(
			'pageSize' => 10
		);
		try {
			$results = $g_services->courses->listCourses($optParams);
			return $results->getCourses();
		} catch (Exception $e) {
			return false;
		}
	}
	public function gc_list_students($courseId)
	{
		$g_services = $this->google_classroom();
		try {
			$results = $g_services->courses_students->listCoursesStudents($courseId);;
			$return = array();
			if ($results->getStudents()) {
				foreach ($results->getStudents() as $key => $rec) {
					$return[]=$rec->getProfile()->getName()->getFullName();
				}
			}
			return $return;
		} catch (Exception $e) {
			return false;
		}
	}
	public function gc_list_teachers($courseId)
	{
		$g_services = $this->google_classroom();
		try {
			$results = $g_services->courses_teachers->listCoursesTeachers($courseId);;
			$return = array();
			if ($results->getTeachers()) {
				foreach ($results->getTeachers() as $key => $rec) {
					$return[]=$rec->getProfile()->getName()->getFullName();
				}
			}
			return $return;
		} catch (Exception $e) {
			return false;
		}
	}
}
