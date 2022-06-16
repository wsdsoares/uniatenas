

<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'REGISTRO - SLIDES SHOW - PÁGINA PRINCIPAL'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart('Paginas/editarSlideShow/'.$idSlid) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título *</label>
                                <?php
                                echo form_input(array('name' => 'titulo', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('titulo', $slideshow->titulo));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Texto breve (*)</label>
                                <?php
                                echo form_input(array('name' => 'textoBreve', 'class' => 'form-control', 'placeholder' => 'Texto breve'), set_value('textoBreve', $slideshow->textoBreve));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-3">
                        <label for="title">Data Início *</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">date_range</i>
                            </span>
                            <div class="form-line">
                                <?php
                                echo form_input(array('name' => 'dataInicio', 'type' => 'date', 'class' => 'form-control', '30/07/2016"'), set_value('dataInicio', $slideshow->dataInicio));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="title">Data Término *</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">date_range</i>
                            </span>
                            <div class="form-line">
                                <?php
                                echo $data = date('d/m/Y', strtotime($slideshow->dataFim));
                                echo form_input(array('name' => 'dataFim', 'type' => 'date', 'class' => 'form-control'), set_value('dataFim'));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="title">Link de Redirecionamento</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">input</i>
                            </span>
                            <div class="form-line">
                                <?php
                                echo form_input(array('name' => 'linkRedir', 'class' => 'form-control', 'placeholder' => 'Link Completo da página a ser redirecionada'), set_value('linkRedir', $slideshow->linkRedir));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Arquivo Atual</label>
                                <?php
                                echo form_input(array('name' => 'fileatual', 'class' => 'form-control', 'placeholder' => 'Texto breve', 'readonly' => 'readonly'), set_value('fileatual', $slideshow->arquivo));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- File Upload | Drag & Drop OR With Click & Choose -->
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">

                                <?php echo form_input(array('name' => 'arquivo', 'type' => 'file', 'class' => 'form-control'), set_value('arquivo')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('Paginas/slideshow', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('users_id', $this->session->userdata('user'));
                        echo form_hidden('campus_id', 1);
                        echo form_hidden('id',  $idSlid);
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
