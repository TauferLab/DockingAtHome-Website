<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/forum.inc");

// show the home page of logged-in user or account help
$user = get_logged_in_user(false);
if ($user) {
	
	$between_surveys=3*30*24*3600;
	if($user->teamid>0){
		$belongs_team1=1;
	}else{
		$belongs_team1=0;
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

	
	<title>Exscitech survey</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/control.js"></script>
	<script type="text/javascript" src="js/dynamicDropDown2.js"></script>
	
	
<?php

   //==========================================================
   

    $con = mysql_connect("localhost","boinc","B01nc1sFun");
    if (!$con){
        die('Could not connect: ' . mysql_error());
    }

    mysql_select_db("docking", $con);

    $result1 = mysql_query( "SELECT num_surveys, dont_bother, unix_timestamp(date) as unixdate from survey where userid=".$user->id ); 

    $nosurvey=0;
    
    if ($row1 = mysql_fetch_array($result1) ){
	   if($row1["dont_bother"]==0){
	       //update date
	       $newdate=time()+$between_surveys;
	       if($row1["unixdate"] < time()+$between_surveys){
	           $nosurvey=1;
	           $msg="<b>You already filled out our survey. Thank you for your participation!</b>";
	       }else{
	       		$newdate=time()+$between_surveys;
	       		$surveyid=$row1["num_surveys"]+1;
	       }
	       
	   }else{
	       $nosurvey=1; 
	   }
	   $hastaken=1;
	}
    else{
       $surveyid=1;
       $newdate=time()+$between_surveys;
       $hastaken=0;
    }
    
    //====================================================
    
    display_page_top("Docking@Home survey");

    
if($nosurvey==1){

echo"<p>$msg</p>";


}else{

?>
			
		</div>
<div>
	<p>Dear <?=$user->name;?>,</p>
 
    <p>The purpose of this survey is to help improve Docking@Home and to attract more people to volunteer. 
       Please take the next minute to share your experiences with Docking@Home. Your participation is voluntary 
       and your responses will be confidential. Individuals will not be identified and only summarized results 
       will be reported. After you complete the survey, you may choose to have Docking@Home place a medal onto 
       your profile as a way of acknowledging your contribution to the project. If you have any questions or concerns, 
       please contact us at <b>dockingadmin@cis.udel.edu</b>
    </p>
 
    <p>Thank you very much for your help with improving Docking@Home!</p><hr>

       <form action="savesurvey.php" method="post">

		<fieldset>
		
		<?php
		
	
			echo"<input type='hidden' name='userid' value='".$user->id."' >";
			echo"<input type='hidden' name='hastaken' value='".$hastaken."' >";
			echo"<input type='hidden' name='newdate' value='".date('Y-m-d', $newdate)."' >";
	
	        echo"<input type='hidden' name='surveyid' value='".$surveyid."'>"; 
		    echo"<input type='hidden' name='date' value='".date('Y-m-d')."'>"; 
		    echo"<input type='hidden' name='joining_date' value='".date_str($user->create_time)."'>"; 
			echo"<input type='hidden' name='country' value='".$user->country."'>"; 
			echo"<input type='hidden' name='has_profile' value='".$user->has_profile."'>"; 
			echo"<input type='hidden' name='belongs_team' value='".$belongs_team1."'>"; 
			echo"<input type='hidden' name='forum_entries' value='".$posts."'>"; 
			echo"<input type='hidden' name='total_credit' value='".$user->total_credit."'>"; 
			echo"<input type='hidden' name='expavg_credit' value='".$user->expavg_credit."'>"; 
			echo"<input type='hidden' name='number_hosts' value='".$number_hosts1."'>"; 
		
		    
	     ?> 

				
		   <ol id="blockage" class="formset">
		   
		   <li><label for="age">Before we start, please identify your age group</label>
				<table>
				<tr>
				<td><input type="radio" name="age" value="underage" class="question0" /> Younger than 18</td>
				<td><input type="radio" name="age" value="18-22" class="question0" /> 18-22</td>
				<td><input type="radio" name="age" value="23-30" class="question0" /> 23-30</td>
				<td><input type="radio" name="age" value="31-45" class="question0" /> 31-45</td>
				<td><input type="radio" name="age" value="46-55" class="question0" /> 46-55</td>
				<td><input type="radio" name="age" value="Older-55" class="question0" /> Older than 55</td>
				</tr></table><br><hr>	
                   </li>
		   </ol>
		   
		   <ol id="blockexit" class="formset">
		   
		   <label for="exit"><b>Thank you very much for your willingness to participate. Unfortunately, we cannot take responses from people who are under 18 years old.</b></label><br>
		   <br><input type="submit" name="submit" value="Finish" class="submitbtn" />
		   
		   </ol>
		
			<ol id="block1" class="formset">
			
				<li><label for="participatedah">Select your TOP THREE reasons for participating in Docking@Home from the list below:</label>		
				<table>
				 <tr><td>Top 1</td><td>
					 <select id="participatedah1" name="participatedah1" onclick="NewListOther('participatedah1','participatedah2','top1other')" onkeypress="NewListOther('participatedah1','participatedah2','top1other')">
					<option value="I would like to help advance science in general" selected="selected">I would like to help advance science in general.</option>
					<option value="I am interested in the Docking@Home goals">I am interested in the Docking@Home goals.</option>
					<option value="My friends, family and/or colleagues approve of my participation">My friends, family and/or colleagues approve of my participation.</option>
					<option value="Other people I know are participating">Other people I know are participating.</option>
					<option value="I want to build a good reputation among volunteer computing participants">I want to build a good reputation among volunteer computing participants.</option>
					<option value="I want to advance my career">I want to advance my career.</option>
					<option value="I want to make new friends">I want to make new friends.</option>
					<option value="Participating in Docking@Home is fun">Participating in Docking@Home is fun.</option>
					<option value="Other">Other (please specify)</option>
					 </select> <input type=text id="top1other" name="top1other" value=""  size=40 style="display:none">
				   </td></tr>
				   
				 <tr><td>Top 2</td><td>
					 <select id="participatedah2" name="participatedah2" onclick="NewListOther('participatedah2','participatedah3','top2other')" onkeypress="NewListOther('participatedah2','participatedah3','top2other')">
					<option value="I would like to help advance science in general">I would like to help advance science in general.</option>
					<option value="I am interested in the Docking@Home goals" selected="selected">I am interested in the Docking@Home goals.</option>
					<option value="My friends, family and/or colleagues approve of my participation">My friends, family and/or colleagues approve of my participation.</option>
					<option value="Other people I know are participating">Other people I know are participating.</option>
					<option value="I want to build a good reputation among volunteer computing participants">I want to build a good reputation among volunteer computing participants.</option>
					<option value="I want to advance my career">I want to advance my career.</option>
					<option value="I want to make new friends">I want to make new friends.</option>
					<option value="Participating in Docking@Home is fun">Participating in Docking@Home is fun.</option>
					<option value="Other">Other (please specify)</option>
					 </select> <input type=text id="top2other" name="top2other" value=""  size=40 style="display:none">
				   </td></tr>
				   
				 <tr><td>Top 3</td><td>
					 <select id="participatedah3"  name="participatedah3" onclick="ShowField1('participatedah3','top3other')" onkeypress="ShowField1('participatedah3','top3other')">
					<option value="I would like to help advance science in general">I would like to help advance science in general.</option>
					<option value="I am interested in the Docking@Home goals">I am interested in the Docking@Home goals.</option>
					<option value="My friends, family and/or colleagues approve of my participation" selected="selected">My friends, family and/or colleagues approve of my participation.</option>
					<option value="Other people I know are participating">Other people I know are participating.</option>
					<option value="I want to build a good reputation among volunteer computing participants">I want to build a good reputation among volunteer computing participants.</option>
					<option value="I want to advance my career">I want to advance my career.</option>
					<option value="I want to make new friends">I want to make new friends.</option>
					<option value="Participating in Docking@Home is fun">Participating in Docking@Home is fun.</option>
					<option value="Other">Other (please specify)</option>
					 </select> <input type=text id="top3other" name="top3other" value="" size=40 style="display:none">
				   </td></tr>
				</table>
				</li><br><hr>
				
				
				
				<li><label for="heardah">How did you first hear about Docking@Home?</label>
			    <select id="heardah" name="heardah" onclick="ShowField1('heardah','hearother');" onkeypress="ShowField1('heardah','hearother');">
					<option value="Word of mouth" selected="selected">Word of mouth</option>
					<option value="Print media">Print media</option>
					<option value="TV">TV</option>
					<option value="Radio">Radio</option>
					<option value="Internet">Internet</option>
					<option value="Other:">Other (please specify)</option>
				</select> <input type=text id="hearother" name="hearother" value="" size=40 style="display:none">
				</li><br><hr>
				
				
				
				<li><label for="interestcomputers">How would you rate your interest in the study of computers?</label>
				<table>
				<tr>
				<td><input type="radio" name="interestcomputers" value="0" class="question4" /> Not interested at all</td>
				<td><input type="radio" name="interestcomputers" value="1" class="question4" /> Only slightly interested</td>
				<td><input type="radio" name="interestcomputers" value="2" class="question4" /> Moderately interested</td>
				<td><input type="radio" name="interestcomputers" value="3" class="question4" /> Very interested </td></tr>
				</table></li><br><hr>
				
				
				
				<li><label>Rate your interest in each of these fields listed below:</label>
				<table>
				<tr><td><label for="interestmath">Mathematics</label></td>
				<td><input type="radio" name="interestmath" value="0" class="question5a" /> Not interested at all</td>
				<td><input type="radio" name="interestmath" value="1" class="question5a" /> Only slightly interested</td>
				<td><input type="radio" name="interestmath" value="2" class="question5a" /> Moderately interested</td>
				<td><input type="radio" name="interestmath" value="3" class="question5a" /> Very interested </td></tr>
				
				<tr><td><label for="interesteng">Any of the Engineering Fields</label></td>
				<td><input type="radio" name="interesteng" value="0" class="question5b" /> Not interested at all</td>
				<td><input type="radio" name="interesteng" value="1" class="question5b" /> Only slightly interested</td>
				<td><input type="radio" name="interesteng" value="2" class="question5b" /> Moderately interested</td>
				<td><input type="radio" name="interesteng" value="3" class="question5b" /> Very interested </td></tr>
				
				<tr><td><label for="interestscience">Sciences</label></td>
				<td><input type="radio" name="interestscience" value="0" class="question5c" /> Not interested at all</td>
				<td><input type="radio" name="interestscience" value="1" class="question5c" /> Only slightly interested</td>
				<td><input type="radio" name="interestscience" value="2" class="question5c" /> Moderately interested</td>
				<td><input type="radio" name="interestscience" value="3" class="question5c" /> Very interested </td></tr>
				</table></li><br><hr>
				
				
				
	
				<li><label for="contributevc">How would you rate your ability to contribute to Volunteer Computing (VC)?</label>
				<table><tr>
				<td><input type="radio" name="contributevc" value="0" class="question6" /> Poor</td>
				<td><input type="radio" name="contributevc" value="1" class="question6" /> Fair</td>
				<td><input type="radio" name="contributevc" value="2" class="question6" /> Good</td>
				<td><input type="radio" name="contributevc" value="3" class="question6" /> Excellent </td></tr></table></li><br><hr>
				
				
				
				
				<li><label for="student">Are you a student (either full time or part time)?</label> 
				<table><tr>
				<td><input type="radio" name="student" value="Yes" class="question7" /> Yes </td>
				<td><input type="radio" name="student" value="No" class="question7" /> No </td>
				<td><input type="radio" name="student" value="NA" class="question7" /> Decline to respond </td>
				</tr></table></li>
			</ol>
			
			<ul id="majorfield" class="formset"><ol type="a">
				
				<li><label for="major">What is your academic major or intended major?</label> 
				<select id="major" name="major" onclick="ShowField1('major','majorother')" onkeypress="ShowField1('major','majorother')">
						<option value="Agriculture and related sciences" selected="selected">Agriculture and related sciences</option>
						<option value="Architecture and planning">Architecture and planning</option>
						<option value="Arts, visual and performing">Arts, visual and performing</option>
						<option value="Biological and biomedical sciences">Biological and biomedical sciences</option>
						<option value="Business">Business</option>
						<option value="Communication and journalism">Communication and journalism</option>
						<option value="Computer and information sciences">Computer and information sciences</option>		
						<option value="Cultures and languages">Cultures and languages</option>		
						<option value="Education">Education</option>
						<option value="Engineering and engineering technologies">Engineering and engineering technologies</option>
						<option value="Law and legal studies">Law and legal studies</option>	
						<option value="Library science">Library science</option>
						<option value="Math and statistics">Math and statistics</option>
						<option value="Mechanic and repair technologies">Mechanic and repair technologies</option>
						<option value="Natural resources and conservation">Natural resources and conservation</option>
						<option value="Personal care and culinary services">Personal care and culinary services</option>
						<option value="Physical Sciences">Physical Sciences</option>
						<option value="Psychology">Psychology</option>
						<option value="Public administration and social services">Public administration and social services</option>
						<option value="Science Technologies">Science Technologies</option>
						<option value="Social Science">Social Science</option>
						<option value="Other:">Other (please specify)</option>
					</select>  <input type=text id="majorother" name="majorother" value=""  size=40 style="display:none"></li><br>
			</ol></ul>
		
	
			
			
			<ol id="block2" class="formset" start="7">
			 	<hr>
				<li><label for="ocupfield">What is your current or intended occupational field?</label>
				<select id="ocupfield" name="ocupfield"  onclick="ShowField1('ocupfield','fieldother');" onkeypress="ShowField1('ocupfield','fieldother');">
							<option value="I do not have an occupational field" selected="selected">I do not have an occupational field.</option>	
							<option value="Agriculture">Agriculture</option>
							<option value="Architecture and drafting">Architecture and drafting</option>		
							<option value="Arts, visual and performing">Arts, visual and performing</option>
							<option value="Business and finance">Business and finance</option>
							<option value="Community and social services">Community and social services</option>		
							<option value="Computers">Computers</option>
							<option value="Construction">Construction</option>
							<option value="Education, museum work, and library science">Education, museum work, and library science</option>
							<option value="Engineering">Engineering</option>
							<option value="Environment">Environment</option>
							<option value="Health">Health</option>
							<option value="Installation and repair">Installation and repair</option>
							<option value="Law and government">Law and government</option>
							<option value="Management">Management</option>
							<option value="Media and communications">Media and communications</option>
							<option value="Office and administrative support">Office and administrative support</option>
							<option value="Personal care and culinary services">Personal care and culinary services</option>
							<option value="Physical and life sciences">Physical and life sciences</option>
							<option value="Sales">Sales</option>
							<option value="Social Science">Social Science</option>
							<option value="Sports and fitness">Sports and fitness</option>
							<option value="Transportation">Transportation</option>
							<option value="Other:">Other (please specify)</option>
					</select> <input type=text id="fieldother" name="fieldother" value=""  size=40 style="display:none"></li><br><hr>
					
					
					
					<li><label for="interestdah"> Has your experience as a volunteer with Docking@Home increased your interest in...</label>
					<table>
					<tr><td><label for="career">having a career working with computers?</label></td>
					<td><input type="radio" name="career" value="Yes" class="question8a" /> Yes </td>
					<td><input type="radio" name="career" value="No" class="question8a" /> No </td></tr>
					
					<tr><td><label for="degree">applying to a degree program in computer science?</label></td>
					<td><input type="radio" name="degree" value="Yes" class="question8b" /> Yes </td>
					<td><input type="radio" name="degree" value="No" class="question8b" /> No </td></tr>
					
					<tr><td><label for="course">taking a course involving computers?</label></td>
					<td><input type="radio" name="course" value="Yes" class="question8c" /> Yes </td>
					<td><input type="radio" name="course" value="No" class="question8c" /> No </td></tr>
					</table></li><br><hr>
					
					
					<li><label for="ethnic">Are you an ethnic <b>MAJORITY</b> in the country where you live?</label>
					<table>
					<td><input type="radio" name="ethnic" value="Yes" class="question9" /> Yes </td>
					<td><input type="radio" name="ethnic" value="No" class="question9" /> No </td></tr>
					</table></li><br><hr>
					
					
					
					<li><label for="gender">Are you </label>
					<table>
					<td><input type="radio" name="gender" value="Male" class="question10" /> Male </td>
					<td><input type="radio" name="gender" value="Female" class="question10" /> Female </td>
					<td><input type="radio" name="gender" value="Other" class="question10" /> Other </td></tr>
					</table></li><br><hr>
					
				
					
					<li><label for="suggestions">Please suggest improvement(s) for Docking@Home:</label><br>
					<textarea rows="3" cols="70"> </textarea></li><br><hr>
					
					
					
					<li><label for="medal">Would you like to have a medal placed onto your account? (You can also choose to remove the medal later.)</label>
					<table>
					<td><input type="radio" name="medal" value="1" class="qmedal" /> Yes </td>
					<td><input type="radio" name="medal" value="0" class="qmedal" /> No </td></tr>
					</table></li><br><hr>
				
					<input type="submit" name="submit" value="Submit" class="submitbtn" />
			</ol>	
			

		</fieldset>
		</form>

	</div>
		

<?php

}
}else{

display_page_top("Please log in");
}

display_page_bottom();


?>

