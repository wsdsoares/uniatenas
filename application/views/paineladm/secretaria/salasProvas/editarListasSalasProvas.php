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
                    <?php echo 'EDIÇÃO - Lista de salas de provas - ' . $course->name; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;

                ?>
                <?php echo form_open_multipart('mural/editarListasSalasProvas/' . $calendar->id) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-2">
                        <label for="campusid">Ciclo <small>(1º ou 2º ou 3º)</small></label>
                        <?php
                        $cycle = array(
                            '1' => '1º',
                            '2' => '2º',
                            '3' => '3º'
                        );
                        echo form_dropdown('cycle', $cycle, set_value('cycle',$calendar->cycle), array('class' => 'form-control show-tick')); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Arquivo Atual</label>
                                <?php
                                echo form_input(array('name' => 'fileatual', 'class' => 'form-control', 'placeholder' => 'Texto breve', 'readonly' => 'readonly'), set_value('fileatual', $calendar->file));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <span> Arquivo <small> (PDF)</small></span>

                        <div class="form-group">
                            <div class="form-line">
                                <?php echo form_input(array('name' => 'file', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano', 'accept' => 'application/pdf'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row clearfix">
                    <div class="col-sm-6">
                        <div class="form-inline">
                            <div class="form-line">
                                <?php
                                echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                                echo anchor('Mural/calendariosProvasCurso/' . $course->idCourseCampus, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                                echo form_hidden('school_semester_id', 3); //todo - SEMESTRE ATIVO - Colocar pro usuário selecionar
                                echo form_hidden('idCourseCampus', $course->idCourseCampus);
                                echo form_hidden('type','salasprovas' );

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
