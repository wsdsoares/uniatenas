<div class="container">
  <div class="row">
    <div class="container">
      <div class="section-header">
        <h3 class="text-center"><?php echo $conteudoPag[0]->title_short; ?></h3>
        <div class="col-md-12">
          <?php echo $conteudoPag[0]->description; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="row">
        <div role="tabpanel">
          <div class="col-sm-3">
            <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
              <?php
                            for ($i = 0; $i < count($conteudo); $i++) {
                                if ($i == 0) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                            ?>
              <li role="presentation" class="brand-nav <?php echo $active; ?>">
                <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab"
                  data-toggle="tab"><?php echo $conteudo[$i]->title ?></a>
              </li>
              <?php
                            }
                            ?>
            </ul>
          </div>
          <hr>
          <br>
          <div class="col-sm-9">
            <div class="tab-content">
              <?php
                            for ($i = 0; $i < count($conteudo); $i++) {
                                if ($i == 0) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                            ?>

              <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
                <div class="row">
                  <div class="col-md-12 ">
                    <?php echo $conteudo[$i]->description; ?>
                  </div>

                </div>
              </div>

              <?php
                            }
                            ?>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="row">
        <div class="col-xs-12">
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar"><?php echo $conteudoContatos[0]->title ?></h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-2 col-xs-2">
                    <div class="ico-wrap">
                      <i class="fas fa-mobile-alt fa-2x "></i>
                    </div>
                    </a>
                  </div>

                  <div class="col-sm-10 col-xs-10 ">
                    <small>
                      <div class=" "><?php echo $conteudoContatos[0]->description ?></div>
                    </small>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar"><?php echo $conteudoContatos[1]->title ?></h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-2 col-xs-2">
                    <div class="ico-wrap">
                      <i class="fas fa-map-marked-alt fa-2x"></i>
                    </div>
                    </a>
                  </div>

                  <div class="col-sm-10 col-xs-10 ">
                    <small>
                      <div class=" "><?php echo $conteudoContatos[1]->description ?></div>
                    </small>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar"><?php echo $conteudoContatos[2]->title ?></h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-2 col-xs-2">
                    <div class="ico-wrap">
                      <i class="fas fa-mobile-alt fa-2x "></i>
                    </div>
                    </a>
                  </div>

                  <div class="col-sm-10 col-xs-10 ">
                    <small>
                      <div class=" "><?php echo $conteudoContatos[2]->description ?></div>
                    </small>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>