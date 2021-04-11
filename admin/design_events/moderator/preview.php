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

    <div class="container-fluid row mx-auto">
        <div class="col col-md-8 p-0 border" id="add-col">

            <div class="row-md-6">
                <iframe id="output"> </iframe>
            </div>

            <script>
                var output = document.getElementById("output").contentWindow.document;

                var htmlFrameCode = `<?php echo $code_row['html_code']; ?>`;
                var cssFrameCode = `<?php echo $code_row['css_code']; ?>`;
                var jsFrameCode = `<?php echo $code_row['js_code']; ?>`;

                output.open();

                var frameCode = htmlFrameCode;
                frameCode += "<style>" + cssFrameCode + "</style>";
                frameCode += "<script>" + jsFrameCode + "<\/script>";

                output.writeln(frameCode);
                output.close();
            </script>


            <div class="row-md-6 p-0 border" id="ready">
                <div class="editor-title border">
                    <p><span id="html-title"> HTML </span> <span id="css-title"> CSS </span> <span id="js-title"> JS
                        </span></p>
                </div>
                <div class="html-div">
                    <div id="html" class="editors" placeholder="HTML"> </div>
                </div>


                <div class="css-div" id="cssDiv">
                    <div id="css" class="editors" placeholder="CSS"> </div>
                </div>
                <div class="js-div" id="jsDiv">
                    <div id="js" class="editors" placeholder="JavaScript"> </div>
                </div>
            </div>
        </div>

    <div class="col-md-4 p-0 border">
        <p class="border-bottom bg-success text-light">Evaluate</p>
        <div class="form-group px-5">
        <br>
            <h2>User Interface</h2>
        <div class="switch-field">
            <input type="radio" id="ui-1" name="ui" value="yes" checked/>
            <label for="ui-1">1</label>
            <input type="radio" id="ui-2" name="ui" value="maybe" />
            <label for="ui-2">2</label>
            <input type="radio" id="ui-3" name="ui" value="no" />
            <label for="ui-3">3</label>
            <input type="radio" id="ui-4" name="ui" value="no" />
            <label for="ui-4">4</label>
            <input type="radio" id="ui-5" name="ui" value="no" />
            <label for="ui-5">5</label>
        </div>
            <br>
            <h2>User Experience</h2>
            <div class="switch-field">
            <input type="radio" id="ux-1" name="ux" value="yes" checked/>
            <label for="ux-1">1</label>
            <input type="radio" id="ux-2" name="ux" value="maybe" />
            <label for="ux-2">2</label>
            <input type="radio" id="ux-3" name="ux" value="no" />
            <label for="ux-3">3</label>
            <input type="radio" id="ux-4" name="ux" value="no" />
            <label for="ux-4">4</label>
            <input type="radio" id="ux-5" name="ux" value="no" />
            <label for="ux-5">5</label>
        </div>
            <br>

            <h2>Color Scheme</h2>
            <div class="switch-field">
            <input type="radio" id="cs-1" name="cs" value="yes" checked/>
            <label for="cs-1">1</label>
            <input type="radio" id="cs-2" name="cs" value="maybe" />
            <label for="cs-2">2</label>
            <input type="radio" id="cs-3" name="cs" value="no" />
            <label for="cs-3">3</label>
            <input type="radio" id="cs-4" name="cs" value="no" />
            <label for="cs-4">4</label>
            <input type="radio" id="cs-5" name="cs" value="no" />
            <label for="cs-5">5</label>
        </div>

            <br>
            <h2>Code Readability</h2>
            <div class="switch-field">
            <input type="radio" id="cr-1" name="cr" value="yes" checked/>
            <label for="cr-1">1</label>
            <input type="radio" id="cr-2" name="cr" value="maybe" />
            <label for="cr-2">2</label>
            <input type="radio" id="cr-3" name="cr" value="no" />
            <label for="cr-3">3</label>
            <input type="radio" id="cr-4" name="cr" value="no" />
            <label for="cr-4">4</label>
            <input type="radio" id="cr-5" name="cr" value="no" />
            <label for="cr-5">5</label>
        </div>
            <br>

            <textarea name="" id="" cols="25" rows="5" placeholder="Enter Feedback" style="border-radius:5px;padding:5px;"></textarea>
            <br><br>
            <button class="btn btn-danger w-100 font-weight-bold">SUBMIT</button>
        </div>
    </div>
    </div>
    </div>

    <div id="output1"></div>
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
        $("#js-title").click(function () {
            $(".js-div").show();
            $(".html-div").hide();
            $(".css-div").hide();
            $("#html-title").css('background', 'rgb(275, 275, 275)');
            $("#js-title").css('background', '#27A444');
            $("#css-title").css('background', 'rgb(275, 275, 275)');
        });

        $("#css-title").click(function () {
            $(".css-div").show();
            $(".html-div").hide();
            $(".js-div").hide();
            $("#html-title").css('background', 'rgb(275, 275, 275)');
            $("#js-title").css('background', 'rgb(275, 275, 275)');
            $("#css-title").css('background', '#27A444');
        });

        $("#html-title").click(function () {
            $(".html-div").show();
            $(".css-div").hide();
            $(".js-div").hide();
            $("#js-title").css('background', 'rgb(275, 275, 275)');
            $("#css-title").css('background', 'rgb(275, 275, 275)');
            $("#html-title").css('background', '#27A444');
        });
    </script>

</body>

</html>