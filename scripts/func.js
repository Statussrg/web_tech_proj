function checkSearch(form)
{   if (form.search_str.value == "")
    {
        alert("Пустой запрос");
        return false;
    }
    else return true;
}

function checkInputR(form)
{
    err = checkLogin(form.userLogin.value);
    err += checkName(form.userName.value);
    err += checkPasw(form.userPasw.value);
    err += checkPaswEq(form.userPasw.value, form.userPaswС.value);
    err += checkEmail(form.userMail.value);
    if (err == "")
        return true;
    else {
        alert(err);
        return false;
    }
}

function checkInputL(form)
{
    err = checkLogin(form.ulog.value);
    err += checkPasw(form.upas.value);
    if (err == "")
        return true;
    else {
        alert(err);
        return false;
    }
}

function checkLogin(field)
{
    if (field == "")
        return "Не введен логин.\n";
    else if (field.length < 5)
        return "В логине должно быть не менее 5 символов.\n";
    else if (/[^a-zA-Z0-9_-]/.test(field))
        return "В логине разрешены только a-z, A-Z, 0-9, - и _.\n";
    else
        return "";

}

function checkName(field)
{
    return (field.trim() == "") ? "Не введено имя.\n" : "";
}

function checkPasw(field)
{
    if (field == "")
        return "Не введен пароль.\n";
    else if (field.length < 6)
        return "В пароле должно быть не менее 6 символов.\n";
    else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) ||
            !/[0-9]/.test(field))
        return "Пароль требует 1 символа из каждого набора a-z, A-Z и 0-9.\n";
    else
        return "";
}

function checkPaswEq(field1, field2)
{
    return (field1 != field2) ? "Пароли не совпадают.\n" : "";
}

function checkEmail(field) {
    if (field == "")
        return "Не введен адрес электронной почты.\n";
    else if (!((field.indexOf(".") > 0) &&
            (field.indexOf("@") > 0)) ||
            /[^a-zA-Z0-9.@_-]/.test(field))
        return "Электронный адрес имеет неверный формат.\n";
    else
        return "";
}

String.prototype.trim = function ()
{
    return this.replace(/^\s+|\s+$/g, '');
};


/*
function ajaxGetForm(vurl)
{
    $.post('urlpost.php', {url: vurl}, function (data)
    {
        $('#lrforms').html(data);
    });
}
*/

function setHandlers()
{
    $('#modal_close').click(
            function ()
            {
                $('#modal_back').css('display', 'none');
            });

    $('.cloglnk').click(
            function ()
            {
                $('#modal_back').css('display', 'block');
                $('#login_form').css('display', 'block');
                $('#register_form').css('display', 'none');
                $('#upload_form').css('display', 'none');
            });

    $('.creglnk').click(
            function ()
            {
                $('#modal_back').css('display', 'block');
                $('#login_form').css('display', 'none');
                $('#register_form').css('display', 'block');
                $('#upload_form').css('display', 'none');
            });
    $('.cupllnk').click(
            function ()
            {
                $('#modal_back').css('display', 'block');
                $('#login_form').css('display', 'none');
                $('#register_form').css('display', 'none');
                $('#upload_form').css('display', 'block');
            });

    $('.menu_l').click(function() { $('.menu_lc').slideToggle('fast'); });
    
    $('.view_l').click(function() { 
        if ($('#info').hasClass('info_b')) {
            $('#info').removeClass('info_b'); } 
        $('#info').addClass('info_l');  }
        );
    
    $('.view_b').click(function() { 
        if ($('#info').hasClass('info_l')) {
            $('#info').removeClass('info_l');}
        $('#info').addClass('info_b');}
        );
}