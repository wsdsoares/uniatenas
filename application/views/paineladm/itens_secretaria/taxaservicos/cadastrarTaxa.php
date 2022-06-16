<?php
$idLocal = $this->uri->segment(3);
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
                    <?php echo 'REGISTRO DE TAXAS E SERVIÇOS'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open('secretaria/cadastrarTaxa/'.$idLocal) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome da taxa'), set_value('name'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">
                                    <Valor>R$ Valor</Valor>
                                </label>
                                <?php
                                echo form_input(array('name' => 'value', 'type' => 'number', 'min' => '0', 'class' => 'form-control', 'placeholder' => 'R$ 00.00'), set_value('value'));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label>
                                    <?php echo form_checkbox('firstfree', '1', set_checkbox('firstfree', '1')); ?>
                                    * A primeira via desse documento é gratis
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-inline">
                            <div class="form-line">
                                <?php
                                echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                                echo anchor('secretaria/taxaservicos/'.$idLocal, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                                echo form_hidden('user', $this->session->userdata('user_codusuario'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>

            </div>
        </div>
    </div>
</div>
