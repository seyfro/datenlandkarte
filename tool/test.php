<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Unbenanntes Dokument</title>
</head>

<body>
<p>
<?php
  if (extension_loaded('Imagick')) { echo 'ja'; } else { echo 'nein'; }
  // $i = new Imagick();  // Fatal error: Class 'Imagick' not found
?>
</p>
<p>
  Triggering with exec(): <code>convert svgs/europe_switzerland.svg upload/test.png</code><br />
<?php
  $stdout = array();
  $return = 0;
  exec('convert svgs/europe_switzerland.svg upload/test.png', $stdout, $return);
?>
  Return value: <?=$return; ?> <br />
  Stdout:
</p>
<blockquote>
<?php
  if (count($stdout) === 0) { echo '<p>No stdout content given.</p>'; }
  else {
    foreach ($stdout as $line) {
      echo '<p>'. $line ."</p>\n";
    }
  }
?>
</blockquote>
<p>
  And does <code>upload/test.png</code> exist now?
  <?php if (file_exists('upload/test.png')) echo 'Yes'; else echo 'No'; ?>
</p>
</body>
</html>
