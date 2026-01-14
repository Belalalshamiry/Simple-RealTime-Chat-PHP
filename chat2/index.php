<?php
require_once "db.php";

if(isset($_POST['login'])){
    $username = trim($_POST['username']);

    if($username != ""){
        $stmt = $db->prepare("SELECT id FROM users WHERE username=?");
        $stmt->execute([$username]);

        if($stmt->rowCount() == 0){
            $db->prepare("INSERT INTO users(username) VALUES(?)")->execute([$username]);
            $_SESSION['user_id'] = $db->lastInsertId();
        } else {
            $_SESSION['user_id'] = $stmt->fetchColumn();
        }

        header("Location: users.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center">

<form method="post" class="login-box">
  <h2>تسجيل الدخول</h2>
  <input type="text" name="username" placeholder="اسم المستخدم" required>
  <button name="login">دخول</button>
</form>

</body>
</html>
