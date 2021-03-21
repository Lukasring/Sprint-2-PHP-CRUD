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
  <header>
    <nav>
      <ul>
        <li><a href="./">Employees</a></li>
        <li><a href="?path=projects">Projects</a></li>
      </ul>
    </nav>
    <div>EMPLOYEE & PROJECTS MANAGER</div>
  </header>
  <main>
    <?php
    require('./db.php');

    $conn = connectToDb('localhost', 'root', 'mysql', 'sprint2');

    if (isset($_POST['delete']) && $_POST['table'] == 'employees') {
      deleteFromTable($conn, 'employees', $_POST['id']);
    }
    if (isset($_POST['delete']) && $_POST['table'] == 'projects') {
      deleteProject($conn, $_POST['pid']);
    }
    if (isset($_POST['new-emp']) && !empty($_POST['firstname']) && !empty($lastname = $_POST['lastname'])) {
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $pid = $_POST['project-id'] === '' ? null : $_POST['project-id'];
      addNewEmployee($conn, $firstname, $lastname, $pid);
    }
    if (isset($_POST['new-project']) && !empty($_POST['name'])) {
      $name = $_POST['name'];
      addNewProject($conn, $name);
    }
    if (isset($_POST['update-emp']) && !empty($_POST['firstname']) && !empty($lastname = $_POST['lastname'])) {
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $pid = $_POST['project-id'] === '' ? null : $_POST['project-id'];
      $eid = $_POST['employee-id'];
      updateEmployee($conn, $firstname, $lastname, $pid, $eid);
    }
    if (isset($_POST['update-project']) && !empty($_POST['name'])) {
      $name = $_POST['name'];
      $pid = $_POST['pid'];
      updateProject($conn, $name, $pid);
    }

    ?>

    <?php
    if (isset($_GET['path']) && $_GET['path'] == 'projects') {
      // Iki else renderina projektu lentele
      require('./lib/renderProjectsTable.php');

      echo "<div class='table projects'>";
      echo "<div class='col'>ID</div>";
      echo "<div class='col'>Name</div>";
      echo "<div class='col'>Employees</div>";
      echo "<div class='col'>Actions</div>";

      $query = "SELECT projects.`pid`, projects.`name`, 
      GROUP_CONCAT(CONCAT_WS(\" \", employees.firstname, employees.lastname) separator \", \") 
      as fullnames FROM projects
      LEFT JOIN employees
      ON projects.pid = employees.pid
      GROUP BY projects.pid";

      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        $count = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          renderProjectRow($row, $count);
          $count++;
        }
        mysqli_free_result($result);
      } else {
        echo "No Projects";
      }
      echo "</div>";


      $defaultProjectName = '';
      $defaultProjectId = '';
      $formName = 'new-project';
      $formTitle = 'Add New Project';

      if (isset($_POST['update'])) {
        $defaultProjectName = $_POST['name'];
        $defaultProjectId = $_POST['pid'];
        $formName = 'update-project';
        $formTitle = 'Update Project Name';
      }
      echo "<form id='employee-form' action='' method='POST' class='form employee'>";
      echo "<h2>{$formTitle}</h2>";
      echo "<label for='name'>Project name*</label>";
      echo "<input type='text' id='name' name='name' placeholder='Project Name' value='{$defaultProjectName}'>";
      echo "<button type='submit' name={$formName} class='btn'>Submit</button>";
      echo "<input type='hidden' name='pid' value='$defaultProjectId'>";
      echo "</form>";
    } else {
      // cia renderina darbuotoju lentele ir forma
      require('./lib/renderEmploeeTable.php');

      echo "<div class='table employee'>";
      echo "<div class='col'>ID</div>";
      echo "<div class='col'>Name</div>";
      echo "<div class='col'>Projects</div>";
      echo "<div class='col'>Actions</div>";

      $query = "SELECT employees.id, employees.firstname, employees.lastname, projects.`name`, projects.`pid` FROM employees
      LEFT JOIN projects ON employees.pid = projects.pid";
      $result = mysqli_query($conn, $query);
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

      echo "</div>";

      $defaultFirstname = '';
      $defaultLastname = '';
      $defaultEmployeeId = null;
      $defaultProjectId = '';
      $formName = 'new-emp';
      $formTitle = 'Add New Employee';

      if (isset($_POST['update'])) {
        $defaultFirstname = $_POST['firstname'];
        $defaultLastname = $_POST['lastname'];
        $defaultEmployeeId = $_POST['id'];
        $defaultProjectId = $_POST['pid'];

        $formName = 'update-emp';
        $formTitle = 'Update Employee Info';
      }

      $query = "SELECT projects.`pid`, projects.`name` FROM projects";
      $result = mysqli_query($conn, $query);

      echo "<form id='employee-form' action='' method='POST' class='form employee'>";
      echo "<h2>{$formTitle}</h2>";
      echo "<label for='firstname'>First name*</label>";
      echo "<input type='text' id='firstname' name='firstname' placeholder='firstname' value='{$defaultFirstname}' required>";
      echo "<label for='lastname'>Last name*</label>";
      echo "<input type='text' id='lastname' name='lastname' placeholder='lastname' value='{$defaultLastname}' required> ";
      echo "<label for='project'>Project</label>";
      echo "<select id='project-id' name='project-id'>";
      echo "<option value='' " . ($defaultProjectId == '' ? 'selected' : '') . ">None</option>";
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value={$row['pid']} " . ($defaultProjectId == $row['pid'] ? 'selected' : '') . ">{$row['name']}</option>";
        }
        mysqli_free_result($result);
      }
      echo "</select>";
      echo "<button type='submit' name={$formName} class='btn'>Submit</button>";
      echo "<input type='hidden' name='employee-id' value='$defaultEmployeeId'>";
      echo "</form>";
    }


    ?>

  </main>
  <?php
  mysqli_close($conn);
  ?>
</body>

</html>