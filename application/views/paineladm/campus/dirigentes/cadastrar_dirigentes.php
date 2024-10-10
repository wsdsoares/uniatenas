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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open_multipart("Painel_Campus/cadastrar_dirigente/$campus->id") ?>

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
                echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nome completo'), set_value('nome'));
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
                echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => 'Email'), set_value('email'));
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
                echo form_input(array('name' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Ex.: Pró-Reitor Administrativo'), set_value('cargo'));
                ?>
              </div>
            </div>
          </div>

          <!-- <div class="col-md-6">
            <label for="title">Cargo <small> (Mesmo cargo, para os campus que são centros
                universitários)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">assignment_ind</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'cargo2', 'class' => 'form-control', 'placeholder' => ' Ex.: Diretor Administrativo'), set_value('cargo2'));
                ?>
              </div>
            </div>
          </div> -->
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
            echo anchor("Painel_Campus/lista_dirigentes/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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