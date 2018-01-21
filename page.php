<?php

//require_once './config.php';
require_once './functions.php';

function htmlGetHeader() {
    global $sitename;
    $header = '<!DOCTYPE html><html><head>' .
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

function htmlGetContent($loggedIn) {    
    $content = '
        <div id="nav-top" class="minWidth gradient">
            <div style="border: 0; display: inline-block; margin: 5px;">
                <ul id="menu-top">
                    <li>Пункт меню 1</li>
                    <li>Пункт меню 2</li>
                    <li>Пункт меню 3</li>
                    <li>Пункт меню 4</li>
                </ul>
            </div>
            <div style="margin: 5px; display: inline-block; float: right; border:0;"> 
                <form method="get" action="index.php" onsubmit="return checkSearch(this);">
                    <label>Поиск: <input name="search_str" style="display: inline-block; height: 1.1em; font: 0.8em sans-serif;" type="text" value ="'.$_GET['search_str'].'" /></label>
                    <!--div style="display: inline-block; background: url(./images/forward.png); width: 18px; height: 18px; border: 0; "></div-->
                    <input type="submit" value="" style="display: inline-block; background: url(./images/forward.png); width: 18px; height: 18px; border: 0; cursor: pointer; " '.($loggedIn ? '': 'disabled').'/>
                </form>
            </div>
        </div>
        <div id="centerblock" class="minWidth">
            <div id="nav-left">
                <div class="menu_l">Меню-лев #1</div>
                <ul class="menu_lc">
                    <li>Пункт меню 1</li>
                    <li>Пункт меню 2</li>
                    <li>Пункт меню 3</li>
                    <li>Пункт меню 4</li>
                </ul>
                <div id="weather">Погода</div>
                <ul>
                    <li><img src="./parser/iwx/iwx300.png" width="50px" height="50px"/>
                            18 Декабря Понедельник <br/>
                            Облачно
                            Ночью -9 °C
                            Днём -6 °C                    

                    </li>
                    <li>Пункт меню 2</li>
                    <li>Пункт меню 3</li>
                    <li>Пункт меню 4</li>
                </ul>                
            </div>            
            <div id="content">
                <div>Наполнение</div>
                <ul>' 
                .($loggedIn ? filesGetList($_GET['search_str']) : '<h3>Просмотр файлов доступен только зарегистрированным</h3>').
                '</ul>
            </div>
        </div>' ;
    return $content;
}

function htmlGetPersonal($loggedIn) {
    if ($loggedIn) {
        $name = $_SESSION['uname'];
        $modal = '<div id="modal_back">
                    <div id="form_container"><a id="modal_close" href="#"></a>
                        <form id="upload_form" enctype="MULTIPART/FORM-DATA" action="upload.php" method="POST">
                            <INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="30000" />
                            <LABEL>Выберите файл:<INPUT TYPE="FILE" NAME="myfile" /></LABEL>                            
                            <INPUT TYPE="SUBMIT" VALUE="Загрузить" />
                        </form>
                    </div>
                </div>';
        $links = '<li><a id="exitlnk" href ="./logout.php">Выход</a></li>';
    } else {
        $name = 'Гость';
        $modal = '<div id="modal_back">
                <div id="form_container"><a id="modal_close" href="#"></a>
                    <form id="login_form" action="login.php" method="POST"> <!-- onsubmit="return checkInputL(this)" -->
                        <label>Вход на сайт</label>
                        <label>Логин:<input type="text" name="ulog" required placeholder="Введите логин" size="25"/></label>
                        <label>Пароль:<input type="password" name="upas" required placeholder="Введите пароль" size="25"/></label>
                        <input type="submit" value="Войти" />
                    </form>
                    <form id="register_form" action="register.php" method="POST" onsubmit="return checkInputR(this)">
                        <label>Регистрация на сайте</label>
                        <label>Логин: <input type="text" name="userLogin" required="required" placeholder="Введите логин" size="25"/></label>
                        <label>Пароль: <input type="password" name="userPasw" required="required" placeholder="Введите пароль" size="25"/></label>
                        <label>Повторите пароль: <input type="password" name="userPaswС" required="required" placeholder="Введите пароль ещё раз" size="25"/></label>
                        <label>Имя: <input type="text" name="userName" placeholder="Введите имя пользователя" size="50"/></label>
                        <label>Электронная почта: <input type="text" name="userMail" required="required" placeholder="Введите адрес почты" size="50"/></label>
                        <input type="submit" value="Зарегистрировать" />
                        <input type="hidden" name="regFrm" value="y" />
                    </form>
                </div>
            </div>';
        $links = '<li><a id="loglnk" href="#">Войти</a><li>
                  <li><a id="reglnk" href="#">Зарегистрироваться</a><li>';
    }
    global $sitename;
    $content = $modal . '
            <div id="header" class="minWidth">
            <div id="logo" class="inline-blck">
                <h1 style="margin-left: 60px; margin-top: 10px;">'. $sitename.
                '</h1>
            </div>
            <div id="personal" class="inline-blck">
                <a>Hello, ' . $name . '</a>
                <ul>'.$links.
                '</ul>
            </div>
        </div>';

    return $content;
}

function htmlGetFooter() {
    $footer = '<div id="footer" class="minWidth gradient">' .
            '<p style="margin: 5px;">&copy; 2017 Файл-хостинг.</p>' .
            '</div></body></html>';
    return $footer;
}
?>
