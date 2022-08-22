<style>
text.Orange-label {
  color: Orange;
}
</style>
<?php
// echo '<pre>';
// print_r($dados);
// echo '</pre>';
?>
<div class="container">
  <div class="dados_gerais">
    <div class="container">
      <div class="section-header">
        <h3 class="text-center">CPA - Comissão Própria de Avaliação</h3>
      </div>

    </div>
  </div>

  <div class="container">
    <div role="tabpanel">
      <div class="col-sm-2">
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
      <div class="col-sm-7">
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
              <div class="col-md-12">
                <?php echo $conteudo[$i]->description; ?>
              </div>
            </div>
          </div>
          <!--div role="tabpanel" class="tab-pane" id="tab3">
            <div class="row">
              <div class="col-md-12">
                <div class="col-sm-5 col-xs-6">
                  <h4 class="text-center titleSPIC">Resultado avaliação CPA Paracatu MG</h4>
                  <div class="card text-center boxSite" id="teste">
                    <a href="http://www.atenas.edu.br/uniatenas/assets/temps/temp_resultado.pdf" class="iconSPIC"
                      target="_blank">
                      <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                      <p>Visualizar</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div-->
          <?php
          }
          ?>
          <div role="tabpanel" class="tab-pane" id="tab4">
            <div class="row">
              <div class="col-md-12">
                <div class="dados_gerais_resultados_cpa">
                  <div class="container">
                    <h3 class="text-center">RESULTADOS DAS ÚLTIMAS AVALIAÇÕES</h3>
                    <div class="row">

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Administração</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/administracao.pdf"><img
                            src="<?php echo base_url() ?>assets/img/adm.png"></a>
                      </div>

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Direito</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/direito.pdf"><img
                            src="<?php echo base_url() ?>assets/img/dir.png"></a>

                      </div>

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Educação Física</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/educacao_fisica.pdf"><img
                            src="<?php echo base_url() ?>assets/img/edub.png"></a>

                      </div>
                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Enfermagem</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/enfermagem.pdf"><img
                            src="<?php echo base_url() ?>assets/img/enf.png"></a>
                      </div>
                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Engenharia Civil</strong></p>
                        <?php echo anchor('inicio/avaliacoesCursos', '
                <img src="' . base_url('assets/img/eng.png') . '">', array('class' => 'css_btn_class view-pdf')); ?>

                      </div>
                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Farmácia</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/farmacia.pdf"><img
                            src="<?php echo base_url() ?>assets/img/far.png"></a>

                      </div>
                    </div>

                    <div class="row">

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Medicina</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/medicina.pdf">
                          <img src="<?php echo base_url() ?>assets/img/med.png"></a>
                      </div>

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Nutrição</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/nutricao.pdf">
                          <img src="<?php echo base_url() ?>assets/img/nut.png"></a>
                      </div>

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Psicologia</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/psicologia.pdf">
                          <img src="<?php echo base_url() ?>assets/img/psi.png"></a>
                      </div>
                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Pedadogia</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/pedagogia.pdf">
                          <img src="<?php echo base_url() ?>assets/img/ped.png"></a>
                      </div>

                      <div class="col-xs-6 col-sm-2 text-center img_cpa">
                        <p><strong>Sistemas de Informação</strong></p>
                        <a class="css_btn_class view-pdf"
                          href="http://www.atenas.edu.br/site_atenas/assets/files/cpa/sistemas.pdf">
                          <img src="<?php echo base_url() ?>assets/img/sis.png"></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <?php if (!empty($contatos)): ?>
      <div class="col-lg-3 col-xs-6">

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
                  <?php foreach ($contatos as $phone): ?>
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
                        <label>Telefone: </label><br>
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
    </div>
  </div>
</div>
<?php
if (!empty($filesPage)) {
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
}
?>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>