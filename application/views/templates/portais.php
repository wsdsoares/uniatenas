<!doctype html>
<html lang="pt-br">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169618030-1"></script>
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-169618030-1');
  </script>
  <!-- Meta tags Obrigatórias -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="<?php echo base_url('assets/css/principal.css') ?>">
  <title><?php echo $head['title'] . 'Grupo - UniAtenas'; ?></title>
  <meta name="description"
    content="UniAtenas - Grupo Uniatenas (Centro Universitário Atenas Paracatu (MG), Faculdade Atenas Passos (MG) e Faculdade Atenas Sete Lagoas (MG)." />
  <meta name="keywords"
    content="UniAtenas, Centro Universitario UniAtenas, UniAtenas - Passos, UniAtenas - Sete Lagoas, UniAtenas, paracatu, faculdade paracatu, vestibular, cursos, curso superior, faculdade, estudar, graduação, pós-graduação, adminitração, direito, educação física, enfermagem, engenharia civil, farmácia, medicina, nutrição, pedagogia, psicologia, sistemas de informação, paracatu, instituição, ensino, qualidade, infraestrutura, reconhecimento, sucesso" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12 logo">
        <img src="<?php echo base_url('assets/images/@principal/tocha.png'); ?>" class="img-responsive" />
        <!--h5 class="cover-heading">Aqui começa uma nova história.</h5-->

      </div>
    </div>
    <div class="row text-center">
      <div class="col-md-12">
        <p class="lead">Portais do Grupo Atenas</p>
      </div>
    </div>

    <div class="row justify-content-md-center">
      <?php
                
                foreach ($dados['campus'] as $local) {
                    if ($local->id == 1) {
                        $localCampus = "paracatu";
                        $cityCampus = "Paracatu (MG)";
                        $imagemPrincipal = 'assets/images/campus/uniatenas-novo.png';
                        $portalinterno = 'http://177.69.195.6:8080/portalatenas/usuarios/login';
                    } elseif ($local->id == 2) {
                        $localCampus = "setelagoas";
                        $cityCampus = "Sete Lagoas (MG)";
                        $imagemPrincipal = 'assets/images/campus/setelagoas-novo.png';
                        $portalinterno = 'http://177.69.195.6:8080/portalsetelagoas/usuarios/login';
                    } elseif ($local->id == 3) {
                        $localCampus = "passos";
                        $cityCampus = "Passos (MG)";
                        $imagemPrincipal = 'assets/images/campus/passos-novo.png';
                        $portalinterno = 'http://177.69.195.6:8080/portalpassos/usuarios/login';
                    }
                    ?>
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="dados <?php echo 'bg-' . $localCampus; ?>" style="
    padding-bottom: 30px;">
          <div class="col-xs-12">
            <div class="dadosCampus">
              <a href="<?=$portalinterno?>">
                <div class="flip-box">
                  <div class="flip-box-inner">
                    <div class="flip-box-front">
                      <img src="<?=base_url($imagemPrincipal)?>" class="img-fluid" />
                    </div>

                    <div class="flip-box-back">
                      <h5>Acesse aqui!<br>
                        Portal do campus <?=$cityCampus?></h5>

                    </div>

                  </div>

                </div>
              </a>

            </div>
          </div>
          <div class="col-xs-12 titleSocialMedias" style="margin-top: 20px;">
            <div class="row d-flex justify-content-center">
              <a type="button" align="center" class="<?php echo 'btn btn-outline-light bg-' . $localCampus; ?>">Acessar
                Portal <?=$cityCampus?></a>
            </div>
          </div>
        </div>
      </div>
      <?php
                }
                ?>

    </div>
  </div>
  <style>
  h5.titlePhotosCourse {
    font-size: 15px;
    color: #f4630b;
  }

  .dadosCampus {
    padding-top: 20px;
  }

  @media screen and (min-width: 1200px) {
    .flip-box {
      background-color: transparent;
      min-width: 245px;
      /* min-width: 310px;
                    min-height: 185px;*/
      min-height: 185px;
      border: 1px solid #f1f1f1;
      perspective: 1000px;
      /* Remove this if you don't want the 3D effect */
    }

    .flip-box-back {
      margin-top: 10%;
    }

  }

  @media screen and (min-width: 991px) and (max-width: 1199px) {
    .flip-box {
      background-color: transparent;
      min-width: 250px;
      min-height: 200px;
      border: 1px solid #f1f1f1;
      perspective: 1000px;
      /* Remove this if you don't want the 3D effect */
    }

    .redes img {
      margin-left: 1%;
      max-width: 65px;
    }

    .flip-box-back {
      margin-top: 10%;
    }
  }

  @media screen and (min-width: 768px) and (max-width: 990px) {
    .flip-box {
      background-color: transparent;
      width: 200px;
      min-height: 145px;
      border: 1px solid #f1f1f1;
      perspective: 1000px;
      /* Remove this if you don't want the 3D effect */
    }

    .flip-box-back {
      margin-top: 5%;
    }
  }

  @media screen and (min-width: 393px) and (max-width: 767px) {
    .flip-box {
      background-color: transparent;
      min-width: 310px;
      height: 250px;
      border: 1px solid #f1f1f1;
      perspective: 1000px;
      /* Remove this if you don't want the 3D effect */
    }

    .flip-box-front img {
      height: 250px;
    }

    .redes img {
      margin-left: 30%;
      max-width: 70px;
    }

    .flip-box-back {
      margin-top: 0%;
    }
  }

  @media screen and (max-width: 392px) {
    .flip-box {
      background-color: transparent;
      min-width: 270px;
      height: 180px;
      border: 1px solid #f1f1f1;
      perspective: 1000px;
      /* Remove this if you don't want the 3D effect */
    }

    .flip-box-front img {
      height: 180px;
    }

    .redes img {
      margin-left: 30%;
      max-width: 60px;
    }

    .flip-box-back {
      margin-top: 0%;
    }

    .socialMedia div {
      margin-top: 5px;
      margin-left: 5px;
      padding-bottom: 5px;
    }
  }

  .flip-box-front,
  .flip-box-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
  }

  .flip-box-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s;
    transform-style: preserve-3d;
  }

  .flip-box:hover .flip-box-inner {
    transform: rotateY(180deg);
  }

  .dadosCampus {
    padding-top: 20px;
  }

  /* Style the front side (fallback if image is missing) */
  .flip-box-front {
    color: black;
  }

  /* Style the back side */
  .flip-box-back {
    background-color: #f1f1f1;
    color: #000;
    transform: rotateY(180deg);
  }
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
</body>

</html>