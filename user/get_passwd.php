<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/user.inc");

display_page_top("Forgot your password?");
?>


<h3>Get email instructions for setting your password</h3>

<form method="post" action="/account/mail_passwd.php">
<p>Email address:<br />
<input type="text" size="40" name="email_addr"><br />
<input type="submit" name="submit" value="Send Email">
</p>
</form>


<h3>If your account's email address is no longer valid</h3>
<p>
If you have run BOINC under the account,
you can access the account
even if you don't know the password and the email
address is no longer valid.  Here's how:
<ul>
	<li>Go to the BOINC directory on your computer (on Windows this is usually <b>C:\Program Files\BOINC</b>).</li>
	<li>Find your account file for this project; this will have a name like <b>account_lhcathome.cern.ch.xml</b> (where the project URL is <b>http://lhcathome.cern.ch</b>).</li>
	<li>Open the file in a text editor like Notepad. You'll see something like:
        <pre>
        &lt;account>
            &lt;master_url>http://lhcathome.cern.ch/&lt;/master_url>
            &lt;authenticator>8b8496fdd26df7dc0423ecd43c09a56b&lt;/authenticator>
            &lt;project_name>lhcathome&lt;/project_name>
            ...
        &lt;/account>
        </pre>
    </li>
    <li>Select and Copy the string between &lt;authenticator> and &lt;/authenticator> (<b>8b8496fdd26df7dc0423ecd43c09a56b</b> in the above example).</li>
    <li>Paste the string into the field below, and click OK.</li>
    <li>You will now be logged in to your account; update the email and password of your account.</li>
</ul>
</p>

<form action="/account/login.php" method="post">
<p>Authenticator:<br />
<input type="text" name="authenticator" size=40 /><br />
<input type="hidden" name="stay_logged_in" value="1" />
<input type="submit" name="submit" value="Login with authenticator" />
</p>
</form>

<?php display_page_bottom(); ?>
