<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
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
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>

        <?php echo form_open_multipart('Painel_home/editarSlideshow/'.$campus->id.'/'. $slideshow->id) ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título *</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $slideshow->title));
                  ?>
              </div>
            </div>

          </div>
          <div class="col-md-3">
            <label for="title">Data Início</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <?php
                  echo $dataInicio = isset($slideshow->datestart) ? date('d/m/Y',strtotime($slideshow->datestart)) : '';
                  echo form_input(array('name' => 'datestart', 'type' => 'date', 'class' => 'form-control'), set_value('datestart'));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label for="title">Data Término</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <?php
                  echo $dataTermino = isset($slideshow->dateend) ? date('d/m/Y',strtotime($slideshow->dateend)) : '';
                  echo form_input(array('name' => 'dateend', 'type' => 'date', 'class' => 'form-control'), set_value('datee_end'));
                  ?>
              </div>
            </div>
          </div>
        </div>


        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Arquivo Atual</label>
                <?php
                echo form_input(array('name' => 'fileatual', 'class' => 'form-control', 'placeholder' => 'Texto breve', 'readonly' => 'readonly'), set_value('fileatual', $slideshow->files));
                ?>
              </div>
            </div>
          </div>
          <style>
          .thumbnail {
            padding: 10px;
            border: 1px solid #0c85d0;
          }
          </style>
          <div class="col-sm-3">
            <div class="form-group">
              <?php
                echo anchor(base_url(verifyImg($slideshow->files)), '<img src="' . base_url(verifyImg($slideshow->files)) . '" class="thumbnail">', array('target' => '_blank'));
                ?>
            </div>
          </div>
          <div class="col-sm-offset-6 col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido na página inicial)</small>
                  <br /><small>A ordem será sequencial. Ex.:1 (primeiro), 2 (segundo), etc... </small></label>
                <?php 
                echo form_input(array('name' => 'priority', 'type' => 'number', 'class' => 'form-control'), set_value('priority',$slideshow->priority)); 
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
            <label for="title">Link de Redirecionamento</label>
            <br />
            <p class="linkAtual">
              LINK ATUAL: <span><?php echo toHtml($slideshow->linkredir); ?></span>
            </p>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">input</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'linkRedir', 'class' => 'form-control', 'placeholder' => 'Link Completo da página a ser redirecionada'), set_value('linkRedir'));
                  ?>
              </div>
            </div>
          </div>
        </div>
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
                  echo form_dropdown('status', $optionSituation, set_value('status', $slideshow->status), array('class' => 'form-control show-tick'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
            echo anchor("Painel_home/slideshow/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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
<script type="text/javascript">
$(document).ready(function() {
  $("#idcampus").change(function() {
    var campus_id = $('#idcampus').val();
    if (campus_id != '') {
      $.ajax({
        url: "<?php echo base_url();?>Painel_home/getBannerPositionbyCampus",
        method: "POST",
        data: {
          campus_id: campus_id
        },
        success: function(data) {
          var opts = $.parseJSON(data);
          $('#selectOrder').empty();
          $('#selectOrder').append($('<option>', {
            value: 'nulo',
            text: "Selecione uma ordem"
          }));
          $.each(opts, function(i, position) {
            $('#selectOrder').append($('<option>', {
              value: position.priority,
              text: position.priority
            }));


            $('#selectOrder').selectpicker('refresh');
          })
        }
      })
    }
    if ('select') {
      $('#selectOrder').empty();
      $('#selectOrder').append($('<option>', {
        text: 'Selecione o campus'
      }));
      $('#selectOrder').selectpicker('refresh');
    }
  });

})
</script>