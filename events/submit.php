<?php 
    use Cloudinary\Api\Upload\UploadApi;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    include('../model/connect-db.php');
    include('../model/client-check.php');
    include('../model/cloudinary-config.php');

    date_default_timezone_set("Asia/Kolkata");

    session_start();

    $client = new UserCheckModel();
    $isUserAuthenticated = false;
    $userId = -1;

    if( isset( $_SESSION["LOGIN_USER"]) && $client->isUserAuthenticated()) {
        $isUserAuthenticated = true;
        $userId = base64_decode($_SESSION["LOGIN_USER"]);
    } else {
        echo "<script> window.location = '../user/user-logout.php' </script>";
    }

    // Object for sending response as JSON
    $ajaxResponse = json_decode('{ "alertToGive" : null, "isError" : true }', TRUE);
                
    $areVarsSet = isset( $_POST['htmlCode']) &&  isset($_POST['cssCode']) && isset($_POST['jsCode']) 
        && isset($_POST['event']) && isset($_POST['imageSrc']);

    if ( $areVarsSet) {
        $htmlCode = $_POST['htmlCode'];
        $cssCode = $_POST['cssCode'];
        $jsCode = $_POST['jsCode'];
        $eventId = $_POST['event'];
        $imageSrc = $_POST['imageSrc'];


        $responseArr = (new UploadApi())->upload( $imageSrc);

        $imageUrl = $responseArr["url"];

        $ajaxResponse["alertToGive"] = $responseArr["url"];

        /******************** CODE SAVE *********************/

        // Checking if code exists
        $codeQuery = "SELECT id FROM design_event_codes WHERE user_id=$userId AND event_id=$eventId";
        $codeRow = mysqli_fetch_assoc( mysqli_query($db,$codeQuery));

        // Creating Query for Saving codes
        $stmt = "";
        if( $codeRow) {
            $stmt = $db->prepare("UPDATE design_event_codes SET html_code = ?, css_code = ?, js_code = ?, output_placeholder = ? WHERE user_id = ?");
            $stmt->bind_param("sssss", $htmlCode, $cssCode, $jsCode, $imageUrl, $userId);
        } else {
            $stmt = $db->prepare("INSERT INTO design_event_codes (user_id, event_id, html_code, css_code, js_code, output_placeholder) VALUES ( ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $userId, $eventId, $htmlCode, $cssCode, $jsCode, $imageUrl);
        }

        if ($stmt->execute()) {
            $ajaxResponse["alertToGive"] = 'Code Saved Successfull';
            $ajaxResponse["isError"] = false;    
        } else {
            $ajaxResponse["alertToGive"] = 'Error while saving and running code...';
        }

    }
    echo json_encode($ajaxResponse);
}

?>