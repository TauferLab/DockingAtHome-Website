<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
//require_once($_SERVER['DOCUMENT_ROOT']."/../inc/survey.inc");


function show_error() {
	setMessage("error","There was a problem logging in. Visit the <a href=\"/account/\">My Account</a> page if you need help.");
}

$next_url = get_str("next_url", true);
if (empty($next_url)) $next_url = post_str("next_url",true);
if (empty($next_url)) $next_url = "/account/";

$submitted = post_str("submit",true);

if ($submitted) {
	$email_addr = strtolower(process_user_text(post_str("email_addr", true)));
	$passwd = stripslashes(post_str("passwd", true));
	$id = get_int('id', true);
	$t = get_int('t', true);
	$h = get_str('h', true);
	if ($email_addr || $passwd) {
		if (empty($email_addr)) {
			show_error();
			add_form_error("email_addr","Email address is required.");
		}
		else {
			$user = lookup_user_email_addr($email_addr);
			if (!$user) {
				show_error();
				add_form_error("email_addr","No account found for this $email_addr");
			}
			else if (substr($user->authenticator, 0, 1) == 'x'){
				//User has been bad so we are going to take away ability to post for awhile.
				$error = "This account has been administratively disabled. Visit the <a href=\"/account/\">My Account</a> page if you need help.";
				setMessage("error",$error);
				add_form_error("email_addr","This account has been administratively disabled.");
			}
			else {
				if (empty($passwd)) {
					show_error();
					add_form_error("passwd","Password is required.");
				}
				else {
					$passwd_hash = md5($passwd.$email_addr);
					if ($passwd_hash != $user->passwd_hash) {
						$error = "Wrong password for $email_addr. Visit the <a href=\"/account/\">My Account</a> page if you need help.";
						setMessage("error",$error);
						add_form_error("passwd","Wrong password.");
					}
					else {
						$authenticator = $user->authenticator;
						$perm = $_POST['stay_logged_in'];
						send_cookie('auth', $authenticator, $perm);
						setMessage("notice","Successfully logged in.");
						gotoLocation($next_url);
					}
				}
			}
		}
	}
	else if ($id && $t && $h){
		// check for time/id/hash case.
		$user = BoincUser::lookup_id($id);
		if (!$user) {
			$error = "Invalid user ID. Please make sure you visited the complete URL (it may have been split across lines by your email reader).";
			setMessage("error",$error);
		}
		$x = $id.$user->authenticator.$t;
		$x = md5($x);
		$x = substr($x, 0, 16);
		if ($x != $h) {
			$error = "Invalid authenticator. Please make sure you visited the complete URL (it may have been split across lines by your email reader).";
			setMessage("error",$error);
		}
		else if (time() - $t > 86400) {
			$error = "Link has expired. Go <a href=\"/account/get_passwd.php\">here</a> to get a new login link by email.";
			setMessage("error",$error);
		}
		else {
                       $perm = $_POST['stay_logged_in']; 
			send_cookie('auth', $user->authenticator, $perm);
			setMessage("notice","Successfully logged in.");
			gotoLocation($next_url);
		}
	}
	else {
		// check for account key case.
		// see if key is in URL; if not then check for POST data
		//
		$authenticator = process_user_text(get_str("key", true));
		if (!$authenticator) {
		   $authenticator = process_user_text(post_str("authenticator", true));
		}
		if (!$authenticator) {
			show_error();
			add_form_error("email_addr","Email address is required.");
			add_form_error("passwd","Password is required.");
		}
		else if (substr($user->authenticator, 0, 1) == 'x'){
			//User has been bad so we are going to take away ability to post for awhile.
			$error = "This account has been administratively disabled. Visit the <a href=\"/account/\">My Account</a> page if you need help.";
			setMessage("error",$error);
		}
		else {
			$user = lookup_user_auth($authenticator);
			if (!$user) {
				$error = "No account was found. Visit the <a href=\"/account/\">My Account</a> page if you need help.";
				setMessage("error",$error);
			} else {
				$perm = $_POST['stay_logged_in'];
				send_cookie('auth', $authenticator, $perm);
				setMessage("notice","Successfully logged in.");
				gotoLocation($next_url);
			}
		}
	}
}
display_page_top("Login");
?>
<p>Not a member? <a href="/account/create_form.php">Create an account</a></p>
<p>
	<? $form="login"; ?>
	<form name="<?= $form ?>" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="hidden" name="form" value="<?= $form ?>" />
    <input type="hidden" name="next_url" value="<?= $next_url ?>" />
    <input type="hidden" name="stay_logged_in" value="1" />
	<table>
        <tr>
            <td>
                <?= tra("Email Address"); ?>
            </td>
            <td>
                <input type="text" name="email_addr" value="<? display_post_value("email_addr"); ?>" size="50" />
                <? display_form_error("email_addr"); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= tra("Password"); ?>
            </td>
            <td>
                <input type="password" name="passwd" value="<? display_post_value("passwd"); ?>" size="32" />
                <? display_form_error("passwd"); ?>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" name="submit" value="Login" />
            </td>
        </tr>
    </table>
	</form>
</p>
<? 
display_page_bottom();
?>

        
