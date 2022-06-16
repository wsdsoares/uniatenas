<?php
$cartilha = isset($dados['filesarray']['cartilha']) ? $dados['filesarray']['cartilha'] : '';
$listasProvas = isset($dados['filesarray']['listasProvas']) ? $dados['filesarray']['listasProvas'] : '';


if ($campus->id == 1) {
    ?>

<div class="container">
  <div class="section-header text-center">
    <h3>Informações / Avisos</h3>

    <h4>
      <?php echo $campus->city; ?>
    </h4>
  </div>
</div>

<?php
}
?>
<section class="avisos-portal-alunos">
  <div class="container">
    <div class="row">
      <div class="col-xl-3 col-sm-4">
        <div class="card text-white bg-ead">
          <a class="card-body text-white" href="https://faculdadeatenas.blackboard.com/webapps/login/">
            <div class="card-body-icon">
              <i class="fa fa-play-circle"></i>
            </div>
            <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> EaD UniAtenas</div>
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-sm-4 mb-3">
        <div class="card text-white bg-interno">
          <a class="card-body text-white" href="http://177.69.195.4:8080/portalatenas/usuarios/login">
            <div class="card-body-icon">
              <i class="fa fa-laptop"></i>
            </div>
            <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> Portal Interno -
              CPA, Jornada, Cursos
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-3 col-sm-4 mb-3">
        <div class="card text-white bg-totvs">
          <a class="card-body text-white" href="http://177.69.195.4:8000/web/app/edu/PortalEducacional/login">
            <div class="card-body-icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="labelBlocoDashboard"><span class="numeroBlocoDashboard"></span> Portal TOTVS - Notas
              e faltas
            </div>
          </a>
        </div>
      </div>


    </div>

  </div>

  </div>
</section>
<section class="informativos-section" style="background:#DFDFDF;">
  <div class="container">
    <div class="row" style="margin-top: 5px;">
      <center>
        <h3 style="padding-top: 20px;color:#000;">Mural de Avisos</h3>
      </center>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Provão internato</h3>
          </div>
          <div class="panel-body-portal">
            <a href="#">
              <img src="<?php echo base_url('assets/images/portais/mapa_salas_internato.png'); ?>"
                class="img-responsive">
            </a>
          </div>
          <div class=" text-center">
            <a href="<?php echo base_url('assets/files/muralProvas/internato/LISTA-MURAL-PROVAO-INTERNATO-5-ANO-6-RODIZIO.pdf'); ?>"
              class="btn btn-success" target="_blank">
              5º Ano</a>
            <a href="<?php echo base_url('assets/files/muralProvas/internato/LISTA-MURAL-PROVAO-INTERNATO-6-ANO-6-RODIZIO.pdf'); ?>"
              class="btn btn-danger" target="_blank">
              6º Ano</a>
          </div>
        </div>
      </div>
      <?php
            if ($listasProvas != '') {
                ?>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <?php echo anchor('PortalAlunos/cursosLista/' . $campus->id, '
                            <div class="panel-heading">
                                <h3 class="panel-title">Salas de Provas</h3>
                            </div>
                            <div class="panel-body-portal">
                                <img src ="' . base_url('assets/images/portais/salas_provas.png') . '" class = "img-responsive">
                            </div>
                            <div class=" text-center">
                                 <button class="btn btn-success">VISUALIZAR</button>
                            </div>
                            <?php
                                ');
                        ?>
          </a>
        </div>
      </div>
      <?php

            }
            ?>
    </div>
  </div>
</section>
<br>
<section class="informativos-section">
  <div class="container">
    <div class="row">
      <center>
        <h3 style="color:#000;">Informativos</h3>
      </center>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Horários de Aula</h3>
          </div>
          <div class="panel-body-portal">
            <a href="#">
              <img src="<?php echo base_url('assets/images/portais/horario_aula.png'); ?>" class="img-responsive">
            </a>
          </div>
        </div>

      </div>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Reemissão Boleto Vencido</h3>
          </div>
          <div class="panel-body-portal">
            <a href="https://www.santander.com.br/br/resolva-on-line/reemissao-de-boleto-vencido">
              <img src="<?php echo base_url('assets/images/portais/reemisao_boleto.png'); ?>" class="img-responsive">
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Calendário Escolar</h3>
          </div>
          <div class="panel-body-portal">
            <a href="http://atenas.edu.br/site_atenas/inicio/secretaria">
              <img src="<?php echo base_url('assets/images/portais/calendario_academico.png'); ?>"
                class="img-responsive">
            </a>
          </div>
        </div>
      </div>

      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Plano de Ensino</h3>
          </div>
          <div class="panel-body-portal">
            <a href="http://177.69.195.4:8080/portalatenas/painel" target="_blank">
              <img src="<?php echo base_url('assets/images/portais/plano_ensino.png'); ?>" class="img-responsive">
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Mapas de Sala</h3>
          </div>
          <?php
                    /* echo anchor('PortalAlunos/mapasSala/' . $campus->id, '

                      <div class="panel-body-portal">

                      <img src ="' . base_url('assets/images/portais/mapas_sala.png') . '" class = "img-responsive">
                      </div>
                      '); */
                    ?>
          <div class="panel-body-portal">
            <img src="<?php echo base_url('assets/images/portais/mapas_sala.png'); ?>" class="img-responsive" />
          </div>
        </div>
      </div>
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Declaração de Vinculo</h3>
          </div>
          <div class="panel-body-portal">
            <a href="http://177.69.195.4/Corpore.Net/Main.aspx?ActionID=EduEmitirRelatoriosActionWeb&SelectedMenuIDKey=mnEmitirRelatoriosEdu"
              target="_blank">
              <img src="<?php echo base_url('assets/images/portais/declaracao_vinculo.png'); ?>" class="img-responsive">
            </a>
          </div>
        </div>
      </div>

    </div>
    <?php
        if ($cartilha != '') {
            ?>

    <div class="row">
      <div class="col-sm-2">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Atividades Complementares</h3>
          </div>
          <div class="panel-body-portal text-center">
            <a class="text-center" href="<?php echo base_url() . $cartilha->files; ?>">
              <img src="<?php echo base_url('assets/images/portais/atividades_complementares.png'); ?>"
                class="img-responsive text-center"> </a>

          </div>
        </div>
      </div>
    </div>
    <?php

        }
        ?>
  </div>
</section>