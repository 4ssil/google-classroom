<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>Google Classroom List Courses</title>
  <!-- Meta-Tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <meta name="keywords" content="Classroom">
  <script>
    addEventListener("load", function () {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <link href="<?=asset('resources/assets/dashboard/css/style.css')?>" rel='stylesheet' type='text/css' media="all">
  <link rel="stylesheet" href="<?=asset('resources/assets/dashboard/css/jquery-ui.css')?>" />
  <link href="<?=asset('resources/assets/dashboard/css/wickedpicker.css')?>" rel="stylesheet" type='text/css' media="all" />
  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="margin-top: -20px;color: white;">
  <h1 class="header-w3ls">
  Courses List</h1>
  
  <div class="container">
    <table class="table table-bordered" id="course_list">
      <thead style="background: black;">
        <tr>
          <th>Course Title</th>
          <th>Course Section</th>
          <th>Course Status</th>
          <th>Students</th>
          <th>Teachers</th>
        </tr>
      </thead>
      <tbody style="background: #e0e0e0; color: black;">
        <?php
        if ($list_arr) {
          foreach ($list_arr as $key => $rec) { ?>
            <tr>
              <td><a href="javascript:;" onclick="show_course_details(<?=$rec['courseId'];?>)"><?=$rec['course_name'];?></a></td>
              <td><?=$rec['course_section'];?></td>
              <td><?=$rec['course_status'];?></td>
              <td><?=count($rec['student_recs']);?></td>
              <td><?=count($rec['teacher_recs']);?></td>
            </tr>
            <?php 
          } 
        } ?>
      </tbody>
    </table>
    <?php
    if ($list_arr) {
      foreach ($list_arr as $key => $rec) { ?>
        <div class="row course_details" style="display: none;" id="course<?=$rec['courseId']?>">
          <div class="col-lg-12">
            <button class="btn btn-success" onclick="show_courses()">Back to courses</button>
          </div>
          <div class="col-lg-6">
            <h3 class="header-w3ls">
              <?=$rec['course_name'];?> Course Students
           </h3>
           <table class="table table-bordered">
            <thead style="background: black;">
              <tr>
                <th>Student Name</th>
              </tr>
            </thead>
            <tbody style="background: #e0e0e0; color: black;">
              <?php
              if ($rec['student_recs']) {
                foreach ($rec['student_recs'] as $skey => $srec) { ?>
                  <tr>
                    <td><?=$srec;?></td>
                  </tr>
                  <?php 
                } 
              } ?>
            </tbody>
          </table>
        </div>
        <div class="col-lg-6">
          <h3 class="header-w3ls">
            <?=$rec['course_name'];?> Course Teachers
          </h3>
          <table class="table table-bordered">
            <thead style="background: black;">
              <tr>
                <th>Teacher Name</th>
              </tr>
            </thead>
            <tbody style="background: #e0e0e0; color: black;">
              <?php
              if ($rec['teacher_recs']) {
                foreach ($rec['teacher_recs'] as $tkey => $trec) { ?>
                  <tr>
                    <td><?=$trec;?></td>
                  </tr>
                  <?php 
                } 
              } ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php 
    } 
  } ?> 
</div>

<div class="copy">

</div>
<!-- js -->
<script type='text/javascript' src='<?=asset('resources/assets/dashboard/js/jquery-2.2.3.min.js')?>'></script>

<script type="text/javascript">
  function show_course_details(courseId) {
    $('#course_list').hide(900);
    $('#course'+courseId).show(1100);
  }  
  function show_courses() {
    $('#course_list').show(1100);
    $('.course_details').hide(900);
  }
</script>

</body>
</html>
