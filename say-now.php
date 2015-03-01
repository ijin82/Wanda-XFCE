#!/usr/bin/php
<?php

if (empty($argv[1])) {
  $mode = 'def';
} else {
  $mode = $argv[1];
}

// icon
$iconFile = __DIR__ . '/wanda-fish.png';

switch ($mode) {

  case 'fortune':
    `msfort=\`fortune\`; notify-send -t 7000 -i "$iconFile" "Wanda fish says:" "\$msfort"`;
  break;

  default:
    $sFile = @file_get_contents('http://fucking-great-advice.ru/api/random');

    if (!empty($sFile)) {

        $oAdvice = json_decode($sFile);

        if (empty($oAdvice)) {
          
          `notify-send "error: no advice found in page :("`;

        } else {

          $aReplace = array(
            '/&#151;/',
            '/&nbsp;/',
          );

          $aReplacers = array(
            '-',
            ',',
          );
          
          $sSovet = strip_tags(html_entity_decode($oAdvice->text, ENT_QUOTES, 'utf-8'));
          $sSovet = preg_replace($aReplace, $aReplacers, $sSovet);

          // send notice here
          `notify-send -i "$iconFile" "Wanda fish says:" "$sSovet"`;
        }

    } else {

      `notify-send "error: no connect to advice page :("`;
    }
  break;

}



