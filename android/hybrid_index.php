<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="imagetoolbar" content="no">
    <title>e약방</title>
    <style>
        html, body {
            height: 100%;
            background-color: #13D191;
        }

        * {
            margin: 0;
            padding: 0;
        }

        /*layer mask*/
        .layer_mask {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 250;
        }

        /*page loading*/
        .loading_wrap {
            width: 60%;
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            z-index: 450;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
        }

        .loading_wrap span {
            display: inline-block;
        }

        .loading_wrap .loader {
            border: 5px solid #777;
            border-radius: 50%;
            border-top: 5px solid #fff;
            width: 80px;
            height: 80px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            -moz-animation: spin 2s linear infinite;
        }

        .loading_wrap .loading_text {
            display: block;
            font-size: 18px;
            color: #fff;
            margin-top: 25px;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @-moz-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .fulidx {
            height: 100%;
            position: relative;
        }

        .midTX {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<div class="fulidx">

    <div class="midTX"><img src="./images/common/elogo.png"></div>

</div>
</body>

<script type="text/javascript" src="./js/jquery-1.12.4.min.js"></script>
<script>
    location.href = "./main/main.php";
</script>
</html>