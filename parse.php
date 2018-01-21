<!DOCTYPE html>
<html>
    <head>
        <title>Погода</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            @import url("./foreca_files/combined.css");
            div{border: 1px solid black; display: inline-block; margin: 5px; padding: 5px; background: #FFFFDD;}
            .h5{color: blue;}
            * {margin: 0px; padding: 5px;}
            p:hover {background: #ffbf00;}
            p{display: inline-block; overflow: hidden;}
            hr{border: 0; border-bottom: 1px solid black;}
            form{border: 1px solid black; background: #CCC}
            .c1, .c2, .c3, .c4, .c5, .c6, .c7, .c8 {border-right: 1px dashed #9f9f9f;}
            .c1{width: 60px;}
            .c2{width: 150px;}
            .c3{width: 50px;}
            .c4{width: 50px;}
            .c5{width: 200px;}
            .c6{width: 50px;}
            .c7{width: 50px;}
            .c8{width: 450px;}
        </style>
    </head>
    <body>
        <form action="parse.php" method="POST">
            <fieldset>
                <legend>Адрес</legend>
                <label>URL или файл
                    <input type="text" name="srcUrl" required="required" 
                           placeholder="Введите URL" size="150" 
                           value="<?php echo(isset($_POST['srcUrl']) ? strip_tags( $_POST['srcUrl']) : 'foreca.html'); ?>"/>
                </label>
                <input type="submit" value="Go" /><input type="reset" value="Reset" />
            </fieldset>
        </form>

        <?php
        //setlocale(LC_CTYPE, 'ru_RU.utf8');
        //setlocale(LC_ALL, 'ru_RU.utf8');        /*/<div +class="c1.*".*[^>]>.*<\/div>/smiU*/
        //setlocale(LC_TIME, 'ru_RU.utf8');
        if (!isset($_POST['srcUrl'])) {
            exit;
        }
        $out = '';
        $now = time();
        $src_url = strip_tags( $_POST['srcUrl'] );
        $page_src = file_get_contents($src_url);                // открываем файл
        $pat_divs = '#<div\s?class="c1\s+(?:clr[\d])?">.*<\/div>#smiU';     // шаблон для div        
        // извлекаем div-ы
        if (preg_match_all($pat_divs, $page_src, $match_divs)) {
            //print_r($match_divs);
            foreach ($match_divs[0] as $div) {
                procD($div);
            }
        } else {
            echo 'no matches';
        }

        $out_win = mb_convert_encoding($out, 'windows-1251', 'utf-8');
        file_put_contents('./iwx/weather2.txt', strtr($out_win, chr(0xB0), chr(0x20)));

        function procD($div) {

            $patt = '#<div\s+class="c1\s+(?:clr[\d])?">[^>](?:\s*\n?)*'
                    . '<a\s+href=".+?"\s+title=".+?"\s+class="cell">[^>](?:\s*\n?)*'
                    . '<span\s+class="h5">((?:\w[\s\.]?)+)</span>(?:\s*\n?)*'  //(\w[\s\.]?)+
                    . '<img\s+src="(.*\/d(.*)(\.png))"\s+alt="((?:\w\s??)+?)"\s+width="50"><br>(?:\s*\n?)*'
                    . 'Макс:\s<strong>(.+)</strong><br>(?:\s*\n?)*'
                    . 'Мин:\s<strong>(.+)</strong><br>(?:\s*\n?)*'
                    . '<span><span>(?:\s*\n?)*'
                    . '<img src=".*" alt=".*" width="27" height="28">(?:\s*\n?)*'
                    . '<strong>\d+</strong>\s+м/с(?:\s*\n?)*'
                    . '</span></span>(?:\s*\n?)*'
                    . '<span class="more">подробнее</span>(?:\s*\n?)*'
                    . '</a>(?:\s*\n?)*?</div>'
                    . '#sum';

            if (preg_match($patt, $div, $match)) {

                $c = count($match);
                for ($i = 1; $i < $c; $i++) {
                    echo "<p class=\"c$i\">" . $match[$i] . '</p>';
                }
                //echo '<br/>**';
                //procDate($match[1]);


                $newfn = './iwx/iwx' . $match[3] . $match[4];
                if (!file_exists($newfn)) {
                    copy($match[2], $newfn);
                }

                $wdays = array('1' => 'Понедельник', '2' => 'Вторник',
                    '3' => 'Среда', '4' => 'Четверг', '5' => 'Пятница',
                    '6' => 'Суббота', '7' => 'Воскресенье');
                $mons = array('1' => 'Января', '2' => 'Февраля', '3' => 'Марта',
                    '4' => 'Апреля', '5' => 'Мая', '6' => 'Июня',
                    '7' => 'Июля', '8' => 'Августа', '9' => 'Сентября',
                    '10' => 'Октября', '11' => 'Ноября', '12' => 'Декабря');

                global $out;
                global $now;
                $dat = $wdays[date('N', $now)] . date('|j ', $now) . $mons[date('n', $now)];
                $now += 1 * 24 * 60 * 60;
                $line = "$dat|$match[5]|Ночью $match[7]|Днём $match[6]|$match[3]";
                echo "<p class=\"c8\">$line</p><hr/>";
                $out .= $line . "\r\n";

                /* Среда|22 ноября|Ясно|Ночью -3|Днем +1|01                 
                  1 Сегодня
                  2 foreca_files/d3000000.png
                  3 3000000
                  4 .png
                  5 Преимущественно облачно
                  6 +2°
                  7 -2
                 */
            } else {
                echo '<b>no_match</b><br/>';
                //echo $div;
                print_r($div);
            }
        }

        function procDate($strdat) {
            //echo $strdat;
            if (preg_match('#(\w+)\s?(\d{1,2}\.){0,2}#u', $strdat, $dats)) {
                print_r($dats);
                return 1;
            } else {
                echo "!no_date!";
                return 0;
            }
        }
        ?>


    </body>
</html>