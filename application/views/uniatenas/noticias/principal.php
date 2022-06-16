<?php
$uricampus = $this->uri->segment(3);
?>
<section>
    <div class="container">

        <div class="dados_gerais text-center">
            <h2 class="text-center">Notícias</h2>
            <span class="double-border"></span>
        </div>


        <div class="row">
            <?php
            foreach ($dados['news'] as $noticia) {
                ?>

                <div class="col-md-3 col-sm-3 col-xs-12 news-box">
                    <div class="news-noticias">
                        <?php
                        echo anchor('site/ver_noticia/' . $uricampus . '/' . $noticia->id, ' 
                            
                            <div class="col-xs-12 news-img-n">
                                <img src="' . base_url(verifyImg($noticia->img_destaque)) . '" class="img-responsive">
                            </div>
                            <div class="col-xs-12 news-title-n">
                                <h4>
                                    ' . toHtml($noticia->title) . '
                                </h4>
                            </div>
                            
                            ');
                        ?>

                    </div>
                    <p class="btn-see-more">
                        <?php echo anchor("site/ver_noticia/$uricampus/$noticia->id", '
                            <span>Saiba mais...</span>
                        ');
                        ?>
                    </p>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</section>
