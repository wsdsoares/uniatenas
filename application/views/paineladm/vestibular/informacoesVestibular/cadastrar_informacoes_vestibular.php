<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'EDIÇÃO DE INFORMAÇÕES DO VESTIBULAR' ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif
                ?>
                <?php echo form_open("Painel_vestibular/editarInformacoesVestibular/" . $listagem->id) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Titulo *</label>
                                <?php
                                echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Titulo'), set_value('name', $listagem->nameVestibular));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="campusid">Local Campus</label>
                        <?php
                        $j = 1;
                        foreach ($locaisCampus as $local) {
                            $optionLocal[$j] = $local->name . ' - ' . $local->city;
                            $j = $j + 1;
                        }
                        echo form_dropdown('campusid', $optionLocal, set_value('campusid', $listagem->idCampus), array('class' => 'form-control show-tick'));
                        ?>
                    </div>
                    <div class="col-sm-3 alert-info">
                        <label for="campusid">Situação Vestibular</label>
                        <?php
                        foreach ($situation as $type) {
                            $optiontypes[$type->id] = $type->name;
                        }

                        echo form_dropdown('vestibular_situationid', $optiontypes, set_value('vestibular_situationid', $listagem->idSituation), array('class' => 'form-control show-tick')); ?>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Edital</label>
                                <?php echo anchor(base_url($listagem->files), '<i class="material-icons">insert_drive_file</i>', array('target' => "_blank")); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-9">
                        <label for="campusid">Link de Inscrição</label>
                        <br/>
                        <p class="linkAtual">
                            LINK ATUAL:  <span><?php echo toHtml($listagem->link); ?></span>
                        </p>
                        <?php
                        echo form_input(array('name' => 'link', 'class' => 'form-control', 'placeholder' => 'link para inscrição'), set_value('link'));
                        ?>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php

                        echo anchor('Painel_vestibular/informacoesVestibular', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('vestibularid',$listagem->id);
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
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