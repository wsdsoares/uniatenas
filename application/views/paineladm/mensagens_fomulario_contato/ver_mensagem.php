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
      <div class="body">
        <?php
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <h2 class="card-inside-title">Dados da Mensagem </h2>
        <div class="row clearfix">
          <div class="col-md-4">
            <label for="title">Nome</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">assignment_ind</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('class' => 'form-control'), set_value('title', $mensagemContato->name));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <label for="title">E-mail</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">email</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('class' => 'form-control'), set_value('title', $mensagemContato->email));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <label for="title">Telefone</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">contact_phone</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('class' => 'form-control'), set_value('title', $mensagemContato->phone));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-4">
            <label for="title">Data e hora mensagem</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('class' => 'form-control'), set_value('title', date('d-m-Y H:i:s', strToTime($mensagemContato->datacreated))));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <label for="title">Site/Campus origem mensagem</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">https</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('class' => 'form-control'), set_value('title', $mensagemContato->city));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Descrição do local da infraestrutura
                  <small> </small>
                </label>
                <p>
                  <?php
                  echo $mensagemContato->message;
                  ?>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
            echo anchor("Painel_mensagens_contatos/lista_mensagens_contatos/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>