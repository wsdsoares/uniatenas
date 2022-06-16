<?php
$page = $this->uri->segment(2);
if (in_array("regNormasIns", $permissionCampusArray['campus-1'])) {
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
                        <?php echo 'Cadastro norma institucional'; ?>
                    </h2>
                </div>
                <div class="body">
                    <?php
                    if ($msg = getMsg()):
                        echo $msg;
                    endif;
                    ?>
                    <?php echo form_open_multipart('Painel_mural_digital/cadastrar_norma_institucional') ?>
                    <h2 class="card-inside-title">Informações</h2>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="title">Título *</label>
                                    <?php
                                    echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title'));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="campusid">Campus</label>
                            <?php
                            $optionLocal[0] = '-- Selecione --';

                            foreach ($campus as $local) {
                                $optionLocal[$local->id] = $local->city;
                            }
                            echo form_dropdown('campusid', $optionLocal, set_value('campusid'), array('class' => 'form-control show-tick')); ?>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control'), set_value('files')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="campusid">Status</label>
                            <?php
                            $optionStatus[0] = '-- Selecione --';
                            $optionStatus[1] = 'Inativo';
                            $optionStatus[2] = 'Ativo';

                            echo form_dropdown('status', $optionStatus, set_value('status'), array('class' => 'form-control show-tick')); ?>
                        </div>
                    </div>


                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <?php

                            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                            echo anchor('Painel_mural_digital/normas_institucionais', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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
    <?php
}
    ?>