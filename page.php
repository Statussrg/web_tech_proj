<?php

//require_once './config.php';
require_once './functions.php';

function htmlGetPage($loggedIn) {
    $page = htmlGetHead();
    $page.= htmlGetModal($loggedIn);
    $page.= htmlGetTopPersonal($loggedIn);
    $page.= htmlGetTopMenuSearch($loggedIn);
    $page.= htmlGetContent($loggedIn);
    $page.= htmlGetFooter();
    return $page;
}

function htmlGetHead() {
    global $sitename;
    $header =   '<!DOCTYPE html><html><head>' .
                    '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' .
                    '<title>'.$sitename.'</title>' .
                    '<script src="./scripts/jquery.js"></script>' .
                    '<script src="./scripts/func.js"></script>' .
                    '<script>$(\'document\').ready(function() { setHandlers(); });</script>' .
                    '<link rel="shortcut icon" href=".images/favicon.png">' .
                    '<style type="text/css">' .
                    '@import "./styles/main.css" screen; /* Стиль для вывода результата на монитор */' .
                    '</style>' .
                '</head><body>';
    return $header;
}

function htmlGetModal($loggedIn) {
    $modal =    '<div id="modal_back">
                    <div id="form_container"><a id="modal_close" href="#"></a>'.
                        ($loggedIn ? htmlGetFormUpload(): htmlGetFormLogin().htmlGetFormRegister()).
                    '</div>
                </div>';
    return $modal;
}

function htmlGetTopPersonal($loggedIn) {
    if ($loggedIn) {
        $name = $_SESSION['uname'];
        $links = '<li><a id="perslnk" class="cperslnk" href ="?page=personal">Персональная страница</a></li>'
               . '<li><a id="exitlnk" class="cexitlnk" href ="./logout.php">Выход</a></li>';
    } else {
        $name = 'Гость';
        $links = '<li><a id="loglnk" class="cloglnk" href="#">Войти</a><li>'
                .'<li><a id="reglnk" class="creglnk" href="#">Зарегистрироваться</a><li>';
    }
    global $sitename;
    $personal = '<div id="header" class="minWidth">
                    <div id="logo" class="inline-blck">
                        <h1 style="margin-left: 60px; margin-top: 10px;">'.$sitename.'</h1>
                    </div>
                    <div id="personal" class="inline-blck">
                        <a>Привет, '.$name.'</a>
                        <ul>'.$links.'</ul>
                    </div>
                </div>';
    return $personal;
}

function htmlGetFormRegister() {
    $frmReg =  '<form id="register_form" action="register.php" method="POST" onsubmit="return checkInputR(this)">
                    <label>Регистрация на сайте</label>
                    <label>Логин: <input type="text" name="userLogin" required="required" placeholder="Введите логин" size="25"/></label>
                    <label>Пароль: <input type="password" name="userPasw" required="required" placeholder="Введите пароль" size="25"/></label>
                    <label>Повторите пароль: <input type="password" name="userPaswС" required="required" placeholder="Введите пароль ещё раз" size="25"/></label>
                    <label>Имя: <input type="text" name="userName" placeholder="Введите имя пользователя" size="50"/></label>
                    <label>Электронная почта: <input type="text" name="userMail" required="required" placeholder="Введите адрес почты" size="50"/></label>
                    <input type="submit" value="Зарегистрировать" />
                    <input type="hidden" name="regFrm" value="y" />
                </form>';
    return $frmReg;
}

function htmlGetFormLogin() {
    $frmLog =  '<form id="login_form" action="login.php" method="POST"> <!-- onsubmit="return checkInputL(this)" -->
                    <label>Вход на сайт</label>
                    <label>Логин:<input type="text" name="ulog" required placeholder="Введите логин" size="25"/></label>
                    <label>Пароль:<input type="password" name="upas" required placeholder="Введите пароль" size="25"/></label>
                    <input type="submit" value="Войти" />
                </form>';
    return $frmLog;
}

function htmlGetFormUpload(){
    $frmUpl =  '<form id="upload_form" enctype="MULTIPART/FORM-DATA" action="upload.php" method="POST">
                    <INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="30000" />
                    <LABEL>Выберите файл:<INPUT TYPE="FILE" NAME="myfile" /></LABEL>
                    <INPUT TYPE="SUBMIT" VALUE="Загрузить" />
                </form>';
    return $frmUpl;
}

function htmlGetTopMenuSearch($loggedIn) {
    $param = filter_input(INPUT_GET, 'page');
    $topMenu = '<div id="nav-top" class="minWidth gradient">
                    <ul id="menu-top">
                        <li class="'.($param==''? 'sel': '').'"><a href="./">На главную</a></li>
                        <li class="'.($param=='files'? 'sel': '').'"><a href="?page=files">Файлы</a></li>
                        <li class="'.($param=='weather'? 'sel': '').'"><a href="?page=weather">Погода</a></li>
                    </ul>
                    <form method="get" action="index.php" onsubmit="return checkSearch(this);" id="search_form">
                        <label>Поиск: <input name="search_str" style="display: inline-block; height: 1.1em; font: 0.8em sans-serif;" type="text" value ="'.filter_input(INPUT_GET, 'search_str').'" /></label>
                        <input type="hidden" name="page" value="'.filter_input(INPUT_GET, 'page').'"/>
                        <input type="submit" value="" '.($loggedIn ? '': 'disabled').'/>
                    </form>
                </div>';
    return $topMenu;
}

function htmlGetContent($loggedIn) {
    $param = filter_input(INPUT_GET, 'page');
    switch ($param)    {
        case 'files':
            $title = 'Список файлов';
            $list = ($loggedIn ? filesGetList(filter_input(INPUT_GET, 'search_str')) : '<p>Просмотр файлов доступен только зарегистрированным</p>');
            $view_opts = TRUE;
            break;
        case 'weather':
            $title = 'Прогноз погоды';
            $list = htmlGetWeather();
            $view_opts = TRUE;
            break;
        case 'personal':
            $title = 'Персональная страница';
            $list = '<p>Personal</p>';
            $view_opts = FALSE;
            break;
        default:
            $title = 'Инфо';
            $reg = $loggedIn ? 'зарегистрироваться': '<a class="creglnk" href="#">зарегистрироваться</a>';
            $log = $loggedIn ? 'войти' : '<a class="cloglnk" href="#">войти</a>';
            $lnk = $loggedIn ? 'перейдите в <a href="?page=files">раздел</a>': 'необходимо '.$reg.' или '.$log.' под своими учетными данными';
            $list = '<p>Данный сайт позволяет хранить <a href="?page=files">файлы</a> для '.
                    'общего доступа. Для работы '.$lnk.'.<br/>'.
                    'Также можно посмотреть <a href="?page=weather">прогноз погоды</a>.</p>';
            $view_opts = FALSE;
            break;    }
    $content = '
        <div id="centerblock" class="minWidth">
            <div id="nav-left">'. htmlGetMenuLeft($loggedIn, $param).
            '</div>
            <div id="content">
                <div>'.$title.($view_opts ? '
                    <div style="display: inline; float: right; border: 0;">
                        <a class="view_l" href="#">Списком</a>
                        <a class="view_b" href="#">Блоками</a>
                    </div>' : '').
                '</div>'
                .$list.
            '</div>
        </div>' ;
    return $content;
}

function htmlGetMenuLeft($loggedIn, $param) {
    switch ($param){
        case 'personal':
            $mnuLeft = '<div class="menu_l">Пользовательское меню</div>
                        <ul class="menu_lc">
                            <li><a href="#">Изменить персональные данные</a></li>
                            <li><a href="#">Пункт меню 2</a></li>
                            <li><a href="#">Пункт меню 3</a></li>
                            <li><a href="#">Пункт меню 4</a></li>
                        </ul>';
            break;
        default :
            $mnuLeft = '<div class="menu_l">Меню</div>
                        <ul class="menu_lc">
                            <li><a href="#">Пункт меню 1</a></li>
                            <li><a href="#">Пункт меню 2</a></li>
                            <li><a href="#">Пункт меню 3</a></li>
                            <li><a href="#">Пункт меню 4</a></li>
                        </ul>';
            break;
    }
    return $mnuLeft;
}

/*
function htmlGetMenuWeather() {
    $mnuWeather = '<div id="weather">Погода</div>
                    <ul>
                        <li>
                            <img src="./parser/iwx/iwx300.png" width="50px" height="50px" style="float:left;" />
                            <p>18 Декабря</p>
                            <p>Понедельник</p>
                            <p>Облачно</p>
                            <p>Ночью -9 &deg;C</p>
                            <p>Днём -6 &deg;C</p>
                        </li>
                        <li>
                            <img src="./parser/iwx/iwx400.png" width="50px" height="50px" style="float:left;" />
                            <p>18 Декабря</p>
                            <p>Понедельник</p>
                            <p>Облачно</p>
                            <p>Ночью -9 &deg;C</p>
                            <p>Днём -6 &deg;C</p>
                        </li>
                        <li>Пункт меню 3</li>
                        <li>Пункт меню 4</li>
                    </ul>';
    return '';// $mnuWeather;
}*/

function htmlGetWeather() {     //Вторник|19 Декабря|Преимущественно облачно|Ночью -4 |Днём -2 |300
    $arr = filesReadWeather();
    if ($arr){
        $weather = '<ul id="weather" class="weather_b">';
        foreach ($arr as $line)
        {
            $exp = explode('|', $line);
            if (trim($exp[0])=='Суббота' || trim($exp[0])=='Воскресенье'){
                $weather .='<li class="holiday">';
            }else {
                $weather .='<li>';
            }
            $weather .= '<p><b>'.$exp[1].'</b> '.$exp[0].'</p>';
            $weather .= '<img src="./parser/iwx/iwx'.$exp[5].'.png" />';
            $weather .= '<p>'.$exp[2].'</p>';
            $weather .= '<p>'.$exp[3].' &deg;C</p>';
            $weather .= '<p>'.$exp[4].' &deg;C</p>';
            $weather .='</li>';
        }
        $weather .= '</ul>';
    } else {
        $weather = '<p>Не найден источник</p>';
    }
    return $weather;
}

function htmlGetFooter() {
    $footer = '<div id="footer" class="minWidth gradient">' .
            '<p style="margin: 5px;">&copy; 2017 Файл-хостинг.</p>' .
            '</div></body></html>';
    return $footer;
}
?>
