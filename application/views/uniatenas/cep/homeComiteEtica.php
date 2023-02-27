<style>
.ico-wrap {
  margin: auto;
}

.mbr-iconfont {
  font-size: 4.5rem !important;
  color: #313131;
  margin: 1rem;
  padding-right: 1rem;
}

.titleSPIC {
  min-height: 80px;
}

a.iconSPIC i {
  margin-top: 20px;
}

text.Orange-label {
  color: Orange;
}
</style>
<div class="container">
  <div class="dados_gerais">
    <div class="container">
      <div class="section-header">
        <h3 class="text-center">Comitê de Ética em Pesquisa</h3>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="col-md-8">
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
          <?php
          if(!empty($dados['conteudo'])){
            ?>
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
                  <?php
                  if (!empty($dados['conteudo'][$i]->title_short)) {
                  ?>
                  <h4 class="text-center">
                    <?php echo $dados['conteudo'][$i]->title_short;?>
                  </h4>
                  <?php
                    } 
                  ?>
                  <div class="col-md-12">
                    <?php
                      echo $dados['conteudo'][$i]->description;
                      ?>
                  </div>

                </div>
              </div>
              <?php
             
              }
              ?>
            </div>
          </div>
          <?php
            
          }
          ?>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-xs-6">
      <?php
      
      if (!empty($dados['conteudoContato']->description)) {
          ?>
      <div class="widget-sidebar">
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
      <br>
      <br><br />
      <?php
      }
      ?>
      <?php
      if (!empty($dados['conteudoAtendimento']->description)) {
          ?>
      <div class="widget-sidebar">
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
      <?php 
    if($dados['conteudoLinksUteis'] !=''){
    ?>
      <div class="widget-sidebar col-xs-12">

        <h2 class="title-widget-sidebar">#Links Úteis</h2>
        <?php 
        foreach ($dados['conteudoLinksUteis'] as $linksUteis){
        ?>
        <div class="last-post-aluno">
          <a target="_blank" href="<?php echo $linksUteis->link_redir;?>"
            class="accordionAluno"><?php echo $linksUteis->title;?></a>
        </div>
        <hr>
        <?php 
        }
      ?>
      </div>
    </div>
    <?php 
    }
    ?>
  </div>
</div>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>