<?php

// TODO: the following is organized in a funky way.  Clean it up
require_once($_SERVER['DOCUMENT_ROOT']."/../project/project.inc");
require_once($_SERVER['DOCUMENT_ROOT']."/../inc/profile.inc");

// output a select form item with the given name,
// from a list of newline-delineated items from the text file.
// If $selection is provided, and if it matches one of the entries in the file,
// it will be selected by default.
//
function show_combo_box($name, $filename, $selection=null) {
    if (!file_exists($filename)) {
        echo "ERROR: $filename does not exist!  Cannot create combo box.<br>";
        exit();
    }
    echo "<select name=\"$name\">\n";

    $file = fopen($filename, "r");

    while ($line = trim(fgets($file, 1024))) {
        if ($line == $selection) {
            echo "<option SELECTED value=\"$line\">$line\n";
        } else {
            echo "<option value=\"$line\">$line\n";
        }
    }

    echo "</select>\n";
    fclose($file);
}


function show_picture_option($profile) {
    row1("Picture");

    $warning = "";
    if (profile_screening() && $profile->has_picture) {
        $warning = offensive_profile_warning($profile->verification);
    }

    if (($profile) && ($profile->has_picture)) {
        echo "
<tr><td colspan=2>
<table border=0 cellpadding=5
<tr>
<td valign=top><a href=\"" . IMAGE_URL . $profile->userid . '.jpg' . "\"><img src=\"" . IMAGE_URL . $profile->userid . '_sm.jpg' . "\"></a>
</td>
<td valign=top> $warning Your profile picture is shown at left.
<p>
To replace it,
click the \"Browse\" button and select a JPEG or PNG file (50KB or less).
<input name=picture type=file><br>
<p>
To remove it from your profile, check this box:
<input type=checkbox name=delete_pic>
<p>
</td></tr>";
        rowify("<br>");
        end_table();
        echo "</td></tr>";
    } else {
        rowify("
If you would like include a picture with your profile,
click the \"Browse\" button and select a JPEG or PNG file.
Please select images of 50KB or less.
<p>
<input name=picture type=file>
        ");
        rowify("<br>");
    }
}

function show_language_selection($profile) {
    row1("Language");
    echo "<tr><td>
        <p>
        Select the language in which your profile is written:
        <p>
    ";
    if (isset($profile->language)) {
        show_combo_box("language", LANGUAGE_FILE, $profile->language);
    } else {
        show_combo_box("language", LANGUAGE_FILE, "English");
    }
    echo "</td></tr>\n";
}

function show_submit() {
    row1("Submit profile");
    echo "<script>var RecaptchaOptions = { theme : 'white' };</script>";
    $config = get_config();
    $publickey = parse_config($config, "<recaptcha_public_key>");
    if ($publickey) {
        table_row("To protect project's webpages from spam, we ask you to type in two words shown in the image:<br>\n".
            recaptcha_get_html($publickey));
    }
    table_row("<p><input type=\"submit\" value=\"Create/edit profile\" name=\"submit\">");
}

// Returns an array containing:
// [0]: The original image refered to by $fileName if its dimensions are
//    less than MAX_IMG_WIDTH x MAX_IMG_HEIGHT, or a version scaled to
//    those dimensions if it was too large.
// [1]: A scaled version of the above.

function getImages($fileName) {
    $size = getImageSize($fileName);

    // Determine if the filetype uploaded is supported.
    // TODO: Change these to constants.
    switch($size[2]) {
    case '2':    // JPEG
        $image = imageCreateFromJPEG($fileName);
        break;
    case '3':    // PNG
        $image = imageCreateFromPNG($fileName);
        break;
    default:
        error_page("The format of your uploaded image is not supported.");
    }

    $width = $size[0];
    $height = $size[1];

    $smallImage = scale_image($image, $width, $height, SMALL_IMG_WIDTH, SMALL_IMG_HEIGHT);

    if ($width > MAX_IMG_WIDTH || $height > MAX_IMG_HEIGHT) {
        $image = scale_image($image, $width, $height, MAX_IMG_WIDTH, MAX_IMG_HEIGHT);
    }

    /*
    echo "<br><br>Image type: $size[2]";
    echo "<br>Original width: $width";
    echo "<br>Original height: $height";
    echo "<br>Scalar: $scalar";
    echo "<br>Dest width: " . ($width / $scalar);
    echo "<br>Dest height: " . ($height / $scalar);
    echo "<br>Horizontal offset: $horiz_offset";
    echo "<br>Vertical offset: $vert_offset";
    echo "<br><br><a href=\"images/user_profile/test.jpg\">View result</a>";
    */

    return array($image, $smallImage);
}

function show_description() {
    echo "
        <p>
        Your <b>profile</b> lets you share your opinions and background
        with the ".PROJECT." community.
        <p>
    ";
}

function show_questions($profile) {
    $response1 = "";
    $response2 = "";
    if (isset($profile->response1)) {
        $response1 = stripslashes($profile->response1);
    }
    if (isset($profile->response2)) {
        $response2 = stripslashes($profile->response2);
    }

    row1(show_profile_heading1());
    rowify(show_profile_question1().html_info());
    rowify("<br>");
    show_textarea("response1", $response1);
    rowify("<br>");
    row1( show_profile_heading2());
    rowify( show_profile_question2().html_info());
    rowify("<br>");
    show_textarea("response2", $response2);
    rowify("<br>");
    show_language_selection($profile);
    rowify("<br>");
}

function show_textarea($name, $text) {
    rowify("<textarea name=\"$name\" cols=80 rows=20>" . $text . "</textarea>");
}

// $profile is null if user doesn't already have a profile.
// Don't assign to $profile->x if this is the case.
//
function process_create_profile($user, $profile) {
    $response1 = $_POST['response1'];
    $response2 = $_POST['response2'];
    $language = $_POST['language'];
    if (isset($_POST['delete_pic'])) {
        $delete_pic = $_POST['delete_pic'];
    } else {
        $delete_pic = "off";
    }

    if (strlen($response1)==0 &&
        strlen($response2)==0 &&
        $delete_pic != "on" &&
        !is_uploaded_file($_FILES['picture']['tmp_name'])
    ) {
        error_page("Your profile submission was empty.");
        exit();
    }

    if ($delete_pic == "on") {
        delete_user_pictures($profile->userid);
        $profile->has_picture = false;
        $profile->verification = 0;
    }

    $profile ? $hasPicture = $profile->has_picture: $hasPicture = false;

    if (is_uploaded_file($_FILES['picture']['tmp_name'])) {
        $hasPicture = true;
        if ($profile) $profile->verification = 0;

        // echo "<br>Name: " . $_FILES['picture']['name'];
        // echo "<br>Type: " . $_FILES['picture']['type'];
        // echo "<br>Size: " . $_FILES['picture']['size'];
        // echo "<br>Temp name: " . $_FILES['picture']['tmp_name'];

        $images = getImages($_FILES['picture']['tmp_name']);

        // Write the original image file to disk.
        // TODO: define a constant for image quality.
        ImageJPEG($images[0], IMAGE_PATH . $user->id . '.jpg');
        ImageJPEG($images[1], IMAGE_PATH . $user->id . '_sm.jpg');
    }
    $response1 = sanitize_html($response1);
    $response2 = sanitize_html($response2);
    if ($profile) {
        $query = " response1 = '".boinc_real_escape_string($response1)."',"
            ." response2 = '".boinc_real_escape_string($response2)."',"
            ." language = '".boinc_real_escape_string($language)."',"
            ." has_picture = '$hasPicture',"
            ." verification = '$profile->verification'"
            ." WHERE userid = '$user->id'";
        $result = BoincProfile::update_aux($query);
        if (!$result) {
            error_page("Couldn't update profile: database error");
        }
    } else {
        $query = 'SET '
            ." userid = '$user->id',"
            ." language = '".boinc_real_escape_string($language)."',"
            ." response1 = '".boinc_real_escape_string($response1)."',"
            ." response2 = '".boinc_real_escape_string($response2)."',"
            ." has_picture = '$hasPicture',"
            ." verification=0";
        $result = BoincProfile::insert($query);
        if (!$result) {
            error_page("Couldn't create profile: database error");
        }
        $user->update("has_profile=1");
    }
	
	/*
    display_page_top("Profile saved");

    
	echo "<h1 id=\"title\">Profile saved
        Congratulations!
        Your profile was successfully entered into our database.<br><br>
        <a href=\"/community/view_profile.php?userid=$user->id\">View your profile</a><br>
    ";

    display_page_bottom();
	*/
	setMessage("notice","Your profile was successfully saved. <a href=\"/community/view_profile.php?userid=$user->id\">View your profile</a>");
}

function show_profile_creation_page($user) {
    $config = get_config();
    $min_credit = parse_config($config, "<profile_min_credit>");
    if ($min_credit && $user->expavg_credit < $min_credit) {
        error_page(
            "To prevent spam, an average credit of $min_credit or greater is required to create or edit a profile.  We apologize for this inconvenience."
        );
    }

    // If the user already has a profile,
    // fill in the fields with their current values.
    //
    $profile = get_profile($user->id);
    if (post_str("submit", true)) {
        $privatekey = parse_config($config, "<recaptcha_private_key>");
        if ($privatekey) {
            $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]
            );
            if (!$resp->is_valid) {
                error_page("The reCAPTCHA wasn't entered correctly. Go back and try it again.<br>".
                    "(reCAPTCHA said: " . $resp->error . ")"
                );
            }
        }

        process_create_profile($user, $profile);
        
    }

    if ($profile) {
        display_page_top("Edit your profile");
		
    } else {
        display_page_top("Create a profile");
		
    }

    echo "
        <form action=", $_SERVER['PHP_SELF'], " method=\"POST\", ENCTYPE=\"multipart/form-data\">
    ";
    start_table_noborder();
    show_description();
    show_questions($profile);
    show_picture_option($profile);
    show_submit();
    end_table();
    echo "</form>";
    display_page_bottom();
}

$user = get_logged_in_user(true);
show_profile_creation_page($user);

?>
