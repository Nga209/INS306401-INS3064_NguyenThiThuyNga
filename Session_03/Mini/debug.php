<?php
echo "<h1>Debug Session và Login</h1>";

// Test 1: Session có hoạt động không?
echo "<h2>Test 1: Session</h2>";
session_start();
$_SESSION['test'] = 'Hello World';
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session test value: " . $_SESSION['test'] . "</p>";

// Test 2: Kiểm tra user trong database
echo "<h2>Test 2: Database</h2>";
if (file_exists('Mini/includes/database.php')) {
    require_once 'Mini/includes/database.php';
    $users = Database::getUsers();
    echo "<p>Số user trong database: " . count($users) . "</p>";
    echo "<pre>";
    foreach ($users as $user) {
        echo "Email: " . $user['email'] . "\n";
        echo "Password hash: " . substr($user['password'], 0, 20) . "...\n";
        echo "---\n";
    }
    echo "</pre>";
}

// Test 3: Kiểm tra password
echo "<h2>Test 3: Password Test</h2>";
if (isset($_POST['test_email']) && isset($_POST['test_password'])) {
    $email = $_POST['test_email'];
    $password = $_POST['test_password'];
    
    $user = Database::findUserByEmail($email);
    if ($user) {
        $result = password_verify($password, $user['password']);
        echo "<p>Password verify: " . ($result ? "✅ ĐÚNG" : "❌ SAI") . "</p>";
        echo "<p>Input password: $password</p>";
        echo "<p>Stored hash: " . $user['password'] . "</p>";
    } else {
        echo "<p>❌ Không tìm thấy user với email: $email</p>";
    }
}

// Test 4: Kiểm tra file paths
echo "<h2>Test 4: File Paths</h2>";
$files = [
    'config.php' => 'Mini/includes/config.php',
    'database.php' => 'Mini/includes/database.php',
    'helpers.php' => 'Mini/includes/helpers.php',
    'users.json' => 'Mini/data/users.json'
];

foreach ($files as $name => $path) {
    if (file_exists($path)) {
        echo "<p>✅ $name: TỒN TẠI tại $path</p>";
    } else {
        echo "<p>❌ $name: KHÔNG TỒN TẠI tại $path</p>";
    }
}
?>

<form method="POST" style="background:#f0f0f0; padding:20px; margin-top:20px;">
    <h3>Test Login Trực Tiếp</h3>
    <input type="email" name="test_email" placeholder="Email" required style="padding:10px; margin:5px;">
    <input type="password" name="test_password" placeholder="Password" required style="padding:10px; margin:5px;">
    <button type="submit" style="padding:10px 20px; background:blue; color:white; border:none;">Test Login</button>
</form>