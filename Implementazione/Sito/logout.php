<!-- © 2016-2017 Andrea Lupica (I4AC) ALL RIGHTS RESERVED -->
<?php
  session_start();
  session_unset();
  session_destroy();
  header("Location: index.php");
 ?>
