<!doctype html>
<html lang="pt-br">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169618030-1"></script>
  <script src="assets/js/lgpd.js"></script>
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
    content="UniAtenas, Centro Universitario UniAtenas, UniAtenas - Passos, UniAtenas - Sete Lagoas,UniAtenas - Valença, UniAtenas, paracatu, faculdade paracatu, vestibular, cursos, curso superior, faculdade, estudar, graduação, pós-graduação, adminitração, direito, educação física, enfermagem, engenharia civil, farmácia, medicina, nutrição, pedagogia, psicologia, sistemas de informação, paracatu, instituição, ensino, qualidade, infraestrutura, reconhecimento, sucesso" />
</head>

<body>
  <div class="cookies-container">
    <!--div class="cookies-content">
      <p> Usamos cookies para analisar suas interações neste site e melhorar a sua experiência de navegação. Ao usar
        nosso site, entendemos que você está ciente da nossa <a
          href="http://www.atenas.edu.br/uniatenas/assets/popup/Politicadeprivacidade.pdf"> Política de Privacidade</a>
        e concorda com o uso de cookies.</p>

      <button class="cookies-save">Aceitar</button>

    </div-->
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12 logo">
        <img src="<?php echo base_url('assets/images/@principal/tocha.png'); ?>" class="img-responsive" />
        <!--h5 class="cover-heading">Aqui começa uma nova história.</h5-->

      </div>
    </div>

    <div class="row justify-content-md-center">

      <?php


      foreach ($dados['informacoesTodosCampus'] as $local) {

        $localCampus = noAccentuation(mb_strtolower(removerAcentos($local->city)));
      ?>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="dados <?php echo 'bg-' . $localCampus; ?>">
          <div class="col-xs-12">
            <div class="dadosCampus">
              <?php echo anchor('atenas/inicio/' . $localCampus, '
                                    <div class="flip-box">
                                        <div class="flip-box-inner">
                                            <div class="flip-box-front">
                                                <img src="' . base_url($local->iconeCampus) . '" class="img-fluid"/>
                                            </div>
                                            
                                            <div class="flip-box-back">
                                                <h5>Acesse aqui!<br>
                                                Informações do campus ' . $local->city . ' (' . $local->uf . ')</h5>
                                                
                                            </div>
                                           
                                        </div>
                                         
                                    </div>
                                    '); ?>

            </div>
          </div>
          <div class="col-xs-12 titleSocialMedias">
            <h5 class="text-center">Siga-nos em nossas redes sociais. </h5>
          </div>
          <div class="socialMedia">
            <div class="row">
              <div class="col-xs-4">
                <div class="dataMedia">
                  <a href="https://www.facebook.com/<?php echo $local->facebook; ?>" target="_blank">
                    <div class="redes" id="facebooks">
                      <img src="<?php echo base_url('assets/images/@principal/images/facebook2.png') ?>"
                        class="iconesocial img-responsive" />
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="dataMedia">
                  <a href="https://www.instagram.com/<?php echo $local->instagram; ?>" target="_blank">
                    <div class="redes" id="instagrams">
                      <img src="<?php echo base_url('assets/images/@principal/images/instagram2.png') ?>"
                        class="iconesocial img-responsive" />
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-xs-4">
                <div class="dataMedia">
                  <a href="https://www.youtube.com/user/<?php echo $local->youtube; ?>" target="_blank">
                    <div class="redes" id="youtubes">
                      <img src="<?php echo base_url('assets/images/@principal/images/youtube2.png') ?>"
                        class="iconesocial img-responsive" />
                    </div>
                  </a>
                </div>
              </div>
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
  p {
    margin: 0px;
    text-align: center;
  }


  a {
    color: blue;
  }

  @keyframes slideUp {

    to {
      transform: initial;
      opacity: initial;
    }

  }

  .cookies-content {
    box-shadow: 0 1px 3px rgba (0, 0, 0, 0.15);
    background: white;
    max-width: 1100px;
    border-radius: 5px;
    padding: 1rem;
    margin: 0 auto;
    display: grid;
    gap: 0.5rem;
    opacity: 0;
    transform: translateY(100rem);
    animation: slideUp 0.5s forwards;
  }

  .cookies-container {
    color: black;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    position: fixed;
    width: 100%;
    bottom: 2rem;
    z-index: 1000;
  }


  .cookies-save {
    grid-column: 2;
    grid-row: 1/2;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    background: #006ad4;
    color: white;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 1.5rem;
    font-size: 1rem;

  }

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
      min-width: 310px;
      min-height: 245px;
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
    height: auto;
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

  <script>
  function cookies(functions) {
    const container = document.querySelector('.cookies-container');
    const save = document.querySelector('.cookies-save');
    functions[aceitar];
    if (!container || !save) {
      return null;
    }

    const localPref = JSON.parse(window.localStorage.getItem('cookies-Uniatenas'));
    if (localPref) activateFunctions(localPref);

    function getFormPref() {
      return ["aceitar"]
        .filter((el) => el.checked)
        .map((el) => el.getAttribute('data-function'));
    }

    function activateFunctions(pref) {

      container.style.display = 'none';
      window.localStorage.setItem('cookies-Uniatenas', JSON.stringify(pref));
    }

    function handleSave() {
      const pref = getFormPref();
      activateFunctions(pref);
    }

    save.addEventListener('click', handleSave);
  }

  function marketing() {
    console.log('Função de marketing');
  }

  function analytics() {
    console.log('Função de analytics');
  }

  function aceitar() {
    console.log('Cookies Uniatenas');
  }

  cookies({
    aceitar
  });
  </script>

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