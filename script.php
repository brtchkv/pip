<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Результат вычислений</title>
    <meta charset='utf-8'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <link href="css/stylesResponse.css" rel="stylesheet">
</head>

<body class="background">
<header>
    Иван Братчиков<br>
    Вариант № 201003<br>
    P3201<br>
</header>

<?php
function getIfSet(&$value, $default = null)
{
    return isset($value) ? $value : $default;
}

$y = getIfSet($_REQUEST['y']);
$x = getIfSet($_REQUEST['x']);
$r = getIfSet($_REQUEST['r']);


$wrongInput = false;
if (is_numeric($x) && is_numeric($y) && is_numeric($r)) {

    $correct = false;

    if ($x >= 0 && $y >= 0 && $y <= -$x + $r) {
        $correct = true;
    } elseif ($x >= 0 && $y <= 0 && $y * $y <= $r * $r / 4 - $x * $x) {
        $correct = true;
    } elseif ($x <= 0 && $y >= 0 && $x >= -$r / 2 && $y <= $r) {
        $correct = true;
    }
} else {
    $wrongInput = true;
}

?>

<main>
    <table id="tableResponse" cellspacing="15">
        <tbody>
        <tr>
            <td class="etRect">
                <span style="font-size: 18px;">Время исполнения</span>
                <p>
                    <?php
                    printf("%.2f мкс", (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000000);
                    ?>
                </p>
            </td>
            <td>
                <table id="tableParameters">

                    <tr>
                        <td class="yRect">
                            <span class="parameters" style="font-size: 18px;">X</span>
                            <?php echo $x ?>
                        </td>
                        <td style="padding:0 5px 0 5px;"></td>
                        <td class="xRect">
                            <span class="parameters" style="font-size: 18px;">Y</span>
                            <?php echo $y ?>
                        </td>
                        <td style="padding:0 5px 0 5px;"></td>
                        <td class="rRect">
                            <span class="parameters" style="font-size: 18px;">R</span>
                            <?php echo $r ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td class="ctRect">
                <span style="font-size: 18px;">Текущее время</span>
                <p id="time"></p>
                <script type="text/javascript">
                    function setTime() {
                        document.getElementById("time").innerHTML = new Date().toLocaleTimeString();
                    }

                    setInterval(setTime, 1000);
                    setTime();
                </script>
            </td>
            <td class="resultRect">
                <span style="font-size: 18px;">Результат</span>
                <?php
                if ($correct && !$wrongInput) {
                    echo '<p style="color:#008000;text-align:center;">Попал!</p>';
                } else {
                    echo '<p style="color:#B22222;text-align:center;">Мимо :(</p>';
                }
                if ($wrongInput) {
                    echo '<p style="color:#B22222;text-align:center;">Данные неверны!</p>';
                }
                ?>
            </td>
        </tr>
        </tbody>
    </table>
</main>
<footer class="footer">
    <p><span id="datetime"></span></p>

    <script type="text/javascript">
        document.write(new Date().getFullYear());
    </script>
</footer>
</body>
</html>

