<?php
    include('../model/connect-db.php');
    include('../model/client-check.php');
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

    if(isset($_REQUEST['event'])){
        $event_id = base64_decode($_REQUEST['event']);
    }
    
    $eventQuery = "SELECT * FROM design_event WHERE id=$event_id";
    $eventResult = mysqli_query($db, $eventQuery);
    $eventRow = mysqli_fetch_assoc($eventResult);

    $eventId = $eventRow["id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/header.css">
</head>

<body onload="getLeaderboard()">
<!-- header -->
<?php  include('header.php') ?>
    <!-- Content -->
    <div class="row container-fluid mx-auto px-0">
        <div class="col-md-12 px-0 mx-0">
            <div class="text-white text-center px-0"
                style="background: url('<?php echo $eventRow["image"] ?>'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 40vh; width:auto;">
                <!-- <h1> <?php // echo $eventRow["name"] ?></h1> -->
            </div>
           <div class="px-5 py-2">
           <div class="justify-content-between border-bottom border-dark">
           
                <span class="h2 py-2 mb-4"><?php echo $eventRow["name"] ?></span>
                <span class="h4 py-2 mb-4"><?php echo $eventRow["duration"] ?></span>
           </div>

            <p class="text-justify pr-3">
                <?php echo $eventRow["description"] ?>
            </p>

            <div class="p-5 mx-5">
                <h2 class="text-center m-3">Leaderboard</h3>
                <table class="table table-light">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Name</th>
                            <th>Ui Points</th>
                            <th>Ux Points</th>
                            <th>Color Points</th>
                            <th>Code Points</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light text-center" id="tableBody">

                    </tbody>
                </table>
            </div>
            
         
           </div>
        </div>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    function compare( a, b ) {
        if ( a.points < b.points ){
            return 1;
        }
        if ( a.points > b.points ){
            return -1;
        }
        return 0;
    }

    function getLeaderboard( ) {

        var checkingData = {
            "event": `<?php echo $eventId; ?>`,
        }

        $.ajax({
            type: "POST",
            url: "get-leaderboard.php",
            data: checkingData,
            beforeSend: function () {
                
            },
            success: function (msg) {
                try {
                    let tableContent = "";
                    let jsonArr = (JSON.parse(msg))["leaderboard"];
                    jsonArr.sort( compare)

                    for( let user of jsonArr) {
                        tableContent += "<tr> ";
                        tableContent += "<td> " + user.name + "</td>";
                        tableContent += "<td> " + user.ui + "</td>";
                        tableContent += "<td> " + user.ux + "</td>";
                        tableContent += "<td> " + user.color + "</td>";
                        tableContent += "<td> " + user.code + "</td>";
                        tableContent += "<td> " + user.points + "</td>";
                        tableContent += "</tr>";
                    }

                    document.getElementById( "tableBody").innerHTML = tableContent;
                } catch (e) {
                } 
            }
        });
    }

    

</script>

</html>

