<?php
$data = file_get_contents("./data.json");
$json = json_decode($data, true);
$days = ['Po', 'Út', 'St', 'Čt', 'Pá'];
$freeRoomArr = array();
function getHour()
{
    $v = json_decode('[{"from":"07:05","to":"07:50","start":0,"break":10},{"from":"08:00","to":"08:45","start":55,"break":5},{"from":"08:50","to":"09:35","start":105,"break":10},{"from":"09:45","to":"10:30","start":160,"break":20},{"from":"10:50","to":"11:35","start":225,"break":10},{"from":"11:45","to":"12:30","start":280,"break":10},{"from":"12:40","to":"13:25","start":335,"break":10},{"from":"13:35","to":"14:20","start":390,"break":5},{"from":"14:25","to":"15:10","start":440,"break":5},{"from":"15:15","to":"16:00","start":490,"break":5},{"from":"16:05","to":"16:50","start":540,"break":5},{"from":"16:55","to":"17:40","start":590,"break":5},{"from":"17:45","to":"18:30","start":640,"break":0}]');
    $t = (date('G') + 1) * 60 + date('i') - 425;
    for ($e = 0; $e < count($v); $e++) {
        if ($v[$e]->start - $v[$e]->break <= $t && $t <  $v[$e]->start - $v[$e]->break + 45)
            if (isset($_GET['hodina'])) {

                return $e + $_GET['hodina'];
            } else {
                return $e;
            }
    }
    return !1;
}


function getFreeClassrooms()
{
    global $json;
    $freeRoom = array();
    $classRooms = ["B101", "B102", "B103", "B104", "B125", "B130", "B133", "B201", "B202", "B203", "B204", "B206", "B221", "B224", "B301", "B302", "B303", "B304", "B305", "B306", "B321", "B322", "B323", "B330", "B332", "B333", "D152", "D251", "D252", "D351"];
    foreach ($classRooms as $room) {
        if (!isset($json[$room][date('N') - 1][getHour()])) {
            array_push($freeRoom, $room);
        }
    }
    return $freeRoom;
}

$freeRoomArr = getFreeClassrooms();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <a href="index.php?hodina=1">Další hodina</a>
    <div class="table">
        <?php foreach ($freeRoomArr as $room) : ?>
            <div class="tatata">
                <table class="g2">
                    <h1><?= $room ?></h1>

                    <tbody>
                        <tr>
                            <th class="p20"></th>
                            <th>
                                <div>0</div><span>07:05 ~ 07:50</span>
                            </th>
                            <th class="p10"></th>
                            <th>
                                <div>1</div><span>08:00 ~ 08:45</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>2</div><span>08:50 ~ 09:35</span>
                            </th>
                            <th class="p10"></th>
                            <th>
                                <div>3</div><span>09:45 ~ 10:30</span>
                            </th>
                            <th class="p20"></th>
                            <th>
                                <div>4</div><span>10:50 ~ 11:35</span>
                            </th>
                            <th class="p10"></th>
                            <th>
                                <div>5</div><span>11:45 ~ 12:30</span>
                            </th>
                            <th class="p10"></th>
                            <th>
                                <div>6</div><span>12:40 ~ 13:25</span>
                            </th>
                            <th class="p10"></th>
                            <th>
                                <div>7</div><span>13:35 ~ 14:20</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>8</div><span>14:25 ~ 15:10</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>9</div><span>15:15 ~ 16:00</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>10</div><span>16:05 ~ 16:50</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>11</div><span>16:55 ~ 17:40</span>
                            </th>
                            <th class="p5"></th>
                            <th>
                                <div>12</div><span>17:45 ~ 18:30</span>
                            </th>
                        </tr>
                        <?php foreach ($json[$room] as $index => $day) : ?>
                            <tr class="tdy">
                                <th class="p20">
                                    <div><?= $days[$index] ?></div><span>20. 1.</span>
                                </th>
                                <?php for ($d = 0; $d <= 12; $d++) : ?>
                                    <?php if (isset($day[$d])) : $hour = $day[$d]; ?>
                                        <td class="hr" title="">
                                            <div>
                                                <div><span><?= $hour['cls'] ?></span><em><?= $hour['group'] ?></em></div>
                                                <div><?= $hour['subject'] ?> <?= $hour['teacher'] ?></div>
                                            </div>
                                        </td>
                                    <?php else : ?>
                                        <?php if (getHour() == $d && $index == date('N') - 1) : ?>
                                            <td class="hr now" title=""></td>
                                        <?php else : ?>
                                            <td class="hr" title=""></td>
                                        <?php endif; ?>
                                    <?php endif ?>
                                    <?php if ($d != 12) : ?>
                                        <td class="ps"></td>
                                    <?php endif ?>

                                <?php endfor ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

        <div id="ptr" style="left: 359.2px; height: 361px; display: block;"><img alt="" src="r_arr.gif"></div>
    </div>
</body>

</html>