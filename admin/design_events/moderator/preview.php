<?php
    include('../../model/connect-db.php');
    include('../../model/moderator-check.php');
    

    session_start();

    $client = new ModeratorCheckModel();
    $isUserAuthenticated = false;
    
    if( isset( $_SESSION["LOGIN_MODERATOR"])) {
        if( $client->isUserAuthenticated()) {
            $isUserAuthenticated = true;
        } else {
            echo "<script> window.location = '../../model/moderator-logout.php' </script>";
        }
    } 
    if(! $isUserAuthenticated){
        include("../../model/moderator-logout.php");
    } 
    if(isset($_REQUEST['code_id'])){
        $code_id = base64_decode($_REQUEST['code_id']);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/design.css">


    <title>Preview</title>

</head>

<body onload="compile();">

    <!-- Content -->
    <?php
        $code_info = "SELECT * FROM design_event_codes 
        WHERE id=$code_id";
        $code_result = mysqli_query($db, $code_info);
            
        while($code_row = mysqli_fetch_assoc($code_result)) { 
    ?>

    <div class="row px-5 py-2 icons">
        <span class="view-code btn btn-secondary btn-sm mr-2"> <img src="../assets/images/icon-code.png"> Show
            Code</span>
        <span class="desktop-view btn btn-secondary btn-sm mr-2 active"> <img src="../assets/images/icon-desktop.png">
            Desktop View</span>
        <span class="mobile-view btn btn-secondary btn-sm"> <img src="../assets/images/icon-mobile.png"> Mobile
            View</span>
        <span class="open-evaluate btn btn-secondary btn-sm px-3 py-2"> <img
                src="../assets/images/icon-evaluate.png">&nbsp; Evaluate</span>
    </div>
    <div class="container-fluid p-0 mx-auto">
        <div class=" p-0 pl-2 border row" id="add-col">



            <!-- Output -->
            <div class="output col-sm-12">
                <iframe id="output"> </iframe>
            </div>

            <!-- Mobile view -->
            
            <div class="mob mob-1 col-sm-4">
                <iframe class="mobile-output mobile-1" id="output1"> </iframe>
            </div>
            <div class="mob mob-2 col-sm-4">
                <iframe class="mobile-output mobile-2" id="output2"> </iframe>
            </div>
            <div class="mob mob-3 col-sm-4">
                <iframe class="mobile-output mobile-3" id="output3"> </iframe>
            </div>
            <!-- </div> -->
            <script>
                var output = document.getElementById("output").contentWindow.document;
                var output1 = document.getElementById("output1").contentWindow.document;
                var output2 = document.getElementById("output2").contentWindow.document;
                var output3 = document.getElementById("output3").contentWindow.document;

                var htmlFrameCode = `<?php echo $code_row['html_code']; ?>`;
                var cssFrameCode = `<?php echo $code_row['css_code']; ?>`;
                var jsFrameCode = `<?php echo $code_row['js_code']; ?>`;

                output.open();

                var frameCode = htmlFrameCode;
                frameCode += "<style>" + cssFrameCode + "</style>";
                frameCode += "<script>" + jsFrameCode + "<\/script>";

                output.writeln(frameCode);
                output.close();

                output1.open();

                var frameCode = htmlFrameCode;
                frameCode += "<style>" + cssFrameCode + "</style>";
                frameCode += "<script>" + jsFrameCode + "<\/script>";

                output1.writeln(frameCode);
                output1.close();

                output2.open();

                var frameCode = htmlFrameCode;
                frameCode += "<style>" + cssFrameCode + "</style>";
                frameCode += "<script>" + jsFrameCode + "<\/script>";

                output2.writeln(frameCode);
                output2.close();

                output3.open();

                var frameCode = htmlFrameCode;
                frameCode += "<style>" + cssFrameCode + "</style>";
                frameCode += "<script>" + jsFrameCode + "<\/script>";

                output3.writeln(frameCode);
                output3.close();
            </script>

            <!-- code -->
            <div class="col-sm-12 code p-0 border" id="ready">
                <div class="row">
                <div class="col-sm-6 html-div">
                    <div class="editor-title border">
                        <p><span id="html-title"> HTML </span></p>
                    </div>
                    <div id="html" class="editors" placeholder="HTML"> </div>
                </div>

                <div class="col-sm-6">
                    <div class="editor-title  border">
                        <p><span id="css-title"> CSS </span> <span id="js-title"> JS
                            </span></p>
                    </div>

                    <div class="css-div" id="cssDiv">
                        <div id="css" class="editors" placeholder="CSS"> </div>
                    </div>

                    <div class="js-div" id="jsDiv">
                        <div id="js" class="editors" placeholder="JavaScript"> </div>
                    </div>
                </div>
                </div>

            </div>
            <!-- Evaluation -->
            <div class="col-sm-3 p-0 evaluate">
                <!-- <img src="../assets/images/close_evaluate.png" class="close-evaluate px-2 py-3"> -->
                <p class="border-bottom w-100 bg-success text-light py-2 h3 px-5">Evaluate</p>
                <form action="./evaluate.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $code_row['user_id'] ?>">
                    <input type="hidden" name="event_id" value="<?= $code_row['event_id'] ?>">
                    <input type="hidden" name="moderator_id"
                        value="<?php echo base64_decode($_SESSION['LOGIN_MODERATOR']); ?>">



                    <div class="form-group px-5">
                        <br>
                        <h2>User Interface</h2>
                        <input type="hidden" name="ui_points" id="inputa" value="1">
                        <div class="switch-field">
                            <input type="radio" id="ui-1" class="input1" onclick="statusChanged()" name="ui" value="1"
                                checked />
                            <label for="ui-1">1</label>
                            <input type="radio" id="ui-2" class="input1" onclick="statusChanged()" name="ui"
                                value="2" />
                            <label for="ui-2">2</label>
                            <input type="radio" id="ui-3" class="input1" onclick="statusChanged()" name="ui"
                                value="3" />
                            <label for="ui-3">3</label>
                            <input type="radio" id="ui-4" class="input1" onclick="statusChanged()" name="ui"
                                value="4" />
                            <label for="ui-4">4</label>
                            <input type="radio" id="ui-5" class="input1" onclick="statusChanged()" name="ui"
                                value="5" />
                            <label for="ui-5">5</label>
                        </div>
                        <br>
                        <h2>User Experience</h2>
                        <input type="hidden" name="ux_points" id="inputb" value="1">
                        <div class="switch-field">
                            <input type="radio" id="ux-1" class="input2" onclick="statusChanged2()" name="ux" value="1"
                                checked />
                            <label for="ux-1">1</label>
                            <input type="radio" id="ux-2" class="input2" onclick="statusChanged2()" name="ux"
                                value="2" />
                            <label for="ux-2">2</label>
                            <input type="radio" id="ux-3" class="input2" onclick="statusChanged2()" name="ux"
                                value="3" />
                            <label for="ux-3">3</label>
                            <input type="radio" id="ux-4" class="input2" onclick="statusChanged2()" name="ux"
                                value="4" />
                            <label for="ux-4">4</label>
                            <input type="radio" id="ux-5" class="input2" onclick="statusChanged2()" name="ux"
                                value="5" />
                            <label for="ux-5">5</label>
                        </div>
                        <br>

                        <h2>Color Scheme</h2>
                        <input type="hidden" name="color_points" id="inputc" value="1">
                        <div class="switch-field">
                            <input type="radio" id="cs-1" class="input3" onclick="statusChanged3()" name="cs" value="1"
                                checked />
                            <label for="cs-1">1</label>
                            <input type="radio" id="cs-2" class="input3" onclick="statusChanged3()" name="cs"
                                value="2" />
                            <label for="cs-2">2</label>
                            <input type="radio" id="cs-3" class="input3" onclick="statusChanged3()" name="cs"
                                value="3" />
                            <label for="cs-3">3</label>
                            <input type="radio" id="cs-4" class="input3" onclick="statusChanged3()" name="cs"
                                value="4" />
                            <label for="cs-4">4</label>
                            <input type="radio" id="cs-5" class="input3" onclick="statusChanged3()" name="cs"
                                value="5" />
                            <label for="cs-5">5</label>
                        </div>

                        <br>
                        <h2>Code Readability</h2>
                        <input type="hidden" name="code_points" id="inputd" value="1">
                        <div class="switch-field">
                            <input type="radio" id="cr-1" class="input4" onclick="statusChanged4()" name="cr" value="1"
                                checked />
                            <label for="cr-1">1</label>
                            <input type="radio" id="cr-2" class="input4" onclick="statusChanged4()" name="cr"
                                value="2" />
                            <label for="cr-2">2</label>
                            <input type="radio" id="cr-3" class="input4" onclick="statusChanged4()" name="cr"
                                value="3" />
                            <label for="cr-3">3</label>
                            <input type="radio" id="cr-4" class="input4" onclick="statusChanged4()" name="cr"
                                value="4" />
                            <label for="cr-4">4</label>
                            <input type="radio" id="cr-5" class="input4" onclick="statusChanged4()" name="cr"
                                value="5" />
                            <label for="cr-5">5</label>
                        </div>
                        <br>

                        <textarea name="feedback" id="" cols="25" rows="5" placeholder="Enter Feedback"
                            style="border-radius:5px;padding:5px;"></textarea>
                        <br><br>
                        <button type="submit" class="btn btn-danger w-100 font-weight-bold">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script src="../../../assets/src-noconflict/ace.js"></script>

    <script>
        var html = ace.edit("html");
        ace.require("ace/ext/language_tools");

        html.setTheme("ace/theme/monokai");
        html.session.setMode("ace/mode/html");
        html.setValue(htmlFrameCode);

        var css = ace.edit("css");
        css.setTheme("ace/theme/monokai");
        css.session.setMode("ace/mode/css");
        css.setValue(cssFrameCode);

        var js = ace.edit("js");
        js.setTheme("ace/theme/monokai");
        js.session.setMode("ace/mode/javascript");
        js.setValue(jsFrameCode);
    </script>

    <script>
        function removeActive() {
            $(".view-code").removeClass("active");
            $(".desktop-view").removeClass("active");
            $(".mobile-view").removeClass("active");
            $(".evaluate").hide();
        }

        $(".desktop-view").click(function () {
            removeActive();
            $(".close-evaluate").show();
            $(".desktop-view").addClass("active");
            $(".output").removeClass("col-md-12");
            // $(".evaluate").show("slide", {
            //     direction: "right"
            // }, 500);
            $(".output").show();
            $(".code").hide();
            $(".mob").hide();
        });


        $(".open-evaluate").click(function () {
            $(".evaluate").toggle("slide", {
                direction: "right"
            }, 500);
        });

        $(".view-code").click(function () {
            removeActive();
            $(".view-code").addClass("active");
            $(".output").hide();
            $(".mob").hide();
            $(".code").show();
        });


        $(".mobile-view").click(function () {
            removeActive();
            $(".mobile-view").addClass("active");
            $(".code").hide();
            $(".mobile-output").show();
            $(".mob").show();
            $(".output").hide();
            $(".mobile-1").css('width', '55%');
            $(".mobile-1").css('height', '75%');
            $(".mobile-2").css('width', '55%');
            $(".mobile-2").css('height', '75%');
            $(".mobile-3").css('width', '45%');
            $(".mobile-3").css('height', '70%');
        });


        $("#js-title").click(function () {
            $(".js-div").show();
            $(".css-div").hide();
            $("#js-title").css('color', 'white');
            $("#css-title").css('color', 'black');
            $("#js-title").css('background', '#2F312A');
            $("#css-title").css('background', 'rgb(275, 275, 275)');
        });

        $("#css-title").click(function () {
            $(".css-div").show();
            $(".js-div").hide();
            $("#js-title").css('color', 'black');
            $("#css-title").css('color', 'white');
            $("#js-title").css('background', 'rgb(275, 275, 275)');
            $("#css-title").css('background', '#2F312A');
        });

        // $("#html-title").click(function () {
        //     $(".html-div").show();
        //     $(".css-div").hide();
        //     $(".js-div").hide();
        //     $("#js-title").css('color', 'black');
        //     $("#html-title").css('color', 'white');
        //     $("#css-title").css('color', 'black');
        //     $("#js-title").css('background', 'rgb(275, 275, 275)');
        //     $("#css-title").css('background', 'rgb(275, 275, 275)');
        //     $("#html-title").css('background', '#2F312A');
        // });
    </script>
    <script>
        function statusChanged() {
            let topics = document.getElementsByClassName("input1");
            for (let index = 0; index < topics.length; index++) {
                const element = topics[index];
                if (element.checked == true) {
                    document.getElementById('inputa').value = element.value;
                    // challengesTable.DataTable().columns(3).search( element.value, false, false, false ).draw();
                }
            }
        }

        function statusChanged2() {
            let topics = document.getElementsByClassName("input2");
            for (let index = 0; index < topics.length; index++) {
                const element = topics[index];
                if (element.checked == true) {
                    document.getElementById('inputb').value = element.value;
                    // challengesTable.DataTable().columns(3).search( element.value, false, false, false ).draw();
                }
            }
        }

        function statusChanged3() {
            let topics = document.getElementsByClassName("input3");
            for (let index = 0; index < topics.length; index++) {
                const element = topics[index];
                if (element.checked == true) {
                    document.getElementById('inputc').value = element.value;
                    // challengesTable.DataTable().columns(3).search( element.value, false, false, false ).draw();
                }
            }
        }

        function statusChanged4() {
            let topics = document.getElementsByClassName("input4");
            for (let index = 0; index < topics.length; index++) {
                const element = topics[index];
                if (element.checked == true) {
                    document.getElementById('inputd').value = element.value;
                    // challengesTable.DataTable().columns(3).search( element.value, false, false, false ).draw();
                }
            }
        }
    </script>


</body>

</html>