<?php

session_start();

require_once 'functions.php';
check_signined();

include(dirname('index.php').'/layouts/head.php');

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

    // 一覧データの取得
    $selectAllPays = $dbh->prepare(
        'SELECT * FROM `pays` WHERE `user_id` = :user_id ORDER BY `date` DESC;'
    );
    $selectAllPays->execute([':user_id' => $_SESSION['user']['id']]);
    $all_pays = $selectAllPays->fetchAll(PDO::FETCH_ASSOC); // fetch,fetchAll,etc. 引数には返り値の形式を指定する.

    // 最新データの取得
    $selectLatestPays = $dbh->prepare(
        'SELECT SUM(`amount`) AS `amount`, `date` FROM `pays`
            WHERE `user_id` = :user_id1 AND `date` = (SELECT MAX(`date`) FROM `pays` WHERE `user_id` = :user_id2)'
    );
    $selectLatestPays->execute(['user_id1' => $_SESSION['user']['id'], 'user_id2' => $_SESSION['user']['id']]);
    $latest_pay = $selectLatestPays->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = $e->getMessage();
}

?>

<section id="top" class="light-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section-title">
          <br />
          <? if (isset($error)) : ?>
            <p class="alert alert-warning"><?= $error ?></p>
          <? endif; ?>
          <? if (isset($_SESSION['message']['error'])) : ?>
            <p class="alert alert-danger"><?= $_SESSION['message']['error'] ?></p>
          <? endif; ?>
          <? if (isset($_SESSION['message']['success'])) : ?>
            <p class="alert alert-success"><?= $_SESSION['message']['success'] ?></p>
          <? endif; ?>
          <div id="notice-latest">
            最後に課金したのは<b><?= date('n月j日', strtotime($latest_pay['date'])) ?>、<?= number_format($latest_pay['amount']) ?>円</b>です。
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="sub-menu">
        <span class="small-letter">表示データの期間を変更：</span>
        <form name="select-period" class="inline-block">
          <select name="period">
            <option value="day" selected>日単位</option>
            <option value="week">週単位</option>
            <option value="month">月単位</option>
            <option value="year">年単位</option>
          </select>
        </form>
        <a href="#" data-toggle="modal" data-target="#Modal-2" class="button record-kakin-log">記録する</a>
      </div>

      <table class="table" id="kakin-list">
        <thead class="block">
          <tr class="block">
            <th class="col-xs-3 block"><center><i class="fa fa-calendar fa-2x"></i></center></th>
            <th class="col-xs-2 block"><center><i class="fa fa-tag fa-2x"></i></center></th>
            <th class="col-xs-3 block"><center><i class="fa fa-money fa-2x"></i></center></th>
            <th class="col-xs-4 block"><center><i class="fa fa-comment fa-2x"></i></center></th>
          </tr>
        </thead>
        <tbody class="block">
          <?php foreach ($all_pays as $row) : ?>
          <tr class="block kakin-list-row">
            <td class="col-xs-3 text-center block"><?= $row['date'] ?></td>
            <td class="col-xs-2 text-center block"><?= $row['detail'] ?></td>
            <td class="col-xs-3 text-center block"><b>¥ <?= number_format($row['amount']) ?></b></td>
            <td class="col-xs-4 block"><?= $row['purpose'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php

include(dirname('index.php').'/layouts/foot.php');
unset($_SESSION['kakin']);
unset($_SESSION['message']);

?>
