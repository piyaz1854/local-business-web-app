<?php
header("Content-Type: application/json");

if ($_POST["name"] && $_POST["rating"]) {
  echo json_encode([
    "status" => "success",
    "message" => "⭐ Review added!"
  ]);
}
