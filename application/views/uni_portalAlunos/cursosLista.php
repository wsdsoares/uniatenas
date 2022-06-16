<?php
$dadosArray = isset($dados['filesarray']) ? $dados['filesarray'] : '';

if ($campus->id == 1) {
    ?>
    <!-- Start Page Header Section -->
    <section class="bg-page-header bg-page-portal-alunos">
        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <div class="page-title titulosImg">
                            <h3>
                                <?php echo 'Informações / Avisos'; ?>
                            </h3>
                            <h2 style="color: #000;">
                                <?php echo $campus->city; ?>
                            </h2>
                        </div>
                        <div class="page-header-content">
                            <ol class="breadcrumb">
                                <!--li>Campus - <?php echo $campus->city; ?></li-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>
    <section class="bg-page-header bg-page-portal-alunos">
        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="page-header">
                        <div class="page-title titulosImg">
                            <h3>
                                <?php echo 'Informações / Avisos'; ?>
                            </h3>
                            <h2 style="color: #000;">
                                <?php echo $campus->city; ?>
                            </h2>
                        </div>
                        <div class="page-header-content">
                            <ol class="breadcrumb">
                                <!--li>Campus - <?php echo $campus->city; ?></li-->
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
<section class="avisos-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-sm-4 mb-3">
                <div class="card text-white bg-ead o-hidden h-100">
                    <a class="card-body text-white" href="https://faculdadeatenas.blackboard.com/webapps/login/">
                        <div class="card-body-icon">
                            <i class="fa fa-play-circle"></i>
                        </div>
                        <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> EaD UniAtenas</div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-4 mb-3">
                <div class="card text-white bg-interno o-hidden h-100">
                    <a class="card-body text-white" href="http://177.69.195.6:8080/portalatenas/usuarios/login">
                        <div class="card-body-icon">
                            <i class="fa fa-laptop"></i>
                        </div>
                        <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> Portal Interno -
                            CPA, Jornada, Cursos
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-4 mb-3">
                <div class="card text-white bg-totvs o-hidden h-100">
                    <a class="card-body text-white"
                       href="http://177.69.195.6:8000/WEB/APP/EDU/PORTALEDUCACIONAL/login/">
                        <div class="card-body-icon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> Portal TOTVS - Notas
                            e faltas
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="informativos-section" style="background:#DFDFDF;">
    <div class="container">
        <div class="row" style="margin-top: 5px;">
            <center><h3 style="padding-top: 20px;color:#000;">CURSOS</h3></center>
            <?php
            $i = 0;
            foreach ($dadosArray['courses'] as $courses) {
                ?>
                <div class="col-sm-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $courses->nameCourse; ?></h3>
                        </div>
                        <div class="panel-body-portal">
                            <a style="cursor:pointer;" id="btn<?php echo mb_substr($courses->nameCourse, 0, 3); ?>">
                                <div class="img_iniciacao">
                                    <img src="<?php echo base_url($courses->icone); ?>" class="img-responsive"/>
                                </div>
                                <div class="text-center">
                                    <strong><span
                                                style="font-size:12px;color: blue;">Clique aqui para ver...</span></strong>
                                </div>
                            </a>

                        </div>

                        <div class="row">

                        </div>
                        <div class=" text-center">

                            <?php
                            $idEfeito = mb_substr($courses->nameCourse, 0, 3);
                            ?>


                            <div class="row" style="display:none;" id="<?php echo $idEfeito; ?>">
                                <span><strong>Salas - Provas</strong></span>
                                <?php
                                foreach ($dadosArray['listasProvas'] as $files) {
                                    if ($courses->idCourses == $files->coursesid) {

                                        if ($files->tipoalunos == "regular") {
                                            $btn = "btn-primary";
                                        } elseif ($files->tipoalunos == "dependencia") {
                                            $btn = "btn-info";
                                        }

                                        if ($courses->idCourses == 8) {
                                            if ($files->period != NULL) {
                                                ?>
                                                <div class="col-md-12">
                                                    <a href="<?php echo base_url($files->files); ?>"
                                                       class="btn <?php echo $btn; ?> botoes-regulares"><?php echo ucfirst($files->period) . 'º'; ?></a>
                                                </div>

                                                <?php
                                            } else {
                                                $btn = "btn-info";
                                                ?>
                                                <div class="col-md-12">
                                                    <a href="<?php echo base_url($files->files); ?>"
                                                       class="btn <?php echo $btn; ?> botoes-regulares"><?php echo ucfirst($files->tipoalunos); ?></a>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-md-12">
                                                <a href="<?php echo base_url($files->files); ?>"
                                                   class="btn <?php echo $btn; ?> botoes-regulares"><?php echo ucfirst($files->tipoalunos) . ''; ?></a>
                                            </div>
                                            <?php
                                        }

                                        $adm = base_url('assets\files\muralProvas\calendariosProva\Adm-Oficial.pdf');
                                        $adm_o = base_url('assets\files\muralProvas\calendariosProva\Adm-Optativa.pdf');
                                        $adm_e = base_url('assets\files\muralProvas\calendariosProva\Adm-Exame.pdf');
                                        $dir = base_url('assets\files\muralProvas\calendariosProva\Dir.Oficial.pdf');
                                        $dir_o = base_url('assets\files\muralProvas\calendariosProva\Dir-Optativa.pdf');
                                        $dir_e = base_url('assets\files\muralProvas\calendariosProva\Dir-Exame.pdf');

                                        $edu = base_url('assets\files\muralProvas\calendariosProva\Educ-Oficial.pdf');
                                        $edu_o = base_url('assets\files\muralProvas\calendariosProva\Educ-Optativa.pdf');
                                        $edu_e = base_url('assets\files\muralProvas\calendariosProva\Educ-Exame.pdf');

                                        $enf = base_url('assets\files\muralProvas\calendariosProva\Enf-Oficial.pdf');
                                        $enf_o = base_url('assets\files\muralProvas\calendariosProva\Enf-Optativa.pdf');
                                        $enf_e = base_url('assets\files\muralProvas\calendariosProva\Enf-Exame.pdf');

                                        $eng = base_url('assets\files\muralProvas\calendariosProva\Eng-Oficial.pdf');
                                        $eng_o = base_url('assets\files\muralProvas\calendariosProva\Eng-Optativa.pdf');
                                        $eng_e = base_url('assets\files\muralProvas\calendariosProva\Eng.Exame.pdf');

                                        $far = base_url('assets\files\muralProvas\calendariosProva\Far-Oficial.pdf');
                                        $far_o = base_url('assets\files\muralProvas\calendariosProva\Far-Optativa.pdf');
                                        $far_e = base_url('assets\files\muralProvas\calendariosProva\Far-Exame.pdf');

                                        $med = base_url('assets\files\muralProvas\calendariosProva\Med-Oficial.pdf');
                                        $med_o = base_url('assets\files\muralProvas\calendariosProva\Med-Optativa.pdf');
                                        $med_e = base_url('assets\files\muralProvas\calendariosProva\Med-Exame.pdf');

                                        $nut = base_url('assets\files\muralProvas\calendariosProva\Nut-Oficial.pdf');
                                        $nut_o = base_url('assets\files\muralProvas\calendariosProva\Nut-Optativa.pdf');
                                        $nut_e = base_url('assets\files\muralProvas\calendariosProva\Nut-Exame.pdf');

                                        $ped = base_url('assets\files\muralProvas\calendariosProva\Ped-Oficial.pdf');
                                        $ped_o = base_url('assets\files\muralProvas\calendariosProva\Ped.Optativa.pdf');
                                        $ped_e = base_url('assets\files\muralProvas\calendariosProva\Ped-Exame.pdf');

                                        $psi = base_url('assets\files\muralProvas\calendariosProva\Psi-Oficial.pdf');
                                        $psi_o = base_url('assets\files\muralProvas\calendariosProva\Psi-Optativa.pdf');
                                        $psi_e = base_url('assets\files\muralProvas\calendariosProva\Psi-Exame.pdf');

                                        $sis = base_url('assets\files\muralProvas\calendariosProva\sis.pdf');
                                        $sis_o = base_url('assets\files\muralProvas\calendariosProva\Sist-Optativa.pdf');
                                        $sis_e = base_url('assets\files\muralProvas\calendariosProva\Sist-Exame.pdf');

                                        ?>
                                        <?php
                                    }
                                }
                                ?>
                                <br>
                                <div class="col-md-12">
                                    <a href="
                                    <?php
                                    if ($courses->idCourses == 1)
                                        echo $adm;
                                    if ($courses->idCourses == 2)
                                        echo $dir;
                                    if ($courses->idCourses == 3)
                                        echo $edu;
                                    if ($courses->idCourses == 5)
                                        echo $enf;
                                    if ($courses->idCourses == 6)
                                        echo $eng;
                                    if ($courses->idCourses == 7)
                                        echo $far;
                                    if ($courses->idCourses == 8)
                                        echo $med;
                                    if ($courses->idCourses == 9)
                                        echo $nut;
                                    if ($courses->idCourses == 10)
                                        echo $ped;
                                    if ($courses->idCourses == 11)
                                        echo $psi;
                                    if ($courses->idCourses == 12)
                                        echo $sis;
                                    ?>
                                       " class="btn btn-warning"
                                       style="margin-bottom:10px; text-transform: none; min-width: 120px;">Ver lista</a>

                                </div>
                                <div class="col-md-12">
                                    <a href="
                                    <?php
                                    if ($courses->idCourses == 1)
                                        echo $adm_o;
                                    if ($courses->idCourses == 2)
                                        echo $dir_o;
                                    if ($courses->idCourses == 3)
                                        echo $edu_o;
                                    if ($courses->idCourses == 5)
                                        echo $enf_o;
                                    if ($courses->idCourses == 6)
                                        echo $eng_o;
                                    if ($courses->idCourses == 7)
                                        echo $far_o;
                                    if ($courses->idCourses == 8)
                                        echo $med_o;
                                    if ($courses->idCourses == 9)
                                        echo $nut_o;
                                    if ($courses->idCourses == 10)
                                        echo $ped_o;
                                    if ($courses->idCourses == 11)
                                        echo $psi_o;
                                    if ($courses->idCourses == 12)
                                        echo $sis_o;
                                    ?>
                                       " class="btn btn-warning"
                                       style="margin-bottom:10px; text-transform: none; min-width: 120px;">Lista
                                        Optativa</a>

                                </div>

                                <div class="col-md-12">
                                    <a href="
                                    <?php
                                    if ($courses->idCourses == 1)
                                        echo $adm_e;
                                    if ($courses->idCourses == 2)
                                        echo $dir_e;
                                    if ($courses->idCourses == 3)
                                        echo $edu_e;
                                    if ($courses->idCourses == 5)
                                        echo $enf_e;
                                    if ($courses->idCourses == 6)
                                        echo $eng_e;
                                    if ($courses->idCourses == 7)
                                        echo $far_e;
                                    if ($courses->idCourses == 8)
                                        echo $med_e;
                                    if ($courses->idCourses == 9)
                                        echo $nut_e;
                                    if ($courses->idCourses == 10)
                                        echo $ped_e;
                                    if ($courses->idCourses == 11)
                                        echo $psi_e;
                                    if ($courses->idCourses == 12)
                                        echo $sis_e;
                                    ?>
                                       " class="btn btn-warning"
                                       style="margin-bottom:10px; text-transform: none; min-width: 120px;">Lista Exame
                                        Especial</a>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
                if ($i == 6) {
                    ?>
                    <div class="row">

                    </div>
                    <?php
                }
            }
            ?>

        </div>
        <div class="row">
            <div class="text-center">
                <div class="container">


                </div>
            </div>
        </div>

    </div>
</section>

<script>
    <?php
    $i = 0;
    foreach ($filesarray['courses'] as $courses) {


    $idEfeito = mb_substr($courses->nameCourse, 0, 3);
    ?>
    $(document).ready(function () {
        $('#<?php echo 'btn' . mb_substr($courses->nameCourse, 0, 3); ?>').click(function () {
            var cadastroUser = document.getElementById('<?php echo $idEfeito; ?>');
            if (cadastroUser.style.display == "none")
                cadastroUser.style.display = "block";
            else
                cadastroUser.style.display = "none";
        });
    });
    <?php
    }
    ?>
</script>
