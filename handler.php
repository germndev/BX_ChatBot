<?php
require_once(__DIR__ . '/crest.php');

    $botCode = 'ActivityBot';
    $botResult = CRest::call('imbot.bot.list');
    $botList = array_column($botResult['result'], 'ID', 'CODE');
    $ID = $botList[$botCode];
    $IDArray = explode(",", iconv("utf-8","windows-1251", $_REQUEST['properties']['ID']));

    $Message = $_REQUEST['properties']['Message'];
    $Message = str_replace('</a>', '', $Message);
    $dir = __DIR__ . '/chat/';

    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    file_put_contents($dir . 'chatinf.txt', var_export($_REQUEST, true), true);
    foreach ($IDArray as $value){
        $value = preg_replace("/\s+/", "", $value);
        $result = CRest::call('imbot.message.add', [
            'BOT_ID' => $ID,
            'DIALOG_ID' => $value,
            'MESSAGE' => $Message
        ]);
    }


