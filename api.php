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

    $pays        = [];
    // 入力値の取得
    $period      = filter_input(INPUT_POST, 'period');
    $period_from = filter_input(INPUT_POST, 'periodFrom');
    $period_to   = filter_input(INPUT_POST, 'periodTo');

    // SQLの設定
    $select  = '';
    $from    = 'FROM `pays` ';
    $where   = 'WHERE `user_id` = :user_id ';
    $groupby = '';
    $orderby = 'ORDER BY `date` DESC ';
    $arg     = [':user_id' => $_SESSION['user']['id']];

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

        case 'specify':
            $select = 'SELECT
                          `date`,
                          `detail`,
                          `amount`,
                          `purpose` ';

            $where .= 'AND `date` >= :period_from AND `date` <= :period_to ';

            $arg[':period_from'] = $period_from;
            $arg[':period_to']   = $period_to;
    }

    $sql = $select . $from . $where . $groupby . $orderby;
    $selectPays = $dbh->prepare($sql);
    $selectPays->execute($arg);
    // $selectPays->execute([':user_id' => $_SESSION['user']['id']]);
    // $selectPays->execute([':user_id' => $_SESSION['user']['id'], ':period_from' => $period_from, ':period_to' => $period_to]);

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
