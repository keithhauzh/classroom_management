<?php
  // put your backend code

  //start session
  session_start();

  // 1. collect database info
  // $host = "localhost"; // for windows user
  // $host = "127.0.0.1";  // for mac user
  $host = 'localhost';
  $database_name = "classroom_management"; // connecting to which database 
  $database_user = "root";
  $database_password = "mysql";

  // 2. connect to database (PDO - PHP database object)
  $database = new PDO(
    "mysql:host=$host;dbname=$database_name",
    $database_user, // username
    $database_password // password
  );

  // 3. get students data from the database
  // 3.1 - SQL command (recipe)
  $sql = "SELECT * FROM students";
  // 3.2 - prepare SQL query (prepare your material)
  $query = $database->prepare($sql); 
  // 3.3 - execute SQL query (to cook)
  $query->execute();
  // 3.4 - fetch all the results (eat)
  $students = $query->fetchAll();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Classroom Management</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
    </style>
  </head>
  <body>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px">
      <div class="card-body">
        <h3 class="card-title mb-3">My Classroom</h3>
        <?php if ( isset ($_SESSION['loggeduser'] ) ) : ?>
          <h4>Welcome back, <?= $_SESSION['loggeduser']['name']; ?></h4>
          <a href="logout.php">Logout</a>
          <form method="POST" action="add_student.php">
            <div class="mt-4 d-flex justify-content-between align-items-center">
              <input
                type="text"
                class="form-control"
                placeholder="Add new student..."
                name="student_name"
              />
              <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
            </div>
          </form>
        <?php else : ?>
          <a href="login.php">Login</a>
          <a href="signup.php">Signup</a>
        <?php endif ;?>
      </div>
    </div>

    <?php if (isset( $_SESSION['loggeduser'])) : ?>
      <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px">
        <div class="card-body">
          <h3 class="card-title mb-3">Students</h3>
          <?php foreach ($students as $index => $student) : ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <h5 class="me-1"><?= $index+1; ?>.</h5>
              <div class="d-flex gap-1 w-100">
                <!-- UPDATE -->
                <form
                  method="POST"
                  action="/update.php"
                  >
                  <input type="text" name="student_name" value="<?= $student["name"]; ?>" />
                  <input type="hidden" name="student_id" value="<?= $student["id"]; ?>" />
                  <button class="btn btn-success btn-sm">Update</button>
                </form>
                <!-- DELETE -->
                <form
                  method="POST"
                  action="/delete_student.php"
                  >
                  <input type="hidden" name="student_id" value="<?= $student["id"]; ?>" />
                  <button class="btn btn-danger btn-sm">Delete</button>
                </form>  
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif ;?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script str="alignment.js"></script>
  </body>
</html>
