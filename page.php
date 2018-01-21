<?php

/*

 */

function htmlGetHeader() {
    $header = '<!DOCTYPE html><html><head>' .
            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' .
            '<title>File Hosting</title>' .
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
    $content = htmlGetPersonal($loggedIn) . '
        <div id="nav-top" class="minWidth gradient">
            <div style="border: 0; display: inline-block; margin: 5px;">
                <ul id="menu-top">
                    <li>Пункт меню 1</li>
                    <li>Пункт меню 2</li>
                    <li>Пункт меню 3</li>
                    <li>Пункт меню 4</li>
                </ul>
            </div>
            <div style="margin: 5px; display: inline-block; float: right; border:0;">Поиск: <input style="display: inline-block; height: 1.1em; font: 0.8em sans-serif;" type="text"/>
                <div style="display: inline-block; background: url(./images/forward.png); width: 18px; height: 18px; border: 0; "></div>
            </div>
        </div>
        <div id="centerblock" class="minWidth">
            <div id="nav-left">
                <div>Меню-лев</div>
                <ul>
                    <li>Пункт меню 1</li>
                    <li>Пункт меню 2</li>
                    <li>Пункт меню 3</li>
                    <li>Пункт меню 4</li>
                </ul>
            </div>
            <div id="content">
                <div>Наполнение</div>
                <ul>' .
            filesGetList() .
            '</ul>
            </div>
            </div>'
    ;
    return $content;
}

function htmlGetPersonal($loggedIn) {
    if ($loggedIn) {
        $name = $_SESSION['login'];
        $modal = '';
        $links = '<li><a href ="./logout.php">exit</a></li>';
    } else {
        $name = 'Гость';
        $modal = '<div id="modal_back">
                <div id="form_container"><a onclick="$(\'#modal_back\').css(\'display\', \'none\')">close</a>
                    <form id="login_form" action="login.php" method="POST">
                        <legend>Вход на сайт</legend>
                        <table>
                            <tr>
                                <td>Логин:</td><td><input type="text" name="ulog" required /></td>
                            </tr>
                            <tr>
                                <td>Пароль:</td><td><input type="password" name="upas" required /></td>
                            </tr>
                        </table></br>
                        <input type="submit" value="Войти" />
                    </form>
                    <form id="register_form" action="register.php" method="POST" onsubmit="return validate(this)">
                        <legend>Регистрация на сайте</legend>
                        <table>
                            <tr>
                                <td>Логин:</td><td><input type="text" name="rulog" required placeholder="введите логин"/></td>
                            </tr>
                            <tr>
                                <td>Пароль:</td><td><input type="password" name="rupas" required /></td>
                            </tr>
                            <tr>
                                <td>Имя:</td><td><input type="text" name="runame" required /></td>
                            </tr>
                            <tr>
                                <td>Электронная почта:</td><td><input type="text" name="rumail" required placeholder="почта" /></td>
                            </tr>
                        </table></br>
                        <input type="submit" value="Зарегистрировать" />
                    </form>
                </div>
            </div>';
        $links = '<li><a id="loglnk" href="#">Войти</a><li>
                  <li><a id="reglnk" href="#">Зарегистрироваться</a><li>';
    }

    $content = $modal . '
            <div id="header" class="minWidth">
            <div id="logo" class="inline-blck">
                <h1 style="margin-left: 60px; margin-top: 10px;  ">Файл-хостинг</h1>
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

