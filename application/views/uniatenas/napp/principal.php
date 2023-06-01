<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-15">
        <?php
        // só exibe a imagem se o title_short for igual a imagem, favor não alterar o short
    
        foreach ($dados['conteudoPaginaNapp'] as $item) {
          if (isset($item->img_destaque)) {
          ?>
        <img src="<?php echo base_url() . $item->img_destaque; ?>" alt="single-services-img-4"
          class="img-responsive img-rounded" />
        <?php
          } 
        }
        ?>
      </div>
    </div>
  </div>
</section>