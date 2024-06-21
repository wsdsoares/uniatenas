<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Gestão de informações da(s) página(s) do Menu Servicos - Itens Gerais e Núcleos - <b> $campus->name ($campus->city)</b>"; ?>
        </h2>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-4">
              <?php echo anchor("Painel_servicos/lista_campus_servicos", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
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
      if ($msg = getMsg()) {
        echo $msg;
      }
      ?>
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>

      </div>

      <br />

      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="row">
            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Itens da Página</h5>
                  <p class="card-text"><small>(Item: Geral ou Núcleo)</small></p>
                  <?php
                  echo anchor("Painel_servicos/lista_informacoes_servicos/$campus->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                  ?>
                </div>
              </div>
            </div>

            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Instituições Convêniadas</h5>
                  <p class="card-text"><small>(Empresas parceiras)</small></p>
                  <?php
                  echo anchor("Painel_servicos/lista_empresas_conveniadas/$campus->id/$paginaEstagiosConvenios->id", 'Ver empresas', array('class' => 'btn btn-primary'));
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