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
    <script>
        function submitForm() {
            document.getElementById('calendarForm').submit();
        }
    </script>
</head>
<body>

<h2>Dynamic Calendar</h2>
<form id="calendarForm" method="GET">
    <label for="month">Month:</label>
    <select id="month" name="month" onchange="submitForm()">
        <?php
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1));
            $selected = (isset($_GET['month']) && $_GET['month'] == $m) ? 'selected' : '';
            echo "<option value='$m' $selected>$monthName</option>";
        }
        ?>
    </select>
    <label for="year">Year:</label>
    <select id="year" name="year" onchange="submitForm()">
        <?php
        $currentYear = date('Y');
        for ($y = $currentYear - 100; $y <= $currentYear + 10; $y++) {
            $selected = (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '';
            echo "<option value='$y' $selected>$y</option>";
        }
        ?>
    </select>
</form>

<?php
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $month = date('n'); // Current month
    $year = date('Y'); // Current year
}

echo generateCalendar($month, $year);

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
