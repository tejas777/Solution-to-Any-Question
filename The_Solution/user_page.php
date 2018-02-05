<?php
    include('session_handling.php');
    include('connection.php');
    $Answer_var = "";
    if (isset($_POST['Submit_Answer'])) {
      $Question_Id = $_POST['Question_Id'];
      $Answer = $_POST['Answer_Of_Ques'];
      $Answered_By = $_POST['Answered_By'];
      $sql = "INSERT INTO answer_bank (Question_Id,Answer,Answered_By) VALUES ('$Question_Id','$Answer','$Answered_By')";
      if (!mysql_query($sql)) {
        $Answer_var = "Error While Submitting Answer";
        echo "<script type='text/javascript'>alert('$Answer_var');</script>";;
      }
      else{
        $Answer_var = 'Answer Submitted Successfully';
        echo "<script type='text/javascript'>alert('$Answer_var');</script>";;
      }
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
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
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
      <a class="navbar-brand" href="#"><b>The Solution</b></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="fa fa-clone"></span> Timeline</a></li>
        <!--<li><a href="#"><span class="fa fa-bell"></span> Notifications<?php /*echo "<sup class='item animated fadeIn'
        style='color:#fff;border-radius:50%;font-weight:700;font-size:12px;padding:2px;background-color:#b30000;padding-left:5px;padding-right:5px;'>2</sup>";*/?></a></li>-->
        <li><a href="Your_Ques.php"><span class="fa fa-question-circle-o"></span> Your Questions</a></li>
        <li><a href="View_Later.php"><span class="fa fa-tags"></span> View Later</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
<?php
    include 'display_profile.php';    	 
?>
	    <span class="caret"></span></a>
        <ul class="dropdown-menu">
	       `<li><a href="view_profile.php"><span class="fa fa-user"></span> Profile</a></li>	
            <li><a href="stats.php"><span class="fa fa-pie-chart"></span> Stats</a></li>
            <li><a href="logout.php"><span class="fa fa-sign-out"></span> Logout</a></li>
        </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 item animated fadeInLeft" data-spy="affix" style="left:0%">
      <h3>Trending Now</h3>
      <hr/>
      <ul style="font-size:17px">
        <br/><br/>
<?php 
        
        $sql = "SELECT * FROM question_bank LIMIT 3";
        $result = mysql_query($sql);        ;

        while($row =  mysql_fetch_array($result)) {
          echo '<li><a href="View_Ques.php?Question_Id='.$row["Question_Id"].'">'.$row['Question'].'</a></li>';
        }
?>
      </ul>
      <hr/>
      <label>Search for User : </label>
      <input style="margin-left:20px;padding:5px;border-radius:10px;" type="text" class="search" id="searchid" placeholder="Search for people" /><br/>
      <i id="result"></i> 
    </div>
    <div class="col-sm-6 item animated fadeInUp">
      <h3>Stories For You</h3>
      <hr width="100%"/>
<?php
    include 'time_elapsed.php';
    $sql = "SELECT * FROM question_bank";
    $result = mysql_query($sql);
    while ($doc = mysql_fetch_array($result)) {
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
?>
    </div>
    <div class="col-sm-3 item animated fadeInRight" data-spy="affix" style="right:0%">
      <h3><a href="Your_Ques.php">Your Questions</a></h3>
      <hr/>
      <ul>
      <br/><br/><br/>
<?php
        $sql = "SELECT * FROM question_bank where User = '$Name' ORDER BY Time_Of_Posting DESC";
        $result = mysql_query($sql);       ;
        if(mysql_num_rows($result) > 0){
          while($row =  mysql_fetch_array($result)) {
            echo '<li><a href="View_Ques.php?Question_Id='.$row["Question_Id"].'">'.$row['Question'].'</a></li>';
          }
        }
        else{
                echo "<h4>You Haven't Ask any Question</h4>";
        } 
?>
        </ul>
        <a href="ask_a_ques.php" type="button" class="btn btn-danger hvr-shutter-out-horizontal" style="margin-left:10%">Ask A Question</a>
    </div>
  </div>
</div>
<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
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
</HTML>