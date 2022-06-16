<section>
  <div class="container">
    <div class="row">
      <?php
      foreach ($dirigentes as $reitor) {
      ?>
      <div class="col-lg-3 col-sm-6">
        <div class="card hovercard">


          <div class="info" style="margin-top: 40%;">
            <div class="title">
              <?php
              if ($dados['campus']->id == 1) {
              ?>
              <div class="cargo"><?php echo $reitor->cargo; ?></div>
              <?php
              }else{
              ?>
              <div class="cargo"><?php echo $reitor->cargo2; ?></div>
              <?php
              }
            ?>
            </div>
            <a target="" href=""><?php echo $reitor->nome; ?></a>
            <div class="desc"><?php echo $reitor->email; ?></div>

          </div>

        </div>

      </div>
      <?php
            }
            ?>

    </div>
  </div>
</section>