<?php
require_once "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}

if(!isset($_GET['user'])){
    die("اختر مستخدم للدردشة");
}

$other = (int)$_GET['user'];
?>



<!DOCTYPE html>
<html>
<head>
<title>Chat</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
    
</style>
</head>
<body>

<div class="chat-container">
<div id="chat-header">الدردشة</div>
  <div id="chat-box"></div>
  <div class="chat-input">
  <img id="preview" src="" alt="معاينة الصورة" style="max-width:50px; display:none; margin-right:5px; border-radius:5px;">

<input type="file" id="file">
  <input type="text" id="msg" placeholder="اكتب رسالة...">
  <button type="button" onclick="sendMessage(otherUser)">➤</button>
  </div>


</div>

<script>
  const otherUser = <?= $other ?>;
  const myId = <?= $_SESSION['user_id'] ?>;
</script>

<script src="assets/script/script.js"></script>
</body>
</html>
