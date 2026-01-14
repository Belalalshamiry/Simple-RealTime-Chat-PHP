<?php
require_once "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}

$me = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$me]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>المستخدمين</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<h2>اختر مستخدم للدردشة معه:</h2>
<ul>
<?php foreach($users as $u): ?>
    <li>
        <a href="chat.php?user=<?= $u['id'] ?>">
            <?= htmlspecialchars($u['username']) ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
</body>
</html>
