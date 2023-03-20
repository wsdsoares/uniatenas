<?php 
$informacoesBiblioteca = $dados['informacoesBiblioteca'] !="" ? $dados['informacoesBiblioteca'] : '';

if($informacoesBiblioteca != ''){
  $tituloInformacoesBiblioteca = $dados['informacoesBiblioteca']->title; 
  $statusInformacoesBiblioteca = $dados['informacoesBiblioteca']->status; 
  $descricaoInformacoesBiblioteca = $dados['informacoesBiblioteca']->description; 
}else{
  $tituloInformacoesBiblioteca = '';
  $statusInformacoesBiblioteca = '';
  $descricaoInformacoesBiblioteca = '';
}
?>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $tituloPagina; ?>
        </h2>
      </div>
      <?php 
      ?>
      <div class="body">
        <?php
          if ($msg = getMsg()){
            echo $msg;
          }
          ?>
        <?php echo form_open("Painel_biblioteca/registro_informacoes_bilbioteca/$campus->id/$pagina->id") ?>

        <h2 class="card-inside-title">Descrição e informações sobre a Bibloteca
        </h2>

        <div class="row clearfix">
          <div class="col-sm-4">
            <label for="title">Título Descrição</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control'), set_value('title', $tituloInformacoesBiblioteca));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    echo form_dropdown('status', $optionSituation, set_value('status',$statusInformacoesBiblioteca), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">

          <div class="col-sm-12">
            <label for="title">Informações a respeito das formas, horários, locais da Biblioteca, entre outros</label>
            <?php
              echo form_textarea('description', to_html(set_value('description',$descricaoInformacoesBiblioteca)));
            ?>
          </div>
          <script type="text/javascript">
          // replace: substitui o formato padrão do textarea (descricao)
          // e aplica as configurações do CKEDitor através do arquivo config.js
          var editor = CKEDITOR.replace('description', {
            customConfig: 'config.js'
          });
          </script>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_biblioteca/lista_informacoes_biblioteca/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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