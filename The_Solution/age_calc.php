<?php
function GetAge($dob) 
{ 
        $dob=explode("/",$dob); 
        $curMonth = date("m");
        $curDay = date("j");
        $curYear = date("Y");
        $age = $curYear - $dob[2]; 
        if($curMonth<$dob[1] || ($curMonth==$dob[1] && $curDay<$dob[2])) 
                $age--; 
        return $age; 
}
?>

