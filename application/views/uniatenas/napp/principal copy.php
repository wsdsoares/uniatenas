<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-15">
        <?php
                // só exibe a imagem se o title_short for igual a imagem, favor não alterar o short
                foreach ($dados['conteudoPag'] as $item) {
                    if ($item->title_short == "imagem") {
                        ?>
        <img src="<?php echo base_url() . $item->img_destaque; ?>" alt="single-services-img-4"
          class="img-responsive img-rounded" />
        <?php
                    } else {
                    ?>
        <div class="col-md-8">
          <div class="row">

          </div>
        </div>

        <?php
                     }
                }
                ?>
      </div>
    </div>
    <?php

                if($dados['conteudoPag'][0]->title_short != "imagem" ){
        if ($dados['conteudoPag'][0]->active == 1){
        ?>
    <div class="container">
      <div class="section-header text-center">
        <h3><?php echo $dados['conteudoPag'][0]->title; ?></h3>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div class="col-xs-12">
              <div class="information-library-campus text-justify">
                <p>
                  <?php echo $dados['conteudoPag'][0]->description; ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <?php
                    if (!empty($dados['conteudoContatos'])) {
                        if ($dados['conteudoContatos'][0]->active == 1) {
                            ?>
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar"><?php echo $dados['conteudoContatos'][0]->title; ?></h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-2 col-xs-4">
                    <div class="ico-wrap">
                      <i class="fas fa-mobile-alt fa-2x"></i>
                    </div>
                    </a>
                  </div>

                  <div class="col-sm-8 col-xs-8 ">
                    <small>
                      <div class=" "><?php echo $dados['conteudoContatos'][0]->description; ?></div>
                    </small>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <br>
          <br><br />
          <?php
                        }
                    }
                    }
                    }
                    ?>
        </div>
      </div>
    </div>
  </div>
</section>