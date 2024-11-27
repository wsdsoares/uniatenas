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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open("Painel_graduacao/editar_vinculo_curso_campus/$campus->id/$campus_has_courses->id") ?>

        <h2 class="card-inside-title">Informações do Curso
        </h2>

        <div class="row clearfix">
          <div class="col-md-4">
            <label for="title">Vínculo do campus</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'link_vestibular', 'class' => 'form-control', 'readonly' => "readonly"), set_value('link_vestibular', $campus->name . ' - ' . $campus->city));
                ?>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Curso vinculado</label>
                <?php
                $opcoesCursos = array();

                foreach ($courses as $course) {
                  $opcoesCursos[$course->id] = $course->name;
                }
                echo form_dropdown('courses_id', $opcoesCursos, set_value('courses_id', $campus_has_courses->courses_id), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
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
                echo form_dropdown('status', $optionSituation, set_value('status', $campus_has_courses->status), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_graduacao/lista_cursos/$campus->id/presencial", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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