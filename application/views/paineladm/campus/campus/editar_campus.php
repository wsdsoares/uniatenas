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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open_multipart('Painel_Campus/editar_campus/' . $campus->id) ?>

        <h2 class="card-inside-title">Informações do Campus</h2>
        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo <small>(Faculdade, Centro Universitário)</small></label>
                <?php
                if ($campus->type == 'centrouniversitario') {
                  $tipoCampus  = 'Centro Universitário';
                  $type = 'centrouniversitario';
                }
                if ($campus->type == 'faculdade') {
                  $tipoCampus  = 'Faculdade';
                  $type = 'faculdade';
                }
                $tipoCampus = array(
                  $campus->type => $tipoCampus,
                  'faculdade' => 'Faculdade',
                  'centrouniversitario' => 'Centro Universitário'
                );
                echo form_dropdown('type', $tipoCampus, set_value('type'), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            <label for="title">Nome do Campus</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_comment</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Ex.: Uniatenas'), set_value('city', $campus->name));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <label for="title">Cidade</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'city', 'class' => 'form-control', 'placeholder' => 'Cidade'), set_value('city', $campus->city));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <label for="title">ESTADO (UF)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                $ufs = array(
                  'default' => $campus->uf,
                  'AC' => 'AC',
                  'AL' => 'AL',
                  'AP' => 'AP',
                  'AM' => 'AM',
                  'BA' => 'BA',
                  'CE' => 'CE',
                  'DF' => 'DF',
                  'ES' => 'ES',
                  'GO' => 'GO',
                  'MA' => 'MA',
                  'MS' => 'MS',
                  'MT' => 'MT',
                  'MG' => 'MG',
                  'PA' => 'PA',
                  'PB' => 'PB',
                  'PR' => 'PR',
                  'PE' => 'PE',
                  'PI' => 'PI',
                  'RJ' => 'RJ',
                  'RN' => 'RN',
                  'RS' => 'RS',
                  'RO' => 'RO',
                  'RR' => 'RR',
                  'SC' => 'SC',
                  'SP' => 'SP',
                  'SE' => 'SE',
                  'TO' => 'TO'
                );
                echo form_dropdown('uf', $ufs, set_value('uf', $campus->uf), array('class' => 'form-control show-tick'));
                // echo form_input(array('name' => 'city', 'class' => 'form-control', 'placeholder' => 'Nome da Cidade'), set_value('city'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-2">
            <label for="title">Telefone (Principal)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'phone', 'class' => 'form-control', 'placeholder' => 'Telefone Fixo'), set_value('phone', $campus->phone));
                ?>
              </div>
            </div>
          </div>
          <!--div class="col-md-2">
            <label for="title">Telefone (Whatsapp)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'whatsapp', 'class' => 'form-control', 'placeholder' => 'Número do Whatsapp'), set_value('whatsapp', $campus->whatsapp));
                ?>
              </div>
            </div>
          </div-->
        </div>

        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-md-3">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mail</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email', $campus->email));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label for="title">Facebook</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">facebook</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'facebook', 'class' => 'form-control', 'placeholder' => 'Perfil do Facebook.'), set_value('facebook', $campus->facebook));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label for="title">Instagram</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">@</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'instagram', 'class' => 'form-control', 'placeholder' => 'Perfil Instagram'), set_value('instagram', $campus->instagram));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label for="title">Youtube</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">movie</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'youtube', 'class' => 'form-control', 'placeholder' => 'Perfil Youtube'), set_value('youtube', $campus->youtube));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-md-12">
            <label for="title">Endereço</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                echo form_textarea(array('name' => 'street', 'class' => 'form-control', 'placeholder' => 'Endereço do campus'), toHtml(set_value('street', $campus->street)));
                ?>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            // replace: substitui o formato padrão do textarea (descricao)
            // e aplica as configurações do CKEDitor através do arquivo config.js
            var editor = CKEDITOR.replace('street', {
              customConfig: 'config.js'
            });
          </script>
          <div class="col-md-12">
            <label for="title">Link da Localização do GOOGLE MAPS (MAPS Frame)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'mapsFrame', 'class' => 'form-control', 'placeholder' => 'Link do MAPS Frame'), set_value('mapsFrame', $campus->mapsFrame));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Descrição do Campus
                  <small> (Explicação e inforamções pertinentes ao campus)</small>
                </label>
                <?php
                echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'placeholder' => 'Explicação e inforamções pertinentes ao campus.'), toHtml(set_value('description', $campus->description)));
                ?>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          // replace: substitui o formato padrão do textarea (descricao)
          // e aplica as configurações do CKEDitor através do arquivo config.js
          var editor = CKEDITOR.replace('description', {
            customConfig: 'config.js'
          });
        </script>
        <div class="separacao-forms"></div>

        <h2 class="card-inside-title">Imagens do Campus - Destaques e logotipos</h2>
        <div class="row clearfix">
          <div class="col-md-8">
            <label for="title">
              Cor de fundo - Exibida na lista dos campus
              <small> (A cor tem que ser em RGB) <br />Exemplo: cor vermelha rgb(255,0,0), caso não saiba clique no <a href="https://erikasarti.com/html/tabela-cores/" target="_blank">CLIQUE AQUI</a><br />
                ou digite no Google: <i>"Tabela de cores RGB"</i>
              </small>
            </label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">format_color_fill</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'cor_fundo_lista_campusRGBA', 'class' => 'form-control', 'placeholder' => 'Ex.: 201,201,204'), set_value('cor_fundo_lista_campusRGBA', $campus->cor_fundo_lista_campusRGBA));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Logotipo
                  <small> (logo colorida)</small>
                </label>
                <?php echo form_input(array('name' => 'logo', 'type' => 'file', 'class' => 'form-control'), set_value('logo')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if ($campus->logo != '' and !empty($campus->logo)) {
                echo anchor(base_url(verifyImg($campus->logo)), '<img src="' . base_url(verifyImg($campus->logo)) . '" class="thumbnail">', array('target' => '_blank'));
              } else {
                echo '<span> Sem imagem cadastrada. <span>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row clearfix" style="background:#D0D0D0">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Logotipo
                  <small> (logo branca)</small>
                </label>
                <?php echo form_input(array('name' => 'logoBranca', 'type' => 'file', 'class' => 'form-control'), set_value('logoBranca')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if ($campus->logo != '' and !empty($campus->logoBranca)) {
                echo anchor(base_url(verifyImg($campus->logoBranca)), '<img src="' . base_url(verifyImg($campus->logoBranca)) . '" class="thumbnail">', array('target' => '_blank'));
              } else {
                echo '<span> Sem imagem cadastrada. <span>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Icone Campus
                  <small> (Imagem exibida na lista dos campus)</small>
                </label>
                <?php echo form_input(array('name' => 'iconeCampus', 'type' => 'file', 'class' => 'form-control'), set_value('iconeCampus')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if ($campus->logo != '' and !empty($campus->iconeCampus)) {
                echo anchor(base_url(verifyImg($campus->iconeCampus)), '<img src="' . base_url(verifyImg($campus->iconeCampus)) . '" class="thumbnail">', array('target' => '_blank'));
              } else {
                echo '<span> Sem imagem cadastrada. <span>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Imagem de plano de fundo
                  <small> (Imagem exibida na segunda tela - Acesso rápido ao campus)</small>
                </label>
                <?php echo form_input(array('name' => 'backgroundPrincipal', 'type' => 'file', 'class' => 'form-control'), set_value('backgroundPrincipal')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if ($campus->logo != '' and !empty($campus->backgroundPrincipal)) {
                echo anchor(base_url(verifyImg($campus->backgroundPrincipal)), '<img src="' . base_url(verifyImg($campus->backgroundPrincipal)) . '" class="thumbnail">', array('target' => '_blank'));
              } else {
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
                echo form_dropdown('status', $optionSituation, set_value('status', $campus->status), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Exibir na página principal dos CAMPUS
                  <small>(www.atenas.edu.br/uniatenas)</small></label>
                <?php
                $optionSituation = array(
                  'SIM' => 'Visível - SIM',
                  'NÃO' => 'Invisível - NÂO'
                );
                echo form_dropdown('visible', $optionSituation, set_value('visible', $campus->visible), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor('Painel_Campus/lista_campus', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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
          url: "<?php echo base_url(); ?>Painel_home/getBannerPositionbyCampus",
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