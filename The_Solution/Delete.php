<?php
include('session_handling.php');
include('connection.php');
	if(isset($_GET['Ques_Id'])){
		$Question_Id = $_GET['Ques_Id'];
        if($_GET['Name'] == $Name){
    
            $sql = "SELECT * FROM answer_bank WHERE Question_Id = '$Question_Id'";
            $result = mysql_query($sql);
        	while($key = mysql_fetch_array($result)) {

	  			$Answer_Id = $key['Answer_Id'];	
	        	$sql = "DELETE FROM likes WHERE Answer_Id = '$Answer_Id'";
                mysql_query($sql);
	            $sql = "DELETE FROM dislikes WHERE Answer_Id = '$Answer_Id'";
                mysql_query($sql);
            }

            $sql = "DELETE FROM view_later WHERE Question_Id = '$Question_Id'";
            mysql_query($sql);

            $sql = "DELETE FROM answer_bank WHERE Question_Id = '$Question_Id'";
            mysql_query($sql);
            
            $sql = "DELETE FROM question_bank WHERE Question_Id = '$Question_Id'";
            mysql_query($sql);
        }
	}
	echo "<script>alert('Question deleted Successfully');
		window.location.href='Your_Ques.php';
		</script>";
?>