<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum_db.inc');
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum_banishment_vote.inc');

$config = get_config();

$logged_in_user = get_logged_in_user();
BoincForumPrefs::lookup($logged_in_user);

if (!get_str('action')) {
    error_page("You must specify an action...");
}
if (!$logged_in_user->prefs->privilege(S_MODERATOR)) {
    // Can't moderate without being moderator
    error_page("You are not authorized to banish users.");
}    

$userid = get_int('userid');
$user = BoincUser::lookup_id($userid);

display_page_top('Banishment Vote');

echo "<form action=\"/community/forum/banishment_vote_action.php?userid=".$userid."\" method=\"POST\">\n";
echo form_tokens($logged_in_user->authenticator);
start_table();
row1("Banishment Vote");

if (get_str('action')=="start") {
    if (!$user) {
        error_page("no user");
    }
    $x = $user->banished_until;
    if ($x>time()) {
        error_page("User is already banished");
    }
    //display input that selects reason
    echo "<input type=hidden name=action value=start>";
    echo "<input type=\"hidden\" name=\"userid\" value=\"".$userid."\">\n";
    row1("Are you sure you want to banish ".$user->name."?
        This will prevent ".$user->name." from posting for chosen time period.<br />
        It should be done only if ".$user->name."
        has consistently exhibited trollish behavior.");
    row2("",
    "Select the reason category, optionally write a longer description of why the user should be banished.");
    row2("Category",
    "<select name=\"category\">
    <option value=\"1\">Obscene</option>
    <option value=\"2\">Flame/Hate mail</option>
    <option value=\"3\">User Request</option>
    <option value=\"4\">Other</option>
</select>");
row2("Reason<br>Mailed if nonempty",
    "<textarea name=\"reason\" rows=\"10\" cols=\"80\"></textarea>");

row2(
    "",
    "<input type=\"submit\" name=\"submit\" value=\"Proceed with vote\">"
);
} elseif (get_str('action')=="yes") {
    vote_yes($config,$logged_in_user,$user);
} elseif (get_str('action')=="no") {
    vote_no($config,$logged_in_user,$user);
} else {
    error_page( "Unknown action");
}


end_table();

echo "</form>";

display_page_bottom();

?>
