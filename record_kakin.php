<?php

session_start();

require_once 'functions.php';
check_signined();

$date    = filter_input(INPUT_POST, 'date');
$detail  = filter_input(INPUT_POST, 'detail');
$amount  = filter_input(INPUT_POST, 'amount');
$purpose = filter_input(INPUT_POST, 'purpose');

if ($date && $detail && $amount && $purpose) {
    try {
        $dbh = new PDO(
             'mysql:host=localhost;dbname=dev_no_kakin;charset=utf8',
            'root',
            'root',
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );

        $insertPay = $dbh->prepare(
            'INSERT INTO `pays` (`user_id`, `date`, `amount`, `detail`, `purpose`, `created_at`)
                VALUES (:user_id, :date, :amount, :detail, :purpose, :created_at);'
        );
        $insertPay->execute([':user_id' => $_SESSION['user_id'], ':date' => $date, ':amount' => $amount,
                                ':detail' => $detail, ':purpose' => $purpose, ':created_at' => date('Y-m-d H:i:s')]);

        $_SESSION['message']['success'] = "登録しました！";
    } catch(PDOException $e) {
        $error = $e->getMessage();
    }
} else {
    $_SESSION['message']['error'] = "入力内容に不足があります。";
}
header('location: /regret_for_expenses/top.php');
