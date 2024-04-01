<?php 

    $msg = ''; 

    $correct_username = 'test'; // Correct username 
    $correct_password = 'test'; // Correct password 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the request method is POST

        $name = htmlspecialchars($_POST["username"]); // Get the username from POST global var
        $psswd = htmlspecialchars($_POST["password"]); // Get the password from POST global var

        if($correct_password === $psswd && $correct_username === $name){
            // Check if the submitted username and password match correct ones

            session_start(); // Start a session 
            $_SESSION['username'] = $name; // Store the username in the session var

            header("Location: dashboard.php"); // Redirect the user to the dashboard page after successful login
            exit(); 
        }
        else{
            $msg = 'Wrong password or email'; // Set an error message 
        }  
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <section id="login">
        <div class="shadow">
            <div class="holder">
                <h1>My cinema archieve</h1>
                <form method="POST" id="login_form">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="login">
                </form>
                <div id="errorContainer"><?= $msg ?></div>
            </div>
        </div>
    </section>
</body>
</html>
