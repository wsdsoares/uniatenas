<style>
.ico-wrap {
  margin: auto;
}

text.Orange-label {
  color: Orange;
}
</style>
<div class="container">
  <div class="dados_gerais">
    <div class="container">
      <div class="section-header">
        <h3 class="text-center">Trabalho de Conclusão de Curso (TCC)</h3>
      </div>

    </div>
  </div>
  <div class="container">
    <div class="col-md-8">
      <div class="row">
        <div role="tabpanel">
          <div class="col-sm-3">
            <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">

              <li role="presentation" class="brand-nav active">
                <a href="#tab0" aria-controls="tab0" role="tab" data-toggle="tab"><?=$conteudoPag[3]->title; ?></a>
              </li>
              <li role="presentation" class="brand-nav">
                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">TCC</a>
              </li>

            </ul>
          </div>
          <div class="col-sm-9">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="tab0">
                <div class="row">
                  <h4 class="text-center">
                    <?= $conteudoPag[3]->title_short; ?>
                  </h4>
                  <div class="col-md-12">
                    <?=$conteudoPag[3]->description; ?>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="tab1">
                <div class="row">

                  <div class="col-md-12">

                    <div class="col-sm-5 col-xs-6">
                      <h4 class="text-center titleSPIC">Portaria Normativa e Manual para
                        elaboração de TCC no UniAtenas</h4>
                      <div class="card text-center boxSite">
                        <a href="<?php echo base_url('assets/files/spic/MANUAL-DE-ELABORACAO-DE-TCC-I-E-TCC-II-2018.pdf') ?>"
                          class="iconSPIC" target="_blank">

                          <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                          <p>Visualizar</p>
                        </a>
                      </div>
                    </div>


                  </div>


                </div>


                <div class="row">
                  <h4 class="text-center titleSPIC">Acesso às monografias desenvolvidas no
                    UniAtenas</h4>
                  <?php
                    foreach ($dados['tcss_cursos'] as $item) {
                        ?>
                  <div class="col-md-4 text-center">

                    <div class="text-center">

                      <div class="card">
                        <div class="card-top">
                          <h4 class="font-weight-normal"><?php echo $item->name; ?>
                            <br />
                          </h4>
                        </div>
                        <div class="card-body">
                          <h1 class="card-title">
                            <img src="<?php echo  base_url($item->icone)  ;?>" class="img-responsive">
                          </h1>
                          <ul class="list-unstyled">

                          </ul>
                          <?php
                                echo anchor('iniciacaoCientifica/listaSemestresTCC/'.$campus->shurtName.'/'. $item->id, 'Acessar', array('class' => "btn btn-lg btn-block btn-primary"));
                                ?>

                        </div>
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
      </div>
    </div>
    <div class="row">
      <?php if (!empty($phones)): ?>

      <div class="col-lg-4 col-xs-6">

        <div class="widget-sidebar">
          <h2 class="title-widget-sidebar">Contatos</h2>
          <div class="content-widget-sidebar">
            <ul>
              <li class="recent-post-alunos">
                <div class="col-sm-2 col-xs-2">
                  <i class="far fa-address-card fa-2x"></i>
                  </a>
                </div>

                <div class="col-sm-10 col-xs-10 ">
                  <?php foreach ($phones as $phone): ?>
                  <small>
                    <div class=" ">
                      <?php if ($phone->email != "" || $phone->email != null): ?>
                      <p>
                        <label>E-mail:</label>
                      <p>
                        <text class="Orange-label"><?= $phone->email ?></text>
                      </p>
                      </p>
                      <?php endif; ?>
                      <?php if ($phone->phonesetor != "" || $phone->phonesetor != null): ?>
                      <p class="Orange-label">
                        <label>Telefone: </label>
                        <text class="Orange-label"><?= $phone->phonesetor ?></text>
                      </p>
                      <?php endif; ?>
                      <p>
                        <label>Telefone: </label>
                        <text class="Orange-label"><?= $campus->phone; ?></text>
                      </p>
                      <?php if ($phone->ramal != "" || $phone->ramal != null): ?>
                      <p>
                        <label>Ramal: </label>
                        <text class="Orange-label"><?= $phone->ramal; ?></text>
                      </p>
                      <?php endif; ?>
                      <?php if ($phone->phone != "" || $phone->phone != null): ?>
                      <p>
                        <label>Cel. Corporativo:</label>
                        <text class="Orange-label"><?= $phone->phone; ?></text>
                      </p>
                      <?php endif; ?>
                    </div>
                  </small>
                  <?php
                                        endforeach;
                                        ?>
                </div>

              </li>
            </ul>
          </div>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-lg-4 col-xs-6">
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
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="widget-sidebar  col-xs-12">
      <h2 class="title-widget-sidebar">#Links Úteis</h2>
      <div class="last-post-aluno">
        <a target="_blank" href="http://www.periodicos.capes.gov.br/" class="accordionAluno">Periódicos Capes</a>
      </div>
      <hr>

      <div class="last-post-aluno">
        <a target="_blank" href="https://scholar.google.com/" class="accordionAluno">Google Acadêmico</a>
      </div>
      <hr>
      <div class="last-post-aluno">
        <a target="_blank" href="https://scielo.org/" class="accordionAluno">Scielo</a>
      </div>
      <hr>
      <div class="last-post-aluno">
        <a target="_blank" href="https://www.redalyc.org/" class="accordionAluno">Redalyc</a>
      </div>
    </div>
  </div>

</div>
</div>
<?php
/*if (!empty($filesPage)) {
    ?>
<style>

</style>
<section>
  <div class="container">

    <div class="filesPage">
      <h3 class="text-center">Documentos</h3>
      <?php
                foreach ($filesPage as $file) {
                    ?>
      <div class="col-sm-4">
        <div class="fileItem">
          <a href="<?php echo $file->files; ?>" target="_blank">
            <img border="0" src="<?php echo base_url('assets/images/icons/downfile.png'); ?>" />
            <span><?php echo $file->name; ?></span>
          </a>
        </div>
      </div>
      <?php
                }
                ?>
    </div>

  </div>
</section>
<?php
}*/
?>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>