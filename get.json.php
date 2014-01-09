<?php
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    if(isset($_GET)) {
        // run a curl get
        $json = file_get_contents('https://www.doritos.com/v4/api/gallery/get.json?' . http_build_query($_GET));
        echo $json;
    } else {
        echo json_encode(array('result' => 'NOT OK'));
    }
?>