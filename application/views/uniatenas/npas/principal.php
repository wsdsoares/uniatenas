<div class="container">
    <div class="dados_gerais textos">
        <div class="container">
            <h2 class="text-center"><?php echo $conteudoPag[0]->title; ?></h2>
            <div class="row">
                <div class="col-sm-12 ">
                    <?php echo $conteudoPag[0]->description; ?>
                </div>
                <?php
                foreach ($dados['conteudoPag'] as $item) {
                    if ($item->title_short == "imagem") {
                        ?>
                        <div class="col-sm-6">
                            <img src="<?php echo base_url() . $item->img_destaque; ?>"
                                 alt="NPAS" class="img-responsive img-rounded"/>
                        </div>
                        <?php
                    }
                }
                ?>


            </div>
        </div>
    </div>
</div>



