<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Ped de Cursos <?php echo $campus->name . ' - ' . $campus->city; ?>
                </h2>

            </div>
            <div class="body">
                <div class="row">
                    <?php

                    foreach ($cursos as $item) {
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                            <div class="card-deck mb-3">
                                <div class="card">
                                    <div class="card-header card-top">
                                        <h4 class="font-weight-normal">Curso - <?php echo $item->name; ?>
                                            <br/>
                                            <small><?php echo $item->city; ?></small>
                                        </h4>
                                    </div>
                                    <div class="col-xs-12 card-body">
                                        <div class="row">
                                            <div class="">
                                                <div class="col-xs-5">
                                                    <h1 class="card-title">
                                                        <h1 class="card-title">
                                                            <img src="<?php echo base_url() . $item->icone; ?>">
                                                        </h1>
                                                </div>
                                                <div class="col-xs-7">
                                                    <ul class="list-unstyled ">
                                                        <li class="action-courses">
                                                            <?php
                                                            echo anchor('Painel_secretaria/pedLista/' . $item->idCourseCAmpus.'/'.$campus->id, '<span class="btn btn-lg btn-block btn-info">Lista Ped</span>', array('class' => ""));
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
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

