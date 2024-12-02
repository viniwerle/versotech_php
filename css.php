<?php
function renderHeader($title = 'VersoTech') {
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$title</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
";}

function renderFooter() {
    echo "
        </div>
    </body>
    </html>
    ";
}
