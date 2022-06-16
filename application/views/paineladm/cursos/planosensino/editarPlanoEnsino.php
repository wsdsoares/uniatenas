<?php
$idCourseCampus = $this->uri->segment(5);
?>

<div class="block-header">
    <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo 'Edição - Planos de Ensino ' .$teachingPlan->course.' - '.$teachingPlan->period.'º Período.'; ?>
                </h2>
            </div>
            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <?php echo form_open_multipart('Cursos/editarPlanoEnsino/'.$teachingPlan->id) ?>
                <h2 class="card-inside-title">Informações</h2>
                <div class="row clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Disciplina</label>
                                <?php
                                echo form_input(array('name' => 'discipline', 'class' => 'form-control', 'placeholder' => 'Disciplina'), set_value('discipline',$teachingPlan->discipline));
                                ?>
                            </div>
                        </div>
                    </div>
                   <div class="col-sm-3">

                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Período ( 1º até 12º)</label>
                                <?php
                                echo form_input(array('name' => 'period', 'type' => 'number', 'min' => '1', 'max' => '12', 'class' => 'form-control','style'=>'background:#f1f1f1;'), set_value('period',$teachingPlan->period),'readonly');
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
                                echo form_input(array('name' => 'fileatual', 'class' => 'form-control', 'placeholder' => 'Texto breve', 'readonly' => 'readonly'), set_value('fileatual', $teachingPlan->file));
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
                                <?php echo form_input(array('name' => 'file', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano', 'accept'=>'application/pdf'), set_value('file')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
                        echo anchor('Cursos/planosEnsinoCurso/'.$teachingPlan->campusid.'/'.$teachingPlan->courses_id.'/'.$teachingPlan->idCourseCampus.'/'.$teachingPlan->period, 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
                        echo form_hidden('campus_has_courses_id',$teachingPlan->idCourseCampus );
                        echo form_hidden('coursesid', $teachingPlan->courses_id);

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
