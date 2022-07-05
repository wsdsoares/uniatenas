<?php
$uricampus = $this->uri->segment(3);
?>
<style>
.single-project-content h2 {
  margin-bottom: 30px;
}

.single-pro-main-content {
  padding-top: 0px;
}

.dados_gerais img {
  float: left;
  margin: 0 30px 15px 0;
}

.imgDescription {
  float: left;
  margin-bottom: 1px;
}

div .classificationDuration {
  width: 200px;
}

.imagemCourseEad img {
  margin-bottom: 10px;
  display: block;
}

.classificationDuration {
  margin-top: 5px;
  border: 5px solid #ffc718;

}

.imgDescription p {
  align-content: center;
  text-align: center;
}
</style>
<?php
echo '<pre>';
//print_r($dados);
echo '</pre>';
?>
<section class="bg-single-project">
  <div class="container">
    <div class="row">
      <div class="single-project">
        <div class="container">
          <div class="row">

            <?php
              if ($msg = getMsg()){
                echo $msg;
              }
              ?>
            <div class="col-md-9 col-sm-10">

              <div class="single-project-content">
                <?php
                if (!empty($conteudoPag->description)) {
                ?>
                <h2 class="text-center"><?php echo $curso->name; ?></h2>
                <div class="dados_gerais text-justify">
                  <div class="imgDescription" style="float:left;">

                    <div class="">
                      <div class="imagemCourseEad">
                        <img src="<?php echo base_url() . $curso->imagem; ?>" alt="courses" class="img-responsive" />
                      </div>
                    </div>
                    <h4>Duração</h4>
                    <p class="classificationDuration ">

                      <span><?php echo $conteudoPag->duration; ?></span>
                    </p>
                  </div>
                  <div class="descriptionCourse">
                    <?php echo $conteudoPag->description; ?>
                  </div>
                </div>

                <?php
                if (!empty($conteudoPag->actuation)) {

                    ?>
                <h2>Áreas de Atuação</h2>
                <div class="icon-box wow fadeInUp">
                  <div class="text-uppercase">

                    <div class="col-sm-5">
                      <h4 class="title">
                        <?php

                        $string = $conteudoPag->actuation;
                        $dadosC = explode('<p>', $string);
                        $qtdeAction = count($dadosC);

                        for ($i = 0; $i < ($qtdeAction / 2); $i++) {
                            echo "<p>$dadosC[$i]</p>";
                        }
                        ?>
                      </h4>
                    </div>
                    <div class="col-sm-5">
                      <h4 class="title">
                        <?php
                        for ($i; $i < $qtdeAction; $i++) {
                            echo "<p>$dadosC[$i]</p>";
                        }
                        ?>
                      </h4>
                    </div>
                  </div>
                </div>
                <?php
                }
              }
              ?>


              </div>
            </div>
            <div class="col-md-3 col-sm-2">
              <div class="single-right-content">
                <div class="download-option">
                  <h4>Venha para o UniAtenas</h4>
                  <!--?php
                                    echo anchor("graduacao/inscricaoEad/$curso->types/$curso->id", '
                                    INSCREVA-SE
                                    <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>', array('class' => "download-btn"));
                                    ?-->
                  <?php
                  
                  if(isset($dados['informacoesCurso']->link_vestibular) and $dados['informacoesCurso']->link_vestibular !='' ){
                    ?>
                  <a href="<?php echo $dados['informacoesCurso']->link_vestibular ?>" class="download-btn">
                    VESTIBULAR ONLINE <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                  </a>
                  <?php
                  }
                  ?>
                </div>
                <div class="contact-quick">
                  <h4>Contatos</h4>
                  <div class="text">
                    <p>
                      Agora você pode fazer a graduação que tanto desejou, sem sair de casa<br>
                      Venha se qualificar agora mesmo, em uma das melhores instituições do
                      país.<br>
                    </p>
                  </div>
                  <ul>
                    <li><span>Canais de Atendimento</span></li>
                    <li><i class="fa fa-phone"></i>Telefone:(38) 3672-3737</li>
                    <li><i class="fa fa-envelope"></i><a href="#">copeve@atenas.edu.br</a></li>
                    <li><i class="fa fa-whatsapp"></i><a href="#">(38)9.9805-9502</a></li>
                  </ul>
                  <!--?php
                                    echo anchor("graduacao/inscricaoEad/$uricampus/$curso->types/$curso->id", '
                                    INSCREVA-SE
                                    <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>', array('class' => "download-btn"));
                                    ?-->
                  <?php
                  if(isset($dados['informacoesCurso']->link_vestibular) and $dados['informacoesCurso']->link_vestibular !='' ){
                    ?>
                  <a href="<?php echo $dados['informacoesCurso']->link_vestibular ?>" class="download-btn">
                    VESTIBULAR ONLINE <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                  </a>

                  <?php
                  }
                  ?>

                </div>

              </div>
            </div>
          </div>
        </div>
        <div id="services">
          <?php
                    if (!empty($dados['gradeCurricular'])) {
                        ?>
          <div class="container wow fadeIn">
            <div class="section-header">
              <h3 class="section-title">Grade Curricular</h3>
              <p class="section-description">Visualize abaixo, os conteúdos que serão
                estudados no curso.</p>
            </div>
            <div class="row">
              <div class="col-sm-9">
                <?php
                                    $i = 0;
                                    foreach ($dados['cursoPeriodos'] as $periodos) {
                                        ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo $i; ?>s">
                  <div class="box">
                    <div class="icon"><a href=""><i class="fa fa-book"></i></a>
                    </div>
                    <h4 class="title"><?php
                                                    if ($dados['informacoesCurso']->id == 8) {
                                                        if ($periodos->period == 9 or $periodos->period == 11) {

                                                            if ($periodos->period == 9) {
                                                                echo "9º e 10";
                                                            } elseif ($periodos->period == 11) {
                                                                echo "11º e 12";
                                                            }
                                                        } else {
                                                            echo $periodos->period;
                                                        }
                                                    } else {
                                                        echo $periodos->period;
                                                    }
                                                    ?>º Período</h4>
                    <p>
                      <?php
                                                    foreach ($dados['gradeCurricular'] as $disciplina)
                                                    if ($periodos->period == $disciplina->period) {
                                                    ?>
                    <p>
                      <i class="fas fa-caret-right"></i>
                      <?php
                                                    echo $disciplina->discipline;
                                                    ?>
                    </p>
                    <?php
                                                }
                                                ?>

                    </p>
                    <div class="text-center">
                      <?php
                                                    echo anchor("graduacao/inscricaoEad/$uricampus/$curso->types/$curso->id", '
                                                                INSCREVA-SE
                                                                <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>', array('class' => "download-btn"));
                                                    ?>

                    </div>

                  </div>
                </div>
                <?php
                                        $i = $i + 2;
                                    }
                                    ?>
              </div>
              <div class="col-sm-12">
                <?php
                                    if (empty($dados['informacoesCurso']->filesGrid)) {
                                    ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                  <div class="boxcoordenador boxitens" style="height: 100px;">
                    <div class="icon">
                      <a href="<?php echo base_url($dados['informacoesCurso']->filesGrid); ?>" target="_blank"><i
                          class="fas fa-file-alt"></i></a>
                    </div>
                    <h4 class="title">
                      <a href="<?php echo base_url($dados['informacoesCurso']->filesGrid); ?>" target="_blank">Arquivo -
                        Grade Curricular</a>
                    </h4>
                    <a href="<?php echo base_url($dados['informacoesCurso']->filesGrid); ?>" target="_blank">
                      <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
                    </a>
                  </div>
                </div>
                <?php } }?>
                <?php
                                    if (!empty($dados['informacoesCurso']->recognition)) {
                                    ?>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                  <div class="boxcoordenador boxitens" <a
                    href="<?php echo base_url($dados['informacoesCurso']->recognition); ?>" target="_blank"></a>
                    <div class="icon">
                      <a href="<?php echo base_url($dados['informacoesCurso']->recognition); ?>" target="_blank"><i
                          class="fas fa-gavel"></i></a>
                    </div>
                    <h4 class="title">
                      <a href="<?php echo base_url($dados['informacoesCurso']->recognition); ?>" target="_blank">Ato de
                        Autorização / Reconhecimento</a>
                    </h4>
                    <a href="<?php echo base_url($dados['informacoesCurso']->recognition); ?>" target="_blank">
                      <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
                    </a>
                  </div>
                </div>
                <?php }?>
                <?php
                                foreach ($dados['dirigentes'] as $row) {
                                    ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                  <div class="boxcoordenador boxitens">
                    <div class="icon"><a><i class="fas fa-graduation-cap"></i></a></div>
                    <?php if(empty($row->nome) || $row->nome == null):?>
                    <h4 class="title">Contato</h4>
                    <?php else: ?>
                    <h4 class="title"><?php echo $row->cargo; ?></h4>
                    <?php endif; ?>
                    <h4>
                      <?php
                                                echo $row->nome;
                                                ?>

                      <?php
                                                echo $row->email;
                                                ?>
                      <?php if (!empty($dados['dadosCurso']['contatos']->phone)): ?>
                      <br>
                      Celular: <?php echo $dados['dadosCurso']['contatos']->phone; ?>
                      <?php endif; ?>
                      <br>
                      Telefone: <?php echo $campus->phone; ?>
                      <?php if (!empty($dados['dadosCurso']['contatos']->ramal)): ?>
                      <br>
                      Ramal: <?php echo $dados['dadosCurso']['contatos']->ramal; ?>
                      <?php endif; ?>
                    </h4>

                  </div>
                </div>
                <?php
                                }
                                ?>
                <?php

                                /*foreach ($informacoesCurso->['dirigentes'] as $row) {
                                    ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                  <div class="boxcoordenador boxitens">
                    <div class="icon"><a><i class="fas fa-graduation-cap"></i></a></div>

                    <h4 class="title"><?php echo $row->cargo; ?></h4>
                    <h4>
                      <?php
                                                echo $row->nome;
                                                ?>

                      <?php
                                                echo $row->email;
                                                ?>

                    </h4>

                  </div>
                </div>
                <?php
                                }*/
                                ?>
                <?php
                                if (!empty($dados['gradeCurricular'])) {
                                    ?>
                <div class="col-sm-12 col-md-12 text-center">
                  <?php
                                    echo anchor('', 'Inscreva-se agora!', array('class' => "btn btns btn-lg"));
                                    ?>
                </div>
              </div>
            </div>
            <?php
                    }
                    ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<link href="<?php echo base_url('assets/Regna/'); ?>lib/animate/animate.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/Regna/'); ?>css/style.css" rel="stylesheet">