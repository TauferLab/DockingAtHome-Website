<?php
// Change the status of a thread.
// A thread can be either unsolved or solved (used in the Q&A part)
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT'].'/../inc/forum.inc');

$threadid = get_int('id');
$thread = BoincThread::lookup_id($threadid);
$logged_in_user = get_logged_in_user();

$owner = BoincUser::lookup_id($thread->owner);
if ($logged_in_user->id == $owner->id){ 
    $ret = $thread->update("status=".THREAD_SOLVED);
    if (!$ret){
        error_page("Could not update the status of the thread: ".$thread->id);
    }
} else {
    error_page("You must be the owner of the thread to do this");
}

// --------------

display_page_top("Status of the thread");
echo "<p>The status has been updated. Thank you!</p>";
echo "<p><a href=\"/community/forum/thread.php?nowrap=true&id=".$thread->id."\">Return to the thread</a></p>";
display_page_bottom();
?>
