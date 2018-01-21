
<h3>Регистрация на сайте</h3>
<div>
    <form action="register.php" method="POST" onsubmit="return validate(this)">
        <table>
            <tr>
                <td>Логин:</td><td><input type="text" name="rulog" required="required" placeholder="введите логин"/></td>
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
</div>
