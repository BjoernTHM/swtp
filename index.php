<?php
if (isset($_POST['action'])) {
    if (!file_exists("./chat/pull.txt")) 
        file_put_contents("./chat/pull.txt", time());
    if (time() - intval(file_get_contents("./chat/pull.txt")) > 10) {
        unlink("./chat/user.txt");
        if (file_exists("./chat/chat.txt") && strpos(file_get_contents("./chat/chat.txt"), "--------------------New Session--------------------" .  chr(10)) !== strlen(file_get_contents("./chat/chat.txt")) - strlen("--------------------New Session--------------------" . chr(10))) 
            file_put_contents("./chat/chat.txt", file_get_contents("./chat/chat.txt") . chr(10) . chr(10) . "--------------------New Session--------------------" . chr(10));
    } 
    $action = $_POST['action'];
    if (!file_exists("./chat/chat.txt")) 
        file_put_contents("./chat/chat.txt", "");
    if (!file_exists("./chat/user.txt")) 
        file_put_contents("./chat/user.txt", "1");
    $file = file_get_contents("./chat/chat.txt");
    switch ($action) {
        case "pull":
            echo $file;
            break;
        case "push":
            file_put_contents("./chat/chat.txt", $file . chr(10) . "[" . date("d.m.Y H:i:s") . "] " . $_POST['user'] . ": " . $_POST['value']);
            echo $file;
            break;
        case "login":
            $nr = intval(file_get_contents("./chat/user.txt")) + 1;
            echo $nr - 1;
            file_put_contents("./chat/user.txt", $nr);
            break;
    }
    file_put_contents("./chat/pull.txt", time());
    exit();
}
?>
<!DOCTYPE HTML>
<html manifest="" lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>sencha</title>
    <style type="text/css">
         /**
         * Example of an initial loading indicator.
         * It is recommended to keep this as minimal as possible to provide instant feedback
         * while other resources are still being loaded for the first time
         */
        html, body {
            height: 100%;
            background-color: #1985D0
        }

        #appLoadingIndicator {
            position: absolute;
            top: 50%;
            margin-top: -15px;
            text-align: center;
            width: 100%;
            height: 30px;
            -webkit-animation-name: appLoadingIndicator;
            -webkit-animation-duration: 0.5s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-direction: linear;
        }

        #appLoadingIndicator > * {
            background-color: #FFFFFF;
            display: inline-block;
            height: 30px;
            -webkit-border-radius: 15px;
            margin: 0 5px;
            width: 30px;
            opacity: 0.8;
        }

        @-webkit-keyframes appLoadingIndicator{
            0% {
                opacity: 0.8
            }
            50% {
                opacity: 0
            }
            100% {
                opacity: 0.8
            }
        }
    </style>
    <!-- The line below must be kept intact for Sencha Command to build your application -->
    <script id="microloader" type="text/javascript" src=".sencha/app/microloader/development.js"></script>
</head>
<body>
    <div id="appLoadingIndicator">
        <div></div>
        <div></div>
        <div></div>
    </div>
</body>
</html>
