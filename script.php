<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Результат вычислений</title>
    <meta charset='utf-8'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>
    <link href="css/stylesResponse.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
    <script language="text/javascript" src="js/script.js" type="text/javascript"></script>
</head>

<body style="overflow:hidden;">
<div class="background">

    <?php
function getIfSet(&$value, $default = null)
{
    return isset($value) ? $value : $default;
}


    function filter($n)
{
    if (abs($n) >= 1000000000000000) return substr((string)($n), 0, 3) . "…";
    else if (abs($n) >= 1000000000000) return round(($n / 1000000000000)) . "k^4";
    else if (abs($n) >= 1000000000) return round(($n / 1000000000), 1) . "kkk";
    else if (abs($n) >= 1000000) return round(($n / 1000000), 1) . "kk";
    else if (abs($n) >= 1000) return round(($n / 1000), 1) . "k";
    else return (string)(floor($n * 100) / 100);
}

    $y = str_replace(',', '.', getIfSet($_REQUEST['y']));
$x = str_replace(',', '.', getIfSet($_REQUEST['x']));
$r = str_replace(',', '.', getIfSet($_REQUEST['r']));


    $wrongInput = false;
$correctNumbers = false;
if (is_numeric($x) && is_numeric($y) && is_numeric($r) && ($r <= 6 && $r >= 1) && ($y >= -5 && 5 >= $y) && ($x >= -2 && 2 >= $x)) {

    if ($x >= 0 && $y >= 0 && $y <= -$x + $r) {
        $correctNumbers = true;
    } elseif ($x >= 0 && $y <= 0 && $y * $y <= $r * $r / 4 - $x * $x) {
        $correctNumbers = true;
    } elseif ($x <= 0 && $y >= 0 && $x >= -$r / 2 && $y <= $r) {
        $correctNumbers = true;
    }
    ?>
    <script>
        function equal(obj, newObj) {
            return (obj.x === newObj.x) && (obj.y === newObj.y) && (obj.r === newObj.r) && (obj.result === newObj.result);
        }

        let obj = {
            x: Number("<?php echo $x; ?>").toString(),
            y: Number("<?php echo $y; ?>").toString(),
            r: Number("<?php echo $r; ?>").toString(),
            result: "<?php echo ($correctNumbers) ? 'true' : 'false'; ?>"
        };
        let allData = [];

        if (sessionStorage.userData) {
            previousObjs = sessionStorage.getItem('userData');
            allData.push(previousObjs);

            if (allData.length == 0 || !equal(JSON.parse(sessionStorage.getItem('lastObj')), obj)) {
                sessionStorage.setItem('lastObj', JSON.stringify(obj));
                allData.push(JSON.stringify(obj));
                sessionStorage.setItem('userData', allData);
            }
        } else {
            allData.push(obj);
            sessionStorage.setItem('lastObj', JSON.stringify(obj));
            sessionStorage.setItem('userData', JSON.stringify(obj));
        }
    </script>
    <?php

} else {
    $wrongInput = true;
}

    ?>

    <main class="animated zoomIn fast">
        <table id="tableResponse" cellspacing="15">
            <a href="index.html" class="close">
                <script>
                    $(function () {
                        $('a').click(function (e) {
                            $('main').addClass('animated zoomOut fast');
                        });
                    });
                </script>
            </a>
            <tbody>
            <tr>
                <td class="etRect">
                    <span style="font-size: 18px;">Время исполнения</span>
                    <p>
                        <?php
                        echo number_format((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) * 1000000, 2, ",", ".") . " мкс";
                        ?>
                    </p>
                </td>
                <td>
                    <table id="tableParameters" style="text-align: center;">
                        <tr>
                            <td class="yRect">
                                <span class="parameters" style="font-size: 18px;">X</span>
                                <?php
                                if (!$wrongInput || is_numeric($x)) {
                                    echo "<span style='text-align:center;' title=\"$x\">" . str_replace('.', ',', filter($x)) . "</span>";
                                } else {
                                    echo "——";
                                }
                                ?>
                            </td>
                            <td style="padding:0 5px 0 5px;"></td>
                            <td class="xRect">
                                <span class="parameters" style="font-size: 18px;">Y</span>
                                <?php
                                if (!$wrongInput || is_numeric($y)) {
                                    echo "<span style='text-align:center;' title=\"$y\">" . str_replace('.', ',', filter($y)) . "</span>";
                                } else {
                                    echo "——";
                                }
                                ?>
                            </td>
                            <td style="padding:0 5px 0 5px;"></td>
                            <td class="rRect">
                                <span class="parameters" style="font-size: 18px;">R</span>
                                <?php
                                if ((!$wrongInput || is_numeric($r))) {
                                    echo "<span style='text-align:center;' title=\"$r\">" . str_replace('.', ',', filter($r)) . "</span>";
                                } else {
                                    echo "——";
                                }
                                ?>
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
                    if ($correctNumbers && !$wrongInput) {
                        echo '<p style="color:#008000;text-align:center;">Попал!</p>';
                    } elseif (!$wrongInput) {
                        echo '<p style="color:#B22222;text-align:center;">Мимо :(</p>';
                    } else {
                        echo '<p style="color:#B22222;text-align:center;">Данные неверны!</p>';
                    }
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="tableFixHead">
            <table id="dataTable" style="text-align: center;" class="hide">
                <thead align="center">
                <tr>
                    <th>X</th>
                    <th>Y</th>
                    <th>R</th>
                    <th>Результат</th width="25%">
                </tr>
                </thead>

                <tbody id="tableBody">
                <script type="text/javascript">
                    let rxp = /{([^}]+)}/g,
                        curMatch;
                    let rows = [], j = -1;
                    if (sessionStorage.userData) {
                        userAttempts = sessionStorage.getItem('userData');
                        while (curMatch = rxp.exec(userAttempts)) {
                            obj = JSON.parse("{" + curMatch[1] + "}");
                            let x = obj.x.toString().length > 15 ?
                                (obj.x.toString().replace(".", ",").substring(0, 15) + "…") :
                                obj.x.toString().replace(".", ",");
                            let y = obj.y.toString().length > 15 ?
                                (obj.y.toString().replace(".", ",").substring(0, 15) + "…") :
                                obj.y.toString().replace(".", ",");
                            let r = obj.r.toString().length > 15 ?
                                (obj.r.toString().replace(".", ",").substring(0, 15) + "…") :
                                obj.r.toString().replace(".", ",");

                            rows[++j] = '<tr><td width="134px">';
                            rows[++j] = '<span title=\"' + obj.x.toString().replace(".", ",") + '\"' + '>' + x + '</span>';
                            rows[++j] = '</td><td width="134px">';
                            rows[++j] = '<span title=\"' + obj.y.toString().replace(".", ",") + '\"' + '>' + y + '</span>';
                            rows[++j] = '</td><td width="134px">';
                            rows[++j] = '<span title=\"' + obj.r.toString().replace(".", ",") + '\"' + '>' + r + '</span>';
                            rows[++j] = '</td><td width="134px">';
                            rows[++j] = obj.result === "true" ? '<p style="color:#008000;text-align:center;">Попал</p>' : '<p style="color:#B22222;text-align:center;">Мимо</p>';
                            rows[++j] = '</td></tr>';
                        }
                        $('#tableBody').html(rows.join(''));
                    }
                </script>
                </tbody>
            </table>
        </div>

        <button id="historyButton" class="historyButton" onclick="showTable()" style="border: none;">
            <svg id="historyIcon" width="64" version="1.1" xmlns="http://www.w3.org/2000/svg" height="64"
                 viewBox="0 0 64 64"
                 xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 64 64">
                <g>
                    <g fill="#333">
                        <path d="m34.688,3.315c-15.887,0-28.812,12.924-28.81,28.729-0.012,0.251-0.157,4.435 1.034,8.941l-3.881-2.262c-0.964-0.56-2.192-0.235-2.758,0.727-0.558,0.96-0.234,2.195 0.727,2.755l9.095,5.302c0.019,0.01 0.038,0.013 0.056,0.022 0.097,0.052 0.196,0.09 0.301,0.126 0.071,0.025 0.14,0.051 0.211,0.068 0.087,0.019 0.173,0.025 0.262,0.033 0.062,0.006 0.124,0.025 0.186,0.025 0.035,0 0.068-0.012 0.104-0.014 0.034-0.001 0.063,0.007 0.097,0.004 0.05-0.005 0.095-0.026 0.144-0.034 0.097-0.017 0.189-0.038 0.282-0.068 0.078-0.026 0.155-0.057 0.23-0.093 0.084-0.04 0.163-0.084 0.241-0.136 0.071-0.046 0.139-0.096 0.203-0.15 0.071-0.06 0.134-0.125 0.197-0.195 0.059-0.065 0.11-0.133 0.159-0.205 0.027-0.04 0.063-0.069 0.087-0.11 0.018-0.031 0.018-0.067 0.033-0.098 0.027-0.055 0.069-0.103 0.093-0.162l3.618-8.958c0.417-1.032-0.081-2.207-1.112-2.624-1.033-0.414-2.207,0.082-2.624,1.114l-1.858,4.6c-1.24-4.147-1.099-8.408-1.095-8.525 0-13.664 11.117-24.78 24.779-24.78 13.663,0 24.779,11.116 24.779,24.78 0,13.662-11.116,24.778-24.779,24.778-1.114,0-2.016,0.903-2.016,2.016s0.901,2.016 2.016,2.016c15.888,0 28.812-12.924 28.812-28.81-0.002-15.888-12.926-28.812-28.813-28.812z"/>
                        <path d="m33.916,36.002c0.203,0.084 0.417,0.114 0.634,0.129 0.045,0.003 0.089,0.027 0.134,0.027 0.236,0 0.465-0.054 0.684-0.134 0.061-0.022 0.118-0.054 0.177-0.083 0.167-0.08 0.321-0.182 0.463-0.307 0.031-0.027 0.072-0.037 0.103-0.068l12.587-12.587c0.788-0.788 0.788-2.063 0-2.851-0.787-0.788-2.062-0.788-2.851,0l-11.632,11.631-10.439-4.372c-1.033-0.431-2.209,0.053-2.64,1.081-0.43,1.027 0.055,2.208 1.08,2.638l11.688,4.894c0.004,0.001 0.008,0.001 0.012,0.002z"/>
                    </g>
                </g>
            </svg>
        </button>
</main>
</div>
<header>
    Иван Братчиков<br>
    Вариант № 201003<br>
    P3201<br>
</header>
<footer class="footer">
    <p><span id="datetime"></span></p>

    <script type="text/javascript">
        document.write(new Date().getFullYear());
    </script>
</footer>
</body>
</html>

