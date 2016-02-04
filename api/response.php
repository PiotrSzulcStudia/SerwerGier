<?php
  function deliver_response($status = 400, $status_message = "Invalid Request", $data = NULL)
  {
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);

    echo $json_response;
  }
?>
