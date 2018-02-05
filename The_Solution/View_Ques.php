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
    min-width: 1024px;
    margin-left: -15%;
    box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.2), 0 5px 12px 0 rgba(0, 0, 0, 0.19);
    transition: box-shadow 0.3s ease-in-out;
    position: absolute; 
    }
    .main_box:hover{
    box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2), 0 5px 24px 0 rgba(0, 0, 0, 0.19);
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
    .text1{
    position:absolute;
    left:41%;
    top:48%;
    }
    .text2{
    position:absolute;
    left:41%;
    top:51%;
    }
    .Image_svg{
    height: auto;
    width: 80%;
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
    
    $Question_Id = $_GET['Question_Id'];
    include 'time_elapsed.php';
    $sql = "SELECT * FROM question_bank WHERE Question_Id = '$Question_Id'";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) > 0) {
        echo '<div class="main_box" data-spy="affix">';
        while ($doc = mysql_fetch_array($result)) {
          $Views = $doc['Views'] + 1;
          $Question_Id = $doc['Question_Id'];
          $Category = $doc['Category_Of_Question'];
          echo "<span class='middleware_category'> Category : <a href='view_ques_category.php?Category=".$Category."'>".$doc['Category_Of_Question']."</a><i> ".time_elapsed_string($doc['Time_Of_Posting'])."
          </i><i style='font-size:13px;margin-right:-200%;'>Views : <label>".$doc['Views']."</label></i><b style='float:right;'><a href='Saved.php?id=".$Question_Id."' class='social'>View Later</a></b>
          <a href='View_Ques.php?Question_Id=".$Question_Id."'><h1 style='font-family: labo, serif;'>".$doc['Question']."</h1></a></span>";
?>
          <img src="/The_Solution/Profile_Pic/<?php echo $doc['Profile_Pic'];?>" width="42px" height="42px" style="border-radius:50%"/>
<?php
          echo "<span style='padding:10px;color: #403f3f ;'><a href='view_profile.php?Name=".$doc['User']."'>".$doc['User']."</a></span>";
          $Image = $doc['Image'];

          if(!empty($Image)){?>
              <br/><img src="data:image/png;base64,<?php echo base64_encode($Image) ?>" style="margin-top:10px" width="70%" height="auto"/><?php
          }
?>
          <br/><button style="margin-top:10px;" type="button" class="btn btn-danger hvr-shutter-out-horizontal" data-toggle="collapse" data-target="#demo<?php echo $doc['Question_Id'];?>">Write Your Answer</button>
            <div id="demo<?php echo $doc['Question_Id'];?>" class="collapse">
              <form role="form" style="margin-top:10px;" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                      <div class="form-group">
                           <textarea type="text" class="form-control" name="Answer_Of_Ques" placeholder="Write your Answer Here" required></textarea>
                      </div> 
                      <input type="hidden" name="Question_Id" value="<?php echo $Question_Id;?>"/>
                      <input type="hidden" name="Answered_By" value="<?php echo $Name;?>"/>
                      <input type="submit" class="btn btn-success" value="Submit Your Answer" name="Submit_Answer">
              </form>
            </div>
<?php       
          $sql = "SELECT * FROM answer_bank WHERE Question_Id = '$Question_Id' limit 3";
          $result = mysql_query($sql);
          if (mysql_num_rows($result)>0) {  
              if (mysql_num_rows($result)>3) {
                echo "<a style='float:right;margin-top:10px;' href='View_Ques.php?Question_Id=".$Question_Id."'><b>More Answers</b></a>";
              }        
            while($doc_answer = mysql_fetch_array($result)) {
                $Answer_Id = $doc_answer['Answer_Id'];
          echo "<p style='width:70%;line-height:20px;font-family: Righteous, cursive;font-family: Raleway, sans-serif;'><b>Answer</b> : ".$doc_answer['Answer']."</p><span style='float:right'>Answered By : <a href='view_profile.php?Name=".$doc_answer['Answered_By']."'>".$doc_answer['Answered_By']."</a></span>";
?>
      <a href="like.php?Answer_Id=<?php echo $Answer_Id;?>" class="fa fa-thumbs-up social">
          &nbsp;
<?php
      $sql = "SELECT count(*) as likes from likes where Answer_Id = '$Answer_Id'";
      $likes=mysql_fetch_assoc(mysql_query($sql));
      echo $likes['likes'];
?> 
      </a>
      &nbsp;
      <a href="dislike.php?User=<?php echo $Name;?>&Answer_Id=<?php echo $Answer_Id;?>" class="fa fa-thumbs-down social">
        &nbsp;
<?php 
      $sql = "SELECT count(*) as dislikes from dislikes where Answer_Id = '$Answer_Id'";
      $dislikes=mysql_fetch_assoc(mysql_query($sql));
      echo $dislikes['dislikes'];
?>
      </a>  
<?php }
      }
      else{
          echo "<h4>Question is Not Yet Answered</h4>";
      }
      echo "<br/><hr/>";
    }
    echo "</div>";
    $sql = "UPDATE question_bank SET Views = '$Views' WHERE Question_Id = '$Question_Id'";
    mysql_query($sql);
    }
    else{
        echo "<center><h5 class='item1 animated bounceInDown text1'><b>You haven't Asked</b></h5><h5 class='item1 animated bounceInDown text2'> <b>any Question ...!</b></h5>";
        echo "<img class='item animated bounceInUp Image_svg' src='thinking.svg'/></center>";
    }
?>
</body>
</HTML>
