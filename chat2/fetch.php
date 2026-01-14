<?php
include "db.php";

$me = $_SESSION['user_id'];
$other = (int)$_GET['user'];

$stmt = $db->prepare("
 SELECT messages.*, users.username
 FROM messages
 JOIN users ON users.id = messages.sender_id
 WHERE 
  (sender_id=? AND receiver_id=?)
  OR
  (sender_id=? AND receiver_id=?)
 ORDER BY id ASC
");

$stmt->execute([$me,$other,$other,$me]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

?>