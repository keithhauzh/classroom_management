<?php

class Student {
    public $database;

    //run this code when the object is created (constructed has two underscores)
    function __construct() {
        $this -> database = connectToDB();
    }

    public function add() {
        $database = connectToDB();

        $name = $_POST["student_name"];

        // 1. check whether the user insert a name
        if ( empty( $name ) ) {
            echo "Please insert a name";
        } else {
            // 2. add the student name to database
            // 2.1 (recipe)
            $sql = 'INSERT INTO students (`name`) VALUES (:name)';
            // 2.2 (prepare)
            $query = $database->prepare( $sql );
            // 2.3 (execute)
            $query->execute([
                'name' => $name
            ]);
            
            // 3. redirect the user back to index.php
            header("Location: /");
            exit;
        }
    }

    public function delete() {
        $database = connectToDB();

        $id = $_POST["student_id"];

        // delete the selected student from the table using student ID
        // sql command (recipe)
        $sql = "DELETE FROM students where id = :id";
        // prepare  
        $query = $database->prepare( $sql );
        // execute
        $query->execute([
            'id' => $id
        ]);

        //redirect
        header("Location: /");
        exit;
    }

    public function edit() {
        $database = connectToDB();

        $name = $_POST["student_name"];
        $id = $_POST["student_id"];

        // check if name if not empty
        if( empty ( $name )) {
            setError ("Please insert a name", '/');
        } else {
            // update the name of the student
            

            // sql command (recipe)
            $sql = "UPDATE students SET name = :name WHERE id = :id";

            // prepare
            $query = $database->prepare ( $sql );

            //execute
            $query->execute([
                'name' => $name,
                'id' => $id
            ]);

            //redirect
            header("Location: /");
            exit;
        }
    }
}