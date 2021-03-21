<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbName = 'sprint2';


// echo "Connected successfully\n";

function connectToDb($servername, $username, $password, $dbName)
{

  $conn = mysqli_connect($servername, $username, $password, $dbName); // Create connection

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  return $conn;
}


function deleteFromTable($conn, $table, $id)
{
  $stmt = $conn->prepare("DELETE FROM {$table} WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

function addNewEmployee($conn, $firstname, $lastname, $projectId)
{
  $stmt = $conn->prepare("INSERT INTO employees (firstname, lastname, pid) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $firstname, $lastname, $projectId);
  $stmt->execute();
}

function addNewProject($conn, $name)
{
  $stmt = $conn->prepare("INSERT INTO projects (`name`) VALUES (?)");
  $stmt->bind_param("s", $name);
  $stmt->execute();
}

function updateEmployee($conn, $firstname, $lastname, $projectId, $employeeId)
{
  $stmt = $conn->prepare("UPDATE employees SET `firstname`=?, `lastname`=?, `pid`=? WHERE `id`=?");
  $stmt->bind_param("ssii", $firstname, $lastname, $projectId, $employeeId);
  $stmt->execute();
}

function updateProject($conn, $name, $pid)
{
  $stmt = $conn->prepare("UPDATE projects SET `name`=? WHERE `pid`=?");
  $stmt->bind_param("si", $name, $pid);
  $stmt->execute();
}

function deleteProject($conn, $pid)
{
  $stmt = $conn->prepare("DELETE FROM projects WHERE `pid`=?");
  $stmt->bind_param("s", $pid);
  $stmt->execute();
}
