<!-- page for managing users and only super admin can use this -->

<?php
require_once "auth.php";
Role(['super_admin']);

// define db
$db = new PDO(
"mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
"chris",
"1234!Apple"
);

// get all users so super admind can play with them or osmething idk
$users = $db->query("SELECT id,username,password, role FROM users")->fetchAll();
?>

<!doctype html>
<html>
<body>
    <h1>manage users</h1>
    <a href="dashboard.php" style = "padding: 10px; border-radius:5px; background-color:lightblue;">Dashboard</a>
    <table style = "padding: 15px; border-spacing: 30px; border: 1px solid black; border-collapse: collapse; margin-top: 20px;">
            <tr style="background-color: #a5afe8; color: black; text-align: left;">
            <th style = "border: 1px solid black; padding: 10px;">id</th>
            <th style = "border: 1px solid black; padding: 10px;">username</th>
            <th style = "border: 1px solid black; padding: 10px;">password</th>
            <th style = "border: 1px solid black; padding: 10px;">role</th>
            </tr>
            <?php foreach ($users  as $r): ?>
            <tr>
                <td style = "border: 1px solid black; padding: 10px;"><?= (int)$r['id'] ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['username'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['password'] ?? '') ?></td>
                <td style = "border: 1px solid black; padding: 10px;"><?= htmlspecialchars($r['role'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
</body>