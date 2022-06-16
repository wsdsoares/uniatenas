<?php
echo '<pre>';
print_r($campus);
echo '</pre>';
?>
<!-- Start Page Header Section -->
<section class="bg-page-header bg-page-portal portal-educacional">
  <div class="page-header-overlay">
    <div class="container">
      <div class="row">
        <div class="page-header">
          <div class="page-title titulosTextos">
            <h2>
              <?php echo strtoupper('Portais Educacionais - ' . $campus->city); ?>
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="portais-educaionais">
  <div class="container">
    <div class="row">
      <div class="itens-portal">
        <a href="http://faculdadeatenas.blackboard.com">
          <div class="">
            <div class="row">
              <div class="col-sm-12">
                <img src="<?php echo base_url('assets/images/portais/portal_ead.jpg') ?>" class="img-responsive">
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="itens-portal">
        <?php
                if ($campus->id == 1) {
                    echo anchor('PortalAlunos/portalInterno/' . $campus->id, '<img src="' . base_url("assets/images/portais/portal_aluno.jpg") . '">');
                } elseif ($campus->id == 2) {
                    ?>
        <a href='http://www.atenas.edu.br/faculdade/setelagoas/portal_alunos'>
          <img src="<?php echo base_url('assets/images/portais/portal_aluno.jpg') ?>">
        </a>
        <?php
                } elseif ($campus->id == 3) {
                    ?>
        <a href='http://www.atenas.edu.br/faculdade/passos/vestibular/'>
          <img src="<?php echo base_url('assets/images/portais/portal_aluno.jpg')  ?>">
        </a>
        <?php
                }
                ?>
      </div>

      <div class="itens-portal">
        <a href='http://177.69.195.4/Corpore.Net/Login.aspx'>
          <img src="<?php echo base_url('assets/images/portais/portal_professor.jpg') ?>">
        </a>
      </div>
      <div class="itens-portal">
        <a href='http://177.69.195.6:8080/portalatenas/usuarios/login'>
          <img src="<?php echo base_url('assets/images/portais/portal_interno.jpg') ?>">
        </a>
      </div>

      <div class="itens-portal">
        <a href='http://177.69.195.4:8000/WEB/APP/EDU/PORTALEDUCACIONAL/login/'>
          <img src="<?php echo base_url('assets/images/portais/poratal_eduConnect.png') ?>">
        </a>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- Start Page Header Section -->
<section class="bg-page-header bg-page-portal-alunos">
  <div class="page-header-overlay">
    <div class="container">
      <div class="row">
        <div class="page-header">
          <div class="page-title titulosImg">
            <h3>
              <?php echo 'Informações / Avisos'; ?>
            </h3>
          </div>
          <div class="page-header-content">
            <ol class="breadcrumb">
              <!--li>Campus - <?php echo $campus->city; ?></li-->
            </ol>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>