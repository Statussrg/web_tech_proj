<?php

echo <<<_PAGE
<!DOCTYPE html>
<html>    
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login</title>
</head>
<body>
    <h3>Вход на сайт</h3>
    <p>
    <form action="login.php" method="POST">
    <table>
        <tr>
            <td>Логин:</td><td><input type="text" name="ulog" /></td>
        </tr>
        <tr>
            <td>Пароль:</td><td><input type="password" name="upas" /></td>
        </tr>
    </table></br>
        <input type="submit" value="Войти" />
    </form>
    </p>
</body>
</html>
_PAGE;

?>