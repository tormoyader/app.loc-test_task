<?php
header("Content-Type: application/json");

$data = [
  'message' => 'Some backend page!'
];

echo json_encode($data);
?>
