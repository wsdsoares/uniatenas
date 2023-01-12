<!DOCTYPE html>
<html>
<?php $this->load->view('templates/elements/headPrincipal');?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<?php
  $nomeCurtoCampus =  $dados['campus']->shurtName;
  $backgroundPrincipal =  $dados['campus']->backgroundPrincipal;
  $classCSS = 'background-'.$nomeCurtoCampus;
?>
<style>
<?php echo '.background-'.$nomeCurtoCampus ?> {
  background-image: url("<?php echo base_url($backgroundPrincipal); ?>");
}

.botoes {
  margin: 10px;
  padding: 10px 0;
  border: 1px solid #f1f1f1;
  color: #fff;
  text-shadow: #778899 0.1em 0.1em 0.2em;
  font-weight: bold;
  text-align: center;
  border-radius: 10px;
}

div.botoes:hover {
  box-shadow: 0 0 10px 0 #1e4592 inset, 0 0 10px 4px #1e4592;
  color: #000;
  text-shadow: none;
  background: #fff !important;
}

div.homeInicio a {
  border-color: #FFF;
  border-radius: 0;
  color: #FFF;
  overflow: hidden;
  z-index: 1;
}

div.homeInicio a:hover {
  color: #FFF;
}
</style>

<body class="<?php echo $classCSS; ?>">
  <div>
    <div class="img">
      <?php
      if($dados['campus']->id==7 or $dados['campus']->id ==8){

        echo anchor('atenas', '<img src="' . base_url('assets/images/aprincipal/tocha.png') . '" class="img-responsive" style="height:150px"/>');
      }else{
        echo anchor('atenas', '<img src="' . base_url('assets/images/aprincipal/tocha.png') . '" class="img-responsive"/>');
      }
      ?>
    </div>
    <?php 
     if($dados['campus']->id==7 or $dados['campus']->id ==8){
    ?>
    <div class="slogam" style="margin-top:-50px;">

      <?php
        $slogam = $dados['campus']->name . ' - ' . $dados['campus']->city . '(' . $dados['campus']->uf . ')';
        echo $slogam;
      ?>
    </div>
    <?php
     }else{
     ?>
    <div class="slogam">

      <?php
        $slogam = $dados['campus']->name . ' - ' . $dados['campus']->city . '(' . $dados['campus']->uf . ')';
        echo $slogam;
      ?>
    </div>
    <?php 
     }
    ?>

    <div class="container">
      <div class="homeInicio">
        <?php
          echo anchor('atenas', '
              <span>Início - Todos os Campus</span> ', array('class' => "btn"));
          ?>
      </div>
    </div>
    <br />
    <br />
    <div class="container ">
      <div class="row">
        <?php
          foreach($dados['lista_botoes_acesso'] as $botao)
          {
            $linkBotao = isset($botao->arquivo) ? $botao->arquivo: $botao->link_redirecionamento;
            $target = isset($botao->arquivo) ? ('"target"="_blank"') : '';
            echo anchor($linkBotao, '
              <div class="col-sm-3 col-md-2 justify-content-sm-center botoes"
                style="background:'.$botao->cor_hexadecimal.'">
                <div class="card">

                  <div class="card-body text-center">
                    '.toHtml($botao->title).'
                  </div>
                </div>
              </div>
            ', array('class' => 'text-center',$target));
           }
        ?>
      </div>
    </div>


    <div class="container">
      <div class="socialMediaCampus">
        <div class="box" style=" text-align: center">
          <a href="https://www.facebook.com/<?php echo $dados['campus']->facebook; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/facebook2.png') ?>"
              class="iconesocial img-responsive" />
          </a>
          <a href="https://www.instagram.com/<?php echo $dados['campus']->instagram; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/instagram2.png') ?>"
              class="iconesocial img-responsive" />
          </a>

          <a href="https://www.youtube.com/<?php echo $dados['campus']->youtube; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/youtube2.png') ?>"
              class="iconesocial img-responsive" />
          </a>

        </div>
      </div>
    </div>
    <style>
    div.mec-qrcode {
      margin-top: 1rem;
      margin-bottom: 2rem;
      margin-left: auto;
      margin-right: auto;
      text-align: center;
      display: block;
    }

    .mec-qrcode span {
      font-weight: bold;
      color: #fff;

    }

    .selo-campus img {
      width: 140px;
    }
    </style>
    <?php 
    if($dados['campus']->id==7 or $dados['campus']->id ==8 ){
     
      
    ?>
    <div class="container">
      <?php 
    if($dados['campus']->id==8) {
      ?>
      <div class="mec-qrcode">
        <div class="row">
          <?php ?>
          <div class="col-xs-12">
            <span>
              Consulte o cadastro da Instituição no sistema E-MEC
            </span>
          </div>
        </div>
      </div>
      <?php 
    }
       if($dados['campus']->id==7){
        $link1 = "https://emec.mec.gov.br/emec/consulta-cadastro/detalhamento/d96957f455f6405d14c6542552b0f6eb/MjUyMjM=";
        $link2 = "https://emec.mec.gov.br/emec/consulta-cadastro/detalhamento/d96957f455f6405d14c6542552b0f6eb/MjU2MzQ=";
      ?>
      <style>
      .dados-mec {
        margin-top: 10px;
      }

      .div-1 {
        float: left;
        width: 40%;
      }

      .div-1 img,
      .div-3 img {
        width: 170px;
        float: left;
      }

      .div-1 img {
        float: right;
      }

      .div-centro {

        padding: 10px;
        float: left;
        width: 10%;

      }

      .div-3 {

        float: left;
        width: 40%;

      }
      </style>
      <div class="mec-qrcode">
        <div class="dados-mec">
          <div class="div-1">
            <a href="<?php echo $link1?>" target="_blank">
              <img src="<?php echo base_url('assets/images/institucional-qrcodes/mec/7/SeloSorriso.png');?>" alt="E-MEC"
                class="s">
            </a>
          </div>
          <div class="div-centro">
            <span>
              Consulte o cadastro da Instituição no sistema E-MEC
            </span>
          </div>
          <div class="div-3">
            <a href="<?php echo $link2?>" target="_blank">
              <img src="<?php echo base_url('assets/images/institucional-qrcodes/mec/7/SeloSorrisoCentroMT.png');?>"
                alt="E-MEC" class="selo-s">
            </a>
          </div>
        </div>
      </div>
      <?php
      }elseif($dados['campus']->id==8){
        $link3 ="https://emec.mec.gov.br/emec/consulta-cadastro/detalhamento/d96957f455f6405d14c6542552b0f6eb/MjUyMjI=";
        ?>
      <div class="mec-qrcode">
        <div class="row">
          <div class="col-xs-12">
            <a href="<?php echo $link3 ?>" target="_blank">
              <img src="<?php echo base_url('assets/images/institucional-qrcodes/mec/8/SeloPortoSeguro.png');?>"
                alt="E-MEC" class="selo-campus" style="width: 170px;">
            </a>

          </div>
        </div>
        <?php
      
      }
    }
    ?>

        <div class="container" style="display:block; position: absolute;  bottom: 0; margin-left: auto;
      margin-right: auto;
      text-align: center;">
          <footer>
            www.atenas.edu.br<br>
            <?php echo $dados['campus']->phone; ?>
          </footer>
        </div>
      </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

</html>