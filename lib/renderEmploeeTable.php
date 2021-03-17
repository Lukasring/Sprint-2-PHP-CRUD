<?php
function renderEmploeeTable($emploees)
{
}

function renderEmploeeRow($emploee, $count)
{
  $projectName = $emploee['name'] === null ? '-' : $emploee['name'];
  echo "<div>{$count}</div>";
  echo "<div>{$emploee['firstname']} {$emploee['lastname']}</div>";
  echo "<div>{$projectName}</div>";
  echo "<div>";
  echo "<form action='' method='POST'>";
  echo "<input type='hidden' name='id' value='{$emploee['id']}'/>";
  echo "<input type='hidden' name='table' value='emploees'/>";
  echo "<button type='submit' name='delete'>Delete</button>";
  echo "</form>";
  echo "<form action='' method='POST'>";
  echo "<input type='hidden' name='id' value='{$emploee['id']}'/>";
  echo "<input type='hidden' name='firstname' value='{$emploee['firstname']}'/>";
  echo "<input type='hidden' name='lastname' value='{$emploee['lastname']}'/>";
  echo "<button type='submit' name='update'>Update</button>";
  echo "</form>";
  echo "</div>";
}
