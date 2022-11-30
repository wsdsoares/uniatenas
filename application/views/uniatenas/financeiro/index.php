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

.imageFinanciamento,
.textFinanciamento {
  max-height: 260px;
  margin-bottom: 2em;
}

.descriptionFinanciamentos {
  padding: 10px 0 30px 0;
}

.sectionFinanciamentos a.linksFinanceiro {
  margin-top: 10px;
  width: 100%;
}
</style>


<?php
//$campus = $this->uri->segment(3);
?>

<div class="container sectionFinanciamentos">
  <div class="sectionFinanciamentos-header">
    <h3>
      Financeiro
      <?php echo $dados['campus']->name . ' - ' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?>
    </h3>
  </div>
  <div class="row">
    <div class="col-md-9">
      <div class="descriptionFinanciamentos">
        <span><?php echo $conteudoPag[0]->description; ?> </span>
      </div>
      <div class="row">
        <?php
      for ($i = 1; $i < count($dados['conteudoPag']); $i++) {
      ?>

        <!--div class="col-md-6 textFinanciamento text-justify">
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
            <?php echo anchor('financeiro/pagina/' . $campus->shurtName . '/' . $dados['conteudoPag'][$i]->id, '<i class="fa fa-plus"></i> Informações', array('class' => 'btn btn-success linksFinanceiro')); ?>
          </div>
        </div-->
        <?php        
        if($dados['conteudoPag'][$i]->description == ''){
          $linkRedir = $dados['conteudoPag'][$i]->link_redir;
          if($linkRedir==''){
            $linkRedir= base_url("financeiro/inicio/$campus->shurtName");
          }
        }else{
          $linkRedir = 'financeiro/pagina/' . $campus->shurtName . '/' . $dados['conteudoPag'][$i]->id;
        }
        
        ?>
        <div class="col-xs-4 imageFinanciamento">
          <?php echo anchor($linkRedir, "
              <img src='" . base_url($dados['conteudoPag'][$i]->img_destaque) . "'/>");
            ?>
          <div class="text-right">
            <?php echo anchor($linkRedir, '<i class="fa fa-plus"></i> Informações', array('class' => 'btn btn-success linksFinanceiro')); ?>
          </div>
        </div>

        <?php
        
      } ?>
      </div>
    </div>

    <div class="col-md-3">
      <?php 
      if (!empty($dados['contatosPagina'])){
      ?>
      <div class="widget-sidebar">
        <h2 class="title-widget-sidebar">Contatos</h2>
        <div class="content-widget-sidebar">
          <ul>
            <li class="recent-post-alunos">
              <div class="col-sm-2 col-xs-2">
                <i class="far fa-address-card fa-2x"></i>
                </a>
              </div>
              <div class="col-sm-12 col-xs-12 ">
                <?php 
                // foreach ($contatos as $phone){
                foreach ($contatosPagina as $informacoesContato){
                ?>
                <small>
                  <?php
                  echo $informacoesContato->description;
                  ?>
                </small>
                <?php
                }
                ?>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <?php 
      } 
      ?>
    </div>
  </div>
</div>