<?php

namespace App\Http\Controllers;
use App\Http\Controllers\GoogleController;
use Storage;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
	public function list_courses()
	{
		if (!Storage::exists($this->google_token())) {
			return redirect('/');
		} else {
			$gcontroller = new GoogleController();
			$list = $gcontroller->gc_list_courses();
			$list_arr = array();
			if ($list) {
				foreach ($list as $key => $rec) {
					$courseId=$rec->getId();
					$list_arr[$key]['courseId'] = $courseId;
					$list_arr[$key]['course_name'] = $rec->getName();
					$list_arr[$key]['course_section'] = $rec->getSection();
					$list_arr[$key]['course_status'] = $rec->getcourseState();
					$list_arr[$key]['student_recs'] = $gcontroller->gc_list_students($courseId);
					$list_arr[$key]['teacher_recs'] = $gcontroller->gc_list_teachers($courseId);
				}
			}
			$return_data = array('list_arr'=>$list_arr);
			return view('list_courses', $return_data);
		}
	}
}
