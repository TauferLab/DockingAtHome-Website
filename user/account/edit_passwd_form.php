<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");

function process_passwords($min_passwd_length,$user){
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
	
	$passwd_hash = md5($passwd.$user->email_addr);
	return $passwd_hash;
}

function process_user($email_addr) {
	$auth = process_user_text(post_str("auth", true));
	$email_addr = strtolower(process_user_text(post_str("email_addr", true)));
	$old_passwd = stripslashes(post_str("old_passwd", true));
	
	if ($auth) {
    	$user = lookup_user_auth($auth);
		if (!$user) {
			add_form_error("auth","Invalid account key");
		} 
	}
	else {
		$user = lookup_user_email_addr($email_addr);
		if (!$user) {
			add_form_error("email_addr","No account with that email address was found");
		}
		else {
			$passwd_hash = md5($old_passwd.$email_addr);
			if ($user->passwd_hash != $passwd_hash) {
				add_form_error("old_passwd","Invalid password");
			}
		}
	}
	return $user;
}

db_init();
$user = get_logged_in_user(false);
$config = get_config();
$min_passwd_length = parse_config($config, "<min_passwd_length>");
if (!$min_passwd_length) $min_passwd_length = 6;
$submitted = post_str("submit", true);

if ($submitted) {
	$user = process_user();
	$new_passwd_hash = process_passwords($min_passwd_length,$user);
	if (any_form_errors()) {
		setMessage("error","There was an error in your submission. Please correct and resubmit.");
	}
	else {
		$result = $user->update("passwd_hash='$new_passwd_hash'");
		if ($result) {
			setMessage("notice","The password of your account has been changed.");
		} else {
			setMessage("error","There was an internal error. Password not updated.<br>\n".BoincDb::error());
		}
		gotoLocation("/account/");
	}
}

display_page_top("Change password");
?>
<p>
	<? $form="change_password"; ?>
	<form name="<?= $form ?>" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="hidden" name="form" value="<?= $form ?>" />
    <? if ($user) { ?>
    	<input type="hidden" name="auth" value="<?= $user->authenticator ?>" />
    <? } else { ?>
    <p>You can identify yourself using either:
        <ul>
            <li>Your email address and old password</li>
            <li>Your account key</li>
        </ul>
    </p>
    <? } ?>
	<table>
        <? if (!$user) { ?>
        <tr>
            <td>
                <?= tra("Email address"); ?>
            </td>
            <td>
                <input type="text" name="email_addr" value="<? display_post_value("email_addr"); ?>" size="50" />
                <? display_form_error("email_addr"); ?>
            </td>
        </tr>
        <tr>
        	<td>
            	<?= tra("Current password"); ?>
            </td>
            <td>
                <input type="password" name="old_passwd" value="<? display_post_value("old_passwd"); ?>" size="32" />
                <? display_form_error("old_passwd"); ?>
            </td>
        </tr>
        <tr>
        	<td>
            	<b>OR</b> Account key<br />
                <span class="description"><a href="/account/get_passwd.php">Get account key by email</a></span>
            </td>
            <td>
                <input type="text" name="auth" value="<? display_post_value("auth"); ?>" size="32" />
                <? display_form_error("auth"); ?>
            </td>
        </tr>           
           
        <? } ?>
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
        <tr>
            <td width="250">&nbsp;</td>
            <td>
                <input type="submit" name="submit" value="<?= tra("Change password"); ?>">
            </td>
        </tr>
    </table>
	</form>
</p>
<? 
display_page_bottom();
?>

