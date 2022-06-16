<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo 'Edição de Campus'; ?>
        </h2>
      </div>
      <div class="body">
        <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
        <?php echo form_open_multipart('Painel_Campus/cadastrar_campus/'. $campus->id) ?>

        <h2 class="card-inside-title">Informações do Campus</h2>
        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo <small>(Faculdade, Centro Universitário)</small></label>
                <?php
                  $tipoCampus = array(
                      'faculdade' => 'Faculdade',
                      'centroUniversitario' => 'Centro Universitário'
                  );
                  echo form_dropdown('name', $tipoCampus, set_value('name'), array('class' => 'form-control show-tick'));
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
                  echo form_input(array('name' => 'city', 'class' => 'form-control', 'placeholder' => 'Cidade'), set_value('city'));
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
                  'selecione'=>'selecione',
                  'AC'=>'Acre',
                  'AL'=> 'Alagoas',
                  'AP'=>'Amapá',
                  'AM'=>'Amazonas',
                  'BA'=>'Bahia',
                  'CE'=>'Ceará',
                  'DF'=>'Distrito Federal',
                  'ES'=>'Espirito Santo',
                  'GO'=>'Goiás',
                  'MA'=>'Maranhão',
                  'MS'=>'Mato Grosso do Sul',
                  'MT'=>'Mato Grosso',
                  'MG'=>'Minas Gerais',
                  'PA'=>'Pará',
                  'PB'=>'Paraíba',
                  'PR'=>'Paraná',
                  'PE'=>'Pernambuco',
                  'PI'=>'Piauí',
                  'RJ'=>'Rio de Janeiro',
                  'RN'=>'Rio Grande do Norte',
                  'RS'=>'Rio Grande do Sul',
                  'RO'=>'Rondônia',
                  'RR'=>'Roraima',
                  'SC'=>'Santa Catarina',
                  'SP'=>'São Paulo',
                  'SE'=>'Sergipe',
                  'TO'=>'Tocantins');
              echo form_dropdown('uf', $ufs, set_value('uf'), array('class' => 'form-control show-tick'));
                  // echo form_input(array('name' => 'city', 'class' => 'form-control', 'placeholder' => 'Nome da Cidade'), set_value('city'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <label for="title">Telefone (Principal)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'phone', 'class' => 'form-control', 'placeholder' => 'Telefone Fixo'), set_value('phone'));
                ?>
              </div>
            </div>
          </div>
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
                  echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email'));
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
                  echo form_input(array('name' => 'facebook', 'class' => 'form-control', 'placeholder' => 'Perfil do Facebook.'), set_value('facebook'));
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
                  echo form_input(array('name' => 'instagram', 'class' => 'form-control', 'placeholder' => 'Perfil Instagram'), set_value('instagram'));
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
                  echo form_input(array('name' => 'youtube', 'class' => 'form-control', 'placeholder' => 'Perfil Youtube'), set_value('youtube'));
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
                  echo form_input(array('name' => 'street', 'class' => 'form-control', 'placeholder' => 'Endereço do campus'), set_value('street'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <label for="title">Link da Localização do GOOGLE MAPS (MAPS Frame)</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'mapsFrame', 'class' => 'form-control', 'placeholder' => 'Link do MAPS Frame'), set_value('mapsFrame'));
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
                  echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'placeholder' => 'Explicação e inforamções pertinentes ao campus.'), set_value('briefText'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="separacao-forms"></div>

        <h2 class="card-inside-title">Imagens do Campus - Destaques e logotipos</h2>
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Logotipo
                  <small> (logo colorida)</small>
                </label>
                <?php echo form_input(array('name' => 'logo', 'type' => 'file', 'class' => 'form-control'), set_value('logo')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Logotipo
                  <small> (logo branca)</small>
                </label>
                <?php echo form_input(array('name' => 'logoBranca', 'type' => 'file', 'class' => 'form-control'), set_value('logoBranca')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
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
            <div class="form-group">
              <div class="form-line">
                <label for="title">Imagem de plano de fundo
                  <small> (Imagem exibida na segunda tela - Acesso rápido ao campus)</small>
                </label>
                <?php echo form_input(array('name' => 'backgroundPrincipal', 'type' => 'file', 'class' => 'form-control'), set_value('backgroundPrincipal')); ?>
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