<?php
if(isset($_GET["Answer_Id"]))
    {
    	$Answer_Id = $_GET["Answer_Id"];
    	
        include 'connection.php';
        include 'session_handling.php';     
        $sql = "SELECT * FROM likes WHERE User = '$Name' AND Answer_Id = '$Answer_Id'";
	    if(mysql_num_rows(mysql_query($sql))<1){
		$sql = "INSERT INTO likes(Answer_Id,User) VALUES ('$Answer_Id','$Name')";
        if(mysql_query($sql)){
           
            echo "<script>alert('You have like this article Succesfully!!!');
            window.history.back();
            </script>"; 
        }
	    }
	    else{
		echo "<script>alert('You have already liked this article');
		window.history.back();
		</script>";
            }
        
         

	}
   
?>
