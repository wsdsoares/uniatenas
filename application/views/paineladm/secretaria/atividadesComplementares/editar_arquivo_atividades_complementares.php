<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php
          echo $page;
          ?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open_multipart("Painel_secretaria/editar_arquivo_atividades_complementares/$campus->id/$arquivoCartilha->id/$pagina->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título do arquivo</label>
                <?php
                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Digite o nome do arquivo...'), set_value('name', $arquivoCartilha->name));
                ?>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                $optionSituation = array(
                  '1' => 'Visível - Ativo',
                  '0' => 'Oculto - Inativo'
                );

                echo form_dropdown('status', $optionSituation, set_value('status', $arquivoCartilha->status), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <label for="files">Caso, deseje trocar o arquivo atual, selecione outro arquivo.</label>
            <div class="form-group">
              <div class="form-line">
                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control'), set_value('files')); ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">
          <div class="col-md-10">
            <label for="title">PDF ATUAL</label>
            <br />
            <p class="" style="background:#D3D3D3	; padding:1em; border: 1px dotted #696969; border-radius:10px;">
              <?php
              $verificaExistenciaArquivo = explode('.', $arquivoCartilha->files);
              $finalArquivo =  end($verificaExistenciaArquivo);
              if (!file_exists($arquivoCartilha->files)) {
                $arquivo = '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - Arquivo não cadastrado no Banco de Dados</span>';
              } elseif ($finalArquivo !== 'xls') {
                $arquivo = '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - ARQUIVO CORROMPIDO</span>';
              } else {
                $arquivo = anchor($arquivoCartilha->files, 'Visualizar Arquivo ', array("target" => 'blank'));
              }
              ?>
              <i class="material-icons">input</i><?php echo $arquivo ?></span>
            </p>

          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_secretaria/lista_atividades_complementares/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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