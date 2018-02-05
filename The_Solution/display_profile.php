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