<?php
function renderEmploeeTable($emploees)
{
}

function renderEmploeeRow($emploee)
{
  echo "<div>{$emploee['eid']}</div>";
  echo "<div>{$emploee['fistname']} {$emploee['lastname']}</div>";
  echo "<div>Projects...</div>";
}
