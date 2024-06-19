<div class="block-header">
  <h2></h2>
</div>
<!-- Exportable Table -->
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
          <?php echo ($page); ?>
        </h2>

      </div>
      <br />
      <div class="body">
        <div class="row">
          <?php

          foreach ($dados['campus'] as $campus) {
          ?>

            <div class="col-md-3">
              <div class="card" style="height:10rem;padding-top:1rem;">
                <div class="center">
                  <h4 class="card-title"><?php echo $campus->name . '<br/> ' . $campus->city . '(' . $campus->uf . ')'; ?>
                  </h4>
                  <span>
                    <?php echo "Menu: <strong>$tipoPagina</strong>" ?>
                  </span>

                  <?php
                  echo anchor("Painel_servicos/lista_informacoes_servicos/$campus->id/$tipoPagina", '<span>Ver (Itens Gerais)', 'class="btn btn-lg btn-block btn-info"');
                  ?>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
          <br />
        </div>
      </div>
    </div>

  </div>
</div>