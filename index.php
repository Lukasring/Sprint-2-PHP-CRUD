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
    require('./db.php');
    require('./lib/delete.php');

    if (isset($_POST['delete'])) {
      $stmt = $conn->prepare("DELETE FROM emploees WHERE id=?");
      $stmt->bind_param("i", $id);
      $table = $_POST['table'];
      $id = $_POST['id'];
      $stmt->execute();
    }
    if (isset($_POST['new-emp'])) {
      $stmt = $conn->prepare("INSERT INTO emploees (firstname, lastname, pid) VALUES (?, ?, ?)");
      $stmt->bind_param("ssi", $firstname, $lastname, $pid);
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $pid = $_POST['project-id'] === '' ? null : $_POST['project-id'];
      $stmt->execute();
    }
    if (isset($_POST['update-emp'])) {
      $stmt = $conn->prepare("UPDATE emploees SET `firstname`=?, `lastname`=?, `pid`=? WHERE `id`=?");
      $stmt->bind_param("ssii", $firstname, $lastname, $pid, $eid);
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $pid = $_POST['project-id'] === '' ? null : $_POST['project-id'];
      $eid = $_POST['employee-id'];
      $stmt->execute();
    }
    ?>
    <div class="table">
      <div class="col">ID</div>
      <div class="col">Name</div>
      <div class="col">Projects</div>
      <div class="col">Actions</div>
      <?php
      $query = "SELECT emploees.id, emploees.firstname, emploees.lastname, projects.`name` FROM emploees
      LEFT JOIN projects ON emploees.pid = projects.pid";
      $result = mysqli_query($conn, $query);
      require('./lib/renderEmploeeTable.php');
      if (mysqli_num_rows($result) > 0) {
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          renderEmploeeRow($row, $count);
          $count++;
        }
        mysqli_free_result($result);
      } else {
        echo "0 results";
      }
      ?>
    </div>
    <div>
      <?php

      ?>
    </div>
    <!-- <div class="table">
      <div class="col">ID</div>
      <div class="col">Name</div>
      <div class="col">Emploees</div>
      <?php
      // include('./lib/renderProjectsTable.php');
      // $query = "SELECT * FROM projects";
      // $result = mysqli_query($conn, $query);
      // if (mysqli_num_rows($result) > 0) {
      //   while ($row = mysqli_fetch_assoc($result)) {
      //     renderProjectRow($row);
      //   }
      //   mysqli_free_result($result);
      // } else {
      //   echo "0 results";
      // }
      ?>
    </div> -->

    <?php
    $defaultFirstname = '';
    $defaultLastname = '';
    $defaultEmployeeId = null;
    $defaultProjectId = '';
    $formName = 'new-emp';

    if (isset($_POST['update'])) {
      // $stmt = $conn->prepare("INSERT INTO emploees (firstname, lastname, pid) VALUES (?, ?, ?)");
      // $stmt->bind_param("ssi", $firstname, $lastname, $pid);
      // $firstname = $_POST['firstname'];
      // $lastname = $_POST['lastname'];
      // $pid = $_POST['project-id'] === '' ? null : $_POST['project-id'];
      // $stmt->execute();
      $defaultFirstname = $_POST['firstname'];
      $defaultLastname = $_POST['lastname'];
      $defaultEmployeeId = $_POST['id'];

      $formName = 'update-emp';

      // $defaultProjectId = $_POST['id'];
    }

    echo "<form id='employee-form' action='' method='POST'>";
    echo "<label for='firstname'>First name</label>";
    echo "<input type='text' id='firstname' name='firstname' placeholder='firstname' value={$defaultFirstname}>";
    echo "<label for='lastname'>Last name</label>";
    echo "<input type='text' id='lastname' name='lastname' placeholder='lastname' value={$defaultLastname}>";
    echo "<label for='project'>Project</label>";
    echo "<select id='project-id' name='project-id'>";
    echo "<option value='' " . ($defaultProjectId == '' ? 'selected' : '') . ">None</option>";
    echo "<option value='1'" . ($defaultProjectId == '1' ? 'selected' : '') . ">Project 1</option>";
    echo "<option value='2'" . ($defaultProjectId == '2' ? 'selected' : '') . ">Project 2</option>";
    echo "</select>";
    echo "<button type='submit' name={$formName}>Submit</button>";
    echo "<input type='hidden' name='employee-id' value='$defaultEmployeeId'>";
    echo "</form>";
    ?>
    <!-- <form id="employee-form" action='' method="POST">
      <label for="firstname">First name</label>
      <input type="text" id="firstname" name="firstname" placeholder="firstname" value="">
      <label for="lastname">Last name</label>
      <input type="text" id="lastname" name="lastname" placeholder="lastname">
      <label for="project">Project</label>
      <select id="project-id" name="project-id">
        <option value=''>None</option>
        <option value="1">Project 1</option>
        <option value="2">Project 2</option>
      </select>
      <button type="submit" name="employee">Submit</button>
    </form> -->

  </main>
  <?php
  mysqli_close($conn);
  ?>
</body>

</html>