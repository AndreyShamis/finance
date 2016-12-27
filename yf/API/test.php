
<?php

echo microtime();
echo "<br/>";
echo microtime(true);
echo "<br/>";

$mtime = microtime();
$mtime = explode(" ",$mtime);
echo  $mtime[1] + $mtime[0];
