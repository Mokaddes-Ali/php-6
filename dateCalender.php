<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Calendar</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Dynamic Calendar</h2>
<form method="POST">
    <label for="month">Month:</label>
    <select id="month" name="month">
        <?php
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1));
            echo "<option value='$m'" . (isset($_POST['month']) && $_POST['month'] == $m ? " selected" : "") . ">$monthName</option>";
        }
        ?>
    </select>
    <label for="year">Year:</label>
    <select id="year" name="year">
        <?php
        $currentYear = date('Y');
        for ($y = $currentYear - 100; $y <= $currentYear + 10; $y++) {
            echo "<option value='$y'" . (isset($_POST['year']) && $_POST['year'] == $y ? " selected" : "") . ">$y</option>";
        }
        ?>
    </select>
    <button type="submit">Show Calendar</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = $_POST['month'];
    $year = $_POST['year'];

    echo generateCalendar($month, $year);
}

function generateCalendar($month, $year) {
    $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<h3>$monthName $year</h3>";
    $calendar .= "<table>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th>$day</th>";
    }

    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        $calendar .= str_repeat('<td></td>', $dayOfWeek);
    }

    $currentDay = 1;

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $calendar .= "<td>$currentDay</td>";

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= str_repeat('<td></td>', $remainingDays);
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}
?>

</body>
</html>
