<?php
$flag =0;
session_start();
    if (isset($_SESSION["Email"])) {
      $Email = $_SESSION["Email"];
      $Name = $_SESSION["Name"];
    }
    else {
      header('Location: index.php');
    }
    if (isset($_GET['Name'])) {
      $User_Name = $_GET['Name'];
      if ($User_Name == $Name) {
        $flag = 1;
      }
    }
    else{
      $User_Name = $Name;
      $flag=1;
    }
    if (isset($_POST['Submit_Update'])) {
      $Username = $_POST['Username'];
      $Mobile = $_POST['Mobile_No'];
      $Birthday = $_POST['Birthday'];
      $Gender = $_POST['Gender'];



      $conn = new MongoClient();           //Connect To MongoDB
        if($conn){

            $database=$conn->thesolution;         //Connecting to database        

            $collection=$database->user_data;       //Connect to user_data collection


            if (!($Username == $Name)) {
              if($collection->findOne(['User' => $Username])){
                echo "<script type='text/javascript'>alert('Sorry ".$Username." already exist !!!');</script>";
              } 
              else{
              $query = array('User' => $Username, 'Gender' => $Gender, 'Mobile' => $Mobile, 'Birthday' => $Birthday);

              $result = $collection->findOne(['User' => $Name]);

              $result['User'] = $Username;

              $result['Mobile'] = $Mobile;

              $result['Birthday'] = $Birthday;

              $result['Gender'] = $Gender;

              session_start();

              $_SESSION["Name"] = $Username;

              if($collection->save($result)){
                  $collection=$database->question_bank;  
                  $result = $collection->find(['Name' => $Name]);
                  foreach ($result as $key) {
                    $key['Name'] = $Username;
                    $collection->save($key);
                  }
                  echo "<script type='text/javascript'>alert('Info Updated Successfully');</script>";
              }
              else{
                  echo "<script type='text/javascript'>alert('Error while Updating Info');</script>";
              }
              $delay=0; //Where 0 is an example of time Delay you can use 5 for 5 seconds for example !
              header("Refresh: $delay;"); 
            }
            }
            else{
              $query = array('User' => $Username, 'Gender' => $Gender, 'Mobile' => $Mobile, 'Birthday' => $Birthday);

              $result = $collection->findOne(['User' => $Name]);

              $result['User'] = $Username;

              $result['Mobile'] = $Mobile;

              $result['Birthday'] = $Birthday;

              $result['Gender'] = $Gender;

              session_start();

              $_SESSION["Name"] = $Username;

              if($collection->save($result)){
                  $collection=$database->question_bank;  
                  $result = $collection->find(['Name' => $Name]);
                  foreach ($result as $key) {
                    $key['Name'] = $Username;
                    $collection->save($key);
                  }
                  echo "<script type='text/javascript'>alert('Info Updated Successfully');</script>";
              }
              else{
                  echo "<script type='text/javascript'>alert('Error while Updating Info');</script>";
              }
              $delay=0; //Where 0 is an example of time Delay you can use 5 for 5 seconds for example !
              header("Refresh: $delay;"); 
            }

        }
    }



    if (isset($_POST['Submit_Update_Interest'])) {

      $Checkbox = implode(',', $_POST['Topic']);

      $conn = new MongoClient();  

      if($conn){

            $database=$conn->thesolution;         //Connecting to database        

            $collection=$database->user_data;       //Connect to user_data collection

            $result = $collection->findOne(['User' => $Name]);

            $result['Topic_Of_Interest'] = $Checkbox;
            if($collection->save($result)){
              echo "<script type='text/javascript'>alert('Topics Of Interest is Updated Successfully');</script>";
            }
            else{
              echo "<script type='text/javascript'>alert('Unexpected Error occured while updating Topics Of Interest');</script>";
            }


      }
    }


    
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
<script>
   function chooseFile() {
      $("#fileInput").click();
   }
</script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="timeline.css"> <!-- Resource style -->
	<script src="modernizr.js"></script> <!-- Modernizr -->
  	
	<title><?php echo $User_Name;?></title>
</head>
<body id="main">
<header>
<?php
          $conn_image = new MongoClient();                                  //Connect To MongoDB
          if($conn_image){
                $database_user=$conn_image->thesolution;                    //Connecting to database                
                $collection_user=$database_user->user_data;                 //Connect to user_data collection
                $result_user = $collection_user->findOne(['User' => "$User_Name"]);
                $Profile_Pic = $result_user['Image'];
                echo '<img class="main_img" src="/The_Solution/Profile_Pic/'.$Profile_Pic.'"> ';
          }
                 
      ?>
<span class="glyphicon glyphicon-camera" id="upload" onclick="chooseFile();"></span>
<div style="height:0px;overflow:hidden">
<form action="#" method="POST" id="form">
   <input type="file" id="fileInput" name="Image" />
</form>   
</div>
<script>
   document.getElementById("fileInput").onchange = function() {
    document.getElementById("form").submit();
};
</script>
<img class="back_img" src="cover.jpg">
<h1><?php echo $User_Name;?></h1>
<button class="About_btn btn btn-default" id="myBtn1" type="button" class="btn btn-danger">About</button>

  <button class="Edit_Topic btn btn-default" id="myBtn3" type="button" class="btn btn-danger">Topics Of Interest</button>

<?php
  if($flag){
    echo '<button class="Edit_btn btn btn-default" id="myBtn2" type="button" class="btn btn-danger">Edit Profile</button>';
  }
?>

</header>
	<section id="cd-timeline" class="cd-container">



<?php
    include 'time_elapsed.php';
    $conn = new MongoClient();            //Connect To MongoDB
        if($conn){

            $database=$conn->thesolution;         //Connecting to database        
  
            $collection_question=$database->question_bank;       //Connect to question_bank collection

            $result=$collection_question->find(['Name' => "$User_Name"])->sort(array('Time_Of_Posting'=> -1));

            if ($result->count()>0) { 
            	foreach ($result as $result_question) {
                	$Question_Id = $result_question['_id'];
                	echo '<div class="cd-timeline-block">
					<div class="cd-timeline-img cd-picture">
					<img src="cd-icon-picture.svg" alt="Picture">
					</div> 

					<div class="cd-timeline-content">
					<span style="font-size:13px"> Category : '.$result_question["Category"].'<i style="font-size:13px;right:30px;position:absolute;"> '.time_elapsed_string($result_question["Time_Of_Posting"]).'</i><br/><br/>
					<h2><a style="color:#303e49;text-decoration:none;" href="View_Ques.php?Question_Id='.$Question_Id.'">'.$result_question["Question"].'</a></h2>';
					
					$Image = $result_question['Image'];

                    if(!empty($Image)){
?>
                      	<br/><img src="/The_Solution/Uploads/<?php echo $Image?>" style="margin-top:10px" width="70%" height="auto"/>
<?php 					echo "<br/><br/>";
                    }


					$collection_answers=$database->answer_bank;       //Connect to user_data collection
                	$result_answer = $collection_answers->find(['Question_Id' => "$Question_Id"])->limit(1);
                	if ($result_answer->count()>0) {          
              		    foreach ($result_answer as $doc_answer) {
              		    	$Answer_Id = $doc_answer['_id'];
          					echo '<p><b>Answer</b> : '.$doc_answer["Answer"].'</p><span style="float:right">Answered By : <a style="color:#b30000;" href="view_profile.php?Name='.$doc_answer[Answered_By].'">'.$doc_answer["Answered_By"].'</a></span><br/>';

                    $collection_likes=$database->likes; 
                            
                    $count = $collection_likes->find(['Answer_Id' => "$Answer_Id"]);

                    $count_likes = $collection_likes->count(['Answer_Id' => "$Answer_Id"]);


                    $result = iterator_to_array($count);

                    foreach ($result as $key) {
                    	echo "<p style='font-size:15px;'>".$key['User']." ";
                    	break;
                    }

                    echo "and ".($count_likes-1)." people liked this</p>";

                		}
              		}
              		else{
              			echo "<br/><h4>Question is Not Yet Answered</h4>";
              		}
					
					echo '<br/><a href="View_Ques.php?Question_Id='.$Question_Id.'" class="cd-read-more">View Question</a>
					<span class="cd-date">'.time_elapsed_string($result_question["Time_Of_Posting"]).'</span>
				</div> 
				</div>';
                
            	}
        	}
          else{
            echo "<br/><h1 style='top:300px;left:30%;position:absolute;'>No Activity is performed</h1>";
          }
		
}
?>
</section> <!-- cd-timeline -->
<script src="main.js"></script>
<script>
$(document).ready(function(){
    $("#myBtn1").click(function(){
        $("#myModal1").modal();
    });
});
</script>
<script>
$(document).ready(function(){
    $("#myBtn2").click(function(){
        $("#myModal2").modal();
    });
});
</script>
<script>
$(document).ready(function(){
    $("#myBtn3").click(function(){
        $("#myModal3").modal();
    });
});
</script>
<?php
            $conn = new MongoClient();            //Connect To MongoDB
            if($conn){

                $database=$conn->thesolution;         //Connecting to database        
  
                $collection=$database->user_data;       //Connect to question_bank collection

                $query=array('User' => $User_Name);
  
                $result=$collection->findOne($query);

                $focus = explode(",", $result['Topic_Of_Interest']);

            }
?>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2><b>About</b></h2>
        </div>
        <div class="modal-body">
          <?php
            include 'age_calc.php';
            if($result){
                      $Birthday = $result["Birthday"];
                      echo '<h4><label class="glyphicon glyphicon-user"> Username</label> : '.$result["User"].'</h4><br/>
                      <h4><label class="glyphicon glyphicon-envelope"> Email</label> : '.$result["Email"].'</h4><br/>
                      <h4><label class="glyphicon glyphicon-heart"> Gender</label> : '.$result["Gender"].'</h4><br/>
                      <h4><label class="glyphicon glyphicon-phone"> Mobile No.</label> : '.$result["Mobile"].'</h4><br/>
                      <h4><label class="glyphicon glyphicon-calendar"> D.O.B</label> : '.$Birthday.'</h4><br/>
                      <h4><label class="glyphicon glyphicon-calendar"> How Old are You</label> : '.GetAge("$Birthday").' Years</h4>';
                }
          ?>
        </div>      
    </div>
  </div> 
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2><b>The Solution</b> Ask To Answer </h2>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

          <div class="form-group">
            <label class="control-label col-sm-2" for="Username">Username : </label>
            <div class="col-sm-5">
              <input name="Username" type="text" class="form-control" pattern="^[a-zA-Z]+\s?[a-zA-Z]{1,20}" placeholder="Username" title="Only Alphbets are allowed with 1 space not in start and max lenght of Username is 20" value="<?php echo $result['User'];?>" required> <b style="color:#b30000;">Must be Unique</b>
            </div>
          </div>    

          <div class="form-group">
            <label class="control-label col-sm-2" for="Mobile_No">Mobile No : </label>
            <div class="col-sm-5">
              <input name="Mobile_No" type="text" pattern="[7-9]{1}[0-9]{9}" title="Enter Valid Mobile No starting with 7,8 or 9" class="form-control" value="<?php echo $result['Mobile'];?>" required>
            </div>
          </div> 

          <div class="form-group">
            <label class="control-label col-sm-2" for="Birthday">Birthday : </label>
            <div class="col-sm-5">
              <input name="Birthday" class="form-control" value="<?php echo $result['Birthday'];?>" required>
            </div>
          </div> 


          <div class="radio" style="margin-left:6%;">
            <label class="control-label" for="Gender"><b>Gender :</b>  </label>&nbsp;&nbsp;&nbsp;&nbsp;
              <b class="radio-inline" style="margin-top:-10px;">
                <input type="radio" name="Gender" value="Male" <?php if($result['Gender'] == 'Male'){echo 'checked="checked"';}?> required>&nbsp;Male
              </b>
            <b class="radio-inline" style="margin-top:-10px;">
              <input type="radio" name="Gender" value="Female" <?php if($result['Gender'] == 'Female'){echo 'checked="checked"';}?> required>&nbsp;Female
            </b>
        </div>
        <br/>
        <button style="margin-left:6%;" type="submit" class="btn btn-danger" name="Submit_Update">Update Info</button>
        <a href="Change_Password.php" type="button" class="btn btn-danger">Change Password</a>
          
        </form>
      </div>      
    </div>
  </div> 
</div>

<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2><b>Topics of Interest</b></h2>
        </div>
        <div class="modal-body">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="checkbox" style="font-size:20px">
          <div style="width:50%;float:left">
            <label><input type="checkbox" name="Topic[]" value="Entertainment" <?php if(in_array("Entertainment",$focus)){echo 'checked="checked"';}?> >&nbsp;&nbsp; Entertainment&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Education" <?php if(in_array("Education",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Education&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Lifestyle" <?php if(in_array("Lifestyle",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Lifestyle&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Fashion" <?php if(in_array("Fashion",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Fashion&nbsp;&nbsp;</label><br/>
          </div>
          <div style="width:50%;float:right">  
            <label><input type="checkbox" name="Topic[]" value="Politics" <?php if(in_array("Politics",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Politics&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Sports" <?php if(in_array("Sports",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Sports&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Technology" <?php if(in_array("Technology",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Technology&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Culture" <?php if(in_array("Culture",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Culture&nbsp;&nbsp;</label><br/>
            <label><input type="checkbox" name="Topic[]" value="Others" <?php if(in_array("Others",$focus)){echo 'checked="checked"';}?>>&nbsp;&nbsp; Others&nbsp;&nbsp;</label><br/>
          </div>  
            </div>
          </div>
<?php
  if($flag){
        echo '<button style="margin:10px;" type="submit" class="btn btn-danger" name="Submit_Update_Interest">Update Topic of Interest</button>';
}else{
        echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
}
?>        </form>  
    </div>
  </div> 
</div>
<div id="mySidenav" class="sidenav">
  <a  href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a class="sidenav_link" href="user_page.php"><span class="glyphicon glyphicon-home"></span> Home</a>
  <a class="sidenav_link" href="Your_Ques.php"><span class="glyphicon glyphicon-question-sign"></span> Your Questions</a>
  <a class="sidenav_link" href="View_Later.php"><span class="glyphicon glyphicon-tags"></span> View Later</a>
  <a class="sidenav_link" href="stats.php"><span class="glyphicon glyphicon-stats"></span> Stats</a><br/>
  <input style="width:70%;margin-left:30px;padding:10px;border-radius:10px;font-size:15px;" type="text" class="search" id="searchid" placeholder="Search for people" /><br/><br/>
  <i id="result"></i> 
</div>
<button class="Menu glyphicon glyphicon-menu-hamburger" onclick="openNav()"></button>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}
</script>
<script type="text/javascript">
$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
  $.ajax({
  type: "POST",
  url: "search.php",
  data: dataString,
  cache: false,
  success: function(html)
  {
  $("#result").html(html).show();
  }
  });
}return false;    
});

jQuery("#result").live("click",function(e){ 
  var $clicked = $(e.target);
  var $name = $clicked.find('.name').html();
  var decoded = $("<div/>").html($name).text();
  $('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
  var $clicked = $(e.target);
  if (! $clicked.hasClass("search")){
  jQuery("#result").fadeOut(); 
  }
});
$('#searchid').click(function(){
  jQuery("#result").fadeIn();
});
});
</script>
</body>
</html>
