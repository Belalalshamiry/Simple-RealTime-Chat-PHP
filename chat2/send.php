<?php
include "db.php";

$sender   = $_SESSION['user_id'];
$receiver = (int)$_POST['receiver'];
$message  = trim($_POST['message']);

$fileName = null;
$fileType = null;

if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){

  $allowed = ['jpg','png','gif','pdf','zip','docx'];
  $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

  if(in_array($ext, $allowed)){
    $fileType = in_array($ext,['jpg','png','gif']) ? 'image' : 'file';
    $newName = time()."_".$_FILES['file']['name'];

    $path = ($fileType == 'image')
      ? "uploads/images/".$newName
      : "uploads/files/".$newName;

    move_uploaded_file($_FILES['file']['tmp_name'], $path);
    $fileName = $newName;
  }
}

$stmt = $db->prepare("
 INSERT INTO messages 
 (sender_id, receiver_id, message, file_name, file_type)
 VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$sender, $receiver, $message, $fileName, $fileType]);

?>