<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'Cadastro dos Financiamentos'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('Painel_Instituicao/cadastrar_dirigentes') ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título *</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="title">Link de Redirecionamento</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">input</i>
                            </span>
                            <div class="form-line">
                                <?php
                                echo form_input(array('name' => 'linkRedir', 'class' => 'form-control', 'placeholder' => 'Link Completo da página a ser redirecionada'), set_value('linkRedir'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
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
                </div>

                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control'), set_value('files')); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php

                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor('Painel_home/financeiro/lista', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('users_id', $this->session->userdata('codusuario'));
                        //echo form_hidden('campus_id', 1);
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
