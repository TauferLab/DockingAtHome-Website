<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/countries.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/translation.inc");

$next_url = get_str('next_url', true);
if(empty($next_url)) {
	$next_url = "/account/";
	if (strpos($next_url, "?") !== false) $next_url = reset(explode("?", $next_url));
}

display_page_top(tra("Create an account"));

$config = get_config();

$disabled = parse_bool($config, "disable_account_creation");
$wac = parse_bool($config, "web_account_creation");

$min_passwd_length = parse_element($config, "<min_passwd_length>");
if (!$min_passwd_length) {
	$min_passwd_length = 6;
}

?>


<?php if ($disabled) { ?>
<h1><?php tra("Account creation is disabled"); ?></h1>
<p><?php tra("Account creation is currently disabled. Please try again later."); ?></p>
<?php 
    display_page_bottom();
    exit();
} ?>

<h1 id="title"><?php print tra("Create an account"); ?></h1>

<?php if (!$wac) { ?>
	<p><b><?php print tra("NOTE: If you use BOINC version 5.2+ with the BOINC Manager, don't use this form. Just run BOINC, select Attach Project, and enter an email address and password."); ?></b></p>
<?php } ?>

<p>
	<form action="create_html_action.php" method="post">
    <input type="hidden" name="form_url" value="/account/create_html.php" />
    <input type="hidden" name="next_url" value="<?php print $next_url; ?>" />
<?php 
$teamid = get_int("teamid", true);
if ($teamid) {
    $team = lookup_team($teamid);
    $user = lookup_user_id($team->userid);
    if (!$user) {
        echo "<p>No such user</p>";
    } else {
        echo "<p><b>".tra("This account will belong to the team %1 and will have the project preferences of its founder.")."<a href=\"team_display.php?teamid=$team->id\">$team->name</a></b><p>";
        echo "<input type=\"hidden\" name=\"teamid\" value=\"$teamid\" />";
    }
}
?>
	<table>
		<?php 
        // Using invitation codes to restrict access?
        //
        if(defined('INVITE_CODES')) { ?>
        	<tr>
        		<td>
             		<?php print tra("Invitation Code"); ?><br />
                    <span class="description"><?php print tra("A valid invitation code is required to create an account."); ?></span>
                </td>
                <td>
                    <input type="text" name="invite_code" size="30" />
                </td>
            </tr>
        <?php } ?>

        	<tr>
            	<td width="250">
            		<?php print tra("Name"); ?><br />
                    <span class="description"><?php print tra("Identifies you on our web site. Use your real name or a nickname."); ?></span>
                </td>
                <td>
            		<input type="text" name="new_name" size="30" />
                </td>
            </tr>
            <tr>
            	<td>
                	<?php print tra("Email Address"); ?><br />
                    <span class="description"><?php print tra("Must be a valid address of the form 'name@domain'."); ?></span>
                </td>
                <td>
            		<input type="text" name="new_email_addr" size="50" />
                </td>
            </tr>
            <tr>
            	<td>
                	<?php print tra("Password"); ?><br />
                    <span class="description"><?php print tra("Must be at least %1 characters", $min_passwd_length); ?></span>
                </td>
                <td>
            		<input type="password" name="passwd" size="32" />
                </td>
            </tr>
            <tr>
            	<td>
                	<?php print tra("Confirm password"); ?>
                </td>
                <td>
                	<input type="password" name="passwd2" size="32" />
                </td>
            </tr>
            <tr>
            	<td>
                	<?php print tra("Country"); ?><br />
                    <span class="description"><?php print tra("Select the country you want to represent, if any."); ?></span>
                </td>
                <td>
            		<select name="country">
        				<?php print_country_select(); ?>
        			</select>
                </td>
			</tr>
            <tr>
            	<td>
                	<?php print tra("Postal or ZIP Code"); ?><br />
                    <span class="description"><?php print tra("Optional"); ?></span>
                </td>
                <td>
            		<input type="text" name="postal_code" size="20" />
                </td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>
                	<input type="submit" value="<?php print tra("Create account"); ?>">
                </td>
            </tr>
        </table>
	</form>
</p>
<?php 
$cvs_version_tracker[]="\$Id: create_account_form.php 14737 2008-02-13 19:54:54Z davea $";  //Generated automatically - do not edit
display_page_bottom();
?>
