<?php

$vals_user_info.= " '".$_POST["surveyid"]."',";
$vals_user_info.= " '".$_POST["date"]."', '".$_POST["joining_date"]."', '".$_POST["country"]."', '".$_POST["has_profile"]."', ";
$vals_user_info.=" '".$_POST["belongs_team"]."', ".$_POST["forum_entries"].", ".$_POST["total_credit"].", ".$_POST["expavg_credit"].", ".$_POST["number_hosts"];


$con = mysql_connect("localhost","boinc","B01nc1sFun");
  if (!$con){
      die('Could not connect: ' . mysql_error());
  }

    mysql_select_db("docking", $con);
    if($_POST["hastaken"]==1){
       mysql_query('delete fom survey where userid='.$_POST["userid"]);
    }
    if($_POST["age"]=='underage'){
    
       mysql_query( "insert into survey values (".$_POST["userid"].", 1, ".$_POST["surveyid"].", '".$_POST["newdate"]."', 1)");

    }else{
    
    mysql_query( "insert into survey values (".$_POST["userid"].", 0, ".$_POST["surveyid"].", '".$_POST["newdate"]."', ".$_POST["medal"].")");
  
  
    mysql_select_db("exscitech", $con);

    mysql_query("INSERT INTO user_info (surveyid, date, joining_date, country, has_profile, belongs_team, forum_entries, total_credit, expavg_credit, number_hosts) VALUES ($vals_user_info)");
  
    $resultid = mysql_query("SELECT LAST_INSERT_ID() AS lastInsertID FROM user_info"); 

    if ($rowid = mysql_fetch_array($resultid)){
	  

		$vals_survey=$rowid['lastInsertID'].", '".$_POST["surveyid"]."',";
		$vals_survey.="'".$_POST["age"]."', '".$_POST["participatedah1"]." ".$_POST["top1other"]."', '".$_POST["participatedah2"]." ".$_POST["top2other"]."', '".$_POST["participatedah3"]." ".$_POST["top3other"]."',";
		$vals_survey.=" '".$_POST["heardah"]." ".$_POST["hearother"]."', '".$_POST["interestcomputers"]."', '".$_POST["interestmath"]."', '".$_POST["interesteng"]."',";
		$vals_survey.=" '".$_POST["interestscience"]."', '".$_POST["contributevc"]."', '".$_POST["student"]."', '".$_POST["major"]." ".$_POST["majorother"]."',";
		$vals_survey.=" '".$_POST["ocupfield"]." ".$_POST["fieldother"]."', '".$_POST["career"]."', '".$_POST["degree"]."', '".$_POST["course"]."', '".$_POST["ethnic"]."',";
		$vals_survey.=" '".$_POST["gender"]."', '".$_POST["suggestions"]."'";
		
		mysql_query("INSERT INTO survey VALUES ($vals_survey)");
		
    } 
    }

  mysql_close($con);
  

?>

<p>Thanks!</p>


