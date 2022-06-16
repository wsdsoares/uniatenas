<style>
    .sectionFinanciamentos {
        margin-top: 2%;

    }

    .sectionFinanciamentos .row {
        margin-bottom: 2%;
    }

    .sectionFinanciamentos .row .col-md-6 {
        background: #f5f5f5;
        padding: 2%;
    }

    .sectionFinanciamentos-header {
        text-align: center;
    }

    .sectionFinanciamentos h3 {
        color: #004085;
    }

    .sectionFinanciamentos p.text {
        margin-top: 6%;
        color: #545b62;
    }

    .sectionFinanciamentos img {
        width: 100%;
        max-height: 260px;
    }

    .imageFinanciamento, .textFinanciamento {
        max-height: 260px;
    }

    .descriptionFinanciamentos {
        padding: 10px 0 30px 0;
    }

    .sectionFinanciamentos a.linksFinanceiro {
        margin-top: 10px;
    }
</style>


<?php


$campus = $this->uri->segment(3);
?>

<div class="container sectionFinanciamentos">
    <div class="sectionFinanciamentos-header">
        <h3>
            Financiamentos <?php echo $dados['campus']->name . ' - ' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?></h3>
    </div>
    <div class="descriptionFinanciamentos">
        <span><?php echo $conteudoPag[0]->description; ?> </span>
    </div>
    <?php

    for ($i = 1; $i < count($dados['conteudoPag']); $i++) {

        ?>
        <div class="row">
            <div class="col-md-6 textFinanciamento text-justify">
                <h3>
                    <?php echo $dados['conteudoPag'][$i]->title; ?>
                </h3>
                <p class="text">
                    <?php
                    $max = 150;
                    $str = $dados['conteudoPag'][$i]->description;
                    to_html(substr_replace($str, (strlen($str) > $max ? '...' : ''), $max));

                    echo $texto = mb_substr($str, 0, mb_strrpos(mb_substr($str, 0, $max), ' '), 'UTF-8') . '...';
                    ?>
                </p>
                <div class="text-right">
                    <?php echo anchor('financiamentos/pagina/' . $campus . '/' . $dados['conteudoPag'][$i]->id, '<i class="fa fa-plus"></i> Informações', array('class' => 'btn btn-success linksFinanceiro')); ?>
                </div>
            </div>
            <div class="col-md-5 imageFinanciamento">
                <?php echo anchor('financiamentos/pagina/' . $campus . '/' . $dados['conteudoPag'][$i]->id, "
                <img src='".base_url($dados['conteudoPag'][$i]->img_destaque)."'/>");
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
