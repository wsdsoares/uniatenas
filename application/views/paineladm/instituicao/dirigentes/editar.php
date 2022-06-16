<?php 
 //var_dump($_SESSION);
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
                    <?php echo 'EDIÇÃO DE ' . strtoupper($page); ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('painel/editarDirigentes/' . $dirigentes->id) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Nome</label>
                                <?php
                                echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $dirigentes->nome));
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">

                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Cargo</label>
                                <?php
                                echo form_input(array('name' => 'cargo', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $dirigentes->cargo));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
               

               
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('painel/dirigentes/', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('idDiritente', $dirigentes->id);
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
