<?php
  header('Content-Type: application/download');
  header('Content-Disposition: attachment; filename="UWI-Logo.jpg"');
  header("Content-Length: " . filesize("UWI-Logo.jpg"));
  $fp = fopen("UWI-Logo.jpg", "r");
  fpassthru($fp);
  fclose($fp);
?>