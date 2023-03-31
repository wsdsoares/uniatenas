<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
section.comutacaoBibliografica {
  padding-top: 4rem;
  padding-bottom: 5rem;
  background-color: #f1f4fa;
}

.wrap {
  display: flex;
  background: white;
  padding: 1rem 1rem 1rem 1rem;
  border-radius: 0.5rem;
  box-shadow: 7px 7px 30px -5px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
  min-height: 110px;
}

.wrap:hover {
  background: linear-gradient(100deg, #ece0d9 0%, #edb492 100%);
  color: #fff;
}

.ico-wrap {
  margin: auto;
}

.mbr-iconfont {
  font-size: 4.5rem !important;
  color: #313131;
  margin: 1rem;
  padding-right: 1rem;
}

.vcenter {
  margin: auto;
}

.mbr-section-title3 {
  text-align: left;
}

h2.mbr-fonts-style {
  margin-top: 0.5rem;
  margin-bottom: 0.5rem;
}

.display-5 {
  font-family: 'Source Sans Pro', sans-serif;
  font-size: 1.4rem;
}

.mbr-bold {
  font-weight: 700;
}

p {
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  line-height: 25px;
}

.display-6 {
  font-family: 'Source Sans Pro', sans-serif;
}

text.Orange-label {
  color: Orange;
}
</style>
<style>
.transition-timer-carousel .carousel-caption {
  background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
  /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(4%, rgba(0, 0, 0, 0.1)), color-stop(32%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 1)));
  /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
  /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
  /* Opera 11.10+ */
  background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
  /* IE10+ */
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
  /* W3C */
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#000000', GradientType=0);
  /* IE6-9 */
  width: 100%;
  left: 0px;
  right: 0px;
  bottom: 0px;
  text-align: left;
  padding-top: 5px;
  padding-left: 15%;
  padding-right: 15%;
}

.transition-timer-carousel .carousel-caption .carousel-caption-header {
  margin-top: 10px;
  font-size: 24px;
}

@media (min-width: 970px) {

  /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
  .transition-timer-carousel .carousel-caption .carousel-caption-header {
    font-size: 36px;
  }
}

@media (max-width: 320px) {

  /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
  .transition-timer-carousel .carousel-caption .carousel-caption-header {
    font-size: 18px;
  }
}

.transition-timer-carousel .carousel-indicators {
  bottom: 0px;
  margin-bottom: 5px;
}

.transition-timer-carousel .carousel-control {
  z-index: 11;
}

.transition-timer-carousel .transition-timer-carousel-progress-bar {
  height: 5px;
  background-color: #5cb85c;
  width: 0%;
  margin: -5px 0px 0px 0px;
  border: none;
  z-index: 11;
  position: relative;
}

.transition-timer-carousel .transition-timer-carousel-progress-bar.animate {

  -webkit-transition: width 4.25s linear;
  -moz-transition: width 4.25s linear;
  -o-transition: width 4.25s linear;
  transition: width 4.25s linear;
}
</style>


<?php
$uricampus = $this->uri->segment(3);


if ($campus->id == 1) {
    // $potho = 'assets/images/gallery/library/fotoptu1.png';
    $potho = 'assets/images/gallery/1/biblioteca/4.jpeg';
    $potho2 = 'assets/images/gallery/library/fotoptu2.png';
    $potho3 = 'assets/images/gallery/library/fotoptu3.png';
} elseif ($campus->id == 2) {
    $potho = 'assets/images/gallery/library/2/fotosete1.png';
    $potho2 = 'assets/images/gallery/library/2/fotosete2.png';
    $potho3 = 'assets/images/gallery/library/2/fotosete3.png';
} elseif ($campus->id == 3) {
    $potho = 'assets/images/gallery/library/3/fotopassos1.png';
    $potho2 = 'assets/images/gallery/library/3/fotopassos2.png';
    $potho3 = 'assets/images/gallery/library/3/fotopassos3.png';  

} elseif ($campus->id == 7) {
    $potho = 'assets/imagessorriso/galeriasorriso/biblioteca/1.jpeg';
    $potho2 = 'assets/imagessorriso/galeriasorriso/biblioteca/3.jpeg';
    $potho3 = 'assets/imagessorriso/galeriasorriso/biblioteca/5.jpeg';
}



    
$linkBibliotecaVirtual = 'https://search.ebscohost.com/login.aspx?authtype=ip,uid&custid=ns263130&groupid=main&profile=ehost&user=atenasacesso&password=faculdade23!';    
$linkBookReenew = "http://177.69.195.4/Corpore.Net/Main.aspx?ActionID=BibEmprestimosPendentesActionWeb&SelectedMenuIDKey=ItemEmprestimosRenovacao";
$linkFichaBook = "http://177.69.195.4:8000/web/app/edu/PortalEducacional/";
?>


<div class="container">
  <div class="row">
    <div class="section-header text-center">
      <h3>Biblioteca <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
    </div>
  </div>

  <div class="row">
    <!-- The carousel -->
    <div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">

        <li data-target="#transition-timer-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#transition-timer-carousel" data-slide-to="1"></li>
        <li data-target="#transition-timer-carousel" data-slide-to="1"></li>
        <li data-target="#transition-timer-carousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
          <img src="<?php echo base_url($potho); ?>" style="background-size: cover;  " />
          <div class="carousel-caption">
            <h1 class="carousel-caption-header">Fotos da biblioteca
              - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h1>

          </div>
        </div>

        <div class="item">
          <img src="<?php echo base_url($potho2); ?>" style="background-size: cover;  " />
          <div class="carousel-caption">
            <h1 class="carousel-caption-header">Fotos da biblioteca
              - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h1>

          </div>
        </div>

        <div class="item">
          <img src="<?php echo base_url($potho3); ?>" style="background-size: cover;  " />
          <div class="carousel-caption">
            <h1 class="carousel-caption-header">Fotos da biblioteca
              - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h1>

          </div>
        </div>
      </div>

      <a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
      <hr class="transition-timer-carousel-progress-bar animate" />
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="container">
      <div class="section-header text-center">
        <!-- <h3>Sobre a Biblioteca</h3> -->
        <h3> <?php echo $dados['conteudoPag'][0]->title; ?></h3>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div class="col-xs-12">
              <div class="information-library-campus text-justify">
                <p>
                  <?php echo $dados['conteudoPag'][0]->description; ?>
                </p>
              </div>
            </div>
            <hr>
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12 text-center">
                  <div class="boxLibrary">
                    <h3 class="text-center">Revistas / Periódicos</h3>
                    <div class="boxLibrary-content">
                      <hr />
                      <!-- Achar a informação antiga que estava na pagina-->
                      <!--p><?php echo $dados['conteudoPag'][1]->description; ?></p-->
                      <br />
                      <div class="btnAcessMagazinesLinks">
                        <?php echo anchor('site/revistas_periodicos/' . $uricampus, 'Acessar', array('class' => "btn btn-primary")); ?>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <?php
        echo '<pre>';
        print_r($conteudoPag);
        print_r($contatos);
        echo '</pre>';
        ?> -->
        <div class="col-lg-4">
          <?php if (!empty($contatos)): ?>
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar">Contatos</h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-2 col-xs-2">
                    <i class="far fa-address-card fa-2x"></i>
                    </a>
                  </div>

                  <div class="col-sm-10 col-xs-10 ">
                    <?php foreach ($contatos as $phone): ?>
                    <small>
                      <div class=" ">
                        <?php if ($phone->email != "" || $phone->email != null): ?>
                        <p>
                          <label>E-mail:</label>
                        <p>
                          <text class="Orange-label"><?= $phone->email ?></text>
                        </p>
                        </p>
                        <?php endif; ?>
                        <?php if ($phone->phonesetor != "" || $phone->phonesetor != null): ?>
                        <p class="Orange-label">
                          <label>Telefone: </label>
                          <text class="Orange-label"><?= $phone->phonesetor ?></text>
                        </p>
                        <?php endif; ?>
                        <!--p>
                                                            <label>Telefone: </label>
                                                            <text class="Orange-label"><?= $campus->phone; ?></text>
                                                        </p-->
                        <?php if ($phone->ramal != "" || $phone->ramal != null): ?>
                        <p>
                          <label>Ramal: </label>
                          <text class="Orange-label"><?= $phone->ramal; ?></text>
                        </p>
                        <?php endif; ?>
                        <?php if ($phone->phone != "" || $phone->phone != null): ?>
                        <p>
                          <label>Cel. Corporativo:</label>
                          <text class="Orange-label"><?= $phone->phone; ?></text>
                        </p>
                        <?php endif; ?>
                      </div>
                    </small>
                    <?php
                                            endforeach;
                                            ?>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <?php endif; ?>
          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar">#LINKS UTEIS</h2>
            <div class="content-widget-sidebar">
              <ul>
                <li class="recent-post-alunos">
                  <div class="col-sm-3 col-xs-4">
                    <a target="_blank" href="<?php echo $linkBookReenew; ?>">
                      <div class="ico-wrap">
                        <span class="mbr-iconfont fa-book fa"></span>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-9 col-xs-8">
                    <a target="_blank" href="<?php echo $linkBookReenew ?>">
                      <h4>Renovação Livros</h4>
                    </a>
                    <p>
                      <small><i target="_blank" class="fa fa-pager" data-original-title="" title=""></i>
                        Renovação de Livros -
                        TOTVS <?php echo $campus->name . '. ' . $campus->city; ?>
                      </small>
                    </p>
                  </div>
                </li>
                <li class="recent-post-alunos">
                  <div class="col-sm-3 col-xs-4">
                    <a target="_blank" href="<?php echo $linkBibliotecaVirtual; ?>">
                      <div class="ico-wrap">
                        <span class="mbr-iconfont fa-desktop fa"></span>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-9 col-xs-8">
                    <a target="_blank" href="<?php echo $linkBibliotecaVirtual ?>">
                      <h4>Biblioteca Virtual</h4>
                    </a>
                    <p>
                      <small><i target="_blank" class="fa fa-pager" data-original-title="" title=""></i>
                        Biblioteca Virutal
                        - <?php echo $campus->name . '. ' . $campus->city; ?>
                      </small>
                    </p>
                  </div>
                </li>
                <?php
                                if ($campus->id == 1) {
                                    ?>
                <li class="recent-post-alunos">
                  <div class="col-sm-3 col-xs-4">
                    <a target="_blank" href="<?php echo $linkBookReenew; ?>">
                      <div class="ico-wrap">
                        <span class="mbr-iconfont fa-address-book fa"></span>
                      </div>
                    </a>
                  </div>

                  <div class="col-sm-9 col-xs-8">
                    <a target="_blank" href="<?php echo $linkFichaBook ?>">
                      <h4>Ficha Catalográfica</h4>
                    </a>
                    <p>
                      <small><i target="_blank" class="fa fa-pager" data-original-title="" title=""></i>
                        Ficha Catalográfica -
                        <?php echo $campus->name . '. ' . $campus->city; ?>
                      </small>
                    </p>

                  </div>
                </li>
                <?php
                  }
                  ?>
                <br />
              </ul>
            </div>
          </div>

          <div class="widget-sidebar">
            <h2 class="title-widget-sidebar">Acesso rápido</h2>
            <div class="last-post-aluno">
              <a target="_blank" href="http://www.periodicos.capes.gov.br/" class="accordionAluno">Periódicos Capes</a>
            </div>
            <hr>

            <div class="last-post-aluno">
              <a target="_blank" href="https://scholar.google.com/" class="accordionAluno">Google
                Acadêmico</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br />
<br />
<section class="comutacaoBibliografica">
  <div class="container">

    <div class="row mbr-justify-content-center">
      <div class="container">
        <div class="section-header text-center">
          <h3>Comutação
            Bibliográfica <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
      </div>
      <div class="container">
        <div class="text">
          <p>
            Serviço de solicitação de artigos de periódicos, capítulos de livros, dissertações,
            teses e
            anais de congressos que não constam no acervo da
            biblioteca <?php //echo //$fragmtext; ?>. Esse serviço permite
            aos usuários o acesso a documentos, localizados nas principais bibliotecas do País,
            em todas as
            áreas do conhecimento.
          </p>
        </div>
      </div>
      <div class="col-lg-4 mbr-col-md-10">
        <a target="_blank" href="http://bvsalud.org/">
          <div class="wrap">
            <div class="ico-wrap">
              <span class="mbr-iconfont fa-link fa"></span>
            </div>
            <div class="text-wrap vcenter">
              <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5">
                <span>BIREME</span>
              </h2>
              <p class="mbr-fonts-style text1 mbr-text display-6">Centro Latino e Americano de
                Informação
                em Ciências da Saúde</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 mbr-col-md-10">
        <a target="_blank" href="<?php echo $linkBibliotecaVirtual ?>">
          <div class="wrap">
            <div class="ico-wrap">
              <span class="mbr-iconfont fa-pager fa"></span>
            </div>
            <div class="text-wrap vcenter">
              <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5"><span>EBSCOHOST</span>
              </h2>
              <p class="mbr-fonts-style text1 mbr-text display-6">A EBSCOHOST é um poderoso
                sistema de
                referência on-line</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-4 mbr-col-md-10">
        <a target="_blank" href="https://scielo.org/">
          <div class="wrap">
            <div class="ico-wrap">
              <span class="mbr-iconfont fa-book fa"></span>
            </div>
            <div class="text-wrap vcenter">
              <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5">
                <span>SCIELO</span>
              </h2>
              <p class="mbr-fonts-style text1 mbr-text display-6">Biblioteca Eletrônica
                Científica -
                Online</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-6 mbr-col-md-10">
        <a target="_blank" href="http://comut.ibict.br/comut/do/index?op=filtroForm">
          <div class="wrap">
            <div class="ico-wrap">
              <span class="mbr-iconfont fa-calendar fa"></span>
            </div>
            <div class="text-wrap vcenter">
              <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5">
                <span>COMUT</span>
              </h2>
              <p class="mbr-fonts-style text1 mbr-text display-6">Programa de Comutação
                Bibliográfica.
                Programa conjunto do IBICT / Finep / Capes / SESu que tem como objetivo
                facilitar o
                acesso à informação nas diversas áreas do conhecimento</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-6 mbr-col-md-10">
        <a target="_blank" href="http://www.ibict.br/">
          <div class="wrap">
            <div class="ico-wrap">
              <span class="mbr-iconfont fa-globe fa"></span>
            </div>
            <div class="text-wrap vcenter">
              <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5">
                <span>IBICT</span>
              </h2>
              <p class="mbr-fonts-style text1 mbr-text display-6">Instituto Brasileiro de
                Informação em
                Ciência e Tecnologia tem como perspectiva facilitar o acesso de todos os
                cidadãos
                brasileiros a informações produzidas no país e exterior</p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
<script>
$(document).ready(function() {
  //Events that reset and restart the timer animation when the slides change
  $("#transition-timer-carousel").on("slide.bs.carousel", function(event) {
    //The animate class gets removed so that it jumps straight back to 0%
    $(".transition-timer-carousel-progress-bar", this)
      .removeClass("animate").css("width", "0%");
  }).on("slid.bs.carousel", function(event) {
    //The slide transition finished, so re-add the animate class so that
    //the timer bar takes time to fill up
    $(".transition-timer-carousel-progress-bar", this)
      .addClass("animate").css("width", "100%");
  });

  //Kick off the initial slide animation when the document is ready
  $(".transition-timer-carousel-progress-bar", "#transition-timer-carousel")
    .css("width", "100%");
});
</script>