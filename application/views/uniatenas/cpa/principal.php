<style>
text.Orange-label {
  color: Orange;
}
</style>
<?php
// echo '<pre>';
// print_r($dados);
// echo '</pre>';
?>
<div class="container">
  <div class="dados_gerais">
    <div class="container">
      <div class="section-header">
        <h3 class="text-center">CPA - Comissão Própria de Avaliação</h3>
      </div>

    </div>
  </div>

  <div class="container">
    <div role="tabpanel">
      <div class="col-sm-2">
        <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
          <?php
          for ($i = 0; $i < count($conteudo); $i++) {
            if ($i == 0) {
              $active = "active";
            } else {
              $active = "";
            }
            ?>
          <li role="presentation" class="brand-nav <?php echo $active; ?>">
            <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab"
              data-toggle="tab"><?php echo $conteudo[$i]->title ?></a>
          </li>
          <?php
            }
            ?>
        </ul>
      </div>
      <div class="col-sm-7">
        <div class="tab-content">
          <?php
          for ($i = 0; $i < count($conteudo); $i++) {
            if ($i == 0) {
                $active = "active";
            } else {
                $active = "";
            }
            ?>

          <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
            <div class="row">
              <div class="col-xs-12">
                <?php   echo $conteudo[$i]->description; ?>
              </div>
            </div>
            <div class="row">
              <?php 
                
              $consultaArquivos = 
                "SELECT
                  *
                FROM
                  at_site.page_contents_files
                where page_contents_files.status=1
                and page_contents_files.id_page_contents =".$conteudo[$i]->id;

              $arquivosConteudosCpa = $this->bancosite->getQuery($consultaArquivos)->result();
            
              foreach($arquivosConteudosCpa as $itensArquivos){
              ?>
              <div class="col-xs-3">
                <h4 class="text-center titleSPIC"><?php echo $itensArquivos->title; ?></h4>
                <div class="card text-center boxSite" id="teste">
                  <a href="<?php echo base_url($itensArquivos->files) ?>" class="iconSPIC" target="_blank">
                    <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                    <p>Visualizar</p>
                  </a>
                </div>
              </div>
              <?php 
                 }
                ?>

            </div>
          </div>

          <?php
          }
          ?>

        </div>
      </div>

    </div>
  </div>
</div>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>