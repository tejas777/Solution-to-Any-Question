<?php
	if (isset($_GET['id'])) {
		$Question_Id = $_GET['id'];
		include 'connection.php';
        include 'session_handling.php';     
        $sql = "SELECT * FROM view_later WHERE User = '$Name' AND Question_Id = '$Question_Id'";
	    if(mysql_num_rows(mysql_query($sql))<1){
	    	$sql = "INSERT INTO view_later (User,Question_Id) VALUES ('$Name','$Question_Id')";
	    	if(mysql_query($sql)){
				echo "<script>alert('You Bookmarked this Article');
				window.location.href='user_page.php';
				</script>";
			}
	    }
	    else{
				echo "<script>alert('You already Added this article to View Later');
				window.location.href='user_page.php';
				</script>";
		}
	}
?>