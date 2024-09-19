<?php
    // Function to connect to database
    function connectToDB(){
        // Setup database credential
        $host = 'localhost';
        $database_name = "classroom_management"; // connecting to which database 
        $database_user = "root";
        $database_password = "mysql";

        // Connect to database (PDO - PHP database object)
        $database = new PDO(
            "mysql:host=$host;dbname=$database_name",
            $database_user, // username
            $database_password // password
        );

        return $database;
    }

     // Function to add error messages
    function setError($message, $path){
        $_SESSION["error"] = $message;
        // Redirect user to a specific page
        header("Location: ".$path);
        exit;
    }

    // Function to add sucees messages
    function setSuccess($message, $path){
        $_SESSION["success"] = $message;
        // Redirect user to a specific page
        header("Location: ".$path);
        exit;
    }

    // Function to add success messages
    

