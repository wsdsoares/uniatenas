<?php
echo '<pre>';
//print_r($dados);
echo '</pre>';
?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header" >
                <h2>
                    Salas de Provas - Cursos
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="row listasProvas" style="text-align: center;">
    <?php
    foreach ($cursos as $item) {
        ?>
        <div class="col-md-3 col-xs-12">

            <div class="card">
                <div class="row">
                    <h4>
                        <?php
                        echo $item->nameCourse;
                        ?>
                    </h4>
                </div>

                <div class="body">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center;">
                            <img src="<?php echo base_url($item->icone); ?>" class="img-responsive" style="text-align: center;"/>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-6 col-xs-6">
                            <?php
                            echo anchor('secretaria/listaProvas/' . $item->idCourses . '/' . $item->idCampus, '<i class = "material-icons">add</i> <span>Cadastrar</span>', array('class' => 'btn btn-primary waves-effect'));
                            ?>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <?php
                            echo anchor('secretaria/listaProvas/' . $item->idCourses . '/' . $item->idCampus, '<i class = "material-icons">search</i> <span>Visualizar</span>', array('class' => 'btn btn-system btn-viewer'));
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>