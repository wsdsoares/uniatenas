<!DOCTYPE html>
<html>
<?php
if (isset($head['head_conteudo']) and $head['head_conteudo'] !== NULL and !empty($head['head_conteudo'])) {
  $this->load->view($head['head_conteudo'], $head);
} else {
  $this->load->view('templates/elements/headMaster', $head);
}
?>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5J2LCLK9" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php

  if (isset($menu) and $menu !== NULL and !empty($menu)) {
    $this->load->view("$menu");
  } else {
    $this->load->view("templates/elements/menuMaster");
  }

  $this->load->view($conteudo, $dados);

  if ($footer !== NULL) {
    $this->load->view('templates/elements/footer', $footer);
  }
  if ($js !== NULL) {
    $this->load->view($js);
  }
  ?>
  <div class="cookies-container">
    <div class="cookies-content">
      <p> Usamos cookies para analisar suas interações neste site e melhorar a sua experiência de navegação. Ao usar
        nosso site, entendemos que você está ciente da nossa <a class="diva"
          href="http://www.atenas.edu.br/uniatenas/assets/popup/Politicadeprivacidade.pdf"> Política de Privacidade</a>
        e concorda com o uso de cookies.</p>

      <button class="cookies-save">Aceitar</button>

    </div>
  </div>
  <!-- 
  Linha removida pois estava bloqueando o menu collapsed com a opção de responsividade 18-09-2024
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
  -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <style>
    p {
      margin: 0px;
      text-align: center;
    }

    .diva {
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

</body>

</html>