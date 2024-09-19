<?php

session_start();

require 'includes/functions.php';

//load the class files
require 'includes/class-auth.php';
require 'includes/class-student.php';

//initialise the classes
$auth = new Auth();
$student = new Student();

$path = $_SERVER['REQUEST_URI'];

switch ($path) {
  // Pages
  case '/login':
    require 'pages/login.php';
    break;
  case '/signup':
    require 'pages/signup.php';
    break;

  // Student
  case '/student/add':
    $student -> add();
    break;
  case '/student/edit':
    $student -> edit();
    break;
  case '/student/delete':
    $student -> delete();
    break;

  // Auth
  case '/auth/login':
    $auth -> login();
    break;
  case '/auth/signup':
    $auth -> signup();
    break;
  case '/auth/logout':
    $auth -> logout();
    break;
    
  // Default
  default:
    require 'pages/home.php';
    break;
}

?>