<?php
$errors = [];
$user_file = 'users.json';
$users = [];

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $name = ($_POST['username']);
    $email = ($_POST['useremail']);
    $password = ($_POST['userpassword']);
    $confirmpassword = ($_POST['userconfirmpassword']);

    if ($name == ''){
        $errors[] = "Name is required";
    }

    if ($email == ''){
        $errors[] = "Email is required";
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Email is not valid";
    }

    if ($password == ''){
        $errors[] = "Password is required";
    }else if (strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters long";
    }else if (!preg_match('/[A-Z]/', $password)){
        $errors[] = "Password must contain at least one uppercase letter";
    }

    if ($confirmpassword == ''){
        $errors[] = "Confirm password is required";
    }else if ($password !== $confirmpassword){
        $errors[] = "Password and Confirm password do not match";
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

