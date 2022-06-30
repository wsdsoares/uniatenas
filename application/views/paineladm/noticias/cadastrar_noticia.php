<script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

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
        <?php echo form_open_multipart("Painel_noticias/cadastrar_noticias/$campus->id");?>


        <div class="row clearfix">
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título</label>
                <?php 
                echo form_input(array('name' => "title", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Titúlo da notícia'), set_value('title'), 'autofocus required');
                ?>
              </div>
            </div>
          </div>


        </div>


        <div class="row clearfix">
          <!-- <div class="col-sm-3">
            <label for="campusid">Campus</label>
            <?php
                        // $optionLocal[0] = '-- Selecione --';

                        // foreach ($campus as $local) {
                        //     $optionLocal[$local->id] = $local->city;
                        // }
                        // echo form_dropdown('campusid', $optionLocal, set_value('campusid'), array('class' => 'form-control show-tick')); ?>
          </div> -->

          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">
                <label for="keywords">Palavras-chave </label><small>Ex. (Educação; Evento; UniAtenas;)</small>
                <?php
                echo form_input(array('name' => "keywords", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Coloque as palavras chave separadas por ponto e vírgula'), set_value('keywords'), 'required');
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <label for="title">Data Início *</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'datestart', 'type' => 'date', 'class' => 'form-control', '30/07/2016"'), set_value('datestart'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-2">
            <span> Imagem destaque</span>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <?php echo form_upload(array('name' => 'files', 'class' => 'input-group'), set_value('files')); ?>
              </div>
            </div>
          </div>

        </div>

        <div class="col-sm-12">
          <?php
            echo form_textarea('description', to_html(set_value('description')));
            ?>
        </div>
        <script type="text/javascript">
        // replace: substitui o formato padrão do textarea (descricao)
        // e aplica as configurações do CKEDitor através do arquivo config.js
        var editor = CKEDITOR.replace('description', {
          customConfig: 'config.js'
        });
        </script>
        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
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
            <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
            <?php
            echo anchor("Painel_noticias/noticias/$campus->id", '
                <i class = "material-icons">
                assignment_return
                </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
            ?>
          </div>
        </div>

        <?php echo form_close();?>
      </div>
    </div>
  </div>
</div>