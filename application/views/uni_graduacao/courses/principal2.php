<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
      <span class="d-block d-lg-none">
        UniAtenas
      </span>
      <span class="d-none d-lg-block">
        <?php
        if ($idCampus == 1) {
          ?>
          <img class="img-fluid img-profile rounded-circle mx-auto mb-2"
            src="<?php echo base_url('assets/images/UniAtenasRedondo.png'); ?>">
          <?php
        } else {
          ?>
          <img class="img-fluid img-profile rounded-circle mx-auto mb-2"
            src="<?php echo base_url('assets/images/FaculdadeAtenasRedondo.png'); ?>">
          <?php
        }
        ?>
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">


        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#page-top">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#provas">Provas e Gabaritos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#recurso">Recurso</a>
        </li>
        <li class="nav-item">
          <?php
          echo anchor('http://www.atenas.edu.br/site_atenas/', 'Site UniAtenas', array('class' => "nav-link js-scroll-trigger"));
          ?>
        </li>
      </ul>
    </div>
  </nav>
  <?php
  if ($idCampus == 1) {
    $pasta = 'http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularparacatu/';
  } elseif ($idCampus == 2) {
    $pasta = 'http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularpassos/';
  } elseif ($idCampus == 3) {
    $pasta = 'http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularsetelagoas/';
  }
  ?>


  <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="provas">
    <div class="my-auto">
      <h3 class="mb-5">Provas e Gabaritos -
        <?php echo $campus . '-' . $local; ?>
      </h3>

      <div class="subheading mb-3">Provas</div>
      <?php
      if ($idCampus == 1) {
        ?>
        <ul class="list-inline dev-icons" style="text-align:center;">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>TIPO-1.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 1</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>TIPO-2.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 2</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>TIPO-3.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 3</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>TIPO-4.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 4</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>TIPO-5.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 5</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>

        </ul>
        <?php
      } elseif ($idCampus == 3) {
        ?>
        <ul class="list-inline dev-icons" style="text-align:center;">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-1-setelagoas.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 1</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-2-setelagoas.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 2</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-3-setelagoas.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 3</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-4-setelagoas.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 4</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-5-setelagoas.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 5</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>

        </ul>
        <?php
      } elseif ($idCampus == 2) {
        ?>
        <ul class="list-inline dev-icons" style="text-align:center;">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-1-passos.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 1</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-2-passos.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 2</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-3-passos.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 3</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-4-passos.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 4</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>tipo-5-passos.pdf">
              <div class="provas-gabaritos">
                <span class="mb-5">Tipo 5</span><br>
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>

        </ul>
        <?php
      }
      ?>
      <div class="subheading mb-3">Gabaritos</div>
      <ul class="list-inline dev-icons">
        <?php
        if ($idCampus == 1) {
          ?>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>Gabarito-Medicina-UniAtenas-2019-paracatu.pdf">
              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>

          <?php
        } elseif ($idCampus == 3) {
          ?>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>GabaritoSETELAGOAS.pdf">
              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <?php
        } elseif ($idCampus == 2) {
          ?>
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>GabaritoPASSOS.pdf">
              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>
          <?php
        }
        ?>
      </ul>

    </div>
  </section>

  <hr class="m-0">
  <?php
  if ($idCampus == 1) {
    ?>
    <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="recurso">
      <div class="my-auto">
        <h2 class="mb-5">Recurso - Prova Objetiva -
          <?php echo $campus . '-' . $local; ?>
        </h2>

        <ul class="list-inline dev-icons">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>recurso.pdf">

              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>


        </ul>

      </div>
    </section>
    <?php
  } elseif ($idCampus == 3) {
    ?>
    <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="recurso">
      <div class="my-auto">
        <h2 class="mb-5">Recurso - Prova Objetiva -
          <?php echo $campus . '-' . $local; ?>
        </h2>

        <ul class="list-inline dev-icons">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>recurso.pdf">

              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>


        </ul>

      </div>
    </section>
    <?php
  } elseif ($idCampus == 2) {
    ?>
    <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="recurso">
      <div class="my-auto">
        <h2 class="mb-5">Recurso - Prova Objetiva -
          <?php echo $campus . '-' . $local; ?>
        </h2>

        <ul class="list-inline dev-icons">
          <li class="list-inline-item">
            <a href="<?php echo $pasta; ?>recurso.pdf">

              <div class="provas-gabaritos">
                <i class="fas fa-file-pdf"></i>
              </div>
            </a>
          </li>


        </ul>

      </div>
    </section>
    <?php
  }
  ?>
</body>