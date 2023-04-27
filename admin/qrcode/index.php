<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Lightweight progressive web app for scanning QR codes offline">
    <meta name="keywords" content="qrcode, scanner, scan, offline, progressive, web, app, pwa, free, lightweight, light">
    <meta name="author" content="Louis Lagrange">
    <title>Kuriftu QR Code Scanner</title>

    <link rel="manifest" href="manifest.json">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="assets/images/icons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="assets/images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#3f51b5">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="QR Code Scanner">
    <meta name="application-name" content="QR Code Scanner">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#3f51b5">

    <script type="text/javascript">
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('service-worker.js');
        }
    </script>

    <link rel="stylesheet" type="text/css" href="assets/lib/dialog-polyfill/dialog-polyfill.css" />
    <link rel="stylesheet" href="assets/lib/material-design-lite/material.min.css">
    <link rel="stylesheet" href="assets/style.css">

    <script src="assets/lib/dialog-polyfill/dialog-polyfill.js"></script>
    <script src="assets/lib/material-design-lite/material.min.js"></script>
    <script src="assets/lib/clipboard/dist/clipboard.min.js"></script>
    <script>
        const role = "<?php echo $_SESSION['ticket_token'] ?>"

        // console.log(role);
    </script>
    <script src="assets/app.js"></script>
</head>

<body>
    <div id="loading" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>

    <video id="camera" autoplay>You need a camera in order to use this app.</video>
    <div id="snapshotLimitOverlay">
        <div id="about">
            <h4>QR Code Scanner</h4>
            <p>
                This is a lightweight progressive web app for scanning QR Codes offline.<br />
                You'll need at least a camera and a compatible browser.<br />
                Source code is available on GitHub (Minishlink/pwa-qr-code-scanner), click the <strong>About</strong> button.
            </p>
        </div>
    </div>
    <canvas id="snapshot"></canvas>
    <button id="flipCamera" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Flip Camera</button>
    <a id="aboutButton" type="button" href="https://github.com/Minishlink/pwa-qr-code-scanner" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">About</a>

    <dialog class="mdl-dialog">
        <h4 class="mdl-dialog__title">Your text</h4>
        <div class="mdl-dialog__content">
            <p id="resultsContainer"><span id="result"></span></p>
            <p>
                <button type="button" class="copy mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised" data-clipboard-target="#result">Copy</button>
                <a class="search mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised">Search</a>
            </p>
        </div>
        <div class="mdl-dialog__actions">
            <button type="button" class="continue mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored">Continue</button>
        </div>
    </dialog>
</body>

</html>