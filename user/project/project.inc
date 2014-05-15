<?php

define("PROJECT", "Docking@Home");
define("PROJECT_BASE_FOLDER", "/boinc/projects/docking/");
define("PROJECT_HTML_FOLDER", PROJECT_BASE_FOLDER."html/");

require_once(PROJECT_HTML_FOLDER."inc/util.inc");
$master_url = parse_config(get_config(), "<master_url>");
define("URL_BASE", $master_url);
define("MASTER_URL", $master_url);
define("IMAGE_PATH", PROJECT_HTML_FOLDER."user_profile/images/");
define("IMAGE_URL", "user_profile/images/");
define("PROFILE_PATH", PROJECT_HTML_FOLDER."user_profile/");
define("PROFILE_URL", "user_profile/");
define("LANGUAGE_FILE", PROJECT_HTML_FOLDER."user/includes/languages.txt");
define("STYLESHEET", "/includes/css/v2.css");
define("COPYRIGHT_HOLDER", "University of Delaware");
define("SYS_ADMIN_EMAIL", "dockingadmin@cis.udel.edu");
define("FORUM_MODERATION_EMAIL_USER_ID", "dockingadmin@cis.udel.edu");
define("EMAIL_FROM", "dockingadmin@cis.udel.edu");
define("EMAIL_FROM_NAME", "Docking@Home Admin");
define("UOTD_ADMIN_EMAIL", "dockingadmin@cis.udel.edu");
define("POST_REPORT_EMAILS", "dockingadmin@cis.udel.edu");
//define('INVITE_CODES', '/D@CK!NG/');
//The email/mailinglist that will receive user reported forum posts
// (offensive etc.)
$forum_post_reporting_admin->email_addr="dockingadmin@cis.udel.edu";


// This is enables user specific global variables! 
// This file should be included on all pages
session_start();

function gotoLocation($location){
	header("Location: ".$location);
	exit;
}

function displayMessages() {
  displayMessage("announcement");
  displayMessage("error");
  displayMessage("notice");
}

function displayMessage($type) {
  if ($type == "announcement" || $type == "error" || $type == "notice") {
    $message = getMessage($type);
    if(!empty($message))
      print "<div id=\"$type\">$message</div>\n";
  }
}

function getMessage($type) {
  if ($type == "announcement" || $type == "error" || $type == "notice") {
    if (array_key_exists($type,$_SESSION)) {
      $message = $_SESSION[$type];
      if (!empty($message)) {
        $_SESSION[$type] = "";
        return $message;
      }
    }
  }
  return "";
}

function setMessage($type,$message) {
  if ($type == "announcement" || $type == "error" || $type == "notice")
	  $_SESSION[$type]=$message;
}

function any_form_errors() {
	global $form_errors;
	return isset($form_errors);
}

function add_form_error($field,$message) {
	global $form_errors;
	if (has_form_error($field)) {
		$form_errors[$field] .= "<br />".$message;
	}
	else {
		$form_errors[$field] = $message;
	}
}

function display_form_error($field) {
	global $form_errors;
	if (has_form_error($field))
		echo "<br /><span class=\"field_error\">".$form_errors[$field]."</span>";
}

function display_post_value($field) {
	if (array_key_exists($field,$_POST))
		print $_POST[$field];
}

function has_form_error($field) {
	global $form_errors;
	return isset($form_errors,$form_errors[$field]);
}

function glossary_link($concept) {
  return "<a href=\"/about/glossary.php?concept=".urlencode($concept)."&keepThis=true&TB_iframe=true&height=300&width=500\" class=\"thickbox\">$concept</a>";
}

function update_jmol_file($current_file,$db_file) {
  $replace=1;
        if(file_exists($current_file)){
	   if((time()-(3600*24))>filemtime($current_file)) $replace=1;
	   else $replace=0;
           $replace=0;
	}
	if($replace==1){
	   $fp=fopen($current_file,'w');
	   fwrite($fp,$db_file);
	   fclose($fp);
	}
}

function get_best_results_item($row) {
  $result["complex"] = $row["complex"];
	$result["model"] = $row["model"];
	$result["pf"] = $row["pf"];
	$result["pdb_file"] = $row["pdb_file"];
	$result["rmsd"] = $row["rmsd"];
	$result["user_name"] = "";
	$result["user_thumbnail"] = "";
	$result["user_text"] = "";

	$result["protein_file"] = "/results/".$result["complex"]."_complex.pdb";
	$result["protein_file_exists"] = file_exists($_SERVER['DOCUMENT_ROOT'].$result["protein_file"]);
	$result["ligand_file"] ="/results/".$result["complex"]."_".$result["model"]."_".$result["pf"].".pdb";
	$result["ligand_file_exists"] = file_exists($_SERVER['DOCUMENT_ROOT'].$result["ligand_file"]);
  

	$userid = $row["userid"];
 	if($userid>0){
 	  $user = BoincUser::lookup_id($userid);
 	  $result["user_name"] = $user->name;
 		$profile=get_profile($userid);
 		if ($profile) {
 			$result["user_thumbnail"] = uotd_thumbnail($profile, $user);
 			$result["user_text"] = sub_sentence(output_transform(strip_tags($profile->response1)), ' ', 300, true);
 		}
 	}
	
  return $result;
}

function get_best_results() {
  $qminrmsd = mysql_query("select id, rmsd, energy, dresult, pdb_file, complex, model, pf, userid from dock_best order by model, complex, pf");
  if($qminrmsd){
    $i = 0;
    while($row = mysql_fetch_array($qminrmsd)){
    	$current_result = get_best_results_item($row);
    	update_jmol_file($_SERVER['DOCUMENT_ROOT'].$current_result["ligand_file"],$current_result["pdb_file"]);
    	$results[$i++] = $current_result;
    }
  }
  return $results;
}

function get_best_results_model($model) {
  $qminrmsd = mysql_query("select id, rmsd, energy, dresult, pdb_file, complex, model, pf, userid from dock_best where model='".$model."' order by complex, pf");
  if($qminrmsd){
    $i = 0;
    while($row = mysql_fetch_array($qminrmsd)){
        $current_result = get_best_results_item($row);
        update_jmol_file($_SERVER['DOCUMENT_ROOT'].$current_result["ligand_file"],$current_result["pdb_file"]);
        $results[$i++] = $current_result;
    }
  }
  return $results;
}

function get_models() {
  $qminrmsd = mysql_query("select distinct(model) from dock_best order by model");
  if($qminrmsd){
    $i = 0;

echo "<table>
           <tr><td style=\"vertical-align:top;\">
           <h4>Models:</h4>
           <p>";

    while($row = mysql_fetch_array($qminrmsd)){
        $models[$i++] = $row["model"];
        echo "<a href=\"bestresults.php?model=".$row["model"]."\">".$row["model"]."</a><br />";
    }
    echo "</td></tr></table><hr>";

  }
  return $models;
}



function display_best_result_item($result) {
  echo "<h2>Complex: ".$result["complex"]." - Model: ".$result["model"]."</h2>";
	
	echo "<table> 
	   <tr><td style=\"padding:0px;vertical-align:top;\">
	   <h4>Information</h4>
	   <p>
	   Force field: ".$result["pf"]."<br />
   	 RMSD: ".$result["rmsd"]."<br />";
	if ($result["protein_file_exists"]) {
		 echo "<a href=\"/about/science/show_jmol.php?type=protein&file=".$result["protein_file"]."&jwidth=600&keepThis=true&TB_iframe=true&height=605&width=600\" 
		 	title=\"Complex: ".$result["complex"]."\"
		 	class=\"thickbox\">
		 	View Protein
		 </a><br />";
	}
	echo "<!--<script>
		 jmolSetAppletColor(\"white\");
		 jmolApplet(300,\"load results/".$result["protein_file"]."\");
		 </script>-->";
  
	if ($result["ligand_file_exists"]) {
	   	 echo "<a href=\"/about/science/show_jmol.php?type=ligand&file=".$result["ligand_file"]."&jwidth=600&keepThis=true&TB_iframe=true&height=605&width=600\" 
		 	title=\"Ligand: ".$result["complex"]."\"
		 	class=\"thickbox\">
		 	View Ligand
		 </a>";
	}
	echo "<!--<script type=\"text/javascript\">
		 jmolSetAppletColor(\"white\");
		 jmolApplet(400,\"load ".$result["ligand_file"]."\");
		 </script>-->";
  echo "</p></td><td style=\"padding:0px;vertical-align:top;\">";
  if (!empty($result["user_name"])) {
    echo "
      <h4>User</h4>
  	  <p>
  	  <b>".$result["user_name"]."</b><br />
  	  ".$result["user_thumbnail"]."
  	  ".$result["user_text"]."
  	  </p>";
  }
	echo "</td></tr></table>";
}



function display_best_results() {
  foreach(get_best_results() as $result) {
    display_best_result_item($result);
  }
}

function display_best_results_model($model) {
  foreach(get_best_results_model($model) as $result) {
    display_best_result_item($result);
  }
}


function display_having_trouble() {
echo <<<HTML
<h3>Having Trouble?</h3>
<p>If you’ve encountered an issue or have any questions regarding Docking@Home or BOINC, there are several places to look for answers:</p>
<ul>
    <li>The <a href="/support/faq.php">Docking@Home FAQ</a>: Maybe your problem is a common one. There are lots of answers here.</li>
    <li>The <a href="/community/forum/">Docking@Home Message Boards</a>: If your question wasn’t answered in the FAQ, chances are it has been on the message board. And if it hasn’t, ASK! The veterans and staff members would love to help.</li>
    <li>The <a href="http://boinc.berkeley.edu/wiki/" target="_blank">BOINC Wiki</a>: A good place to look for all things BOINC.</li>
    <li><a href="http://boinc.berkeley.edu/help.php" target="_blank">BOINC Live Help / Email</a>: Lets you talk one-on-one with experienced BOINC users. Volunteers speaking many languages are available! Note: The live help uses <a href="http://www.skype.com/" target="_blank">Skype</a>, which will need to be downloaded and installed on your computer.</li>
    <li><a href="/status/">Docking@Home Server Status Page</a>: Check to see if you aren’t getting any work because there is a problem on our end.</li>
</ul>

HTML;
}

function get_current_cotd() {
  $db_c1 = BoincDb::get();
	$res_nc=$db_c1->do_query("select count(id) from docking_glossary");
	if ($row_nc = mysql_fetch_array($res_nc)) {
		$var_time=round(time()/(60*60*24));
    $conceptid = ($var_time % $row_nc[0])+1;
    if ($conceptid>0) {
			$res_concept=$db_c1->do_query("select concept, definition from docking_glossary where id=$conceptid");
			if ($row_concept = mysql_fetch_array($res_concept)) {
        $concept = $row_concept[0];
        $definition = $row_concept[1];
				if(strlen($definition)>200){
					 $definition = substr( $definition, 0, 200 )." ... ";
				}
			}
      $cotd["concept"] = glossary_link($concept);
      $cotd["definition"] = $definition;
    }
	}
	return $cotd;
}

function display_cotd() {
  $cotd = get_current_cotd();
  echo "<h5>".$cotd["concept"]."</h5>";
  echo "<p>".$cotd["definition"]."</p>";
}

function uotd_homepage_thumbnail($profile, $user) {
    if ($profile->has_picture) {
        return "<a href=".URL_BASE."community/view_profile.php?userid=$user->id><img id=\"homepage_uotd_img\"  src=\"".URL_BASE.IMAGE_URL.$user->id."_sm.jpg\" /></a>";
    } else {
        return "";
    }
}

function get_current_uotd_profile() {
  $profile = get_current_uotd();
  if ($profile) {
      $user = lookup_user_id($profile->userid);
      $uotd["name"] = $user->name;
      $uotd["thumbnail"] = uotd_homepage_thumbnail($profile, $user);
      $stringprf= sub_sentence(output_transform(strip_tags($profile->response1)), ' ', 300, true);
  }
  $stringprf = str_replace("<img ", "<img width=\"150\" ", $stringprf);
  $uotd["text"] = $stringprf;
  return $uotd;
}

function display_uotd() {
  $uotd = get_current_uotd_profile();
  echo $uotd["thumbnail"];
  echo "<p><b>".$uotd["name"]."</b></p>";
  echo "<p>".$uotd["text"]."</p>";
  echo "<div class=\"clear\">&nbsp;</div>";
}

function display_page_top_jmol($title, $java_onload=null, $title_plain=null, $prefix="") {
  display_page_top($title,$java_onload,$title_plain,$prefix,true);
}

function display_page_top($title, $java_onload=null, $title_plain=null, $prefix="", $jmol=false) {
if (!isset($_SERVER,$_SERVER['REQUEST_URI'])) {
  echo "<? require(\"".PROJECT_HTML_FOLDER."project/project.inc\"); ?>";
}
echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>$title</title>
HTML;
  if (isset($_SERVER,$_SERVER['REQUEST_URI'])) {
    require(PROJECT_HTML_FOLDER."user/includes/head.php");
  }
  else {
    echo "<? require(\"".PROJECT_HTML_FOLDER."user/includes/head.php\"); ?>";
  }
  if ($jmol) {
    echo "<script src=\"/jmol/Jmol.js\" type=\"text/javascript\"></script>\n";
  }
echo <<<HTML
</head>
  
HTML;
  if ($java_onload) {
    echo "<body onload=\"$java_onload\">\n";
  }
  else {
    echo "<body>\n";
  }
  if ($jmol) {
    echo "<script type=\"text/javascript\">jmolInitialize(\"jmol\");</script>\n";
  }
  if (isset($_SERVER,$_SERVER['REQUEST_URI'])) {
    require(PROJECT_HTML_FOLDER."user/includes/header.php");
  }
  else {
    echo "<? require(\"".PROJECT_HTML_FOLDER."user/includes/header.php\"); ?>";
  }
echo <<<HTML
    <div id="content">
      <h1 id="title">$title</h1>
HTML;
}

function display_page_bottom() {
  echo "</div>";
  if (isset($_SERVER,$_SERVER['REQUEST_URI'])) {
    require(PROJECT_HTML_FOLDER."user/includes/footer.php");
  }
  else {
    echo "<? require(\"".PROJECT_HTML_FOLDER."user/includes/footer.php\"); ?>";
  }
  echo "</body>\n</html>";
}

function page_head($title, $java_onload=null, $title_plain=null, $prefix="") {
  display_page_top($title, $java_onload, $title_plain, $prefix);
}


function page_head_jmol($title, $java_onload=null, $title_plain=null, $prefix="") {
  display_page_top_jmol($title, $java_onload, $title_plain, $prefix);
}

function project_banner($title) {
echo " <center><a href=\"".URL_BASE."\"><img src=/img/dockinghdr.jpg width=90%></a></center>\n";
echo " <table width=\"90%\" align=center>\n
          <tr>\n
            <td><h2>$title</h2></td>\n
            <td align=right></td>\n
          </tr>\n
       </table>\n
       <table class=tables white-space= \"normal\" width=\"90%\" align=center cellpadding=5>\n
         <tr><td>\n
    ";
}

function project_footer($show_return, $show_date) {
    echo "  </td></tr>
          </table>";

    if ($show_return) {
        echo "<br><center><a href=".URL_BASE.">Return to ".PROJECT." main page</a></center><br>\n";
    }

    echo "<br><br><center>";
    echo "<div id=\"footer\"><br><font size=4 color=ffffff>";
    echo "Copyright &copy; ".date("Y ").COPYRIGHT_HOLDER."
           <br><a href=\"http://www.mozilla.com/firefox\" target=\"_blank\">This site is best viewed with Firefox</a></center></font>\n";
    if ($show_date) {
        echo "<font size=-2 color=bbbbbb>Generated ",time_str(time()),"</font>\n";
    }

    	echo"<!--Footer end-->
          <div id=\"bottom_line\"></div>";
	echo "</div></div>";
}

function show_profile_heading1() {
    return "Your personal background.";
}

function show_profile_question1() {
    return "
        Tell us about yourself.
        You could tell us where you're from, your age, occupation, hobbies,
        or anything else about yourself.
    ";
}

function show_profile_heading2() {
    return "Your opinions about " . PROJECT;
}

function show_profile_question2() {
    return "
        Tell us your thoughts about " . PROJECT . "<ol>
        <li>Why do you run " . PROJECT . "?
        <li>What are your views about the project?
        <li>Any suggestions?
        </ol>
    ";
}

function project_workunit($wu){
    //echo "This is displayed on the workunit page";
}

function project_user_summary($user){
    //echo "Text here will go to the user summary page";
}

function project_user_page_private($user){
    //echo "Whatever is here is added to the private account page";
}

function project_user_credit($user){
    //echo "Whatever is here is added to the private account page";
}

function project_forum_post_rules() {
    // Add <li> entries for additional forum post rules
    return "
    ";
}


// This query defines the set of users eligible to be UOTD.
// To override this with your own policy, create a similar function in
// your own project.inc called uotd_candidates_query()
//
/*
function uotd_candidates_query(){
    $query = "SELECT * FROM profile,user WHERE profile.userid=user.id ";
    $query .= " AND verification=1 ";
    $query .= " AND expavg_credit>1 ";
    $query .= " AND uotd_time IS NULL ";
    $query .= "ORDER BY RAND()";
    return $query;
}*/

?>
