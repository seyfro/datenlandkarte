<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->loadXML(file_get_contents('europe_switzerland.svg'));
$switch = $dom->getElementsByTagName('switch')->item(0);
header('Content-Type: text/html; charset=UTF-8');
echo '<pre>';
foreach ($switch->childNodes as $a) {
  if ($a->nodeName == 'g') {
    foreach ($a->childNodes as $state) {
      if ($state->nodeName == '#text') {
        continue;
      }
      if ($state->getAttribute('id') == '') {
        continue;
      }
      
      echo $state->getAttribute('id') . "\n";
      foreach ($state->childNodes as $county) {
        if ($county->nodeName == '#text') {
          continue;
        }
        if ($county->getAttribute('id') == '') {
          continue;
        }
        echo '    ' . $county->getAttribute('id') . "\n";
        foreach ($county->childNodes as $town) {
          if ($town->nodeName == '#text') {
            continue;
          }
          if ($town->getAttribute('id') == '') {
            continue;
          }
          echo '        ' . $town->getAttribute('id') . "\n";
        }
      }
    }
  }
}