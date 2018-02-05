<?php
  session_start();
  if(isset($_SESSION['Email'])){
      $Email = $_SESSION["Email"];
      $Name = $_SESSION["Name"];
  }
  else{
    header('Location: index.php');
  }
  $conn = new MongoClient();            //Connect To MongoDB
     if($conn){
        $database=$conn->thesolution;         //Connecting to database        
  
        $collection_ques=$database->question_bank;       //Connect to question_bank collection

        $collection_ans=$database->answer_bank;

        $collection_likes=$database->likes;

        $collection_dislikes=$database->dislikes;

        $result_ques = $collection_ques->count(['Name' => $Name]);

        $result_ans = $collection_ans->count(['Answered_By' => $Name]);

        $result_likes = $collection_likes->count(['User' => $Name]);

        $result_dislikes = $collection_dislikes->count(['User' => $Name]);
  } 
  
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
		      $conn_image = new MongoClient();                                  //Connect To MongoDB
        	if($conn_image){
            		$database_user=$conn_image->thesolution;                    //Connecting to database                
            		$collection_user=$database_user->user_data;                 //Connect to user_data collection
			          $result_user = $collection_user->findOne(['User' => "$Name"]);
			          $Profile_Pic = $result_user['Image'];
                echo '<img src="/The_Solution/Profile_Pic/'.$Profile_Pic.'" width="25px" height="25px" style="border-radius:50%"> ';
                echo $Name;
		      }
              	 
    	?>
	<span class="caret"></span></a>
          <ul class="dropdown-menu">
	    <li><a href="view_profile.php"><span class="fa fa-user"></span> Profile</a></li>	
            <li><a href="#"><span class="fa fa-pie-chart"></span> Stats</a></li>
            <li><a href="logout.php"><span class="fa fa-sign-out"></span> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="middleware"><h1 class="animated fadeInDownBig"><?php echo $Name;?> your Statistics ...</h1><br/>
  <div class="square animated fadeInUp"><h1>Question</h1>
    <span class="count"><?php echo $result_ques;?></span>
  </div>
  <div class="square animated fadeInDown"><h1>Answer</h1>
    <span class="count"><?php echo $result_ans;?></span> 
  </div>
  <div style='clear:both'></div>
  <div class="square animated fadeInDown"><h1>Likes</h1>
    <span class="count"><?php echo $result_likes;?></span>
  </div>
  <div class="square animated fadeInUp"><h1>Dislikes</h1>
    <span class="count"><?php echo $result_dislikes;?></span>
  </div>
</div>

<style type="text/css">
  .middleware{
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.square{
  width: 300px;
  height: 300px;
  background-color: #ebe9e8;
  color: #686665;
  float: left;
  border: 2px solid #e4e1e0;
  text-align: center; 
}
.count
{
  position: relative;
  top: 70px;
  font-size:55px;
-}
.square:hover{
  color: #b30000;
  background-color: #e4e2e1;
}
h1{
  text-align: center;
}
h1:hover{
  color: #b30000;
}
 @media only screen and (max-width: 768px) {
 .middleware{
  margin-top: 60%;
 }
}

</style>
<script type="text/javascript">
  $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 3000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
</script>
</body>
</HTML>