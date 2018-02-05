<?php
include('db.php');
$collection = $db->user_data;
$q=$_POST['search'];
$regex = new MongoRegex("/^$q/i");
$result =$collection->find(array('User' => $regex));

foreach($result as $row){
	$username=$row['User'];
/*$b_username='<strong>'.$q.'</strong>';
$final_username = str_ireplace($q, $b_username, $username);*/
?>
<div>
<span class="user"><img src="/The_Solution/Profile_Pic/<?php echo $row['Image'];?>" width="42px" height="42px" style="border-radius:50%"/>
                    &nbsp;&nbsp;&nbsp;<a href="view_profile.php?Name=<?php echo $row['User']?>"><?php echo $username; ?>	</a></span>
</div><?php
} ?>
<style type="text/css">
	.user{
  		padding: 10px;
  		font-size: 17px;
  		margin-left:50px;
	}
</style>

 