<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/util.inc");


$field = $_GET["field"];

switch($field) {
case "result_server_state":
    display_page_top("Server states");
    echo "
        <p>
        A tasks's <b>server state</b> indicates
        whether the task has been sent to a computer,
        and if so whether the computer has finished it.
        Possible values are:
        <p>
    ";
    start_table();
    row2_plain("<b>Inactive</b>",
        "The task is not ready to send
        (for example, because its input files are unavailable)"
    );
    row2_plain("<b>Unsent</b>",
        "The task is ready to send, but hasn't been sent yet."
    );
    row2_plain("<b>In Progress</b>",
        "The task has been sent; waiting for completion."
    );
    row2_plain("<b>Over</b>",
        "The task has been sent to a computer and either
        it has timed out or the computer has reported its completion."
    );
    break;

case "result_outcome":
    display_page_top("Outcomes");
    echo "
        <p>
        A tasks's <b>outcome</b> is defined if its server state is <b>over</b>.
        Possible values are:
        <p>
    ";
    start_table();
    row2_plain("<b>Unknown</b>",
        "The task was sent to a computer, but the computer has not
        yet completed the work and reported the outcome."
    );
    row2_plain("<b>Success</b>",
        "A computer completed and reported the task successfully."
    );
    row2_plain("<b>Couldn't send</b>",
        "The server wasn't able to send the task to a computer
        (perhaps because its resource requirements were too large)"
    );
    row2_plain("<b>Client error</b>",
        "The task was sent to a computer and an error occurred."
    );
    row2_plain("<b>No reply</b>",
        "The task was sent to a computer
        and no reply was received within the time limit."
    );
    row2_plain("<b>Didn't need</b>",
        "The task wasn't sent to a computer because
        enough other tasks were completed for this workunit."
    );
    row2_plain("<b>Validate error</b>",
        "The task was reported but could not be validated,
        typically because the output files were lost on the server."
    );
    break;

case "result_client_state":
    display_page_top("Client states");
    echo "<p>A result's <b>client state</b>
        indicates the stage of processing at which an error occurred.
        <p>
    ";
    start_table();
    row2_plain("<b>New</b>",
        "The computer has not yet completed the task."
    );
    row2_plain("<b>Done</b>",
        "The computer completed the task successfully."
    );
    row2_plain("<b>Downloading</b>",
        "The computer couldn't download the application or input files."
    );
    row2_plain("<b>Computing</b>",
        "An error occurred during computation."
    );
    row2_plain("<b>Uploading</b>",
        "The computer couldn't upload the output files."
    );
    break;

case "result_time":
    display_page_top("Time reported and deadline");
    echo "
        <p>
        A task's <b>Time reported or deadline</b> field depends
        on whether the task has been reported yet:
        <p>
    ";
    start_table();
    row2("Already reported", "The date/time it was reported");
    row2("Not reported yet, deadline in the future",
        "Deadline, shown in green."
    );
    row2("Not reported yet, deadline in the past",
        "Deadline, shown in red."
    );
    break;

default:
    display_page_top("Unknown field");
}

end_table();
display_page_bottom();
?>
