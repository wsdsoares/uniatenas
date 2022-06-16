<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Planos de Ensino - <?php echo $campus->city; ?>
                </h2>

            </div>
            <div class="register">

                <?php
                echo anchor('painel', '
                    <i class = "material-icons">
                    arrow_back
                    </i> <span>Voltar</span>', array('class' => 'btn btn-danger btn-system m-t-15 btn-viewer'));
                ?>


            </div>


            <div class="body">
                <div class="row">
                    <?php
                   
                    foreach ($courses as $item) {
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">

                            <div class="card-deck mb-3 text-center">

                                <div class="card">
                                    <div class="card-header card-top">
                                        <h4 class="font-weight-normal">Curso - <?php echo $item->name; ?>
                                            <br/>
                                            <small><?php echo $item->city; ?></small>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <h1 class="card-title">
                                            <?php
                                            echo anchor('Cursos/planosEnsinoCurso/' . $item->campusid.'/'. $item->courses_id.'/'.$item->id, '<img src="' . base_url() . $item->icone . '">');
                                            ?>
                                        </h1>
                                        <ul class="list-unstyled mt-3 mb-4">
                                            <!--li>20 Anais Cadastrados</li>
                                            <li>10 GB of storage</li>
                                            <li>Priority email support</li>
                                            <li>Help center access</li-->
                                        </ul>
                                        <?php
                                        echo anchor('Cursos/planosEnsinoCurso/' . $item->campusid.'/'. $item->courses_id.'/'.$item->id, 'Gerenciar', array('class' => "btn btn-lg btn-block btn-primary"));
                                        ?>

                                    </div>
                                </div>

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

