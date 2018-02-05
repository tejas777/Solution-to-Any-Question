<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Submit_Login'])) {
  $Email = test_input($_POST["Email"]);
  $Password = test_input($_POST["Password"]);

  include 'connection.php';
  $sql = "select * FROM User_Data where Email= '$Email' AND Password = '$Password' LIMIT 1";
  $res = mysql_query($sql);
  $row = mysql_fetch_array($res);
  if ($row['Email'] == $Email && $row['Password'] == $Password) {
    session_start();
    $_SESSION["Email"] = $Email;
    $_SESSION["Name"] = $row['Name'];

    $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Attempt: ".($result['Email']==$Email && $result['Password']==$Password ?'Success':'Failed').PHP_EOL.
            "User: ".$Email.PHP_EOL.
            "Pass: ".$Password.PHP_EOL.
            "-------------------------".PHP_EOL;
    //-
    file_put_contents('./log.txt', $log, FILE_APPEND);
    

    header( 'Location: user_page.php' );
  }
  else{
    $message = "Invalid Info";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  mysql_close($conn);
}

if (isset($_POST['Submit_SignUp'])) {

  $Name = test_input($_POST['Name']);
  $Email = test_input($_POST['Email']);
  $Password = test_input($_POST['Password']);
  $Confirm_Password = test_input($_POST['Confirm_Password']);
  $Gender = test_input($_POST['Gender']);
  $Mobile = test_input($_POST['Mobile']);
  $Birthday = test_input($_POST['Birthday']);
  $Checkbox = implode(',', $_POST['Topic']);

  include 'connection.php';
  $Image_Name=$_FILES["Image"]["name"]; 
  $Image=addslashes (file_get_contents($_FILES['Image']['tmp_name']));
  $sql = "SELECT Email,Name FROM user_data WHERE Email = '$Email' LIMIT 1";
  $query=mysql_query($sql,$conn);
  $row = mysql_fetch_array($res);
  if (!($row['Email'] == $Email)) {
    
    if (!($row['Name'] == $Name)){
  
      if ($Confirm_Password == $Password) {
        $sql = "INSERT INTO user_data(Email,Password,Name,Birthday,Mobile_No,Gender,Profile_Pic,Checkbox) values ('$Email','$Password','$Name','$Birthday','$Mobile','$Gender','$Image','$Checkbox')";
        $query=mysql_query($sql,$conn);
        session_start();
        $_SESSION["Email"] = $Email;
        $_SESSION["Name"] = $Name;

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                   // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                            // Enable SMTP authentication
$mail->Username = 'solutionservice30@gmail.com';          // SMTP username
$mail->Password = 'Solution@123'; // SMTP password
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                 // TCP port to connect to

$mail->setFrom('solutionservice30@gmail.com', 'The Solution');
//$mail->addReplyTo('email@codexworld.com', 'CodexWorld');
$mail->addAddress($Email);   // Add a recipient
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->isHTML(true);  // Set email format to HTML

$bodyContent = '<h1>Welcome to the World of <b>THE SOLUTION</b></h1>';
$bodyContent .= '<p><b>The Solution</b> welcomes you to the social network that brings world closer</p>';

$bodyContent .= '<p>Your User Name is '.$Name.'</p>';

$bodyContent .= '<p>Your Password is '.$Password.'</p>';

$mail->Subject = 'Welcome to The Solution';
$mail->Body    = $bodyContent;
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}



        header( 'Location: user_page.php' );
      }
      else{
          echo "<script>alert('Password Donot Match');</script>";
      } 
    }
    else{
        echo "<script>alert('Username is already existed.Please register with another User Name!.');</script>";
    }
  }
  else{
      echo "<script>alert('Email is already existed.Please register with another Email id!.');</script>";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>The Solution - Ask To Answer</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h1>The Solution</h1>
<h3>Ask To Answer</h3>
<div class="main_box">
  <h4>Login To <b>The Solution</b></h4>
  <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <input type="email" class="form-control" name="Email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="Password" placeholder="Enter password" required>
            </div>
            
              <button type="submit" class="btn btn-default" name="Submit_Login"><span class="glyphicon glyphicon-off"></span> Login</button>
  </form>
  <hr width="100">
  <footer>
    <ul>
    <li><a href="#" id="myBtn1">About Us</a></li><li class="item animated flash"><a href="#" id="myBtn2"><b>Sign Up</b></a></li><li><a href="#" id="myBtn3">Developers</a></li>
    </ul>
  </footer>
-</div>
<div class="modal fade" id="myModal2" role="dialog" style="margin-top:-5%">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Create your <b>The Solution</b> Account </h4>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <input type="text" class="form-control" name="Name" pattern="^[a-zA-Z]+\s?[a-zA-Z]{1,20}" placeholder="Username" title="Only Alphbets are allowed with 1 space not in start and max lenght of Username is 20" required>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="Email" placeholder="Email" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="Password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control" name="Confirm_Password" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="Mobile" maxlength="10" pattern="[7-9]{1}[0-9]{9}" title="Enter Valid Mobile No starting with 7,8 or 9" placeholder="Mobile No" required>
            </div>
            <div class="radio">
             <b>Gender : </b>
            <label><input type="radio" name="Gender" value="Male" required> Male&nbsp;&nbsp;</label>
            <label><input type="radio" name="Gender" value="Female" required> Female</label>
            </div>
            <div class="form-group">
              <input type="date" class="form-control" name="Birthday" placeholder="dd/mmy/yyyy" required>
            </div>
            <div class="form-group">
                  <label for="Image">Upload Profile Pic</label> <input type="file" name="Image">
            </div>



            <div class="checkbox" style="font-size:14px">
             <b>Topics of Interest : </b><br/>
            <label><input type="checkbox" name="Topic[]" value="Entertainment"> Entertainment&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Education"> Education&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Lifestyle"> Lifestyle&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Fashion"> Fashion&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Politics"> Politics&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Sports"> Sports&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Technology"> Technology&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Culture"> Culture&nbsp;&nbsp;</label>
            <label><input type="checkbox" name="Topic[]" value="Others"> Others&nbsp;&nbsp;</label>
            </div>




              <button type="submit" class="btn btn-default" name="Submit_SignUp">Lets Get Started!</button>
          </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Developers - <b>The Solution</b></h4>
        </div>
        <div class="modal-body">
        <div class="container">
          <span class="col-sm-4"><img src="/The_Solution/Developers/Tejas.jpg"/><figcaption>Tejas Sangani</figcaption></span>
          <span class="col-sm-4"><img src="/The_Solution/Developers/dev.jpg"/><figcaption>Dev Oswal</figcaption></span>
          <span class="col-sm-4"><img src="/The_Solution/Developers/madhura.jpg"><figcaption>Madhura Chougule</figcaption></span>
          </div>
        </div>
      </div>
    </div>
  </div> 
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2><b>The Solution</b> Ask To Answer </h2>
        </div>
        <div class="modal-body">
          <h3 style="text-align:center;">Why <b>The Solution</b> Exists</h3>
          <p style="align:left;font-size:18px;line-height:30px;font-family:Verdana;margin-top:-50px;"><b>The Solution</b> mission is to share and grow the world's knowledge. A vast amount of the knowledge that would be valuable to many people is currently only available to a few either locked in people's heads, or only accessible to select groups. We want to connect the people who have knowledge to the people who need it, to bring together people with different perspectives so they can understand each other better, and to empower everyone to share their knowledge for the benefit of the rest of the world.</p>
      </div>      
    </div>
  </div> 
</div>
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
</body>
</html>
