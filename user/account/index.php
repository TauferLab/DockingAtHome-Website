<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/forum.inc");

// show the home page of logged-in user or account help
$user = get_logged_in_user(false);
if ($user) {

	BoincForumPrefs::lookup($user);
	$user = get_other_projects($user);
	
	$init = isset($_COOKIE['init']);
	$via_web = isset($_COOKIE['via_web']);
	if ($via_web) {
		clear_cookie('via_web');
	}
	
	if ($init) {
		clear_cookie('init');
		display_page_top(tra("Welcome to %1", PROJECT));
		echo "<p>".tra("View and edit your account preferences using the links below.")."</p>\n";
		if ($via_web) {
			echo "
				<p> If you have not already done so,
				<a href=\"http://boinc.berkeley.edu/download.php\">download BOINC client software</a>.</p>
			";
		}
	} else {
		display_page_top("Your ".PROJECT." account");
	}
	
	
	start_table();
	echo "<tr><td valign=\"top\">";
	start_table();
	show_user_info_private($user);
	if (!no_computing()) {
		show_user_stats_private($user);
	}
	
	if (file_exists($_SERVER['DOCUMENT_ROOT']."/../project/donations.inc")) {
		require_once($_SERVER['DOCUMENT_ROOT']."/../project/donations.inc");
		if (function_exists('show_user_donations_private')) {
			show_user_donations_private($user);
		}
	}
	end_table();
	show_other_projects($user, true);
	project_user_page_private($user);
	echo "</td><td valign=\"top\">";
	start_table();
	show_community_private($user);
	end_table();
	
	echo "</td></tr></table>";
}
else {
	display_page_top("My Account");
?>

<p>If you login, this page will display options and preferences for your account.</p>
<h3>Don't have an account?</h3>
<p>Visit the <a href="/account/create_form.php">Create Account</a> page.</p>
<h3>Having trouble logging in?</h3>
<p>If you forgot your password, visit the <a href="/account/get_passwd.php">Get Password</a> page.</p>
<p>If your email is no longer valid, you can still login using a saved BOINC authenicator on your computer. Visit the <a href="/account/get_passwd.php">Get Password</a> page and follow the instructions.</p>
<?php
}
display_page_bottom();
?>
