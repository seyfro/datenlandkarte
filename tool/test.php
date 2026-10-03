<?php
    /*
        Diagnosis of the PNG creation ("Eine Graphik konnte nicht erzeugt
        werden"). Converts a template with every known program and shows
        exit code and output. Remove this file from the server after use.
    */
    $root = './';
    require_once($root.'global.php');

    $svg_file = $location_pattern_svgs.'europe_austria_federal_bl.svg';
    $writable = is_dir($location_creation) && is_writable($location_creation);

    if (FileManager::$png_converter !== '')
        $converters = array(FileManager::$png_converter);
    else
        $converters = FileManager::$png_converters_auto;

    $results = array();
    if (FileManager::exec_available() && $writable)
    {
        foreach ($converters as $i => $bin)
        {
            $png = $location_creation.'test-'.$i.'.png';
            $big = $location_creation.'test-'.$i.'.big.png';
            @unlink($png);
            @unlink($big);

            $version = array();
            exec(escapeshellarg($bin).' -version 2>&1', $version);

            $runs = array();
            foreach (FileManager::png_commands($bin, $svg_file, $png, $big) as $command)
            {
                $output = array();
                $status = -1;
                exec($command.' 2>&1', $output, $status);
                $runs[] = array($command, $status, implode("\n", $output));
            }

            $results[] = array($bin, implode("\n", array_slice($version, 0, 2)),
                $runs, file_exists($png), file_exists($big));
            @unlink($png);
            @unlink($big);
        }
    }

    function yes_no($b) { return $b ? 'ja' : '<strong>nein</strong>'; }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Diagnose PNG-Erzeugung</title>
<style type="text/css">
  pre { background: #EEE; padding: 5px; white-space: pre-wrap; }
  td, th { text-align: left; padding: 2px 10px 2px 0; vertical-align: top; }
</style>
</head>

<body>
<h1>Diagnose PNG-Erzeugung</h1>
<table>
  <tr><th>PHP-Version</th><td><?=_e(PHP_VERSION); ?></td></tr>
  <tr><th>exec() verfügbar</th><td><?=yes_no(FileManager::exec_available()); ?></td></tr>
  <tr><th>disable_functions</th><td><?=_e(ini_get('disable_functions')); ?></td></tr>
  <tr><th>open_basedir</th><td><?=_e(ini_get('open_basedir')); ?></td></tr>
  <tr><th>Ordner <?=_e($location_creation); ?> beschreibbar</th><td><?=yes_no($writable); ?></td></tr>
  <tr><th>PHP-Erweiterung imagick</th><td><?=yes_no(extension_loaded('imagick')); ?></td></tr>
  <tr><th>Vorlage <?=_e($svg_file); ?></th><td><?=yes_no(file_exists($svg_file)); ?></td></tr>
  <tr><th>Konfiguriert (global.php)</th><td><?=_e(FileManager::$png_converter === '' ? '(automatisch)' : FileManager::$png_converter); ?></td></tr>
</table>

<?php foreach ($results as $r) { ?>
<h2><?=_e($r[0]); ?>: <?=($r[3] && $r[4]) ? 'funktioniert' : '<span style="color:#F00">funktioniert nicht</span>'; ?></h2>
<pre><?=_e($r[1] === '' ? '(keine Ausgabe bei -version)' : $r[1]); ?></pre>
<?php foreach ($r[2] as $run) { ?>
<p><code><?=_e($run[0]); ?></code><br />Exit-Code: <?=(int)$run[1]; ?></p>
<?php if ($run[2] !== '') { ?><pre><?=_e($run[2]); ?></pre><?php } ?>
<?php } ?>
<?php } ?>

<p><small>Diese Datei nach der Fehlersuche vom Server löschen.</small></p>
</body>
</html>
