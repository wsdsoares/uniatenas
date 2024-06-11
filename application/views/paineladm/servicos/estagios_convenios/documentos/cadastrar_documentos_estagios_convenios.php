<?php
$year = date('Y');
?>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<?php
echo '<pre>';
print_r($dados);
echo '</pre>';
?>
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
        <?php echo form_open_multipart("Painel_estagios_convenios/cadastrar_documentos_estagios_convenios/$campus->id/$conteudoItemEstagiosConvenios->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título Arquivo</label>
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título arquivos'), set_value('title'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido dentro da página)</small>
                  <br /><small>A ordem será sequencial. </small></label>
                <?php
                echo form_input(array('name' => 'order', 'type' => 'number', 'min' => '1', 'class' => 'form-control'), set_value('order'));
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

                echo form_dropdown('status', $optionSituation, set_value('status'), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <!-- File Upload | Drag & Drop OR With Click & Choose -->
        <div class="row clearfix">
          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">

                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_estagios_convenios/lista_documentos_estagios_convenios/$campus->id/$conteudoItemEstagiosConvenios->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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