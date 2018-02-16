<?php

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function check_signined() {
    if (!isset($_SESSION['user']['id'])) {
        $_SESSION['is_signined'] = false;
        header('location: /regret_for_expenses/index.php');
    } else {
        $_SESSION['is_signined'] = true;
    }
}
