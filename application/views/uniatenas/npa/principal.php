<div class="container">
    <div class="dados_gerais">
        <div class="container">
            <div class="section-header">
                <h3 class="text-center"><?php echo $conteudoPag[0]->title_short; ?></h3>
            </div>

        </div>
    </div>
    <div class="container">
        <div role="tabpanel">
            <div class="col-sm-3">
                <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                    <?php
                    for ($i = 0; $i < count($conteudoPag); $i++) {
                        if ($i == 0) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        if($conteudoPag[$i]->active > 0) {
                            ?>
                            <li role="presentation" class="brand-nav <?php echo $active; ?>">
                                <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab"
                                   data-toggle="tab"><?php echo $conteudoPag[$i]->title ?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                    </br>
                </ul>
            </div>
            <div class="col-sm-5">
                <div class="tab-content">
                    <?php
                    for ($i = 0; $i < count($conteudoPag); $i++) {
                        if ($i == 0) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        ?>

                        <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $conteudoPag[$i]->description; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 col-md-4 col-sm-4">
                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar"><?php echo $conteudoPag[4]->title; ?></h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post-alunos">
                                <div class="col-sm-3 col-xs-4">
                                    <div class="ico-wrap">
                                        <i class="fas fa-mobile-alt fa-2x"></i>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-sm-9 col-xs-8 ">
                                    <small>
                                        <div class=" "><?php echo $conteudoPag[4]->description; ?></div>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar"><?php echo $conteudoPag[5]->title; ?></h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post-alunos">
                                <div class="col-sm-3 col-xs-4">
                                    <a target="_blank"
                                       href="https://www.google.com.br/search?client=opera&hs=06a&sxsrf=ACYBGNRKHKySOw3joRpwnxcy8geUv-HM6Q:1569440790185&q=Rua%20Euridamas%20Avelino%20de%20Barros%2C%20n%C2%BA%2060%20%E2%80%93%20Lavrado%2C%20Paracatu%2FMG.&sa=X&ved=2ahUKEwiR2q3G3uzkAhXOEbkGHR6xD60QvS4wAHoECAoQEg&biw=1320&bih=658&dpr=1&npsic=0&rflfq=1&rlha=0&rllag=-17228203,-46888900,656&tbm=lcl&rldimm=17283646869125714587&rldoc=1&tbs=lrf:!2m1!1e2!3sIAE,lf:1,lf_ui:2#rlfi=hd:;si:7210518833530095322;mv:[[-17.2249028,-46.8805074],[-17.2304849,-46.8955299]]">
                                        <div class="ico-wrap">
                                            <i class="fas fa-map-marked-alt fa-2x"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-9 col-xs-8 ">
                                    <small>
                                        <div class=" "><?php echo $conteudoPag[5]->description; ?></div>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><div class="widget-sidebar">
                    <h2 class="title-widget-sidebar"><?php echo $conteudoPag[6]->title; ?></h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post-alunos">
                                <div class="col-sm-3 col-xs-4">
                                    <a target="_blank"
                                       href="https://www.google.com.br/search?client=opera&hs=06a&sxsrf=ACYBGNRKHKySOw3joRpwnxcy8geUv-HM6Q:1569440790185&q=Rua%20Euridamas%20Avelino%20de%20Barros%2C%20n%C2%BA%2060%20%E2%80%93%20Lavrado%2C%20Paracatu%2FMG.&sa=X&ved=2ahUKEwiR2q3G3uzkAhXOEbkGHR6xD60QvS4wAHoECAoQEg&biw=1320&bih=658&dpr=1&npsic=0&rflfq=1&rlha=0&rllag=-17228203,-46888900,656&tbm=lcl&rldimm=17283646869125714587&rldoc=1&tbs=lrf:!2m1!1e2!3sIAE,lf:1,lf_ui:2#rlfi=hd:;si:7210518833530095322;mv:[[-17.2249028,-46.8805074],[-17.2304849,-46.8955299]]">
                                        <div class="ico-wrap">
                                            <i class="fas fa-user-clock fa-2x"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-9 col-xs-8 ">
                                    <small>
                                        <div class=" "><?php echo $conteudoPag[6]->description; ?></div>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!empty($filesPage)) {
    ?>
    <style>

    </style>
    <?php
}
?>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



