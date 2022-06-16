<?php
$page = $this->uri->segment(2);
//if (in_array("regTempsArgs", $permissionCampusArray['campus-1'])) {

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
                        <?php echo 'Cadastro do Mapa de Vista de Prova'; ?>
                    </h2>
                </div>
                <div class="body">
                    <?php
                    if ($msg = getMsg()):
                        echo $msg;
                    endif;
                    ?>
                    <?php echo form_open_multipart("mural/mapaDeVista_cadastrar/$id") ?>
                    <h2 class="card-inside-title">Informações</h2>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <label for="Courseid">Curso</label>
                            <?php
                            $optionCourses[0] = '-- Selecione --';
                            foreach ($courses as $type) {
                                $optionCourses[$type->id] = $type->name;
                            }


                            echo form_dropdown('course', $optionCourses, set_value('course'), array('class' => 'form-control show-tick')); ?>
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
                    </div>


                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <?php

                            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                            echo anchor("Mural/mapaDeVista/$id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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
//}
    ?>