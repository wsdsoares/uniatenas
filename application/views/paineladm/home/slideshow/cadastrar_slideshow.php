<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo 'Cadastro de Slide Show - Página Inicial'; ?>
        </h2>
      </div>
      <div class="body">
        <?php
          if ($msg = getMsg()){
              echo $msg;
          }
         ?>
        <?php echo form_open_multipart('Painel_home/cadastrar_slideshow/') ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título *</label>
                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Texto Breve <small> (Máximo 55 caracteres)</small> *</label>
                <?php
                                echo form_input(array('name' => 'briefText', 'class' => 'form-control', 'placeholder' => 'Texto breve'), set_value('briefText'));
                                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Local Campus</label>
                <?php
                                foreach ($locaisCampus as $local) {
                                    $optionLocal[0] = 'Selecione o campus';
                                    $optionLocal[$local->id] = $local->name . ' - ' . $local->city;
                                }
                                echo form_dropdown('campusid', $optionLocal, set_value('campusid'), array('class' => 'form-control show-tick', 'id' => 'idcampus'));

                                ?>
              </div>
            </div>
          </div>
        </div>
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


        <div class="row clearfix">
          <div class="col-md-3">
            <label for="title">Data Início</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <?php
                                echo form_input(array('name' => 'dataInicio', 'type' => 'date', 'class' => 'form-control', '30/07/2016"'), set_value('date_start'));
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
                                echo form_input(array('name' => 'dataFim', 'type' => 'date', 'class' => 'form-control'), set_value('datee_end'));
                                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control'), set_value('files')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-offset-6 col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> - Exibido na página inicial</small></label>
                <?php
                                echo form_dropdown('priority', 'Selecione uma ordem', set_value('priority'), array('class' => 'form-control show-tick', 'id' => 'selectOrder'));
                                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-10">
            <label for="title">Link de Redirecionamento</label>
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
          <div class="col-sm-6">
            <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor('Painel_home/slideshow', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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
          $.each(opts, function(i, position) {
            $('#selectOrder').append($('<option>', {
              value: position.priority,
              text: position.priority
            }));

            if (opts.length == i + 1) {
              $('#selectOrder').append($('<option>', {
                value: (+(position.priority) + +(1)),
                text: (+(position.priority) + +(1))
              }));
            }
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