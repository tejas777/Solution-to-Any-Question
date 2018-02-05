<?php
	include('session_handling.php');
  include('connection.php');
?>
<!DOCTYPE HTML>
<HTML lang="en">
<head>
    <title>The Solution - Ask To Answer</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
    <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="user_page.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway|Righteous" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <style type="text/css">
    .main_box{
    margin-top: 5%;
    padding: 30px;
    min-width: 50%;
    margin-left: -5%;
    box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.2), 0 5px 12px 0 rgba(0, 0, 0, 0.19);
    transition: box-shadow 0.3s ease-in-out;
    position: absolute; 
    }
    .main_box:hover{
    margin-top: 5%;
    padding: 30px;

    transition: box-shadow 0.3s ease-in-out;
    box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2), 0 5px 24px 0 rgba(0, 0, 0, 0.19);
    position: absolute; 
    }
    h1{
    font-size: 2em;
    }
    h1:hover{
    color: #b30000;
    }
    h3{
    font-size: 1.2em;
    margin-left: 2%;
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
        <li><a href="#"><span class="fa fa-tags"></span> View Later</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
<?php
        include 'display_profile.php';  
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
<div class="container col-sm-6">
  <div class="row">
    

    <?php
    include 'time_elapsed.php';
    $sql = "SELECT Question_Id FROM view_later WHERE User = '$Name'";
    $result = mysql_query($sql);
    while ($doc = mysql_fetch_array($result)) {
      echo $xyz[] = $doc['Question_Id'];
    }
    $sql = "SELECT * from question_bank Where Question_Id IN (".implode(',',$xyz).")";
    echo $sql;
    $result = mysql_query($sql);
    while ($doc = mysql_fetch_array($result)) {
      echo $doc['Question'];
    }
    ?>
<style type="text/css">
  .text1{
    position:absolute;
    left:41%;
    top:50%;
  }
  .text2{
    position:absolute;
    left:41%;
    top:53%;
  }
  .Image_svg{
    height: auto;
    width: 60%;
    margin-top:20%;
  }
  @media only screen and (max-width: 768px) {
    .text1{
    position:absolute;
    left:55%;
    top:27%;
  }
  .text2{
    position:absolute;
    left:57%;
    top:30%;
  }
  .Image_svg{
    height: auto;
    width: 150%;
  }
}
</style>
  </div>
 </div>
</body>
</HTML>
