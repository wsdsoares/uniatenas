<?php
$uricampus = $this->uri->segment(3);

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

        <a href="http://177.69.195.21:8080/prova/entrar" class="btn btns btn-lg">
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