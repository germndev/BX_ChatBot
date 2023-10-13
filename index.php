<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="windows-1251">
    <script src="//api.bitrix24.com/api/v1/"></script>
</head>
    <body>
        <h1 style="text-align: center;margin-bottom: 2rem;width: 100%">Активити оптим</h1>
        <div style="margin-left: 30px;max-width: 26rem;">
            <div class="item">
                <h3 style="text-align: center;">"Выборка элементов СП"</h3>
                <button class="btn btn-primary" style="margin-right: 8px;" onclick="installActivity();"><i class="bi bi-download"></i>1</button>
                <button class="btn btn-primary" onclick="uninstallActivity('md5');"><i class="bi bi-x-square"></i>2</button>
            </div>
        </div>
        <script type="text/javascript">
            function installActivity()
            {
                var params = {
                    'CODE': 'md5',
                    'HANDLER': 'http://prakaem7.beget.tech/ACTIVITY/handler.php',
                    'AUTH_USER_ID': 1,
                    'USE_SUBSCRIPTION': 'Y',
                    'NAME': {
                        'ru': 'Сообщение от Чат-Бота',
                        'en': 'Сообщение от Чат-Бота'
                    },
                    'DESCRIPTION': {
                        'ru': 'Создание сообщения от Чат-Бота',
                        'en': 'Создание сообщения от Чат-Бота'
                    },
                    'PROPERTIES': {
                        'ID': {
                            'Name': {
                                'ru': 'ID чата',
                                'en': 'Input string'
                            },
                            'Description': {
                                'ru': 'Введите id чата или чатов через запятую',
                                'en': 'Input string for hashing'
                            },
                            'Type': 'string',
                            'Required': 'Y',
                            'Multiple': 'N',
                            'Default': null,
                        },
                        'Message': {
                            'Name': {
                                'ru': 'Сообщение',
                                'en': 'Input string'
                            },
                            'Description': {
                                'ru': 'Введите строку, которую вы хотите отправить получателю',
                                'en': 'Input string for hashing'
                            },
                            'Type': 'string',
                            'Required': 'Y',
                            'Multiple': 'N',
                            'Default': null,
                        }
                    },
                    'RETURN_PROPERTIES': {
                        'outputString': {
                            'Name': {
                                'ru': 'бот тест',
                                'en': 'бот тест'
                            },
                            'Type': 'string',
                            'Multiple': 'N',
                            'Default': null
                        }
                    }
                };

                BX24.callMethod(
                    'bizproc.activity.add',
                    params,
                    function(result)
                    {
                        if(result.error())
                            alert("Error: " + result.error());
                        else
                            alert("Успешно: " + result.data());
                    }
                );

                BX24.callMethod(
                    'bizproc.activity.add',
                    params,
                    function(result)
                    {
                        if(result.error())
                            alert("2: " + result.error());
                        else
                            alert("1: " + result.data());
                    }
                );
            }
            function uninstallActivity(code)
            {
                let params = {
                    'CODE': code
                };

                BX24.callMethod(
                    'bizproc.activity.delete',
                    params,
                    function(result)
                    {
                        if(result.error())
                            alert('Error: ' + result.error());
                        else
                            alert("Успешно: " + result.data());
                    }
                );
            }
        </script>
    </body>
</html>