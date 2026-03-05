<?php
declare(strict_types=1); 
session_start();
$db = new PDO(
    "mysql:host=localhost;dbname=CSE135;charset=utf8mb4",
    "chris",
    "1234!Apple"
);
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
  );

  CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
  );
");


$userCount = (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($userCount == 0) {
  $graderPw = password_hash('grader', PASSWORD_DEFAULT);
  $query = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
  $query->execute(['grader', $graderPw]);
}

if (isset($_SESSION['user'])) {
  header("Location: dashboard.php");
  exit;
}

// if someone tries to log in, it would be a post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // without the '', it would give error if empty login info
  $username = trim($_POST['username'] ?? '');
  $pass = $_POST['password'] ?? '';

  $query = $db->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
  $query->execute([$username]);
  $user = $query->fetch(PDO::FETCH_ASSOC);

  if (!$user || !password_verify($pass, $user['password'])) {
    $err = "username or password wrong";
  } 
  else {
    // make and store new user
    session_regenerate_id(true);
    $_SESSION['user'] = [
      'id' => $user['id'],
      'username' => $user['username']
    ];
    header("Location: dashboard.php");
    exit;
  }
}
?>

<!doctype html>
<html>
  <body>
    <h2>Login</h2>
    <form method="POST" style="display: flex; flex-direction: column; gap: 30px;">
      <label>Username <input name="username" required></label>
      <label>Password <input type="password"name="password" required></label>
      <button type="submit" style="width: 20%;">Login</button>
    </form>
    <!-- this shows if login is right or not -->
    <?php if (!empty($err)): ?>
      <p style="color:red"><?= htmlspecialchars($err) ?></p>
    <?php endif; ?>
  </body>

</html>

