<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<script>
function mostrarOcultarSenha() {
  var senha = document.getElementById("senha");
  var confirmaSenha = document.getElementById("confirmaSenha");

  senha.type = senha.type == "password" ? senha.type = "text" : senha.type = "password";
  confirmaSenha.type = confirmaSenha.type == "password" ? confirmaSenha.type = "text" : confirmaSenha.type = "password";

}
</script>

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
        <?php echo form_open("Painel_usuarios/cadastrar_usuario") ?>

        <h2 class="card-inside-title">Informações do usuário</h2>
        <div class="row clearfix">
          <div class="col-md-12">
            <label for="title">Nome completo do usuário</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">account_circle</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome Completo'), set_value('name'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Usuario (Código usuário <small>(recomenda-se: nome.sobrenome)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">account_circle</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'cod_user', 'class' => 'form-control', 'placeholder' => 'Usuário. Ex.: mateus.silva'), set_value('cod_user'));
                ?>
              </div>
            </div>
          </div>

        </div>
        <div class="row clearfix">
          <div class="col-md-5">
            <label for="title">Email</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mail</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'type'=>'mail'), set_value('email'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix" style="background:#c1c1c1">
          <div class="col-md-5">
            <label for="title">Senha</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">fingerprint</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'password', 'class' => 'form-control', 'placeholder' => 'Mínimo de 6 dígitos', 'type'=>'password','id'=>'senha'), set_value('password'));
                ?>
              </div>
              <input type="checkbox" onClick="mostrarOcultarSenha()">Mostrar senha</input>
            </div>
          </div>

          <div class="col-md-5">
            <label for="title">Confirmação da Senha</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">fingerprint</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'confirm_password', 'class' => 'form-control', 'placeholder' => 'Mínimo de 6 dígitos', 'type'=>'password','id'=>'confirmaSenha'), set_value('confirm_password'));
                ?>
              </div>
            </div>
          </div>

        </div>

        <div class="separacao-forms"></div>

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
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_usuarios/lista_usuarios", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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