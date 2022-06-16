<?php
//var_dump($_SESSION);
/*echo '<pre>';
print_r($norms);
echo '</pre>';*/
//if (in_array("regNormasIns", $permissionCampusArray['campus-1'])) {
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
                    <?php echo 'EDIÇÃO DE ARQUIVOS TEMPORARIOS' ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart("Painel_mural_digital/editar_norma_institucional/" . $item) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">nome *</label>
                                <?php
                                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'nome'), set_value('title', $norms->name));
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
                        echo form_dropdown('campusid', $optionLocal, set_value('campusid',$norms->campusid), array('class' => 'form-control show-tick')); ?>
                    </div>
                    <div class="col-sm-3">
                        <label for="campusid">Tipo</label>
                        <?php
                        $optiontypes[0] = '-- Selecione --';
                        foreach ($types as $type) {
                            $optiontypes[$type->id] = $type->name;
                        }

                        echo form_dropdown('type', $optiontypes, set_value('type', $norms->mural_typeid), array('class' => 'form-control show-tick')); ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Arquivo Atual</label>
                                <?php echo anchor($norms->files, '<i class="material-icons">insert_drive_file</i>', array('title' => "arquivo")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <span> Caso, deseje trocar o arquivo atual, selecione o arquivo.</span>
                        <?php echo form_input(array('name' => 'arquivo', 'type' => 'file', 'class' => 'form-control'), set_value('arquivo')); ?>
                    </div>
                    <div class="col-sm-3">
                        <label for="campusid">Status</label>
                        <?php
                        $optionStatus[0] = '-- Selecione --';
                        $optionStatus[1] = 'Inativo';
                        $optionStatus[2] = 'Ativo';
                        $status = $norms->status+1;
                        echo form_dropdown('status', $optionStatus, set_value('status',$status), array('class' => 'form-control show-tick')); ?>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('Painel_mural_digital/normas_institucionais/', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('idTempsArc', $norms->id);
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
    <?php
//}
?>