<?php
$year = date('Y');
?>	
<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'REGISTRO - Links de Revistas e Periódicos' ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('biblioteca/cadastrarLinks/'.$idArea) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                ?>
                            </div>
                        </div>
                    </div>

                
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Link</label>
                                <?php
                                echo form_input(array('name' => 'link', 'class' => 'form-control', 'placeholder' => 'Link da revista'), set_value('link'));
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
                $options = array(
                    'nenhum' => 'NENHUM',
                    'a1' => 'A1',
                    'a2' => 'A2',
                    'a3' => 'A3',
                    'a4' => 'A4',
                    'b1' => 'B1',
                    'b2' => 'B2',
                    'b3' => 'B3',
                    'b4' => 'B4',
                    'b5' => 'B5',
                    'c' => 'C'
                    );
                ?>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Classificação - A, B, C ou Nenhum</label>

                                <?php
                                echo form_dropdown('classification', $options);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor('biblioteca/listaLinksRevistas/'.$idArea, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('usersid', $this->session->userdata('user'));
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
