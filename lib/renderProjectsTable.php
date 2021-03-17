<?php

function renderProjectRow($project, $count)
{
  echo "<div>{$count}</div>";
  echo "<div>{$project['name']}</div>";
  echo "<div>{$project['fullnames']}</div>";
  echo "<div>Delete Update</div>";
}
