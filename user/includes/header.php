<? 
	
	$next_url = get_str("next_url", true);
	if(empty($next_url)) {
		if (isset($_SERVER,$_SERVER['REQUEST_URI'])) $next_url = $_SERVER['REQUEST_URI'];
		//if (strpos($next_url, "?") !== false) $next_url = reset(explode("?", $next_url));
	}
	$user = get_logged_in_user(false);
?>

<div id="header">
    <a href="/"><img border="0" src="/images/dh_logo.png" width="396" height="125" alt="Docking@Home Logo" style="float: left;" /></a>
	<? if ($user) { ?>
    	<div id="memberarea">
         	<p>
            	Hello! You are logged in as:<br />
				<?= $user->name ?>
            </p>
            <p>
            	<a href="/account/">My Account</a> | 
                <? if ($user->has_profile) { ?>
                    <a href="/community/view_profile.php?userid=<?= $user->id ?>">My Profile</a> | 
    			<? } ?>
            	<a href="/account/logout.php?<?= url_tokens($user->authenticator); ?>">Log out</a>
            </p>
        </div>
    <? } else { ?>
    	<div id="loginarea">
            <form action="/account/login.php" method="post">
                <input type="hidden" name="next_url" value="<?= $next_url ?>" />
                <input type="hidden" name="stay_logged_in" value="1" />
                <input type="hidden" name="submit" value="submit" /><br />
                Email <input name="email_addr" type="text" size="20" /><br />
                Password <input name="passwd" type="password" size="20" /><br />
                <span>Not a member? <a href="/account/create_form.php">Create an account</a></span><br />
                <input type="image"
                    src="/images/login_button.png"
                    alt="Login"
                    onmouseover="this.src='/images/login_button_over.png'"
                    onmouseout="this.src='/images/login_button.png'" />
             </form>
         </div>
    <? } ?>
</div>
<div id="navbar">
    <a href="/">Home</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/about/" onclick="return clickReturnValue()" 
		onmouseover="dropdownmenu(this,event,aboutmenu,'150px')" 
		onmouseout="delayhidemenu()">About</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/join/" onclick="return clickReturnValue()" 
		onmouseover="dropdownmenu(this,event,joinmenu,'150px')" 
		onmouseout="delayhidemenu()">Join</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/community/" onclick="return clickReturnValue()" 
		onmouseover="dropdownmenu(this,event,communitymenu,'150px')" 
		onmouseout="delayhidemenu()">Community</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/status/" onclick="return clickReturnValue()" 
		onmouseover="dropdownmenu(this,event,statusmenu,'150px')" 
		onmouseout="delayhidemenu()">Status</a>
    &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="/support/" onclick="return clickReturnValue()" 
		onmouseover="dropdownmenu(this,event,supportmenu,'150px')" 
		onmouseout="delayhidemenu()">Support</a>
</div>

<?

// Temporary way to set announcements and such...
//setMessage("announcement","This is a site wide announcement!");

displayMessages();

?>