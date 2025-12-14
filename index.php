<?php
$errors = [
    'name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if ($name === '') $errors['name'] = 'Please enter name';
    
    if ($email === '') $errors['email'] = 'Please enter email';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
    
    if ($password === '') $errors['password'] = 'Please enter password';
    else {
        if (strlen($password) < 8) $errors['password'] = 'Password must be at least 8 characters';
        elseif (!preg_match('/[A-Z]/', $password)) $errors['password'] = 'Password must include an uppercase letter';
        elseif (!preg_match('/[0-9]/', $password)) $errors['password'] = 'Password must include a number';
        elseif (!preg_match('/[\W_]/', $password)) $errors['password'] = 'Password must include a special character';
    }

    if ($confirm_password === '') $errors['confirm_password'] = 'Please confirm password';
    elseif ($password !== $confirm_password) $errors['confirm_password'] = 'Passwords do not match';

    if (!array_filter($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        $file = 'users.json';
        $users = [];

        try {
            if (file_exists($file)) {
                $jsonData = file_get_contents($file);
                $users = json_decode($jsonData, true);
                if (!is_array($users)) $users = [];
            }
            $users[] = $user;

            if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)) === false) {
                throw new Exception('Error writing to JSON file.');
            }

            echo "<p style='color:green;'>Registration successful!</p>";

        } catch (Exception $e) {
            echo "<div style='color:red'>" . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>welcome to Registration</h2>
    <form  method="post" action="">
        <label for="username">Name:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="useremail">Email:</label>
        <input type="text" name="useremail" id="useremail" required><br><br>
        
        <label for="userpassword">Password:</label>
        <input type="text" name="userpassword" id="userpassword" required><br><br>

        <label for="userconfirmpassword">Confirm Password:</label>
        <input type="text" name="userconfirmpassword" id="userconfirmpassword" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

