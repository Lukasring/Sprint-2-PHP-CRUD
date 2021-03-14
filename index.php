<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/main.css">
  <title>Management</title>
</head>

<body>
  <main>
    <?php
    include('./db.php');
    ?>
    <div class="table">
      <div class="col">ID</div>
      <div class="col">Name</div>
      <div class="col">Projects</div>
      <?php
      $query = "SELECT * FROM emploees";
      $result = mysqli_query($conn, $query);
      include('./lib/renderEmploeeTable.php');
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          renderEmploeeRow($row);
        }
        mysqli_free_result($result);
      } else {
        echo "0 results";
      }
      ?>
    </div>
    <div class="table">
      <div class="col">ID</div>
      <div class="col">Name</div>
      <div class="col">Emploees</div>
      <?php
      include('./lib/renderProjectsTable.php');
      $query = "SELECT * FROM projects";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          renderProjectRow($row);
        }
        mysqli_free_result($result);
      } else {
        echo "0 results";
      }
      ?>
    </div>


  </main>
  <?php
  mysqli_close($conn);
  ?>
</body>

</html>