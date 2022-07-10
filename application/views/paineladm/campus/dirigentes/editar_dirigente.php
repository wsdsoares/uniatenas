<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo 'Cadastro de Campus - Página Princial'; ?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>
        <?php echo form_open_multipart("Painel_Campus/editar_dirigente/$dirigente->id") ?>

        <h2 class="card-inside-title">Informações do Dirigentes</h2>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">people</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nome completo'), set_value('nome',$dirigente->nome));
                ?>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mail</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email',$dirigente->email));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Cargo</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">assignment_ind</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Ex.: Pró-Reitor Administrativo'), set_value('cargo',$dirigente->cargo));
                ?>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="title">Cargo <small> (Mesmo cargo, para os campus que são centros
                universitários)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">assignment_ind</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'cargo2', 'class' => 'form-control', 'placeholder' => ' Ex.: Diretor Administrativo'), set_value('cargo2',$dirigente->cargo2));
                ?>
              </div>
            </div>
          </div>
        </div>
        <h2 class="card-inside-title">Foto do dirigente</h2>
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Foto do dirigente
                </label>
                <?php echo form_input(array('name' => 'photo', 'type' => 'file', 'class' => 'form-control'), set_value('photo')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if($dirigente->photo!='' and !empty($dirigente->photo)){
                echo anchor(base_url(verifyImg($dirigente->photo)), '<img src="' . base_url(verifyImg($dirigente->photo)) . '" class="thumbnail">', array('target' => '_blank'));
                }else{
                  echo '<span> Sem imagem cadastrada. <span>';
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
                    echo form_dropdown('status', $optionSituation, set_value('status',$dirigente->status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor('Painel_Campus/lista_dirigentes', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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