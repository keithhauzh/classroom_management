<?php

class Auth {
    public $database;

    //run this code when the object is created (constructed has two underscores)
    function __construct() {
        $this -> database = connectToDB();
    }

    public function login() {

        //3. get all the data from the login page form
        $email = $_POST['email'];
        $password = $_POST['password'];

        //4. check for error (make sure all fields are filled)
        if( empty($email ) || empty ($password) ) {
            setError("Please fill in all fields." , '/login');
        } else {
            //5. check if the email entered is in the system or not
            //5.1 sql command
            $sql = "SELECT * FROM users WHERE email = :email";

            //5.2 prepare
            $query = $this -> database -> prepare($sql);

            //5.3 execute
            $query->execute([
                'email' => $email
            ]);

            //5.4 fetch
            $user = $query -> fetch(); //return the first row of the list

            //check if user exists
            if ($user) {    
                //6. check if the password is correct or not
                if ( password_verify( $password, $user["password"] ) ) {

                    //7. login the user ('loggeduser' is declared and used in index.html as well)
                    $_SESSION['loggeduser'] = $user;

                    //8. redirect the user back in index.php
                    header("Location: /");
                    exit;

                } else {
                    echo "The password provided is incorrect";  
                }

                
            } else {
                echo "This email is not registered in our database.";
            }

            
        }
    }

    public function signup() {
        $database = connectToDB();

        // 3. get all the data from the sign-up page form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // 4. check for error (make sure all fields are filled)
        if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $confirm_password ) ) {
            setError( "All the fields are required", '/signup' );
        } else if ( $password !== $confirm_password ) {
            setError( "The password is not match", '/signup' );
        } else if ( strlen( $password ) < 8 ) { // check for the password length (make sure it's at least 8 characters)
            setError( 'Your password must be at least 8 characters', '/signup' );
        } else {
            // 5. create a user account
            // sql command 
            $sql = "INSERT INTO users (`name`,`email`,`password`) VALUES (:name, :email, :password)";
            // prepare
            $query = $database->prepare( $sql );
            // execute
            $query->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]);

            // redirect to login.php
            header("Location: /login");
            exit;
        }



    }

    public function logout(){
        //remove the user session
        unset($_SESSION['user']);

        //redirect back to index.php
        header("Location: /");
        exit;
    }
}