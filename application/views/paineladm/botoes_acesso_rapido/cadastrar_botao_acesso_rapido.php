<script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
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
      <?php 
      ?>
      <div class="body">
        <?php
          if ($msg = getMsg()){
              echo $msg;
          }
          ?>
        <?php echo form_open_multipart("Painel_campus/cadastrar_botoes_acesso_rapido/$campus->id") ?>

        <h2 class="card-inside-title">Botões de Acesso</i>
        </h2>

        <div class="row clearfix">
          <div class="col-md-4">
            <label for="title">Título do botão</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">format_color_text</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título do Botão. Ex.: Site Principal'), set_value('title'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <label for="title">
              Cor do Botão
              <small> (A cor tem que ser em HEXADECIMAL), caso não saiba clique no <a
                  href="https://erikasarti.com/html/tabela-cores/" target="_blank">CLIQUE AQUI</a><br />
                ou digite no Google: <i>"Tabela de cores HEXADECIMAL"</i>
              </small>
            </label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">format_color_fill</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'cor_hexadecimal', 'class' => 'form-control', 'placeholder' => 'Ex.: #9400D3'), set_value('cor_hexadecimal'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido na página inicial)</small>
                  <br /><small>A ordem será sequencial. Ex.:1 (primeiro), 2 (segundo), etc... </small></label>
                <?php 
                echo form_input(array('name' => 'priority', 'type' => 'number', 'class' => 'form-control'), set_value('priority')); 
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="separacao-forms"></div>

        <h2 class="card-inside-title">Função do botão de acesso rápido</h2>
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-7">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Arquivo (PDF)
                  <small> (Arquivo que será acessado a partir do botão que está sendo cadastrado)</small>
                </label>
                <?php echo form_input(array('name' => 'arquivo', 'type' => 'file', 'class' => 'form-control'), set_value('arquivo')); ?>
              </div>
            </div>
          </div>
        </div>
        <br />
        <h3>
          OU <small> (O botão de acesso rápido deverá ter PDF ou Link - NUNCA OS DOIS AO MESMO TEMPO</small>
        </h3>
        <br />
        <div class="row clearfix">
          <div class="col-md-12">
            <label for="title">Link do botão</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">insert_link</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'link_redirecionamento', 'class' => 'form-control', 'placeholder' => 'Ex.: http://www.google.com.br'), set_value('link_redirecionamento'));
                ?>
              </div>
            </div>
          </div>

        </div>
        <br />


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
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_Campus/lista_botoes_acesso_rapido/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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