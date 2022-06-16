
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Cadastro de Infraestrutura / Laboratórios do curso - <?php echo $courses->name.' - '.$campus->name;?>
                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('cursos/cadastrarInfraestrutura/'.$courses->idCourseCampus);
                ?>


                <div class="row clearfix">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título do Laboratório</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Descrição breve</label>
                                <?php
                                echo form_input(array('name' => 'subtitle', 'class' => 'form-control', 'placeholder' => 'Descrição Breve'), set_value('subtitle'));
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <span> Imagem destque laboratório</span>
                            <div class="form-line">
                                <?php echo form_upload(array('name' => 'files', 'class' => 'input-group'), set_value('files')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
                <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
                <div class="col-sm-">

                    <?php
                    echo form_textarea('description', to_html(set_value('description')));
                    ?>
                </div>
                <script type="text/javascript">
                    // replace: substitui o formato padrão do textarea (descricao)
                    // e aplica as configurações do CKEDitor através do arquivo config.js
                    var editor = CKEDITOR.replace('description', {customConfig: 'config.js'});
                </script>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php
                        echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR');
                        echo form_hidden('usersid', $user = $this->session->userdata('codusuario')); ?>
                        <?php
                        echo anchor('cursos/verFotos/'.$courses->idCourseCampus, '
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






