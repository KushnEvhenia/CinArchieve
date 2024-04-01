<?php

session_start();  // Start session


if (isset($_SESSION['username'])) {
    //Check if user is logged

    $db = mysqli_connect('localhost', 'root', '', 'Movies');
    //Connect to db

    if (mysqli_connect_errno()) {
        //Check db connection
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle POST requests

        if(isset($_POST['delete'])){
            // Handle deletion of record

            $id = $_POST['delete'];

            $sql = "DELETE FROM Movies WHERE ID = $id";

            $db->query($sql);

        }

        elseif(isset($_FILES["file"])){
            //Handle file upload

            $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

            if($fileType == 'txt'){
            //Check fil type

                $path = $_FILES['file']["tmp_name"];

                $content = file_get_contents($path);

                if($content){
                //Check function got content of uploaded file

                    $content = trim($content, "\xEF\xBB\xBF");

                    $movie_data = explode("\r\n\r\n\r\n", $content);

                    if(!empty($movie_data)){
                    //Check if array with exploded content is not empty

                        foreach($movie_data as $arr){

                            $parsedData = [];
                        
                            $parts = explode("\n", $arr);

                            if(!empty($parts)){
                                //Check if array with exploded string is not empty

                                foreach($parts as $part){
                                
                                    $data = explode(':', $part);

                                    if(isset($data[0]) && isset($data[1])){
                                    // Check if both key and value exist in the parsed data array before adding them

                                        $parsedData[$data[0]] = $data[1];

                                    }
                                
                                }

                            }

                            if(isset($parsedData['Title']) && isset($parsedData['Stars']) && isset($parsedData['Release Year']) && isset($parsedData['Format'])){
                            //Check if written data in arr about movies exists 

                                $title = mysqli_real_escape_string($db, $parsedData['Title']);
                            
                                $year = (int) mysqli_real_escape_string($db, $parsedData['Release Year']);
                            
                                $format = mysqli_real_escape_string($db, $parsedData['Format']);
                            
                                $actors = mysqli_real_escape_string($db, $parsedData['Stars']);
                            
                                $sql = "INSERT INTO Movies (Title, Year, Format, Actors) VALUES ('$title', $year, '$format', '$actors')";

                                $db->query($sql);

                            }
                        
                        }

                    }

                }

            }

        }

        else{
        // Handle adding new movie record

            if(isset($_POST['name']) && isset($_POST['year']) && isset($_POST['actors']) && isset($_POST['format'])){
            //Check existance of keys and values to write values to table
            
                $name = mysqli_real_escape_string($db, $_POST['name']);

                $year = (int) mysqli_real_escape_string($db, $_POST['year']);

                $actors = mysqli_real_escape_string($db, $_POST['actors']);

                $format = mysqli_real_escape_string($db, $_POST['format']);

                $sql = "INSERT INTO Movies (Title, Year, Format, Actors) VALUES ('$name', $year, '$format', '$actors')";

                $db->query($sql);

            }

        }

        header("Location: dashboard.php", true, 303);

    }

    else{
        // Handle GET requests

        if(isset($_GET['sort'])){
        // Handle sorting query

            $sql = 'SELECT * FROM Movies ORDER BY Title ASC;';

        }

        elseif(isset($_GET['filmName'])){
        // Handle filtering by film name
            $filmName = mysqli_real_escape_string($db, $_GET['filmName']);

            $sql = "SELECT * FROM Movies WHERE Title LIKE '%$filmName%'";

        }

        elseif(isset($_GET['actorName'])){
        // Handle filtering by actor name

            $actorName = mysqli_real_escape_string($db, $_GET['actorName']);

            $sql = "SELECT * FROM Movies WHERE Actors LIKE '%$actorName%'";

        }

        else{
        // Default query to fetch all movies

            $sql = 'SELECT * FROM Movies';

        }

        $result = $db->query($sql);

        if($result->num_rows === 0){
        // Display message if no records found

            $result = "<p>Nothing found</p>";

        }

    }

}
else{
//Redirect if user is not logged in

    header("Location: index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <section class="darken">
    <div class="dashboard-holder">
        <h1>Add movie</h1>
        <form id="add" method="post">
            FILM NAME
            <input type="text" required name="name" placeholder="Film name">
            RELEASE YEAR
            <input type="number" required name="year" placeholder="Release year">
            ACTORS
            <textarea name="actors" required placeholder="Actors"></textarea>
            FORMAT
            <select name="format">
                <option value="DVD">DVD</option>
                <option value="VHS">VHS</option>
                <option value="B-RAY">B-RAY</option>
            </select>
            <input type="submit">
        </form>
        <h1>Add from file</h1>
        <form method="post" enctype="multipart/form-data" id="file">
            <input type="file" name="file" required>
            <input type="submit" value="Add from file">
        </form>
        <h1>My list</h1>
        <form method="get" id="sort">
            <input type="submit" name="sort" value="sort">
        </form>
        <form method="get" class="filter-form">
            <input type="text" name="filmName" placeholder="Search by film name" required>
            <input type="submit" value="Search">
        </form>
        <form method="get" class="filter-form">
            <input type="text" name="actorName" placeholder="Search by actors" required>
            <input type="submit" value="Search">
        </form>
        <a href="/dashboard.php" id="reset">Reset filter</a>
        <div id="movies-list">
            <?php 
                if($result && is_iterable($result)){
                    foreach($result as $arr){
            ?>
                        <div class="item">
                            <h2><?= $arr['Title'] ?? '' ?></h2>
                            <div><?= $arr['Year'] ?? '' ?></div>
                            <div><?= $arr['Actors'] ?? '' ?></div>
                            <div><?= $arr['Format'] ?? ''?></div>
                            <form method="POST">
                                <input type="submit" value="<?= $arr['id'] ?? '' ?>" name="delete" id="delete">
                            </form>
                        </div>     
            <?php 
                    }
                }
                else{
                    echo $result;
                }
            ?>
        </div>
    </div>
    </section>
    <script>
        document.getElementById('delete').addEventListener('click', function() {

            var confirmed = confirm('Are you sure you want to delete?');

            if (confirmed) {

                this.form.submit();

            }

        });
    </script>
</body>
</html>