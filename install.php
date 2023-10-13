<?php
require_once (__DIR__.'/crest.php');

$result = CRest::installApp();
$botCode = 'ActivityBot';

// handler for events "handler.php"
$handlerBackUrl = ($_SERVER['HTTPS'] === 'on' || $_SERVER['SERVER_PORT'] === '443' ? 'https' : 'http') . '://'
    . $_SERVER['SERVER_NAME']
    . (in_array($_SERVER['SERVER_PORT'],	['80', '443'], true) ? '' : ':' . $_SERVER['SERVER_PORT'])
    . str_replace($_SERVER['DOCUMENT_ROOT'], '',__DIR__)
    . '/handler.php';



// If is reinstall
// delete old bot
$botResult = CRest::call('imbot.bot.list');
if($botResult['result'])
{
    $botList = array_column($botResult['result'], 'ID', 'CODE');
    if($botList[$botCode] > 0)
    {
        $t = CRest::call(
            'imbot.unregister',
            [
                'BOT_ID' => $botList[$botCode],
            ]
        );
    }
}

// If your application supports different localizations
// use $_REQUEST['data']['LANGUAGE_ID'] to load correct localization
// register new bot
$Botresult = CRest::call(
    'imbot.register',
    [
        'CODE' => $botCode,// unique bot identifier  (req.)
        'TYPE' => 'B',// Bot type
        'EVENT_MESSAGE_ADD' => $handlerBackUrl,// Bot handler for new messages from user (req.)
        'EVENT_WELCOME_MESSAGE' => $handlerBackUrl,// Bot handler for joining to a chat (req.)
        'EVENT_BOT_DELETE' => $handlerBackUrl,// Bot handler for deleting bot (req.)
        'PROPERTIES' => [ // Bot personality (req.)
            'NAME' => 'Art24',// Bot name (NAME or LAST_NAME is required)
            'LAST_NAME' => 'Bot',// Bot last name
            'COLOR' => 'AQUA',// Bot color for mobile Bitrix24 application RED,  GREEN, MINT, LIGHT_BLUE, DARK_BLUE, PURPLE, AQUA, PINK, LIME, BROWN,  AZURE, KHAKI, SAND, MARENGO, GRAY, GRAPHITE
            'EMAIL' => 'info@artsolution24.ru',
            'PERSONAL_BIRTHDAY' => '2023-04-23',// format YYYY-mm-dd
            'WORK_POSITION' => '',// Bot 'job-title' as a bot description
            'PERSONAL_WWW' => 'https://artsolution24.ru/',
            'PERSONAL_GENDER' => 'M',// Bot gender
            'PERSONAL_PHOTO' =>  base64_encode(file_get_contents(__DIR__.'/avatar.jpg'))
    ],
    ]
);
$result = CRest::call('bizproc.activity.delete', ['CODE' => 'aa']);
$result = CRest::call('bizproc.activity.add',
    [
        'CODE' => 'aa',
        'HANDLER' => 'http://prakaek3.beget.tech/Art24_Bot/handler.php',
        'AUTH_USER_ID' => 1,
        'USE_SUBSCRIPTION' => 'Y',
        'NAME' =>
        [
            'ru' => 'Сообщение от Чат-Бота',
            'en' => 'Message from Chat-bot'
        ],
        'DESCRIPTION' =>
        [
            'ru' => 'Создание сообщения от Чат-Бота',
            'en' => 'Creating a message from the Chat-bot'
        ],
        'PROPERTIES' => [
        'ID' =>
            [
                'Name' =>
                    [
                        'ru' => 'ID чата',
                        'en' => 'Chat ID'
                    ],
                'Description' =>
                    [
                        'ru' => 'Введите ID чата (Можно ввести несолько через запятую).',
                        'en' => 'Enter the chat ID (You can enter more than one, separated by commas).'
                    ],
                'Type' => 'string',
                'Required' => 'Y',
                'Multiple' => 'N',
                'Default' => null,
            ],
            'Message' =>
                [
                    'Name' =>
                        [
                            'ru' => 'Сообщение',
                            'en' => 'Input string'
                        ],
                    'Description' =>
                        [
                            'ru' => 'Введите сообщение, которое вы хотите отправить в чат. (Можно использовать вставку значений)',
                            'en' => 'Enter the message you want to send to the chat. (You can use value insertion)'
                        ],
                    'Type' => 'string',
                    'Required' => 'Y',
                    'Multiple' => 'N',
                    'Default' => null,
                ],
        ],
        'RETURN_PROPERTIES' =>
            [
                'outputString' =>
                    [
                        'Name' =>
                            [
                                'ru' => 'Сообщение от Чат-Бота',
                                'en' => 'Message from Chat-bot'
                            ],
                        'Type' => 'string',
                        'Multiple' => 'N',
                        'Default' => null
                    ],
            ],
    ]
);
?>