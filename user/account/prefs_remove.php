<?php


$cvs_version_tracker[]="\$Id: prefs_remove.php 11995 2007-01-29 18:15:16Z boincadm $";  //Generated automatically - do not edit

require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/prefs.inc");


db_init();


$user = get_logged_in_user();
check_tokens($user->authenticator);

$confirmed=0;

$subset = get_str("subset");
$venue = get_str("venue");
$confirmed = get_str("confirmed", true);
$columns = get_int("cols", true);
$c = $columns?"&cols=$columns":"";

if ($confirmed) {
    if ($subset == "global") {
        $main_prefs = prefs_parse_global($user->global_prefs);
        $main_prefs->$venue = null;
        global_prefs_update($user, $main_prefs);
    } else {
        $main_prefs = prefs_parse_project($user->project_prefs);
        $main_prefs->$venue = null;
        project_prefs_update($user, $main_prefs);
    }
    gotoLocation("prefs.php?subset=$subset$c");
} else {
    $tokens = url_tokens($user->authenticator);
   echo "<p>TOKENS $tokens</p>";
   display_page_top("Delete preferences?");
}

?>

<p>
    Are you sure you want to delete your separate <?= subset_name($subset); ?>
    preferences for <?= $venue; ?>?
</p>
<?php

echo"<p><a href=\"prefs_remove.php?subset=$subset&venue=$venue&confirmed=yes$c$tokens\">Yes</a>";
echo"| <a href=\"prefs.php?subset=$subset$c\">Cancel</a></p>";

display_page_bottom();
?>
