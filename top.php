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
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        )
    );

    // 一覧データの取得
    $selectAllPays = $dbh->prepare(
        'SELECT * FROM `pays` WHERE `user_id` = :user_id ORDER BY `date` DESC;'
    );
    $selectAllPays->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT); // bindValue() or bindParam()
    $selectAllPays->execute();
    $all_pays = $selectAllPays->fetchAll(PDO::FETCH_ASSOC); // fetch,fetchAll,etc. 引数には返り値の形式を指定する.

    // 最新データの取得
    $selectLatestPays = $dbh->prepare(
        'SELECT SUM(`amount`) as `amount`, `date` FROM `pays`
            WHERE `user_id` = :user_id1 AND `date` = (SELECT MAX(`date`) FROM `pays` WHERE `user_id` = :user_id2)'
    );
    $selectLatestPays->bindValue(':user_id1', $_SESSION['user_id'], PDO::PARAM_INT);
    $selectLatestPays->bindValue(':user_id2', $_SESSION['user_id'], PDO::PARAM_INT);
    $selectLatestPays->execute();
    $latest_pay = $selectLatestPays->fetch(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = $e->getMessage();
}

?>
<?= $error ?>

<section id="top" class="light-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section-title">
          <br />
          <div id="notice-latest">
            最後に課金したのは<b><?= date('n月j日', strtotime($latest_pay['date'])) ?>、<?= number_format($latest_pay['amount']) ?>円</b>です。
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="display-period">
        <span class="small-letter">表示データの期間を変更：</span>
        <form name="data-period" id="period-form">
          <select name="data-period">
            <option value="year" selected>年単位</option>
            <option value="month">月単位</option>
            <option value="week">週単位</option>
          </select>
        </form>

      </div>

      <table class="table" id="kakin-list">
        <thead>
          <tr>
            <th class="col-xs-3"><center><i class="fa fa-calendar fa-2x"></i></center></th>
            <th class="col-xs-2"><center><i class="fa fa-jpy fa-2x"></i></center></th>
            <th class="col-xs-3"><center><i class="fa fa-tag fa-2x"></i></center></th>
            <th class="col-xs-4"><center><i class="fa fa-comment fa-2x"></i></center></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($all_pays as $row) : ?>
          <tr>
            <td class="col-xs-3 text-center"><?= $row['date'] ?></td>
            <td class="col-xs-2 text-center"><b>¥ <?= number_format($row['amount']) ?></b></td>
            <td class="col-xs-3 text-center"><?= $row['detail'] ?></td>
            <td class="col-xs-4"><?= $row['purpose'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php

readfile(dirname('index.php').'/layouts/foot.html');

?>