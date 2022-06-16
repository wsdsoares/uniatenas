<?php
$campusid = $this->uri->segment(3);
$idCourseCampus = $this->uri->segment(5);
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Planos de Ensino - <?php echo $course->name; ?>
                </h2>
            </div>

            <div class="register">
                <?php
                echo anchor('Cursos/cadastrarPlanoEnsino/' . $campusid . '/' . $course->id . '/' . $idCourseCampus, '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                ?>
                <?php
                echo anchor('Cursos/cursosPlanosEnsino/' . $campusid, '
                    <i class = "material-icons">
                    arrow_back
                    </i> <span>Voltar</span>', array('class' => 'btn btn-danger btn-system m-t-15 btn-viewer'));
                ?>
            </div>

            <div class="body">
                <div class="row">
                    <?php
                    if ($msg = getMsg()):
                        echo $msg;
                    endif;
                    ?>
                    <?php

                    foreach ($periods as $item) {
                        ?>
                        <div class="col-sm-2 text-center">

                            <div class="card-deck mb-3 text-center">

                                <div class="card">
                                    <div class="card-header card-top">
                                        <h4 class="font-weight-normal"><?php echo $item->period; ?>º
                                            <br/>
                                            <small>Período</small>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        echo anchor('Cursos/visualizarPlanosEnsino/'.$campusid.'/'.$course->id.'/'.$idCourseCampus.'/'.$item->period, 'Visualizar Planos', array('class' => "btn btn-lg btn-block btn-primary"));
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                    if(empty($periods)){
                        ?>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <strong>Atenção!</strong> Nenhum plano de ensino cadastrado.
                            </div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>