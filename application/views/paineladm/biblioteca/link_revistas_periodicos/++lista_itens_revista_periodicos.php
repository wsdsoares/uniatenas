<div class="block-header">
  <h2>Painel Administrativo</h2>

</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <div class="col-xs-6">
                <?php echo anchor("Painel_biblioteca/lista_informacoes_biblioteca/$campus->id", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()){
        echo $msg;
      }
      ?>
      <div class="header">
      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="row">
            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"> -> Áreas/Cursos <br>
                    -> Links de Revistas e Periódicos</h5>
                  <p class="card-text"><small>(Lista)</small></p>
                  <?php
                    echo anchor("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$campus->id/$pagina->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>