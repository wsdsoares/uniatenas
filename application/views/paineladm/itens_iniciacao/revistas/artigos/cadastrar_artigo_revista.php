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
          if ($msg = getMsg()):
            echo $msg;
          endif;
          ?>
        <?php echo form_open_multipart("painel_publicacoes/cadastrar_artigo_revista/$campus->id/$revista->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-7">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título do Artigo</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título do Artigo'), set_value('title'));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Ano</label>
                <?php
                echo form_input(array('name' => 'year', 'type' => 'number', 'min' => '1990', 'max' => date('Y'), 'class' => 'form-control'), set_value('year'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Curso</label>
                <select name="courses_id" style="margin-top:20px;">
                  <option value="0" selected="selected" class='form-control show-tick'>-- Selecione --</option>
                  <?php
                    $options = array();
                    foreach ($cursos as $teste) {
                        echo '<option value="' . $teste->id . '" ' . set_select('courses_id', $teste->id) . '>' . $teste->name . '</option>';
                    }
                    ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-2">
            <div class="form-line">
              <label for="title">Volume</label>
              <?php
              echo form_input(array('name' => 'volume', 'type' => 'number', 'min' => '1', 'max' => '99', 'class' => 'form-control'), set_value('volume'));
              ?>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-line">
              <label for="title">Nº</label>
              <?php
              echo form_input(array('name' => 'number_vol', 'type' => 'number', 'min' => '1', 'max' => '11', 'class' => 'form-control'), set_value('number_vol'));
              ?>
            </div>
          </div>
        </div>

        <!-- File Upload | Drag & Drop OR With Click & Choose -->
        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">

                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
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
                  echo form_dropdown('status', $optionSituation, set_value('status',$revista->status), array('class' => 'form-control show-tick'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
              echo anchor("Painel_publicacoes/lista_artigos_revistas/$campus->id/$revista->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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