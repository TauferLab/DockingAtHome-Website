<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/boinc_db.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/profile.inc");

function delete_profile($user) {
    $result = BoincProfile::delete_aux("userid = $user->id");
    if (!$result) {
        error_page("couldn't delete profile - please try again later");
    }
    delete_user_pictures($user->id);
    
    $user->update("has_profile=0");
    setMessage("notice","Your profile has been deleted.");
	gotoLocation("/account/");
}

$user = get_logged_in_user();

if (isset($_POST['delete']) && $_POST['delete']) {
    delete_profile($user);
}

display_page_top("Delete profile?");
?>

<p>
    Deleted profiles are gone forever and cannot be recovered --
    you will have to start from scratch
    if you want another profile in the future.
</p>
<p>
    If you're sure, click 'Delete'
    to remove your profile from our database.
</p>
<p>
    <form action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
        <input type="submit" name="delete" value="Delete">
    </form>
</p>
<?php
display_page_bottom();

?>
