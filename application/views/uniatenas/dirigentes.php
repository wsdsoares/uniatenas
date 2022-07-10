<style>
.image--cover {
  margin-top: 5em;
  width: 150px;
  height: 150px;
  border-radius: 50%;

  object-fit: cover;
  object-position: center right;
}
</style>

<section>
  <div class="container">
    <div class="row">
      <?php
      foreach ($dirigentes as $reitor) {
        if($reitor->photo){
          $marginTop = '1em';
        }else{
          $marginTop = '40%';
        }
      ?>
      <div class="col-lg-3 col-sm-6">
        <div class="card hovercard">
          <?php  
        if($reitor->photo){
          ?>
          <div class="<?php  //$cadheader; ?>">
            <div class="image-wrapper">
              <img src="<?php echo base_url($reitor->photo); ?>" alt="" class="image--cover" />
            </div>
          </div>
          <?php 
        }
          ?>
          <div class="info" style="margin-top: <?php echo $marginTop ?>;">
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