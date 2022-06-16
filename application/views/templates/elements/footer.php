<style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,500,300,700);

.footer-distributed {
  margin-top: 2%;
  background: #003a63;
  box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.12);
  box-sizing: border-box;
  width: 100%;
  text-align: left;
  font: bold 16px sans-serif;
  padding: 55px 50px;
}

.footer-distributed .footer-left,
.footer-distributed .footer-center,
.footer-distributed .footer-right {
  display: inline-block;
  vertical-align: top;
}

/* Footer left */

.footer-distributed .footer-left {
  width: 40%;
}

/* The company logo */

.footer-distributed h3 {
  color: #ffffff;
  font: normal 36px 'Open Sans', cursive;
  margin: 0;
}

.footer-distributed h3 span {
  color: lightseagreen;
}

/* Footer links */

.footer-distributed .footer-links {
  color: #ffffff;
  margin: 20px 0 12px;
  padding: 0;
}

.footer-distributed .footer-links a {
  display: inline-block;
  line-height: 1.8;
  font-weight: 400;
  text-decoration: none;
  color: inherit;
}

.footer-distributed .footer-company-name {
  color: #222;
  font-size: 14px;
  color: #fff;
  font-weight: normal;
  margin: 0;
}

/* Footer Center */

.footer-distributed .footer-center {
  width: 35%;
}

.footer-distributed .footer-center i {
  background-color: #33383b;
  color: #ffffff;
  font-size: 25px;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  text-align: center;
  line-height: 42px;
  margin: 10px 15px;
  vertical-align: middle;
}

.footer-distributed .footer-center i.fa-envelope {
  font-size: 17px;
  line-height: 38px;
}

.footer-distributed .footer-center p {
  display: inline-block;
  color: #ffffff;
  font-weight: 400;
  vertical-align: middle;
  margin: 0;
}

.footer-distributed .footer-center p span {
  display: block;
  font-weight: normal;
  font-size: 14px;
  line-height: 2;
}

.footer-distributed .footer-center p a {
  color: lightseagreen;
  text-decoration: none;
  ;
}

/* Footer Right */
.footer-distributed h4 {
  color: #fff;

}

.footer-distributed .footer-right {
  width: 20%;
}

.footer-distributed .footer-company-about {
  line-height: 20px;
  color: #92999f;
  font-size: 13px;
  font-weight: normal;
  margin: 0;
}

.footer-distributed .footer-company-about span {
  display: block;
  color: #ffffff;
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 20px;
}

.footer-distributed .footer-icons {
  margin-top: 25px;
}

.footer-distributed .footer-icons a {
  display: inline-block;
  width: 35px;
  height: 35px;
  cursor: pointer;
  background-color: #33383b;
  border-radius: 2px;

  font-size: 20px;
  color: #ffffff;
  text-align: center;
  line-height: 35px;

  margin-right: 3px;
  margin-bottom: 5px;
}

/* If you don't want the footer to be responsive, remove these media queries */

@media (max-width: 880px) {

  .footer-distributed {
    font: bold 14px sans-serif;
  }

  .footer-distributed .footer-left,
  .footer-distributed .footer-center,
  .footer-distributed .footer-right {
    display: block;
    width: 100%;
    margin-bottom: 40px;
    text-align: center;
  }

  .footer-distributed .footer-center i {
    margin-left: 0;
  }

}

img.partnerimg {
  width: 180px;
}

.partnerimg {
  padding-bottom: 10px;
}

.partner {
  text-align: center;
}

.linkFooter a {
  color: #fff;
}

.copyr {
  text-align: center;
  background: #003257;
  padding: 10px;

}

.copyr p {
  font-size: 10px;
  color: #fff;
}
</style>
<?php
$uricampus = $this->uri->segment(3);

$colunasTabelaCampus = array(
  'campus.facebook',
  'campus.instagram',
  'campus.youtube',
  'campus.shurtName',
  'campus.logoBranca',
  'campus.id',
  'campus.email',
  'campus.description',
  'campus.name',
  'campus.phone',
  'campus.city',
);

$informacoesCampus = $this->bancosite->where($colunasTabelaCampus, 'campus', NULL, array('campus.shurtName' => $uricampus))->row();


$indicadores = $this->bancosite->where(array('campus_indicadores.arquivo', 'campus_indicadores.nome'), 'campus_indicadores', NULL, array('campus_indicadores.campusid' => $informacoesCampus->id))->result();



// if ($campus == 'paracatu') {
//   $city = "Paracatu";
// } elseif ($campus == 'passos') {
//   $city = "Passos";
// } elseif ($campus == 'setelagoas') {
//   $city = "Sete Lagoas";
// } elseif ($campus == 'valenca') {
//   $city = "Valenca";
// }
?>

<footer class="footer-distributed">
  <div class="container">
    <div class="col-md-3">

      <?php echo anchor('atenas/inicio/' . $informacoesCampus->shurtName, '<img src="' . base_url($informacoesCampus->logoBranca) . '" alt="logo" class="img-responsive logoPrincipal" />', array('class' => 'logooficial')); ?>
      <br />
      <h4 class="">Links</h4>
      <div class="footer-linksPage">

        <p class="linkFooter">
          <?php
          echo anchor('site/trabalheconosco/' . $informacoesCampus->shurtName, 'Trabalhe Conosco ');
          ?>
        </p>

        <?php
        if ($informacoesCampus->shurtName == 'paracatu') {
        ?>

        <?php
        }
        ?>

        <p class="linkFooter">
          <?php
          echo anchor('site/inicio/' . $informacoesCampus->shurtName, 'Espaço para Eventos ');
          ?>
        </p>
        <p class="linkFooter">
          <?php
          echo anchor('site/contato/' . $informacoesCampus->shurtName, 'Contato ');
          ?>
        </p>

      </div>
    </div>
    <div class="col-md-3">

      <p class="footer-company-about">
        <span>Sobre <?php
                    if ($informacoesCampus->shurtName == 'paracatu') {
                      echo "o ";
                    } else {
                      echo "a ";
                    }
                    echo $informacoesCampus->name . ' ' . $dados['campus']->city;
                    ?> </span>
        <?php echo $informacoesCampus->description; ?>
      </p>
      <p class="footer-company-about">
        <span>Contatos</span>
      <p>
        <?php echo 'Telefone: ' . $informacoesCampus->phone; ?>
      </p>
      <p>
        <?php echo 'Email: ' . $informacoesCampus->email; ?>
      </p>
      </p>

      <div class="footer-icons">
        <a href="https://www.facebook.com/<?php echo $informacoesCampus->facebook ?>" target="_blank">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="http://instagram.com/<?php echo $informacoesCampus->instagram ?>" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.youtube.com/<?php echo $informacoesCampus->youtube ?>" target="_blank">
          <i class="fab fa-youtube"></i>
        </a>
      </div>
    </div>
    <?php
    if ($indicadores) {
    ?>
    <div class="col-md-6">
      <h4 class="text-center">Indicadores</h4>
      <div class="indicadores">
        <?php
          $quantidadeIndicadores = count($indicadores);
          for ($i = 0; $i < $quantidadeIndicadores; $i++) {
          ?>
        <div class="partner">
          <div class="col-md">
            <img src="<?php echo base_url($indicadores[$i]->arquivo); ?>" class="partnerimg"
              alt="<?php echo $indicadores[$i]->nome  ?>">
          </div>
        </div>
        <?php
          }
          ?>
      </div>
    </div>
    <?php
    }
    ?>
  </div>

</footer>
<div class="copyr">
  <div class="container">

    <p class="footer-company-name">uniatenas©<?php echo date('Y'); ?></p>
  </div>
</div>