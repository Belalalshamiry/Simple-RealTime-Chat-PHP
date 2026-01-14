<?php
session_start();
require_once "db.php";  // الاتصال بقاعدة البيانات

// تأكد أن المستخدم مسجّل الدخول
if(!isset($_SESSION['user_id'])){
    die("غير مسموح");
}

$sender = $_SESSION['user_id'];
$receiver = isset($_POST['receiver']) ? (int)$_POST['receiver'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : null;

$fileName = null;
$fileType = null;

// إذا تم رفع ملف
if(!empty($_FILES['file']['name'])){
    $fileTmp  = $_FILES['file']['tmp_name'];
    $origName = $_FILES['file']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

    // مجلد الصور
    $uploadDir = "uploads/images/";

    if(!file_exists($uploadDir)){
        mkdir($uploadDir, 0777, true); // إنشاء المجلد إذا لم يكن موجود
    }

    // اسم جديد للملف
    $fileName = time() . "_" . rand(1000,9999) . "." . $ext;

    // رفع الملف
    if(move_uploaded_file($fileTmp, $uploadDir . $fileName)){
        $fileType = "image"; // نوع الملف
    } else {
        $fileName = null;
        $fileType = null;
    }
}

// إدخال الرسالة في قاعدة البيانات
$stmt = $db->prepare("
    INSERT INTO messages (sender_id, receiver_id, message, file_name, file_type)
    VALUES (?,?,?,?,?)
");
$stmt->execute([$sender, $receiver, $message, $fileName, $fileType]);

// إعادة JSON للتأكيد (اختياري)
// echo json_decode([
//     "status" => "success",
//     "message" => $message,
//     "file_name" => $fileName,
//     "file_type" => $fileType
// ]);