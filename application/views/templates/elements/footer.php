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

.footer-distributed .footer-left {
  width: 40%;
}

.footer-distributed h3 {
  color: #ffffff;
  font: normal 36px 'Open Sans', cursive;
  margin: 0;
}

.footer-distributed h3 span {
  color: lightseagreen;
}

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

/** Botão do whatsapp */
.float {
  position: fixed;
  width: 50px;
  height: 50px;
  bottom: 40px;
  right: 40px;
  background-color: #25d366;
  z-index: 100;
}

.my-float {
  margin-top: 16px;
}

div#div-fixa {
  display: fixed;
  margin: 0 20px;
  background: rgb(89, 245, 122);
  width: 50px;
  border-radius: 50px;
  cursor: pointer;
  transition: 0.5s all;
  overflow: hidden;
}

div#div-fixa.shrink {
  width: 250px;
}

div#div-fixa img {
  width: 50px;
  height: 50px;
}

div#div-fixa a .flex-itens {
  display: flex;
  align-items: center;
}

div#div-fixa a .flex-itens span.aparecer {
  display: block;
  font-weight: bold;
  color: #040305;
  margin-left: 5px;
  font-size: 15px;
  min-width: 190px;
  opacity: 1;
}

div#div-fixa a .flex-itens span {
  transition: 0.5s all;
  opacity: 0;
}

.flutuar {
  animation-name: flutuar;
  animation-duration: 0.7s;
  animation-iteration-count: infinite;
  animation-direction: alternate;
  animation-timing-function: ease-in-out;
}

@keyframes flutuar {
  from {
    transform: translate3d(0, 0, 0);
    filter: brightness(100%);
  }

  to {
    transform: translate3d(0, -1px, 0);
    filter: brightness(105%);
  }
}
</style>
<?php

$uricampus = $this->uri->segment(3);
$joinWhatsapp = array(
  'campus'=>'campus.id=integracao_whatsapp.id_campus'
);
$whereWhatsapp = array(
'campus.shurtName'=>$uricampus
);

if($this->bancosite->where('*','integracao_whatsapp',$joinWhatsapp, $whereWhatsapp,null)->row()){
  $dadosIntegracaoWhatsapp = $this->bancosite->where('*','integracao_whatsapp',$joinWhatsapp, $whereWhatsapp,null)->row();
}else{
  $dadosIntegracaoWhatsapp = '';
}

$colunasTabelaCampus = array('campus.facebook','campus.instagram','campus.youtube','campus.shurtName','campus.logoBranca',
  'campus.id','campus.email','campus.description','campus.name','campus.phone','campus.city');
$informacoesCampus = $this->bancosite->where($colunasTabelaCampus, 'campus', NULL, array('campus.shurtName' => $uricampus))->row();
$indicadores = $this->bancosite->where(array('campus_indicadores.arquivo', 'campus_indicadores.nome'), 'campus_indicadores', NULL, array('campus_indicadores.campusid' => $informacoesCampus->id))->result();

?>

<?php
if($dadosIntegracaoWhatsapp!=''){
?>
<div id="div-fixa" class="float flutuar" data-shrink="yes">
  <a href="https://api.whatsapp.com/send?phone=<?php echo $dadosIntegracaoWhatsapp->numero_whatsapp?>&text=<?php echo $dadosIntegracaoWhatsapp->texto_padrao_mensagem?>"
    target="_blank">
    <div class="flex-itens">
      <img src="<?php echo base_url('assets/images/icones/whatsapp.png')?>" alt="chamar no whatsapp">
      <span><?php echo $dadosIntegracaoWhatsapp->titulo_botao ?></span>
    </div>
  </a>
</div>
<?php 
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
<?php
if($dadosIntegracaoWhatsapp!=''){
?>
<script>
const content = document.querySelector('[data-shrink="yes"]');

const span = document.querySelector('[data-shrink="yes"] span');

span.classList.remove('aparecer');

setInterval(function() {
  content.classList.toggle('shrink');
}, <?php echo $dadosIntegracaoWhatsapp->tempo_interacao_segundos;?>);

setTimeout(() => {
  setInterval(function() {
    span.classList.toggle('aparecer');
  }, <?php echo $dadosIntegracaoWhatsapp->tempo_interacao_segundos;?>);
}, 200);
</script>
<div class="copyr">
  <div class="container">

    <p class="footer-company-name">uniatenas©<?php echo date('Y'); ?></p>
  </div>
</div>
<?php 
} 
?>