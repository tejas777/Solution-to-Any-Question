<?php
    include('session_handling.php');
    include('connection.php');
    $var = "";
    if(isset($_POST['Submit_Question'])){
        $Question = $_POST['Question'];
        $Category = $_POST['Category'];
        $Image_Name=$_FILES["Image"]["name"]; 
        $Image=addslashes (file_get_contents($_FILES['Image']['tmp_name']));

        $sql = "INSERT INTO question_bank(Question,User,Category_Of_Question,Image) values ('$Question','$Name','$Category','$Image')";
        //$sql = "SELECT * FROM user_data";
        if(mysql_query($sql)){
            $var = "Question Submitted Successfully";
            echo "<script type='text/javascript'>alert('$var');</script>";
        }
        else {
            $var = "Error While Submitting the Question";
            echo "<script type='text/javascript'>alert('$var');</script>";
        }
            
    }
?>
<!DOCTYPE HTML>
<HTML lang="en">
<head>
	<title>The Solution - Ask To Answer</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="user_page.css">
  	<link rel="stylesheet" type="text/css" href="index.css">
  	<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<style type="text/css">
  	.main_box{
	padding: 30px;
	box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2), 0 10px 24px 0 rgba(0, 0, 0, 0.19);
    margin: 0;
    position: absolute;
    top: 45%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
}

  	</style>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" >
 	<div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="user_page.php"><b>The Solution</b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="user_page.php"><span class="fa fa-clone"></span> Timeline</a></li>
        <li><a href="Your_Ques.php"><span class="fa fa-question-circle-o"></span> Your Questions</a></li>
        <li><a href="View_Later.php"><span class="fa fa-tags"></span> View Later</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          	<?php
                $sql = "SELECT Profile_Pic FROM user_data where Name = '$Name' LIMIT 1";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                $Profile_Pic = $row['Profile_Pic'];
                if(!empty($Profile_Pic)){?>
                  <img src="data:image/png;base64,<?php echo base64_encode($Profile_Pic) ?>" width="25px" height="25px" style="border-radius:50%"/><?php
                }
                else{
                  echo '<img src="default_profile.png" width="25px" height="25px" style="border-radius:50%"/>';
                }
                echo " $Name";     
            ?>
          	  <span class="caret"></span></a>
          <ul class="dropdown-menu">
	    <li><a href="view_profile.php"><span class="fa fa-user"></span> Profile</a></li>	
            <li><a href="stats.php"><span class="fa fa-pie-chart"></span> Stats</a></li>
            <li><a href="logout.php"><span class="fa fa-sign-out"></span> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container main_box" style="margin-top:5%;">
	<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<h1 style="color:#b30000;;text-align:center;">Ask A Question</h1>
		<hr/>
		<div class="form-group">
              <textarea type="text" class="form-control" name="Question" placeholder="Ask a Question" required></textarea>
            </div>
            <label>Category : </label>
            <select class="form-control" name="Category">
              <option name="Category" value="Education">Education</option>
              <option name="Category" value="Entertainment">Entertainment</option>
              <option name="Category" value="Technology">Technology</option>
              <option name="Category" value="Culture">Culture</option>
              <option name="Category" value="Lifestyle">Lifestyle</option>
              <option name="Category" value="Sports">Sports</option>
              <option name="Category" value="Politics">Politics</option>
              <option name="Category" value="Fashion">Fashion</option>
              <option name="Category" value="Others">Others</option>
            </select><br/>
            <div class="form-group">
                  You can Upload a Image for your Question <input type="file" name="Image">
            </div>
              <button type="submit" class="btn btn-default" name="Submit_Question"><span class="glyphicon glyphicon-off"></span> Submit Question</button>
  </form>
</div>
</body>
</html>
