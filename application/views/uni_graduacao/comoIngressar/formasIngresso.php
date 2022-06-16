<?php
$uricampus = $this->uri->segment(3);

$urlVestibular= '';
if($dados['campus']->id == 1) {
    $urlVestibular = 'http://177.69.195.4:8000/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=58#/es/informacoes';
}
else if($dados['campus']->id == 2){
    $urlVestibular ='http://177.69.195.4:8000/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=59#/es/informacoes';
}
else if($dados['campus']->id == 3){
    $urlVestibular = 'http://177.69.195.4:8000/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=60#/es/informacoes';
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-4 textFinanciamento text-justify">
            <h3>
                <?php echo $dados['conteudoPag']->title; ?>
            </h3>
            <p class="text">
                <?php
                echo $dados['conteudoPag']->description;;
                ?>
            </p>
            <?php
            if ($dados['conteudoPag']->title != 'COMO INGRESSAR - VESTIBULAR TRADICIONAL'){
                if ($uricampus == 'paracatu') {
                    ?>
                    <div class="text-center">
                        <?php
                        //echo anchor('graduacao/inscricao/' . $uricampus, 'Inscreva-se agora!', array('class' => "btn btns btn-lg"));
                        ?>
                        <a href="http://177.69.195.21:8080/prova/entrar"
                           class="btn btns btn-lg">
                            VESTIBULAR ONLINE
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-md-8 imageFinanciamento">
          <?php echo anchor($urlVestibular ,'
                <img src="'. base_url($dados['conteudoPag']->img_destaque).'" alt=""/>');
            ?>
        </div>
    </div>
</div>
