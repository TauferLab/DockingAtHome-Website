<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/countries.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/translation.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");

function process_country() {
	$country = post_str("country");
	if ($country == "") {
		$country = "International";
	}
	if (!is_valid_country($country)) {
		add_form_error("country","Invalid country");
	}
	return $country;
}

function process_email() {
	$new_email_addr = process_user_text(post_str("new_email_addr"));
	$new_email_addr = strtolower($new_email_addr);
	if (!is_valid_email_addr($new_email_addr)) {
		add_form_error("new_email_addr","Invalid email address:
			you must enter a valid address of the form
			name@domain"
		);
	}
	$user = lookup_user_email_addr($new_email_addr);
	if ($user) {
		add_form_error("new_email_addr","There's already an account with that email address.");
	}
	return $new_email_addr;
}

function process_invite_code() {
	$invite_code = process_user_text(post_str("invite_code"));
    if (strlen($invite_code)==0) {
    	add_form_error("invite_code",tra("You must supply an invitation code to create an account."));
    }
    if (!preg_match(INVITE_CODES, $invite_code)) {
        add_form_error("invite_code",tra("The invitation code you gave is not valid."));
    }
}

function process_name() {
	$new_name = process_user_text(post_str("new_name"));
	if (empty($new_name)) {
		add_form_error("new_name","You must supply a name for your account");
	}
	if ($new_name != strip_tags($new_name)) {
		add_form_error("new_name","HTML tags not allowed in name");
	}
	return $new_name;
}

function process_passwords($min_passwd_length,$new_email_addr){
	$passwd = stripslashes(post_str("passwd"));
	$passwd2 = stripslashes(post_str("passwd2"));
	if ($passwd != $passwd2) {
		add_form_error("passwd2","Passwords are different");
	}
	
	if (!is_ascii($passwd)) {
		add_form_error("passwd","Passwords may only include ASCII characters.");
	}
	
	if (strlen($passwd)<$min_passwd_length) {
		add_form_error("passwd",
			"Password is too short:
			minimum password length is $min_passwd_length characters."
		);
	}
	
	$passwd_hash = md5($passwd.$new_email_addr);
	return $passwd_hash;
}

function process_postal_code() {
	$postal_code = strip_tags(process_user_text(post_str("postal_code", true)));
	return $postal_code;
}

function display_internal_error($str) {
    //display_page_top("Can't create account");
    //echo "$str<br>\n";
    //echo BoincDb::error();
    //echo "<p>Click your browser's <b>Back</b> button to try again.\n<p>\n";
    //display_page_bottom();
    //exit();
	setMessage("error","$str<br>\n".BoincDb::error());
	gotoLocation(current_url());
}

$config = get_config();

$disabled = parse_bool($config, "disable_account_creation");
$wac = parse_bool($config, "web_account_creation");
$min_passwd_length = parse_element($config, "<min_passwd_length>");
if (!$min_passwd_length) {
	$min_passwd_length = 6;
}

$submitted = post_str("submit", true);

if ($submitted) {
	$auth = process_user_text(post_str("auth",true));
	$wizard = (empty($auth)?false:true);
	
	$config = get_config();
	if (parse_bool($config, "disable_account_creation")) {
		//display_page_top("Account creation is disabled");
		//echo "
		//    <h3>Account creation is disabled</h3>
		//    Sorry, this project has disabled the creation of new accounts.
		//    Please try again later.
		//";
		//exit();
		setMessage("error","Sorry, this project has disabled the creation of new accounts. Please try again later.");
		gotoLocation("/");
	}
	
	// see whether the new account should be pre-enrolled in a team,
	// and initialized with its founder's project prefs
	//
	$teamid = post_int("teamid", true);
	if ($teamid) {
		$team = lookup_team($teamid);
		$clone_user = lookup_user_id($team->userid);
		if (!$clone_user) {
			//echo "User $userid not found";
			//exit();
			add_form_error($form,"teamid","User $userid not found");
		}
		else {
			$project_prefs = $clone_user->project_prefs;
		}
	} else {
		$teamid = 0;
		$project_prefs = "";
	}
	
	if(defined('INVITE_CODES')) {
		process_invite_code();
	} 
	
	if ($wizard) {
		$name = process_name();
		$country = process_country();
		$postal_code = process_postal_code();
		
		if (!any_form_errors()) {
			$user = BoincUser::lookup("authenticator='$auth'");
			if (!$user) {
				display_internal_error("There was an error with the BOINC wizard. Please fill the entire form.");
			}
			$retval = $user->update("name='$name', country='$country', postal_code='$postal_code'");
			if (!$retval) {
				display_internal_error("There was an internal error. Please try again later.");
			}
			send_cookie('auth', $auth, true);
		}
	}
	else {
		$new_name = process_name();
		$new_email_addr = process_email();
		$passwd_hash = process_passwords($min_passwd_length,$new_email_addr);
		$country = process_country();
		$postal_code = process_postal_code();
		
		if (!any_form_errors()) {
			$user = make_user(
				$new_email_addr, $new_name, $passwd_hash,
				$country, $postal_code, $project_prefs, $teamid
			);
			if (!$user) {
				display_internal_error("Couldn't create account");
			}
			send_auth_email($user, true, false);
			send_cookie('auth', $user->authenticator, true);
		}
	}
	
	if (any_form_errors()) {
		setMessage("error","There was an error in your submission. Please correct and resubmit.");
	}
	else {
		if(defined('INVITE_CODES')) {
			error_log("Account '$new_email_addr' created using invitation code '$invite_code'");
		}
		
		send_cookie('init', "1", true);
		send_cookie('via_web', "1", true);
		$next_url = ($wizard?"/community/team/search.php":"/account/");
		gotoLocation($next_url);
	}
}
else {
	$wizard = false;
	$auth = process_user_text(get_str("auth", true));
	if ($auth) {
		$user = lookup_user_auth($auth);
		if ($user) {
			setMessage("notice","Welcome to the ".PROJECT." website! Please fill out this form to continue.");
			$wizard = true;
		}
		else {
			setMessage("error","Welcome to the ".PROJECT." website! There seems to have been an error with the BOINC wizard. Please fill out the full account creation form to continue.");
		}
	}
}

display_page_top(tra("Create an account"));
?>


<? if ($disabled) { ?>
<h1><? tra("Account creation is disabled"); ?></h1>
<p><? tra("Account creation is currently disabled. Please try again later."); ?></p>
<? 
    display_page_bottom();
    exit();
}?>



<? if (!$wac && !$wizard) { ?>
	<p><b><?= tra("NOTE: If you use BOINC version 5.2+ with the BOINC Manager, don't use this form. Just run BOINC, select Attach Project, and enter an email address and password."); ?></b></p>
<? } ?>

<p>
	<? $form="create_account"; ?>
	<form name="<?= $form ?>" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="hidden" name="form" value="<?= $form ?>" />
    <input type="hidden" name="auth" value="<?php if ($wizard) print $user->name; ?>" />
<?
if (!$wizard) {
	$teamid = get_int("teamid", true);
	if (!$teamid) $teamid = post_int("teamid", true);
	if ($teamid) {
		$team = lookup_team($teamid);
		$user = lookup_user_id($team->userid);
		if (!$user) {
			echo "<p>No such user</p>";
		} else {
			echo "<p><b>".tra("This account will belong to the team %1 and will have the project preferences of its founder.")."<a href=\"/community/team/display.php?teamid=$team->id\">$team->name</a></b><p>";
			echo "<input type=\"hidden\" name=\"teamid\" value=\"$teamid\" />";
		}
	}
}
?>
	<table>
		<?
        // Using invitation codes to restrict access?
        //
        if(defined('INVITE_CODES')) { ?>
        	<tr>
        		<td>
             		<?= tra("Invitation Code"); ?><br />
                    <span class="description"><?= tra("A valid invitation code is required to create an account."); ?></span>
                </td>
                <td>
                    <input type="text" name="invite_code" value="<? display_post_value("invite_code"); ?>" size="30" />
                    <? display_form_error("invite_code"); ?>
                </td>
            </tr>
        <? } ?>

        	<tr>
            	<td width="250">
            		<?= tra("Name"); ?><br />
                    <span class="description"><?= tra("Identifies you on our web site. Use your real name or a nickname."); ?></span>
                </td>
                <td>
            		<input type="text" name="new_name" value="<? display_post_value("new_name"); ?>" size="30" />
                    <? display_form_error("new_name"); ?>
                </td>
            </tr>
		<? if (!$wizard) { ?>
            <tr>
            	<td>
                	<?= tra("Email Address"); ?><br />
                    <span class="description"><?= tra("Must be a valid address of the form 'name@domain'."); ?></span>
                </td>
                <td>
            		<input type="text" name="new_email_addr" value="<? display_post_value("new_email_addr"); ?>" size="50" />
                    <? display_form_error("new_email_addr"); ?>
                </td>
            </tr>
            <tr>
            	<td>
                	<?= tra("Password"); ?><br />
                    <span class="description"><?= tra("Must be at least %1 characters", $min_passwd_length); ?></span>
                </td>
                <td>
            		<input type="password" name="passwd" value="<? display_post_value("passwd"); ?>" size="32" />
                    <? display_form_error("passwd"); ?>
                </td>
            </tr>
            <tr>
            	<td>
                	<?= tra("Confirm password"); ?>
                </td>
                <td>
                	<input type="password" name="passwd2" value="<? display_post_value("passwd2"); ?>" size="32" />
                    <? display_form_error("passwd2"); ?>
                </td>
            </tr>
		<? } ?>
            <tr>
            	<td>
                	<?= tra("Country"); ?><br />
                    <span class="description"><?= tra("Select the country you want to represent, if any."); ?></span>
                </td>
                <td>
            		<select name="country">
        				<? print_country_select(); ?>
        			</select>
                    <? display_form_error("country"); ?>
                </td>
			</tr>
            <tr>
            	<td>
                	<?= tra("Postal or ZIP Code"); ?><br />
                    <span class="description"><?= tra("Optional"); ?></span>
                </td>
                <td>
            		<input type="text" name="postal_code" value="<? display_post_value("postal_code"); ?>" size="20" />
                    <? display_form_error("postal_code"); ?>
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
                    <input type="submit" name="submit" value="<?= tra("Create account"); ?>">
                </td>
            </tr>
        </table>
	</form>
</p>
<? 
display_page_bottom();
?>
