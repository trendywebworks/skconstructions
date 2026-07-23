<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<?php
$grandTotal = 0;
$totalExpense = 0;
$totalIncome = 0;

$date = new DateTime("$year-$month-01");
$date->modify('-1 month');

$prevMonth = $date->format('m');
$prevYear = $date->format('Y');

// Next month and year
$dateNext = clone $date;
$dateNext->modify('+2 month');
$nextMonth = $dateNext->format('m');
$nextYear = $dateNext->format('Y');

$firstDay = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$dayOfWeek = date('w', $firstDay);

$calendarTable = '<table border="1" class="table text-center">';
$calendarTable .= '<tr>
        <th><a href="'.base_url('reports-daily/'.$prevYear.'/'.$prevMonth).'"><<</a></th>
        <th colspan="5">' . date('M Y', $firstDay) . '</th>
        <th><a href="'.base_url('reports-daily/'.$nextYear.'/'.$nextMonth).'">>></a></th>
    </tr>';
$calendarTable .= '<tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>';

$calendarTable .= '<tr>';
for ($i = 0; $i < $dayOfWeek; $i++) {
    $calendarTable .= '<td></td>';
}

for ($day = 1; $day <= $daysInMonth; $day++) {
    $thisDate = $year.'-'.$month.'-'.$day;
    $calendarTable .= '<td style"width:100px;">' . $day;
    if($reportArray[$thisDate][0]['total'] > 0)
    {
        $grandTotal += $reportArray[$thisDate][0]['total'];
        $totalExpense += $reportArray[$thisDate][0]['total_expense'];
        $totalIncome += $reportArray[$thisDate][0]['total_income'];

        $gTotal = $reportArray[$thisDate][0]['total_income'] + $reportArray[$thisDate][0]['total_expense'];
        $calendarTable .= '<table class="table table-condensed table-stripedx" style="margin-bottom:0;"><tbody><tr><td><span style="font-weight:normal;">Income<br>Expense</span></td><td style="text-align:right;"><span style="font-weight:normal;">'.numFormat($reportArray[$thisDate][0]['total_income']).'<br>'.numFormat($reportArray[$thisDate][0]['total_expense']).'</span></td></tr><tr style="background-color:#ededed"><td class="violet">Grand Total</td><td style="text-align:right;" class="violet">'.numFormat($gTotal).'</td></tr></tbody></table>';
    }
    $calendarTable .= '</td>';

    if ($dayOfWeek == 6) {
        $calendarTable .= '</tr><tr>';
        $dayOfWeek = 0;
    } else {
        $dayOfWeek++;
    }
}

while ($dayOfWeek < 7) {
    $calendarTable .= '<td></td>';
    $dayOfWeek++;
}

$calendarTable .= '</tr>';
$calendarTable .= '</table>';
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-blue order-card">
                            <div class="card-block">
                                <h6 class="m-b-20 text-white">Total Expense</h6>
                                <h2 class="text-right text-white"><i class="fa fa-cart-plus f-left"></i><span><?php echo numFormat($totalExpense); ?></span></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h6 class="m-b-20 text-white">Total Income</h6>
                                <h2 class="text-right text-white"><i class="fa fa-rocket f-left"></i><span><?php echo numFormat($totalIncome); ?></span></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h6 class="m-b-20 text-white">Total Amount</h6>
                                <h2 class="text-right text-white"><i class="fa fa-refresh f-left"></i><span><?php echo numFormat($grandTotal); ?></span></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="calendar table-responsive">
                    <?php echo $calendarTable; ?>
                </div>
            </div>
        </div>
    </div>
</div>