<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edição de Foto de Notícias
                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('Noticias/editar/' . $id);
                ?>


                <div class="row clearfix">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => "title", 'type' => 'text', 'class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => 'Titúlo da notícia'), set_value('title', $news->title), 'readonly ');
                                ?>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row clearfix">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="form-line ">
                                <label for="title ">Imagem Atual</label>
                                <img src="<?php echo base_url(verifyImg($newsfoto->file)); ?>" class="thumbnail"
                                     id="myImg<?php echo $id; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_upload(array('name' => 'files[]', 'class' => 'input-group'), set_value('files[]'), 'multiple'); ?>
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
                        echo anchor('Painel_noticias/noticias', '
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






