<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="windows-1251">
    <script src="//api.bitrix24.com/api/v1/"></script>
    <script>
        <?php
        header('Content-Type: text/html; charset=windows-1251');

        $dir = __DIR__ . '/chat/';

        if(!file_exists($dir)){mkdir($dir, 0777, true);}

        file_put_contents($dir . 'chatinfo.txt', var_export(json_decode($_REQUEST['PLACEMENT_OPTIONS']), true), true);

        $arrjson = json_decode($_REQUEST['PLACEMENT_OPTIONS'], true);

        $id = iconv("utf-8","windows-1251", $arrjson['current_values']['DialogID']);
        file_put_contents($dir . 'chatinfo.txt', $id, true);

        $msg = iconv("utf-8","windows-1251", $arrjson['current_values']['Message']);
        ?>

        var arrs = [];
        var element;
        var maintext;
        arrs = [[], [], [], [], []];
        function funcappendid(ids) {
            BX24.placement.call( //обновим параметры после заполнения каждого пу
                // нкта
                'setPropertyValue',
                {'DialogID': ids.value}
            );
        }
        function funcappendmessage(message){
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Message': message}
            );
        }
        function inf(value){
            switch (value.id)
            {
                case 'Deal':
                    arrs[0] = [];

                    for (let i = 0; i <= value.options.length - 1; i++){
                        if (value.options[i].selected){
                            arrs[0].push(value.options[i].value);
                        }
                    }
                    break;
                case 'Lid':
                    arrs[1] = [];

                    for (let i = 0; i <= value.options.length - 1; i++){
                        if (value.options[i].selected){
                            arrs[1].push(value.options[i].value);
                        }
                    }
                    break;
                case 'Contact':
                    arrs[2] = [];

                    for (let i = 0; i <= value.options.length - 1; i++){
                        if (value.options[i].selected){
                            arrs[2].push(value.options[i].value);
                        }
                    }
                    break;
                case 'Company':
                    arrs[3] = [];

                    for (let i = 0; i <= value.options.length - 1; i++){
                        if (value.options[i].selected){
                            arrs[3].push(value.options[i].value);
                        }
                    }
                    break;
                case 'Invoice':
                    arrs[4] = [];

                    for (let i = 0; i <= value.options.length - 1; i++){
                        if (value.options[i].selected){
                            arrs[4].push(value.options[i].value);
                        }
                    }
                    break;
            }
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Arr1': arrs[0].join("-")}
            );
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Arr2': arrs[1].join("-")}
            );
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Arr3': arrs[2].join("-")}
            );
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Arr4': arrs[3].join("-")}
            );
            BX24.placement.call( //обновим параметры после заполнения каждого пункта
                'setPropertyValue',
                {'Arr5': arrs[4].join("-")}
            );
        }
        function append_text(text){
            switch (text.parentNode.id)
            {
                case 'deal':
                    document.getElementById('place-text').value = document.getElementById('place-text').value + '{{Сделка: ' + text.text + '}}';
                    break;
                case 'lead':
                    document.getElementById('place-text').value = document.getElementById('place-text').value + '{{Лид: ' + text.text + '}}';
                    break;
                case 'contact':
                    document.getElementById('place-text').value = document.getElementById('place-text').value + '{{Контакты: ' + text.text + '}}';
                    break;
                case 'company':
                    document.getElementById('place-text').value = document.getElementById('place-text').value + '{{Компания: ' + text.text + '}}';
                    break;
                case 'invoice':
                    document.getElementById('place-text').value = document.getElementById('place-text').value + '{{Счет: ' + text.text + '}}';
                    break;
            }

            document.getElementById('menu-calc-checkbox').checked = false;
            document.getElementById('deal-btn').checked = false;
            document.getElementById('lead-btn').checked = false;
            document.getElementById('company-btn').checked = false;
            document.getElementById('contact-btn').checked = false;
            document.getElementById('invoice-btn').checked = false;

            funcappendmessage(text.text)
        }
    </script>
    <style>
        body {
            background-color: #f5f9f9;
            height: auto;
            width: auto;

            overflow-x: hidden;
            overflow-y: scroll;
        }
        .param-box{
            position: relative;
            display: flex;
            margin-left: 10px;
        }
        .name{
            display: block;
            position: relative;
            left: 0;

            width: 190px;
            text-align: right;
            margin-bottom: 10px;
            font-weight: 100;
            color: #333333;
            font-family: "Times New Roman", Georgia, Serif;
            font-size: 1em;
        }
        .param{
            display: block;
            position: relative;
            left: 15px;
        }
        .param input{
            width: 451px;
        }
        .name div, .param div{
            margin-bottom: 15px;
        }

        .choosemultiply div{
            position: relative;

            margin-bottom: 10px;
        }
        .choosemultiply {
            position: absolute;
            left: 222px;
        }

        .text-calc{
            background-color: transparent;
            width: auto;
            height: 60px;

            position: relative;
            display: flex;
            flex-flow: wrap;

            left: 120px;
            top: 10px;
        }
        #place-text{
            width: 450px;
            height: 50px;
        }

        #menu-calc-label{
            border-radius: 5px;

            height: 30px;
            width: 40px;

            margin-left: 10px;
            margin-top: 10px;
            font-size: 1em;
            cursor: pointer;

            text-align: center;
            box-shadow: #595959 0px 0px 3px 1px;
            background: linear-gradient(45deg, #dce7ea, #f8fafb);

            transition: .1ms;
        }
        .calc-btn:checked ~ .param-window-calc{
            height: 300px;
            border: 1.5px solid #5a5a96;
            box-shadow: #5D6162 0 0 15px 5px;
        }
        #menu-calc-label:hover{
            background: linear-gradient(45deg, #ffffff, #ffffff);
        }
        .param-window-calc{
            position: fixed;
            display: block;

            background-color: lightgray;
            border-radius: 5px;
            overflow-y: scroll;
            overflow-x: hidden;

            height: 0;
            width: 460px;

            left: 222px;
            top: 25px;

            transition: .3ms;
        }

        #deal-btn:checked ~ .deal-container{
            height: auto;
            display: block;
        }
        #lead-btn:checked ~ .lead-container{
            height: auto;
            display: block;
        }
        #company-btn:checked ~ .company-container{
            height: auto;
            display: block;
        }
        #contact-btn:checked ~ .contact-container{
            height: auto;
            display: block;
        }
        #invoice-btn:checked ~ .invoice-container{
            height: auto;
            display: block;
        }

        .deal-container{
            display: none;

            height: 0px;
            width: 400px;
            background-color: #e7e7e0;

            border-radius: 5px;
        }
        .lead-container{
            display: none;

            height: 0px;
            width: 400px;
            background-color: #e7e7e0;

            border-radius: 5px;
        }
        .contact-container{
            display: none;

            height: 0px;
            width: 400px;
            background-color: #e7e7e0;

            border-radius: 5px;
        }
        .company-container{
            display: none;

            height: 0px;
            width: 400px;
            background-color: #e7e7e0;

            border-radius: 5px;
        }
        .invoice-container{
            display: none;

            height: 0px;
            width: 400px;
            background-color: #e7e7e0;

            border-radius: 5px;
        }
        .param-window-calc-containers{
            position: relative;
            display: block;

            margin-left: 10px;
            margin-top: 10px;
            margin-right: 10px;

            height: auto;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="param-box">
        <div class="name">
            <div>ID чата:</div>
        </div>
        <div class="param">
            <div><textarea onchange="funcappendid(this)"><?php echo $id;?></textarea></div>
        </div>
    </div>
<!--<div class="choosemultiply">-->
<!--        <form>-->
<!--            <p><select id="Deal" onchange="inf(this)" name="select" size="5" multiple>-->
<!--                    <option value="1">Название</option>-->
<!--                    <option value="2">Сумма</option>-->
<!--                    <option value="3">Валюта</option>-->
<!--                    <option value="4">Валюта учета</option>-->
<!--                    <option value="5">Ответственный</option>-->
<!--                    <option value="6">Стадия</option>-->
<!--                    <option value="7">Тип</option>-->
<!--                    <option value="8">Комментарий</option>-->
<!--                    <option value="9">Дата начала</option>-->
<!--                    <option value="10">Контакт</option>-->
<!--                    <option value="11">Компания</option>-->
<!--                    <option value="12">Источник</option>-->
<!--                    <option value="13">Дополнительно об источнике</option>-->
<!--                    <option value="14">Источник сквозной аналитики</option>-->
<!--                </select>-->
<!--        </form>-->
<!--        <form>-->
<!--            <p><select id="Lid" onchange="inf(this)" name="select" size="5" multiple>-->
<!--                    <option value="1">Название лида</option>-->
<!--                    <option value="2">Статус</option>-->
<!--                    <option value="3">Дополнительно о статусе</option>-->
<!--                    <option value="4">Доступен для всех</option>-->
<!--                    <option value="5">Возможная сумма сделки</option>-->
<!--                    <option value="6">Валюта</option>-->
<!--                    <option value="7">Ответственный</option>-->
<!--                    <option value="8">Комментарий</option>-->
<!--                    <option value="9">Имя</option>-->
<!--                    <option value="10">Фамилия</option>-->
<!--                    <option value="11">Отчество</option>-->
<!--                    <option value="12">Обращение</option>-->
<!--                    <option value="13">Дата рождения</option>-->
<!--                    <option value="14">E-mail</option>-->
<!--                    <option value="15">Телефон</option>-->
<!--                    <option value="16">Сайт</option>-->
<!--                    <option value="17">Мессенджер</option>-->
<!--                    <option value="18">Название компании</option>-->
<!--                    <option value="19">Должность</option>-->
<!--                    <option value="20">Улица, номер дома</option>-->
<!--                    <option value="21">Квартира, офис, комната, этаж</option>-->
<!--                    <option value="22">Населенный пункт</option>-->
<!--                    <option value="23">Почтовый индекс</option>-->
<!--                    <option value="24">Район</option>-->
<!--                    <option value="25">Регион</option>-->
<!--                    <option value="26">Страна</option>-->
<!--                    <option value="27">Источник</option>-->
<!--                    <option value="28">Дополнительно об источнике</option>-->
<!--                    <option value="29">Источник сквозной аналитики</option>-->
<!--                </select>-->
<!--        </form>-->
<!--        <form>-->
<!--            <p><select id="Contact" onchange="inf(this)" name="select" size="5" multiple>-->
<!--                    <option value="1">Имя</option>-->
<!--                    <option value="2">Фамилия</option>-->
<!--                    <option value="3">Отчество</option>-->
<!--                    <option value="4">Обращение</option>-->
<!--                    <option value="5">Дата рождения</option>-->
<!--                    <option value="6">E-mail</option>-->
<!--                    <option value="7">Телефон</option>-->
<!--                    <option value="8">Сайт</option>-->
<!--                    <option value="9">Мессенджер</option>-->
<!--                    <option value="10">Должность</option>-->
<!--                    <option value="11">Адрес</option>-->
<!--                    <option value="12">Улица, номер дома</option>-->
<!--                    <option value="13">Квартира, офис, комната, этаж</option>-->
<!--                    <option value="14">Населенный пункт</option>-->
<!--                    <option value="15">Почтовый индекс</option>-->
<!--                    <option value="16">Район</option>-->
<!--                    <option value="17">Регион</option>-->
<!--                    <option value="18">Страна</option>-->
<!--                    <option value="19">Комментарий</option>-->
<!--                    <option value="20">Тип контакта</option>-->
<!--                    <option value="21">Ответственный</option>-->
<!--                    <option value="22">Источник</option>-->
<!--                    <option value="23">Описание</option>-->
<!--                    <option value="24">Компания</option>-->
<!--                    <option value="25">Источник сквозной аналитики</option>-->
<!--                </select>-->
<!--        </form>-->
<!--        <form>-->
<!--            <p><select id="Company" onchange="inf(this)" name="select" size="5" multiple>-->
<!--                    <option value="1">Название компании</option>-->
<!--                    <option value="2">Тип компании</option>-->
<!--                    <option value="3">Сфера деятельности</option>-->
<!--                    <option value="4">Кол-во сотрудников</option>-->
<!--                    <option value="5">Годовой оборот</option>-->
<!--                    <option value="6">Валюта</option>-->
<!--                    <option value="7">Ответственный</option>-->
<!--                    <option value="8">Комментарий</option>-->
<!--                    <option value="9">E-mail</option>-->
<!--                    <option value="10">Телефон</option>-->
<!--                    <option value="11">Сайт</option>-->
<!--                    <option value="12">Мессенджер</option>-->
<!--                    <option value="13">Фактический адрес</option>-->
<!--                    <option value="14">Юридический адрес</option>-->
<!--                    <option value="15">Банковские реквезиты</option>-->
<!--                    <option value="16">Источник сквозной аналитики</option>-->
<!--                </select>-->
<!--        </form>-->
<!--        <form>-->
<!--            <p><select id="Invoice" onchange="inf(this)" name="select" size="5" multiple>-->
<!--                    <option value="1">Название</option>-->
<!--                    <option value="2">Сумма</option>-->
<!--                    <option value="3">Валюта</option>-->
<!--                    <option value="4">Валюта учета</option>-->
<!--                    <option value="5">Ответственный</option>-->
<!--                    <option value="6">Стадия</option>-->
<!--                    <option value="7">Тип</option>-->
<!--                    <option value="8">Комментарий</option>-->
<!--                    <option value="9">Дата начала</option>-->
<!--                    <option value="10">Контакт</option>-->
<!--                    <option value="11">Компания</option>-->
<!--                    <option value="12">Источник</option>-->
<!--                    <option value="13">Дополнительно об источнике</option>-->
<!--                    <option value="14">Источник сквозной аналитики</option>-->
<!--                </select>-->
<!--        </form>-->
<!--    </div>-->
    <div class="text-calc">
        <div style="margin-right: 13px">Сообщение:</div>
        <textarea id="place-text" onchange="funcappendmessage(this.value)"><?php print_r($msg);?></textarea>
        <input type="checkbox" id="menu-calc-checkbox" class="calc-btn" hidden>
        <label for="menu-calc-checkbox" id="menu-calc-label">...</label>
        <div class="param-window-calc" id="window-calc">
            <div id="deal" class="param-window-calc-containers">
                <input type="checkbox" id="deal-btn" hidden>
                <label for="deal-btn" id="deal-label" class="param-window-calc-label">Сделка</label>
                <div class="deal-container" id="deal">
                    <a ondblclick="append_text(this)">Название</a>
                    <br>
                    <a ondblclick="append_text(this)">Сумма</a>
                    <br>
                    <a ondblclick="append_text(this)">Валюта</a>
                    <br>
                    <a ondblclick="append_text(this)">Стадия</a>
                    <br>
                    <a ondblclick="append_text(this)">Тип</a>
                    <br>
                    <a ondblclick="append_text(this)">Комменатрий</a>
                    <br>
                    <a ondblclick="append_text(this)">Дата начала</a>
                    <br>
                    <a ondblclick="append_text(this)">Контакт</a>
                    <br>
                    <a ondblclick="append_text(this)">Компания</a>
                    <br>
                </div>
            </div>
            <div id="lead" class="param-window-calc-containers">
                <input type="checkbox" id="lead-btn" hidden>
                <label for="lead-btn" id="lead-label" class="param-window-calc-label">Лид</label>
                <div class="lead-container" id="lead">
                    <a ondblclick="append_text(this)">Название лида</a>
                    <br>
                    <a ondblclick="append_text(this)">Статус</a>
                    <br>
                    <a ondblclick="append_text(this)">Дополнительно о статусе</a>
                    <br>
                    <a ondblclick="append_text(this)">Возможная сумма сделки</a>
                    <br>
                    <a ondblclick="append_text(this)">Валюта</a>
                    <br>
                    <a ondblclick="append_text(this)">Комменатрий</a>
                    <br>
                    <a ondblclick="append_text(this)">Имя</a>
                    <br>
                    <a ondblclick="append_text(this)">Фамилия</a>
                    <br>
                    <a ondblclick="append_text(this)">Отчество</a>
                    <br>
                    <a ondblclick="append_text(this)">Обращение</a>
                    <br>
                    <a ondblclick="append_text(this)">Дата рождения</a>
                    <br>
                    <a ondblclick="append_text(this)">E-mail</a>
                    <br>
                    <a ondblclick="append_text(this)">Телефон</a>
                    <br>
                    <a ondblclick="append_text(this)">Сайт</a>
                    <br>
                    <a ondblclick="append_text(this)">Мессенджер</a>
                    <br>
                    <a ondblclick="append_text(this)">Название компании</a>
                    <br>
                    <a ondblclick="append_text(this)">Должность</a>
                    <br>
                    <a ondblclick="append_text(this)">Улица, номер дома</a>
                    <br>
                    <a ondblclick="append_text(this)">Квартира, офис, комната, этаж</a>
                    <br>
                    <a ondblclick="append_text(this)">Населенный пункт</a>
                    <br>
                    <a ondblclick="append_text(this)">Почтовый индекс</a>
                    <br>
                    <a ondblclick="append_text(this)">Район</a>
                    <br>
                    <a ondblclick="append_text(this)">Регион</a>
                    <br>
                    <a ondblclick="append_text(this)">Страна</a>
                </div>
            </div>
            <div id="contact" class="param-window-calc-containers">
                <input type="checkbox" id="contact-btn" hidden>
                <label for="contact-btn" id="contact-label" class="param-window-calc-label">Контакты</label>
                <div class="contact-container" id="contact">
                    <a ondblclick="append_text(this)">Имя</a>
                    <br>
                    <a ondblclick="append_text(this)">Фамилия</a>
                    <br>
                    <a ondblclick="append_text(this)">Отчество</a>
                    <br>
                    <a ondblclick="append_text(this)">Обращение</a>
                    <br>
                    <a ondblclick="append_text(this)">Дата рождения</a>
                    <br>
                    <a ondblclick="append_text(this)">E-mail</a>
                    <br>
                    <a ondblclick="append_text(this)">Телефон</a>
                    <br>
                    <a ondblclick="append_text(this)">Сайт</a>
                    <br>
                    <a ondblclick="append_text(this)">Мессенджер</a>
                    <br>
                    <a ondblclick="append_text(this)">Должность</a>
                    <br>
                    <a ondblclick="append_text(this)">Адрес</a>
                    <br>
                    <a ondblclick="append_text(this)">Улица, номер дома</a>
                    <br>
                    <a ondblclick="append_text(this)">Квартира, офис, комната, этаж</a>
                    <br>
                    <a ondblclick="append_text(this)">Населенный пункт</a>
                    <br>
                    <a ondblclick="append_text(this)">Почтовый индекс</a>
                    <br>
                    <a ondblclick="append_text(this)">Район</a>
                    <br>
                    <a ondblclick="append_text(this)">Регион</a>
                    <br>
                    <a ondblclick="append_text(this)">Страна</a>
                    <br>
                    <a ondblclick="append_text(this)">Комменатрий</a>
                    <br>
                    <a ondblclick="append_text(this)">Тип контакта</a>
                    <br>
                    <a ondblclick="append_text(this)">Компания</a>
                    <br>
                </div>
            </div>
            <div id="company" class="param-window-calc-containers">
                <input type="checkbox" id="company-btn" hidden>
                <label for="company-btn" id="company-label" class="param-window-calc-label">Компания</label>
                <div class="company-container" id="company">
                    <a ondblclick="append_text(this)">Название компании</a>
                    <br>
                    <a ondblclick="append_text(this)">Тип компании</a>
                    <br>
                    <a ondblclick="append_text(this)">Сфера деятельности</a>
                    <br>
                    <a ondblclick="append_text(this)">Кол-во сотрудников</a>
                    <br>
                    <a ondblclick="append_text(this)">Годовой оборот</a>
                    <br>
                    <a ondblclick="append_text(this)">Комменатрий</a>
                    <br>
                    <a ondblclick="append_text(this)">E-mail</a>
                    <br>
                    <a ondblclick="append_text(this)">Телефон</a>
                    <br>
                    <a ondblclick="append_text(this)">Сайт</a>
                    <br>
                    <a ondblclick="append_text(this)">Мессенджер</a>
                    <br>
                    <a ondblclick="append_text(this)">Фактический адрес</a>
                    <br>
                    <a ondblclick="append_text(this)">Юридический адрес</a>
                    <br>
                    <a ondblclick="append_text(this)">Банковские реквезиты</a>
                    <br>
                </div>
            </div>
            <div id="invoice" class="param-window-calc-containers">
                <input type="checkbox" id="invoice-btn" hidden>
                <label for="invoice-btn" id="invoice-label" class="param-window-calc-label">Счет</label>
                <div class="invoice-container" id="invoice">
                    <a ondblclick="append_text(this)">Название</a>
                    <br>
                    <a ondblclick="append_text(this)">Сумма</a>
                    <br>
                    <a ondblclick="append_text(this)">Валюта</a>
                    <br>
                    <a ondblclick="append_text(this)">Стадия</a>
                    <br>
                    <a ondblclick="append_text(this)">Тип</a>
                    <br>
                    <a ondblclick="append_text(this)">Комменатрий</a>
                    <br>
                    <a ondblclick="append_text(this)">Дата начала</a>
                    <br>
                    <a ondblclick="append_text(this)">Контакт</a>
                    <br>
                    <a ondblclick="append_text(this)">Компания</a>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>