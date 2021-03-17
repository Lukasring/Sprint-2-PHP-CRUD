<?php
function renderDeleteBtn($table, $id)
{
  echo "<form action='' method='POST'>";
  echo "<input type='hidden' name='id' value={$id}/>";
  echo "<input type='hidden' name='table' value={$table}/>";
  echo "<button type='submit' name='delete'>Delete</button>";
  echo "</form>";
}
