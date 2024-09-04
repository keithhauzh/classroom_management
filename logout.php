<?php
    //start session
    session_start();

    //remove the user session
    unset ( $_SESSION ['loggeduser'] );

    //redirect back to index.php
    header("Location:index.php");
    exit;