<?php

function check_signined() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['status'] = "利用にはサインインが必要です。";
        header('location: /regret_for_expenses/index.php');
        exit;
    } else {
        unset($_SESSION['status']);
    }
}
