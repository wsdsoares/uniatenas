<?php
$uricampus = $this->uri->segment(3);
?>

<div class="container sectionFinanciamentos">
    <div class="sectionFinanciamentos-header text-center">
        <h3>
            Financiamentos <?php echo $dados['campus']->name . ' - ' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?></h3>
    </div>
    <div class="btn-back">
        <?php echo anchor('financiamentos/inicio/' . $uricampus, '
            Voltar', array('class' => "btn btn-danger"));
        ?>
    </div>

    <div class="row">
        <div class="col-md-12 textFinanciamento">
            <h3>
                <?php echo $dados['conteudoPag']->title; ?>
            </h3>
            <?php
            if ($uricampus == 'paracatu') {
                ?>
                <div class="text-center">
                    <?php
                    echo anchor('graduacao/inscricao/' . $uricampus, 'Inscreva-se agora!', array('class' => "btn btns btn-lg"));
                    ?>
                </div>
                <?php
            }
            ?>


            <p class="text">

                <img src="<?php echo base_url() . $dados['conteudoPag']->img_destaque; ?>"
                     class="img-responsive imgFinancing"/>
                <div class="text-justify">
                    <?php
                    $max = 150;
                    $texto = $dados['conteudoPag']->description;
                    echo $texto;
                    ?>
                </div>
                <?php
                if ($dados['conteudoPag']->title == "BANCO BRADESCO"
                    or $dados['conteudoPag']->title == "BANCO SANTANDER"
                    or $dados['conteudoPag']->title == "BANCO SICOOB"
                    or $dados['conteudoPag']->title == "FIES"
                    or $dados['conteudoPag']->title == "PROUNI"
                ) {
                    echo anchor($dados['conteudoPag']->link_redir, '<i class="fa fa-home"></i> Acessar ao site.', array('class' => 'btn btn-info linksFinanceiro', 'target' => '_blank'));
                }
            ?>
            </p>
            <?php
            if ($uricampus == 'paracatu') {
                ?>
                <section id='cta-1'>

                    <div class='container'>
                        <?php
                        echo anchor('graduacao/inscricao/' . $uricampus, "
                    <div class='row text-right'>

                        <img src='" . base_url('assets/images/financing/inscreva-se-geral.jpg') . "'class='img-fluid'>

                    </div>
                    ");
                        ?>
                    </div>
                </section>
                <?php
            }
            ?>


        </div>
    </div>

</div>
