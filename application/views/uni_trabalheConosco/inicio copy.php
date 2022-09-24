<?php
$uricampus = $this->uri->segment(3);
?>
<div class="dados_gerais">
    <div class="container">
        <h2 class="text-center"><?php echo $conteudoPag[0]->title . ' - ' . $campus->name . ' - ' . $campus->city; ?></h2>
        <div class="row">

            <div class="col-sm-6 text-justify">
                <?php
                echo $conteudoPag[0]->description;
                if ($campus->id == 1) {
                    ?>
                    <img src="<?php echo base_url('assets/images/services/trabalhe-conosco-01.jpg'); ?>"
                         class="img-responsive" style="max-width: 350px;float: left; margin-right: 10px;"/>
                    <?php
                } else {
                    ?>
                    <div class="row">
                        <div class="text-center">
                            <h4><?php echo $conteudoPag[1]->title;?></h4>
                        </div>
                        <div class="text">
                            <p><?php echo $conteudoPag[1]->description;?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <style>
                .panelResume {
                    background: #16A085;
                }

                .panelResume span {
                    color: #000;
                    font-weight: bold;
                }
            </style>
            <br/>
            <br/>
            <br/>
            <?php if ($uricampus == "paracatu"):?>
            <div class="col-sm-offset-2 col-sm-4">
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
                                        <small>
                                            <div class=" ">
                                                <p>
                                                    <label>Telefone: (38) 3672-3737</label><br>
                                                    <text class="Orange-label"> </text>
                                                </p>
                                                    <p>
                                                        <label>Ramal: </label>
                                                        <text class="Orange-label">1020</text>
                                                    </p>
                                            </div>
                                        </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="col-sm-offset-2 col-sm-4">
                <div class="panelResume">
                    <div class="panel-heading">
                        <div class="text-center">
                            <span>Enviar Curriculo</span>
                        </div>
                    </div>
                    <div class="col-xs-12 panelsite">
                        <p>Você pode fazer o cadastro do seu currículo em nosso banco de talentos.</p>
                        <p class="text-center">
                            <?php
                            //O atributo currículo 1 vem da VAGA - Currículo geral, que pode ser enviado sem necessáriamente ter uma vaga.
                            $curriculoAvulso = 1;
                            echo anchor("site/envioCurriculo/$uricampus/$curriculoAvulso", 'Enviar Currículo', array('class' => 'btnEdital'));
                            //echo anchor("http://177.69.195.4:8000/RM/Rhu-BancoTalentos/#/RM/Rhu-BancoTalentos/home", 'Enviar Currículo', array('class' => 'btnEdital',"target"=>'_blank')); ?>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<section class="bg-trabalhe-conosco">
    <div class="container">
        <div class="row">
            <div class="single-events">
                <div class="row">
                    <?php
                    if ($msg = getMsg()):
                        echo $msg;
                    endif;
                    ?>
                    <!--div class="col-sm-8">
                        <div class="sidebar">
                            <div class="widget">
                                <h4 class="sidebar-widget-title">VAGAS ABERTAS <p><small>Inscreva-se / Edital</small></p></h4>
                                <div class="widget-content">
                                    <ul class="catagories">
                                        <?php
                    foreach ($vagasAbertas as $item) {
                        ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">

                                                        <?php
                        echo anchor(base_url() . $item->files, '<i class="fa fa-angle-double-right" aria-hidden="true"></i><span> ' . $item->name . '</span>', array('target' => '_blank'));
                        ?>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            <div class="col-md-6 col-sm-12">
                                                                <?php
                        echo anchor(base_url() . $item->files, '
                                                                    <span class="btnEdital">Edital</span></a>', array('target' => '_blank')
                        );
                        ?>

                                                            </div>
                                                            <div class="col-md-6 col-sm-12">
                                                                <?php
                        echo anchor('site/envioCurriculo/' . $uricampus . '/' . $item->id, '<span class="btns">Inscreva-se</span>')
                        ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                    }
                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div-->

                </div>
            </div>
        </div>
    </div>
</section>