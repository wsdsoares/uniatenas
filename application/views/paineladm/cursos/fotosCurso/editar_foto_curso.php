<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>

      </div>
      <div class="body">
        <?php
        if ($msg = get_msg()){
            echo $msg;
        }
        ?>
        <?php
        echo form_open_multipart("Painel_graduacao/editar_foto_curso/$cursoPorCampus->campus_coursesid/$campus->id/$fotoCurso->id");
        ?>
        <div class="row clearfix">
        </div>
        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título da Foto</label>
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title',$fotoCurso->title));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Legenda</label>
                <?php
                echo form_input(array('name' => 'subtitle', 'class' => 'form-control', 'placeholder' => 'Legenda'), set_value('subtitle',$fotoCurso->subtitle));
                ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="campusid">Foto</small></label>
              <div class="form-line">
                <?php echo form_upload(array('name' => 'files', 'class' => 'input-group'), set_value('files')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Acessar Arquivo Atual</label>
            <div class="input-group">
              <?php
              if($fotoCurso->files!='' and !empty($fotoCurso->files)){
                echo anchor(base_url(verifyImg($fotoCurso->files)), '<img src="' . base_url(verifyImg($fotoCurso->files)) . '" class="thumbnail">', array('target' => '_blank'));
                }else{
                  echo '<span> Não há imagem cadastrada. <span>';
                }
              ?>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    echo form_dropdown('status', $optionSituation, set_value('status'), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-12">
            <?php
              echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR');
              ?>
            <?php
            echo anchor("Painel_graduacao/lista_fotos_curso/$cursoPorCampus->campus_coursesid/$campus->id", '
                <i class = "material-icons">
                assignment_return
                </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
            ?>
          </div>
        </div>

        <?php
        echo form_close();
        ?>
      </div>
    </div>
  </div>
</div>