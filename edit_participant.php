<?php

//ensure users are logged in to access this page
session_start();
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update participants score</title>
</head>
<body>
<a href=".">Back to index</a>
    <?php
        
        //including connection variables   
        include 'dbconnect.php';

        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') //has the user submitted the form and edited the participant
            {
                //UPDATE section
                $id = $_POST['id'];
                $kills = $_POST['kills'];
                $deaths = $_POST['deaths'];
                
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn->prepare("UPDATE participant SET kills = :kills, deaths = :deaths WHERE id = :id");
                $stmt->bindParam(':kills', $kills);
                $stmt->bindParam(':deaths', $deaths);
                $stmt->bindParam(':id', $id);
                
                if($stmt->execute()) {
                    echo "<p>Participant updated successfully!</p>";
                    echo "<a href='view_participants_edit_delete.php'>Back to participants list</a>";
                } else {
                    echo "<p>Error updating participant.</p>";
                }
                
            }
            else{
                //SELECT section
                $id = $_GET['id'];
                
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn->prepare("SELECT * FROM participant WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                $participant = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($participant) {
                    // Pass the participant data to the form
                    include "edit_participant_form.php";
                } else {
                    echo "<p>Participant not found.</p>";
                }
            }
        }
        catch(PDOException $e)
            {
                echo $e->getMessage(); //If we are not successful in connecting or running the query we will see an error
            }


        ?>


</body>
</html>