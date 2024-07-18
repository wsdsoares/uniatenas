<style>
.ico-wrap {
  margin: auto;
}

p {
  text-align: justify !important;
}


.imagem-nucleo {
  display: flex;
  justify-content: center;
  align-items: center;
}

.img-responsive {
  max-height: 450px;
  border-radius: 10px;

}
</style>

<div class="container">
  <div class="parte-1">
    <div class="row">
      <div role="tabpanel">
        <div class="col-sm-3">
          <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
            <?php
            for ($i = 0; $i < count($conteudoPagina); $i++) {
              if ($i == 0) {
                $active = "active";
              } else {
                $active = "";
              }
            ?>
            <li role="presentation" class="brand-nav <?php echo $active; ?>">
              <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab"
                data-toggle="tab"><?php echo $conteudoPagina[$i]->title ?></a>
            </li>
            <?php
            }
            ?>
          </ul>
        </div>
        <?php

        if (!empty($dados['conteudoPagina'])) {
        ?>
        <div class="col-sm-9">
          <div class="tab-content">
            <?php
              for ($i = 0; $i < count($conteudoPagina); $i++) {
                if ($i == 0) {
                  $active = "active";
                } else {
                  $active = "";
                }
              ?>
            <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
              <div class="row">
                <?php
                    if (!empty($dados['conteudoPagina'][$i]->title_short)) {
                    ?>
                <h4 class="text-center">
                  <?php echo $dados['conteudoPagina'][$i]->title_short; ?>
                </h4>
                <?php
                    }

                    ?>
                <div class="col-md-12">
                  <?php
                      echo $dados['conteudoPagina'][$i]->description;
                      ?>
                  <div class="row">
                    <div class="imagem-nucleo">
                      <?php if (!empty($dados['conteudoPagina'][$i]->img_destaque)) { ?>
                      <img src="<?php echo base_url($dados['conteudoPagina'][$i]->img_destaque); ?>"
                        alt="<?php echo $dados['conteudoPagina'][$i]->title_short ?>" class="img-responsive">
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
              }
              ?>
            <?php
          }
            ?>
          </div>
        </div>
        <?php

          ?>
      </div>
    </div>
  </div>

  <div class="parte-2">
    <?php

    if (!empty($dados['conteudoContato']->description)) {
    ?>

    <div class="col-xs-6">
      <h2 class="title-widget-sidebar"><?php echo $dados['conteudoContato']->title; ?></h2>
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
                <div class=" "><?php echo $dados['conteudoContato']->description; ?></div>
              </small>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <?php
    }
    ?>
    <?php
    if (!empty($dados['conteudoAtendimento']->description)) {
    ?>
    <div class="col-xs-6">
      <h2 class="title-widget-sidebar">Atendimento</h2>
      <div class="content-widget-sidebar">
        <ul>
          <li class="recent-post-alunos">
            <div class="col-sm-2 col-xs-4">
              <div class="ico-wrap">
                <i class="fas far fa-address-card fa-2x"></i>
              </div>

            </div>

            <div class="col-sm-8 col-xs-8 ">
              <small>
                <div class=" "><?php echo $dados['conteudoAtendimento']->description; ?></div>
              </small>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <?php
    }
    ?>
  </div>

</div>



<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>