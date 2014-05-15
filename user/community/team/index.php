<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/team.inc");

display_page_top("Teams");
?>
<p><?= PROJECT?> participants may form <b>teams</b>.</p>
<p>
	You may belong to only one team and can join or quit a team at any time.
</p>
<p>
    Each team has a <b>founder</b>, who may
    <ul>
        <li> access team members' email addresses</li>
        <li> edit the team's name and description</li>
        <li> remove members from the team</li>
        <li> disband a team if it has no members</li>
    </ul>
</p>
<p>
    To join a team, visit its team page and click <b>Join this team</b>.
</p>
<h3>Find a team</h3>
<? team_search_form(null); ?>
<h3>Top teams</h3>
<ul>
	<li> <a href=/community/top_teams.php>All teams</a> </li>
<? for ($i=1; $i<8; $i++) {
    echo "<li><a href=/community/top_teams.php?type=$i>".team_type_name($i)." teams</a></li>\n";
}
?>
</ul>
<h3>Create a new team</h3>
<p>
	If you can't find a team that's right for you, you can
	<a href="/community/team/create_form.php">create a team</a>.
</p>
<?
display_page_bottom();
?>
