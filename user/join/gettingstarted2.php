<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("Join Docking@Home: Getting Started Guide (Step 2 of 3)");
?>

<p>Start Docking! Joining Docking@Home is extremely easy - it takes just 3 steps, which we will walk you through.</p>
<ol>
    <li><a href="gettingstarted.php">Download the software (BOINC)</a></li>
    <li>Join the Docking@Home Project <b>&lt;- You Are Here</b></li>
    <li><a href="gettingstarted3.php">Set Your Preferences</a></li>
</ol>

<h3>Step 2 - Join the Docking@Home Project</h3>
<p>BOINC offers many different computing projects you can join, simply select Docking@Home.</p>
<ol>
    <li>The first time you run the BOINC manager, it will ask you to choose a project to attach.</li>
    <li>Choose Docking@Home (you may choose to add additional projects later).
        <ul><li><i>If Docking@Home does not appear in the projects list, enter <b>http://docking.cis.udel.edu</b> as the project URL.</i></li></ul>
    </li>
    <li>The BOINC manager will ask you to enter your email and select a password.</li>
</ol>


<p style="text-align:center;">
    <span class="caption">Click thumbnail for larger image</span><br />
    <a href="/images/screenshots/boinc_attach_project.png" class="thickbox" title="BOINC Attach Project">
        <img src="/images/screenshots/boinc_attach_project.png" alt="BOINC Attach Project" width="350px" />
    </a>
    <a href="/images/screenshots/boinc_new_user.png" class="thickbox" title="BOINC New User Form">
        <img src="/images/screenshots/boinc_new_user.png" alt="BOINC New User Form" width="350px" />
    </a>
</p>


<h3 style="margin-bottom:20px;margin-top:20px;text-align:right;"><a href="gettingstarted3.php" style="color:#3CBEEE;">&gt; Goto Step 3 - Set Your Preferences</a></h3>

<hr class="centered" />

<?php display_having_trouble(); ?>

<hr class="centered" />
<p>Go back to <a href="index.php">Join Docking@Home</a></p>
<?php display_page_bottom(); ?>
