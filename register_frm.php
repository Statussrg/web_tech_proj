<?php

echo <<<_PAGE
<!DOCTYPE html>
<html>
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Register</title>
</head>
<body>
    <h3>Регистрация на сайте</h3>
    <p>
    <form action="register.php" method="POST">
    <table>
        <tr>
            <td>Логин:</td><td><input type="text" name="rulog" required="required" /></td>
        </tr>
        <tr>
            <td>Пароль:</td><td><input type="password" name="rupas" required="required" /></td>
        </tr>
        <tr>
            <td>Имя:</td><td><input type="text" name="runame" required="required" /></td>
        </tr>
        <tr>
            <td>Электронная почта:</td><td><input type="text" name="rumail" required="required" placeholder="почта" /></td>
        </tr>
    </table></br>
        <input type="submit" value="Зарегистрировать" />
    </form>
    </p>
</body>
</html>
_PAGE;

?>