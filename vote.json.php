<?php
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');

    if(isset($_GET)) {
        // https://doritoscrashthesuperbowl.thismoment.com/v4/api/content/vote.json?content_id=14389
        $result = json_decode(file_get_contents('https://doritoscrashthesuperbowl.thismoment.com/v4/api/content/vote.json?' . http_build_query($_GET)), true);
        array_push($result, array('queried_url' => 'https://doritoscrashthesuperbowl.thismoment.com/v4/api/content/vote.json?' . http_build_query($_GET)));
        echo json_encode($result);
    } else {
        echo json_encode(array('result' => 'NOT OK'));
    }
?>