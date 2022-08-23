<?php
$uricampus = $this->uri->segment(3);
$link = $dados['conteudoPag']->link_redir != '' ? $dados['conteudoPag']->link_redir : '#' ;
?>
<div class="container">
  <div class="row">
    <div class="col-md-4 textFinanciamento text-justify">
      <h3>
        <?php echo $dados['conteudoPag']->title; ?>
      </h3>
      <p class="text">
        <?php
					echo $dados['conteudoPag']->description;
				?>
      </p>
      <div class="text-center">
        <?php 
				if($dados['conteudoPag']->link_redir != ''){
				?>
        <a href="<?php echo $dados['conteudoPag']->link_redir ?>" class="btn btns btn-lg">
          ACESSAR
        </a>
        <?php 
				}
				?>
      </div>
    </div>
    <div class="col-md-8 imageFinanciamento">

      <a href="<?php echo  $link ?>">
        <img src="<?php echo base_url($dados['conteudoPag']->img_destaque)?>" alt="" />
      </a>
      <?php 
				if($dados['conteudoPag']->link_redir != ''){
					echo $dados['conteudoPag']->link_redir;
				}
      ?>
    </div>
  </div>
</div>