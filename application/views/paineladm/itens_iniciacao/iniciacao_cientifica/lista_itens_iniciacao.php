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
            <div style="background">
              <span>
                <i><?php echo "Local para gestão de itens Gerais no menu Serviços do Site: 
            <br> <u>Itens Gerais</u> (Biblioteca, Secretaria, Portal Aluno e Portal Professor) 
            <br> <u>Itens Específicos</u> (Núcleos - NAPP, NPJ, NPA, NPAS) ou outros que precisarem ser cadastrados
            
            "; ?></i>
              </span>
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
        <h2>
          <?php echo $page; ?>
        </h2>

      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="row">
            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Itens da Iniciação</h5>
                  <p class="card-text"><small>(Apresentação e outros)</small></p>
                  <a href="#" class="btn btn-primary">Ver itens</a>
                </div>
              </div>
            </div>

            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Links ùteis</h5>
                  <p class="card-text"><small>(Links importantes)</small></p>
                  <a href="#" class="btn btn-primary">Ver núcleos</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br />

    </div>
  </div>
</div>