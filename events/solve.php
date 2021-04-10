<?php
    include('../model/connect-db.php');
    include('../model/client-check.php');
    date_default_timezone_set("Asia/Kolkata");
    
    session_start();

    $client = new UserCheckModel();
    $isUserAuthenticated = false;
    $userId = $eventId = -1;

    if( isset( $_SESSION["LOGIN_USER"]) && $client->isUserAuthenticated()) {
        $isUserAuthenticated = true;
        $userId = base64_decode($_SESSION["LOGIN_USER"]);
    } else {
        echo "<script> window.location = '../user/user-logout.php' </script>";
    }

    if( isset( $_GET["event"])) {
        $eventId = $_GET["event"];
    }

    $eventQuery = "SELECT id, name, description, instructions, prizes, duration, start_time, end_time, image, registration, image, registration_starts, registration_ends 
        FROM design_event LIMIT 1";
    $eventResult = mysqli_query($db, $eventQuery);
    $eventRow = mysqli_fetch_assoc($eventResult);

    $eventId = $eventRow["id"];
    $eventEndTime = $eventRow["end_time"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/styles/style.css" />
</head>

<body onload="compile();">
    <!-- content -->

    <div class="container-fluid pb-4">
        <div class="row m-0">
            <div class="col-sm-5 p-0 border">
                <div class="editor-title border">
                    <p id="html-title"> HTML </p>
                </div>
                <div id="html" class="editors" placeholder="HTML"></div>
                <div class="editor-title border">
                    <p><span id="css-title"> CSS </span> <span id="js-title"> JS </span></p>

                </div>
                <div class="css-div" id="cssDiv">
                    <div id="css" class="editors" placeholder="CSS"></div>
                </div>
                <div class="js-div" id="jsDiv">

                    <div id="js" class="editors" placeholder="JavaScript"></div>
                </div>
            </div>
            <div class="col-sm-7 p-0 border" id="add-col">
                <div class="border-bottom border-dark pb-4">
                    <div class="fullscreen p-1"><img src="../assets/images/expand.svg" alt=""></div>
                    <span class="custom-tooltip">View fullscreen</span>

        
       
                    
                    <a href="#" onclick="runDesign()" class="btn btn-success run">RUN</a>
                    <a href="#" onclick="takeSnapshot()" class="btn btn-danger submit">SUBMIT</a>

                    <?php
                    $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
                    $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
                    $currentTime=date("Y-m-d H:i:s");
                    if($currentTime >=$startTime) {
                        if($currentTime < $endTime) {
                            // Start Test
                            echo "<span id='timer' class='timer text-dark'></span>";
                           
                        }else{
                            echo "<script>window.alert('Event Ended'); window.location = 'info?id=$eventId'</script>";
                        }
                    }else{
                        echo "<script>window.alert('Event Not Started Yet'); window.location = 'info?id=$eventId'</script>";
                    }

        ?>

                    <div class="fullscreen1 p-1"><img src="../assets/images/compress.svg" alt=""></div>
                    <span class="custom-tooltip1">Exit fullscreen</span>
                </div>
                <iframe class="mt-3" id="output"></iframe>
            </div>
        </div>
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="http://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="../assets/src-noconflict/ace.js"></script>
<script type="text/javascript" src="../assets/scripts/app.js"></script>

<script>
    $(".fullscreen").click(function () {
        $("#add-col").addClass("col-md-12");
        $(".col-sm-5").hide("slide", {
            direction: "left"
        }, 50);
        $(".fullscreen1").show();
        $(".fullscreen").hide();
    });

    $(".fullscreen1").click(function () {
        $(".fullscreen").show();
        $(".fullscreen1").hide();
        $(".col-sm-5").show("slide", {
            direction: "left"
        }, 400);
        $("#add-col").removeClass("col-md-12");
    });

    $("#js-title").click(function () {
        $(".js-div").show();
        $(".css-div").hide();
        $("#js-title").css('background', '#27A444');
        $("#css-title").css('background', 'rgb(275, 275, 275)');
    });

    $("#css-title").click(function () {
        $(".css-div").show();
        $(".js-div").hide();
        $("#js-title").css('background', 'rgb(275, 275, 275)');
        $("#css-title").css('background', '#27A444');
    });
</script>

<?php 
    $codeQuery = "SELECT * FROM design_event_codes WHERE user_id=$userId"; 
    $codeRow = mysqli_fetch_assoc( mysqli_query($db,$codeQuery));

    if($codeRow) { ?>
<script>
    var htmlInput = `<?php echo $codeRow["html_code"] ?>`;
    var cssInput = `<?php echo $codeRow["css_code"] ?>`;
    var jsInput = `<?php echo $codeRow["js_code"] ?>`;

    html.setValue(htmlInput);
    css.setValue(cssInput);
    js.setValue(jsInput);
</script>
<?php   }  ?>

<script>
    function takeSnapshot() { 
        const iframe = document.getElementsByTagName('iframe');
        const screen = iframe[0]?.contentDocument?.body;

        html2canvas(screen).then( 
            function (canvas) { 
                var dataUrl = canvas.toDataURL("image/png", 1);
                
                var img = new Image();
                img.src = dataUrl;
                submitCode( img.src)
            }); 
    } 

    function submitCode( imageSrc) {
        var htmlCode = html.session.getValue();
        var cssCode = css.session.getValue();
        var jsCode = js.session.getValue();

        var checkingData = {
            "htmlCode": htmlCode,
            "cssCode": cssCode,
            "jsCode": jsCode,
            "event": `<?php echo $eventId; ?>`,
            "imageSrc": imageSrc
        }

        $.ajax({
            type: "POST",
            url: "submit.php",
            data: checkingData,
            beforeSend: function () {
                
            },
            success: function (msg) {
                console.log(msg);
                try {
                    let runResponse = JSON.parse(msg);

                    console.log(runResponse);
                    alert("Code saved successfull");
                } catch (e) {
                    alert("Code saved successfull");
                } finally {
                    
                }
            }
        });
    }
</script>

<!-- Timer Script -->
<script>

// var countDownDate=new Date("June 15, 2021 11:00:00").getTime();

var countDownDate=new Date("<?= $eventEndTime ?>").getTime();

var x=setInterval(function() {
        var now=new Date().getTime();
        var distance=countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        var days=Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours=Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes=Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds=Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("timer").innerHTML= "<b>"+ hours + "</b>"  + " : "+  "<b>"
        + minutes + "</b>" + " : "+   "<b>" +seconds + "" + "</b>";

        // If the count down is finished, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML="YOU CAN START TEST NOW";
        }
    }, 1000);


</script>

</html>