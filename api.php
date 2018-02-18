<?php

session_start();
header('Content-Type: application/json');

try {
    $dbh = new PDO(
        'mysql:host=localhost;dbname=dev_no_kakin;charset=utf8',
        'root',
        'root',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $period  = filter_input(INPUT_POST, 'period');
    $pays    = [];

    $select  = '';
    $from    = 'FROM `pays` ';
    $where   = 'WHERE `user_id` = :user_id ';
    $groupby = '';
    $orderby = 'ORDER BY `date` DESC ';

    switch ($period) {
        case 'day':
            $select = 'SELECT
                          `date`,
                          `detail`,
                          `amount`,
                          `purpose` ';
            break;
        case 'week':
            $select = 'SELECT
                          SUBDATE(`date`, WEEKDAY(`date`)) AS `date`,
                          `detail`,
                          SUM(`amount`) AS `amount`,
                          `purpose` '; // 最新のレコードのものが取得される

            $groupby = 'GROUP BY
                          `detail`,
                          SUBDATE(`date`, WEEKDAY(`date`)) ';
            break;
        case 'month':
            $select = 'SELECT
                          DATE_FORMAT(`date`, "%Y/%m") AS `date`,
                          `detail`,
                          SUM(`amount`) AS `amount`,
                          `purpose` '; // 最新のレコードのものが取得される

            $groupby = 'GROUP BY
                          `detail`,
                          DATE_FORMAT(`date`, "%Y%m") ';
            break;
        case 'year':
            $select = 'SELECT
                          DATE_FORMAT(`date`, "%Y") AS `date`,
                          `detail`,
                          SUM(`amount`) AS `amount`,
                          `purpose` '; // 最新のレコードのものが取得される

            $groupby = 'GROUP BY
                          `detail`,
                          DATE_FORMAT(`date`, "%Y") ';
            break;
    }

    $sql = $select . $from . $where . $groupby . $orderby;
    $selectPays = $dbh->prepare($sql);
    $selectPays->execute([':user_id' => $_SESSION['user']['id']]);

    $keys = ['date', 'detail', 'amount', 'purpose'];
    while ($row = $selectPays->fetch(PDO::FETCH_ASSOC)) {
        foreach ($keys as $k) {
            $pay[$k] = $row[$k];
        }
        $pays[] = $pay;
    }
    echo json_encode($pays);

} catch(PDOException $e) {
    $error = $e->getMessage();
}
