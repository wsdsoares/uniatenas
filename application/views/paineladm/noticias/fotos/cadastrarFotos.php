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
        if ($msg = get_msg()){
            echo $msg;
        }   
        ?>
        <?php
            echo form_open_multipart("Painel_noticias/cadastrarFotos/$campus->id/$news->id");
        ?>
        <div class="row clearfix">
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título - Notícia</label>
                <?php echo form_input(array('name' => "title", 'type' => 'text', 'class' => 'form-control', 'readonly'=>'readonly'), set_value('title',$news->title), 'readonly ');?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-2">
            <span> Imagem destaque</span>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <?php echo form_upload(array('name' => 'files[]', 'class' => 'input-group'), set_value('files[]'),'multiple'); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-12">
            <?php
            echo form_hidden('usersid', $this->session->userdata('user'));
            echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR');
            echo form_hidden('usersid', $user = $this->session->userdata('codusuario')); ?>
            <?php
            echo anchor("Painel_noticias/noticias/$campus->id", '
                <i class = "material-icons">
                assignment_return
                </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
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