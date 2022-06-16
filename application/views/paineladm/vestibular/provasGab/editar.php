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
                    <?php echo 'EDIÇÃO DE PROVAS E GABARITOS' ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart("Painel_vestibular/editar_provaGab/" . $item) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Titulo *</label>
                                <?php
                                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Titulo'), set_value('title', $provaGab->title));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="campusid">Vestibular</label>
                        <?php
                        $optionLocal[0] = '-- Selecione --';

                        foreach ($vestibular as $local) {
                            $optionLocal[$local->id] = $local->name;
                        }
                        echo form_dropdown('vestibularid', $optionLocal, set_value('vestibularid',$provaGab->vestibularid), array('class' => 'form-control show-tick')); ?>
                    </div>
                    <div class="col-sm-3">
                        <label for="campusid">Tipo</label>
                        <?php
                        $optiontypes[0] = '-- Selecione --';
                        foreach ($tipos as $type) {
                            $optiontypes[$type->id] = $type->title;
                        }

                        echo form_dropdown('type', $optiontypes, set_value('type', $provaGab->typeid), array('class' => 'form-control show-tick')); ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Arquivo Atual</label>
                                <?php echo anchor($provaGab->files, '<i class="material-icons">insert_drive_file</i>', array('title' => "arquivo")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <span> Caso, deseje trocar o arquivo atual, selecione o arquivo.</span>
                        <?php echo form_input(array('name' => 'arquivo', 'type' => 'file', 'class' => 'form-control'), set_value('arquivo')); ?>
                    </div>
                    <!--div class="col-sm-3">
                        <label for="campusid">Status</label>
                        <?php
                        $optionStatus[0] = '-- Selecione --';
                        $optionStatus[1] = 'Inativo';
                        $optionStatus[2] = 'Ativo';
                        $status = $provaGab->status+1;
                        echo form_dropdown('status', $optionStatus, set_value('status',$status), array('class' => 'form-control show-tick')); ?>
                    </div-->
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('Painel_vestibular/provaGab', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('idprovaGab', $provaGab->id);
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