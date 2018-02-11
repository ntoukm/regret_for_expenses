<?php

function check_signined() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['is_signined'] = false;
        header('location: /regret_for_expenses/index.php');
    } else {
        $_SESSION['is_signined'] = true;
    }
}
