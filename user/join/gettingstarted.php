<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
	display_page_top("Join Docking@Home: Getting Started Guide (Step 1 of 3)");
?>

<p>Start Docking! Joining Docking@Home is extremely easy - it takes just 3 steps, which we will walk you through.</p>
<ol>
    <li>Download the software (BOINC) <b>&lt;- You Are Here</b></li>
    <li><a href="gettingstarted2.php">Join the Docking@Home Project</a></li>
    <li><a href="gettingstarted3.php">Set Your Preferences</a></li>
</ol>

<h3>What is BOINC?</h3>
<img src="/images/boinc_logo.gif" alt="BOINC Logo" style="float:right" />
<p>
    <a href="http://boinc.berkeley.edu/" target="_blank">BOINC</a> is free, open-source software developed by the University of California used for volunteer and distributed computing.
    It’s safe, secure, and easy.
    It uses the idle time on your computer to do mathematical and scientific calculations.
    The calculations go toward goals like discovering extra-terrestrial life or in the case of Docking@Home, curing diseases like HIV.
    You can decide exactly how much and how often BOINC uses your computer.
</p>


<h3>Step 1 - Download the software (BOINC)</h3>
<p>Note for Linux users: Installing is slightly more complicated. The BOINC website provides an <a href="http://boinc.berkeley.edu/wiki/Installing_on_Linux" target="_blank">in-depth guide</a>.</p>
<ol>
    <li>Go to the BOINC <a href="http://boinc.berkeley.edu/download.php" target="_blank">download page</a> - the page will automatically give you the right installer for your operating system.</li>
    <li>Save and run the BOINC installer</li>
    <li>Follow the on-screen instructions</li>
    
</ol>

<p style="text-align:center;">
    <span class="caption">Click thumbnail for larger image</span><br />
    <a href="/images/screenshots/boinc_download.png" class="thickbox" title="BOINC Download Page">
        <img src="/images/screenshots/boinc_download.png" alt="BOINC Download Page" width="500px" />
    </a>
</p>

<h3 style="margin-bottom:20px;margin-top:20px;text-align:right;"><a href="gettingstarted2.php" style="color:#3CBEEE;">&gt; Goto Step 2 - Join the Docking@Home Project</a></h3>

<hr class="centered" />

<?php display_having_trouble(); ?>

<hr class="centered" />
<p>Go back to <a href="index.php">Join Docking@Home</a></p>
<?php display_page_bottom(); ?>
