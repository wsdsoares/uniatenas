<script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<?php
// echo '<pre>';
// // print_r($informacoesCurso);
// echo '</pre>';
?>

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
        <?php echo form_open_multipart("Painel_graduacao/cadastrar_informacoes_curso/$informacoesCurso->campus_coursesid") ?>

        <h2 class="card-inside-title">Informações do Curso <i><u><?php echo $informacoesCurso->nameCourse;?></u></i>
        </h2>

        <div class="row clearfix">
          <div class="col-md-8">
            <label for="title">Link do Vestibular</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'link_vestibular', 'class' => 'form-control', 'placeholder' => 'URL do Vestibular (Link)'), set_value('link_vestibular',$informacoesCurso->link_vestibular));
                ?>
              </div>
            </div>

          </div>
          <div class="col-md-4">
            <label for="title">Acessar Link</label>
            <div class="input-group">

              <?php
              if(isset($informacoesCurso->link_vestibular) and $informacoesCurso->link_vestibular != ''){
                echo anchor($informacoesCurso->link_vestibular,'<button type="button" class="btn btn-info">Ver Link</button>');
              }
            ?>
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
                  echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'placeholder' => 'Explicação e inforamções pertinentes ao campus.'), toHtml(set_value('description',$informacoesCurso->description)));
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
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Áreas de Atuação
                  <small> (Áreas de atuação do curso)</small>
                </label>
                <?php
                  echo form_textarea(array('name' => 'actuation', 'class' => 'form-control', 'placeholder' => 'Explicação e inforamções pertinentes ao campus.'), toHtml(set_value('actuation', $informacoesCurso->actuation)));
                ?>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
        // replace: substitui o formato padrão do textarea (descricao)
        // e aplica as configurações do CKEDitor através do arquivo config.js
        var editor = CKEDITOR.replace('actuation', {
          customConfig: 'config.js'
        });
        </script>

        <div class="separacao-forms"></div>

        <h2 class="card-inside-title">Matriz/Grade Curricular <small>(Exibida no site página do curso)</small></h2>
        <div class="row clearfix" style="background:#E0FFFF">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Matriz/Grade (PDF) do curso
                </label>
                <?php echo form_input(array('name' => 'filesGrid', 'type' => 'file', 'class' => 'form-control'), set_value('filesGrid')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Acessar Arquivo</label>
            <div class="input-group">
              <?php
              if($informacoesCurso->filesGrid!='' and !empty($informacoesCurso->filesGrid)){
                echo '<i class="material-icons">archive</i>"';
                echo anchor($informacoesCurso->filesGrid,'<button type="button" class="btn btn-sucess"><i class="material-icons">archive</i> Ver Arquivo</button>',array('target' => '_blank'));
                }else{
                  echo '<span> Não há arquivo cadastrado. <span>';
                }
              ?>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>
        <div class="separacao-forms"></div>
        <div class="separacao-forms"></div>

        <h2 class="card-inside-title">Arquvivos de Autorização/Reconhecimento</h2>
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Arquivo (PDF) de Autorização do Curso
                  <small> (Arquivo que permite o início do curso)</small>
                </label>
                <?php echo form_input(array('name' => 'autorization', 'type' => 'file', 'class' => 'form-control'), set_value('autorization')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Acessar Arquivo</label>
            <div class="input-group">
              <?php
              if($informacoesCurso->autorization!='' and !empty($informacoesCurso->autorization)){
                echo '<i class="material-icons">archive</i>"';
                echo anchor($informacoesCurso->autorization,'<button type="button" class="btn btn-info"><i class="material-icons">archive</i> Ver Arquivo</button>',array('target' => '_blank'));
                }else{
                  echo '<span> Não há arquivo cadastrado. <span>';
                }
              ?>
            </div>
          </div>
        </div>
        <br />
        <div class="row clearfix" style="background:#DCDCDC">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Arquivo (PDF) de Recnhecimento do curso
                  <small> (Arquivo que indica o reconhecimento do curso)</small>
                </label>
                <?php echo form_input(array('name' => 'recognition', 'type' => 'file', 'class' => 'form-control'), set_value('recognition')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Acessar Arquivo</label>
            <div class="input-group">
              <?php
              if($informacoesCurso->recognition!='' and !empty($informacoesCurso->recognition)){
                echo form_input(array('name' => 'recognitionAtual', 'type'=>'hidden', 'class' => 'form-control', 'readonly' => 'readonly'), set_value('recognitionAtual', $informacoesCurso->recognition));
                echo anchor($informacoesCurso->recognition,'<button type="button" class="btn btn-info"><i class="material-icons">archive</i> Ver Arquivo</button>',array('target' => '_blank'));
                }else{
                  echo '<span> Não há arquivo cadastrado. <span>';
                }
              ?>
            </div>
          </div>
        </div>
        <br />
        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Imagem CAPA Curso
                  <small> (Imagem exibida na tela do curso <br /> - Junto ao lema /Fotos do Curso)</small>
                </label>
                <?php echo form_input(array('name' => 'capa', 'type' => 'file', 'class' => 'form-control'), set_value('capa')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if($informacoesCurso->capa!='' and !empty($informacoesCurso->capa)){
                echo form_input(array('name' => 'capaAtual', 'type'=>'hidden'), set_value('capaAtual', $informacoesCurso->capa));
                echo anchor(base_url(verifyImg($informacoesCurso->capa)), '<img src="' . base_url(verifyImg($informacoesCurso->capa)) . '" class="thumbnail">', array('target' => '_blank'));
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
                    echo form_dropdown('status', $optionSituation, set_value('status',$informacoesCurso->status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor('Painel_graduacao/lista_cursos/7/presencial', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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