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

    switch ($period) {
        case 'day':
            $sql = 'SELECT
                      `date`,
                      `detail`,
                      `amount`,
                      `purpose`
                    FROM
                      `pays`
                    WHERE
                      `user_id` = :user_id
                    ORDER BY
                      `date` DESC';
            break;
        case 'week':
            $sql = 'SELECT
                      SUBDATE(`date`, WEEKDAY(`date`)) AS `date`,
                      `detail`,
                      SUM(`amount`) AS `amount`,
                      `purpose` -- 最新のレコードのものが取得される
                    FROM
                      `pays`
                    WHERE
                      `user_id` = :user_id
                    GROUP BY
                      `detail`,
                      SUBDATE(`date`, WEEKDAY(`date`))
                    ORDER BY
                      `date` DESC';
            break;
        case 'month':
            $sql = 'SELECT
                      DATE_FORMAT(`date`, "%Y%m") AS `date`,
                      `detail`,
                      SUM(`amount`) AS `amount`,
                      `purpose` -- 最新のレコードのものが取得される
                    FROM
                      `pays`
                    WHERE
                      `user_id` = :user_id
                    GROUP BY
                      `detail`,
                      DATE_FORMAT(`date`, "%Y%m")
                    ORDER BY
                      `date` DESC';
            break;
        case 'year':
            $sql = 'SELECT
                      DATE_FORMAT(`date`, "%Y") AS `date`,
                      `detail`,
                      SUM(`amount`) AS `amount`,
                      `purpose` -- 最新のレコードのものが取得される
                    FROM
                      `pays`
                    WHERE
                      `user_id` = :user_id
                    GROUP BY
                      `detail`,
                      DATE_FORMAT(`date`, "%Y")
                    ORDER BY
                      `date` DESC';
            break;
    }

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
