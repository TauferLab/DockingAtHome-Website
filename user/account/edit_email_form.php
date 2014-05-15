<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");

function process_email($user) {
	$current_email_addr = $user->email_addr;
	$new_email_addr = strtolower(process_user_text(post_str("new_email_addr")));
	if (!is_valid_email_addr($new_email_addr)) {
		add_form_error("new_email_addr","Invalid email address:
			you must enter a valid address of the form
			name@domain"
		);
	}
	if ($new_email_addr == $current_email_addr) {
		add_form_error("new_email_addr","The current and new email addresses are the same.");
	}
	else {
		$new_user = lookup_user_email_addr($new_email_addr);
		if ($new_user) {
			add_form_error("new_email_addr","There's already an account with that email address.");
		}
	}
	return $new_email_addr;
}


function process_password($user){
	$passwd = process_user_text(post_str("passwd"));
	if (empty($passwd)) {
		add_form_error("passwd","You must enter your account password.");
	}
	else {
		$passwd_hash = md5($passwd.$user->email_addr);
	
		// deal with the case where user hasn't set passwd
		// (i.e. passwd is account key)
		//
		if ($passwd_hash != $user->passwd_hash) {
			$passwd = $user->authenticator;
			$passwd_hash = md5($passwd.$user->email_addr);
		}
		if ($passwd_hash != $user->passwd_hash) {
			add_form_error("passwd","Wrong account password.");
		}
	}
	return $passwd;
}

db_init();
$user = get_logged_in_user();
$submitted = post_str("submit", true);

if ($submitted) {
	$new_email_addr = process_email($user);
	$passwd = process_password($user);
	if (any_form_errors()) {
		setMessage("error","There was an error in your submission. Please correct and resubmit.");
	}
	else {
		$new_passwd_hash = md5($passwd.$new_email_addr);
		$result = $user->update("email_addr='$new_email_addr', passwd_hash='$new_passwd_hash', email_validated=0");
		if ($result) {
			setMessage("notice","The email address of your account is now $new_email_addr.");
		} 
		else {
			setMessage("error","There was an internal error. Email address not updated.<br>\n".BoincDb::error());
		}
		gotoLocation("/account/");
	}
}

display_page_top("Change email address");
?>
<p>
	<? $form="change_email"; ?>
	<form name="<?= $form ?>" action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="hidden" name="form" value="<?= $form ?>" />
	<table>
        <tr>
            <td width="250">
                <?= tra("Current email address"); ?>
            </td>
            <td>
                <?= $user->email_addr ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= tra("New email address"); ?><br />
                <span class="description"><?= tra("Must be a valid address of the form 'name@domain'."); ?></span>
            </td>
            <td>
                <input type="text" name="new_email_addr" value="<? display_post_value("new_email_addr"); ?>" size="50" />
                <? display_form_error("new_email_addr"); ?>
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
                <input type="submit" name="submit" value="<?= tra("Change email address"); ?>">
            </td>
        </tr>
    </table>
	</form>
</p>
<? 
display_page_bottom();
?>
