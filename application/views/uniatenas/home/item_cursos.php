<section class="course-content" data-container="cursos">
    <div class="container">
        <div class="row">
            <div class="our-courses">
                <div class="section-header title-principals">
                    <h2>Nossos Cursos</h2>
                    <span class="double-border"></span>
                    <p>Gradue-se nos melhores cursos do país.</p>
                </div>
                <div id="filters" class="button-group ">
                    <button class="button is-checked" data-filter="*">Todos os cursos</button>
                    <button class="button" data-filter=".cat-1">Exatas</button>
                    <button class="button" data-filter=".cat-2">Saúde</button>
                    <button class="button" data-filter=".cat-3">Humanas / Social</button>
                    <button class="button" data-filter=".cat-4">EaD</button>
                </div>
                <div class="col-xs-12">
                    <div class="course-items">
                        <?php
                        $cat = '';
                        foreach ($cursos as $row) {
                            if ($row->areas_id == 1) {
                                $cat = 'cat-1';
                            } elseif ($row->areas_id == 2) {
                                $cat = 'cat-2';
                            } elseif ($row->areas_id == 3) {
                                $cat = 'cat-3';
                            }
                            ?>
                            <div class="item <?php echo $cat; ?>" data-category="transition">
                                <div class="item-inner">
                                    <?php
                                    echo anchor("graduacao", '
                                    <h4 class="title-ead">' . $row->name . '</h4>
                                    <div class="course-img">
                                        <div class="course-overlay"></div>
                                        <img src="' . base_url() . $row->icone . '" alt="recent-project-img-1">
                                    </div>');
                                    ?>
                                    <div class="our-course-content">
                                        <h4>
                                            <?php
                                            echo anchor("Site/InscricaoEad/$row->types/$row->id", '
                                            INSCREVA-SE
                                            <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                            ?>
                                        </h4>
                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-12">
                            <div class="item cat-4" data-category="transition">
                                <div class="item-inner">
                                    <?php
                                    echo anchor("Site/graduacaoEad/ead", '
                                        <h4 class="title-ead">Graduação EaD</h4>
                                        <div class="course-img">
                                            <div class="course-overlay"></div>
                                            <img src="' . base_url('assets/images/courses/ead/EadUniAtenas.jpg') . '" alt="recent-project-img-1">
                                            <ul class="course-link">
                                                <li class="c-link">


                                                </li>
                                            </ul>

                                        </div>');
                                    ?>
                                    <div class="our-course-content">
                                        <h4>
                                            <?php
                                            echo anchor("Site/graduacaoEad/ead", '
                                    Saiba mais
                                        <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                            ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="item cat-4" data-category="transition">
                                <div class="item-inner">
                                    <?php
                                    echo anchor("Site/graduacaoEad/eadUniasselvi/uniasselvi", '
                                    <h4 class="title-ead">Demais Cursos</h4>
                                    <div class="course-img">
                                        <div class="course-overlay"></div>
                                        <img src="' . base_url('assets/images/courses/ead/demais_cursos.jpg') . '" alt="recent-project-img-1">
                                        <ul class="course-link">
                                            <li class="c-link">
                                            </li>
                                        </ul>

                                    </div>');
                                    ?>
                                    <div class="our-course-content">
                                        <h4>
                                            <?php
                                            echo anchor("Site/graduacaoEad/eadUniasselvi/uniasselvi", '
                                    Saiba mais
                                        <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                            ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>