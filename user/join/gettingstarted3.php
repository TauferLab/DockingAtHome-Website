<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("Join Docking@Home: Getting Started Guide (Step 3 of 3)");
?>

<p>Start Docking! Joining Docking@Home is extremely easy - it takes just 3 steps, which we will walk you through.</p>
<ol>
    <li><a href="gettingstarted.php">Download the software (BOINC)</a></li>
    <li><a href="gettingstarted2.php">Join the Docking@Home Project</a></li>
    <li>Set Your Preferences <b>&lt;- You Are Here</b></li>
</ol>

<h3>Step 3 - Set Your Preferences</h3>
<p>There are several places to choose how BOINC uses your computer.</p>
<ul>
    <li>Preferences can be set by visiting the Docking@Home <a href="/account/prefs.php" target="_blank">preferences page</a>. These preferences are referred to as “global” and will affect any computer on which you run Docking@Home.</li>
    <li>Preferences are also available from two places within the BOINC manager. These preferences are “local” and affect all BOINC projects running on this particular computer.
        <ul>
            <li>In the Simple View, the preferences tab at the bottom of the window.</li>
            <li>In the Advanced and Grid Views, the Advanced->Preferences… menu option.</li>
        </ul>
    </li>
</ul>


<p style="text-align:center;">
    <span class="caption">Click thumbnail for larger image</span><br />
    <a href="/images/screenshots/boinc_advanced_menu.png" class="thickbox" title="BOINC Advanced Menu">
        <img src="/images/screenshots/boinc_advanced_menu.png" alt="BOINC Advanced Menu" align="top" />
    </a>
    <a href="/images/screenshots/boinc_preferences.png" class="thickbox" title="BOINC Preferences">
        <img src="/images/screenshots/boinc_preferences.png" alt="BOINC Preferences" height="200px" />
    </a>
</p>

<h3>That's it! Here's Some Other Fun Stuff</h3>
<ul>
    <li><a href="/account/create_profile.php">Set up a profile</a>! Create a community profile. Maybe you’ll even get to be user of the day!</li>
    <li><a href="/community/team/search.php">Join a team</a>! You can team up with users with similar interests and affiliations. Teams can group statistics together and complete. Find a team or start your own!</li>
    <li><a href="http://docking.cis.udel.edu/download_network.php">Get Add-ons</a>! Utilize a variety of logging/statistical/fun add-ons.</li>
    <li>Learn about our <a href="/join/rulespolicies.php">Rules and Policies</a></li>
</ul>

<hr class="centered" />
<?php display_having_trouble(); ?>
<hr class="centered" />
<p>Go back to <a href="index.php">Join Docking@Home</a></p>
<?php display_page_bottom(); ?>
