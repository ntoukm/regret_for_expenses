<?php

$keys = ['date', 'detail', 'amount', 'purpose'];
foreach ($keys as $k) {
  ${$k} = filter_input(INPUT_POST, $k);
}

?>

  <p id="back-top">
    <a href="#top"><i class="fa fa-angle-up"></i></a>
  </p>
  <footer>
    <div class="container text-center">
      <p>Theme made by <a href="http://moozthemes.com"><span>MOOZ</span>Themes.com</a></p>
    </div>
  </footer>

  <!-- Modal for portfolio item 1 -->
  <div class="modal fade" id="Modal-1" tabindex="-1" role="dialog" aria-labelledby="Modal-label-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="Modal-label-1">SIGNIN</h4>
        </div>
        <div class="modal-body">
          <p>下記よりTwitterでログインをしてください。</p>
          <div class="modal-works">
            <a href="./oauth/login.php" class="button twitter-login">
              <i class="fa fa-twitter fa-1x"></i> Twitterでログイン
            </a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal for portfolio item 2 -->
  <div class="modal fade" id="Modal-2" tabindex="-1" role="dialog" aria-labelledby="Modal-label-2">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="Modal-label-2">RECORD</h4>
        </div>
        <div class="modal-body">
          <p>各項目を入力して登録ボタンを押してください。</p>
          <div class="modal-works">
            <form action="record_kakin.php" method="post">
              <div class="form-group inline-block">
                <label for="date"><i class="fa fa-calendar fa-1x"></i> 日付</label>
                <input type="text" name="date" value="<?= h($date) ?>" class="form-control" style="width: 100px;" id="datepicker" />
              </div>
              <div class="form-group inline-block">
                <label for="detail"><i class="fa fa-tag fa-1x"></i> ゲームタイトル</label>
                <input type="text" name="detail" value="<?= h($detail) ?>" class="form-control" style="width: 200px;" />
              </div><br />
              <div class="form-group inline-block">
                <label for="amount"><i class="fa fa-jpy fa-1x"></i> 金額</label>
                <input type="text" name="amount" value="<?= h($amount) ?>" class="form-control" style="width: 150px;" />
              </div>
              <div class="form-group inline-block">
                <label for="purpose"><i class="fa fa-comment fa-1x"></i> 目的</label>
                <input type="text" name="purpose" value="<?= h($purpose) ?>" class="form-control" style="width: 250px;" />
              </div>
              <input type="submit" name="submit" class="button inline-block record-kakin-log" value="登録" />
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/cbpAnimatedHeader.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/SmoothScroll.min.js"></script>
  <script src="js/theme-scripts.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.ja.min.js"></script>
  <script src="js/functions.js"></script>
  <script>
  $(function(){
    $('#datepicker').datepicker({
        format: "yyyy/mm/dd",
        language: 'ja'
    });
  });
  </script>
</body>
</html>
