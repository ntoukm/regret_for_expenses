<?php

session_start();

include(dirname('index.php').'/layouts/head.php');
?>

<section id="about" class="light-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section-title">
          <br />
          <? if (isset($_SESSION['is_signined']) && !$_SESSION['is_signined']) : ?>
            <p class="alert alert-warning">利用にはサインインが必要です。</p>
          <? endif; ?>
          <h2>About</h2>
          <p>
            "<strong>1万円は安くないっ！</strong>"は、ソーシャルゲームへの課金の記録をつけることができるアプリケーションです。
          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- about module -->
      <div class="col-md-3 text-center">
        <div class="mz-module">
          <div class="mz-module-about">
            <i class="fa fa-edit color4 ot-circle"></i>
            <h3>課金履歴の登録</h3>
            <p>「課金日」「金額」「ゲームタイトル」「目的（何を引きたかったか）」の4項目で、課金の記録を行うことができます。</p>
          </div>
          <!-- <a href="#" class="mz-module-button">read more</a> -->
        </div>
      </div>
      <!-- end about module -->
      <!-- about module -->
      <div class="col-md-3 text-center">
        <div class="mz-module">
          <div class="mz-module-about">
            <i class="fa fa-list-ol color4 ot-circle"></i>
            <h3>課金額の視覚化</h3>
            <p>登録した履歴をもとに、年/月/週単位での課金履歴を一覧表示し、合計課金額を算出します。</p>
          </div>
          <!-- <a href="#" class="mz-module-button">read more</a> -->
        </div>
      </div>
      <!-- end about module -->
      <!-- about module -->
      <div class="col-md-3 text-center">
        <div class="mz-module">
          <div class="mz-module-about">
            <i class="fa fa-diamond color4 ot-circle"></i>
            <h3>ほしいものリスト</h3>
            <p>サブ機能である「ほしいものリスト」を作成することで、課金をしなかったら買うことができたものを知ることができます。</p>
          </div>
          <!-- <a href="#" class="mz-module-button">read more</a> -->
        </div>
      </div>
      <!-- end about module -->
      <!-- about module -->
      <div class="col-md-3 text-center">
        <div class="mz-module">
          <div class="mz-module-about">
            <i class="fa fa-frown-o color4 ot-circle"></i>
            <h3>アプリケーションを利用することで得られる効果</h3>
            <p>人によっては自身の行いに危機感を覚え、反省を促されます。もしくは課金への後悔を誘発する効果があるでしょう。<br />少なくとも私には。</p>
          </div>
          <!-- <a href="#" class="mz-module-button">read more</a> -->
        </div>
      </div>
      <!-- end about module -->
    </div>
  </div>
  <!-- /.container -->
</section>

<section class="section-cta">
  <div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-7">
        <h4>アプリケーションの利用登録、もしくはサインインはこちらから！　<i class="fa fa-angle-double-right fa-2x"></i></h4>
      </div>
      <div class="col-md-4">
        <a href="#" class="button-cta" data-toggle="modal" data-target="#Modal-1">SIGNIN</a>
      </div>
    </div>
  </div>
</section>

<?php

include(dirname('index.php').'/layouts/foot.php');

?>
