<?php

function renderProjectRow($project, $count)
{
  echo "<div>{$count}</div>";
  echo "<div>{$project['name']}</div>";
  echo "<div>{$project['fullnames']}</div>";
  echo "<div>";
  echo "<form action='' method='POST'>";
  echo "<input type='hidden' name='pid' value='{$project['pid']}'/>";
  echo "<input type='hidden' name='table' value='projects'/>";
  echo "<button type='submit' name='delete' class='btn delete'>Delete</button>";
  echo "</form>";
  echo "<form action='' method='POST'>";
  echo "<input type='hidden' name='pid' value={$project['pid']}/>";
  echo "<input type='hidden' name='name' value='{$project['name']}'/>";
  echo "<button type='submit' name='update' class='btn update'>Update</button>";
  echo "</form>";
  echo "</div>";
}
