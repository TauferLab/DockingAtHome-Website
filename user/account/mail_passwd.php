<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/email.inc");


function email_sent_message($email_addr) {
    if (defined('EMAIL_FROM')) {
        $email_from = EMAIL_FROM;
    } else {
        $email_from = URL_BASE;
    }

    display_page_top("Email sent");
    echo "
        Instructions have been emailed to $email_addr.
        <p>
        If the email doesn't arrive in a few minutes,
        your ISP may be blocking it as spam.
        In this case please contact your ISP and
        ask them to not block email from $email_from.
    ";
}

$email_addr = process_user_text(strtolower($_POST["email_addr"]));
if (empty($email_addr)) {
    $error = "No email address was given. Try reentering your email address.";
	setMessage("error",$error);
	gotoLocation("/account/get_passwd.php");
}
$user = lookup_user_email_addr($email_addr);

if (!$user) {
	$error = "There is no user with email address $email_addr. Try reentering your email address.";
	setMessage("error",$error);
	gotoLocation("/account/get_passwd.php");
} else {
	if (substr($user->authenticator, 0, 1) == 'x') {
		$error = "This account has been administratively disabled.";
		setMessage("error",$error);
		gotoLocation("/account/get_passwd.php");
	} else {
		$user->email_addr = $email_addr;
		$retval = send_auth_email($user, false);
		if ($retval) {
			email_sent_message($email_addr);
		} else {
			$error = "Can't send email to $user->email_addr: $retval";
			setMessage("error",$error);
			gotoLocation("/account/get_passwd.php");
		}
	}
}

display_page_bottom();

?>
