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
        if ($msg = get_msg()) {
          echo $msg;
        }
        ?>
        <?php
        echo form_open_multipart("Painel_graduacao/cadastrar_arquivo_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$campus->id");
        ?>

        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo do Arquivo <small>(PDF - Autorização ou reconhecimento)</small></label>
                <?php
                $tipoArquivo = array(
                  'autorizacao' => 'Autorização',
                  'reconhecimento' => 'Reconhecimento'
                );
                echo form_dropdown('tipo_arquivo', $tipoArquivo, set_value('tipo_arquivo'), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-2">
            <span> Arquivo PDF</span>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <?php echo form_upload(array('name' => 'files', 'class' => 'input-group'), set_value('files')); ?>
              </div>
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
            echo anchor('cursos/verFotos/', '
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