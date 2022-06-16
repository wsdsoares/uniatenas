<!--section class="bg-page-header bg-pos-graduacao-ead">
    <div class="page-header-overlay">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
</section>
<style>
    section.course-content-pos {
        margin-bottom: 45px;
    }

    section.course-content-pos p {
        margin-top: 25px;
        text-indent: 3.5em;
        text-align: justify;
    }
</style>

<section class="course-content course-content-pos">
    <div class="container">
        <div class="row">
            <div class="section-header text-center">
                <h3>Pós-Graduação</h3>
                <span class="double-border"></span>
            </div>

            <div class="col-sm-12">
                <div class="section">
                    <div class="container">
                        <div class="row align-items-center">

                            <?php
                            foreach ($conteudoPag as $dados) {
                                ?>


                                <h2 class="section-title">
                                    <?php
                                    echo $dados->title;
                                    ?>
                                </h2>
                                <div class="col-md-6 mr-auto">
                                    <p>
                                        <?php
                                        echo $dados->description;
                                        ?>
                                    </p>
                                    <a target="_blank" href="https://portal.uniasselvi.com.br/posgraduacao/mg/cursos?list=1" class="btnEdital">Escolher meu curso</a>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6 mr-auto">
                                <img src="<?php echo base_url('assets/images/posgraduation/1280x962-20190213134252-pos.png');?>"/> 
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section-->

