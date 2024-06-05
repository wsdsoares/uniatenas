<style>
    text.Orange-label {
        color: Orange;
    }
</style>
<section class="body-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="section-header">
                    <h3 class="text-center"><?php echo $conteudoPag[0]->title; ?></h3>
                </div>

                <div role="tabpanel">
                    <div class="col-sm-3">
                        <a class="list-group-item active"></a>
                        <ul class="nav nav-pills brand-pills nav-stacked sidebarList" role="tabpanel">
                            <li role="presentation" class="brand-nav active">
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><i class="fas fa-home"></i>Estágios e Convênios</a>
                            </li>
                            <?php

                            if (!empty($dadosEstagio['vagasEstagio'])) {
                            ?>
                                <li role="presentation" class="brand-nav">
                                    <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Oportunidade de Estágios</a>
                                </li>
                            <?php
                            }
                            ?>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab3" aria-controls="tab4" role="tab" data-toggle="tab">Modalidades de Estágio</a>
                            </li>
                            <li role="presentation" class="brand-nav">

                                <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Guia do estágio</a>
                            </li>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab5" aria-controls="tab4" role="tab" data-toggle="tab">Instituições Convêniadas</a>
                            </li>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab6" aria-controls="tab4" role="tab" data-toggle="tab">Documentos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <div class="row">
                                    <div class="estagiosConvenios">
                                        <?php echo $conteudoPag[0]->description; ?>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <script>
                                    $(document).ready(function() {
                                        $('#vagasEstagio').DataTable({
                                            "language": {
                                                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                                            }
                                        });
                                    });
                                </script>

                                <p>
                                    Visualize aqui as oportunidades de estágio.
                                </p>
                                <br>
                                <br>
                                <?php
                                //if (!empty($dadosEstagio['vagasEstagio'])) {
                                ?>
                                <table id="vagasEstagio" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Estágio</th>
                                            <th>Atividades</th>
                                            <th>Edital</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($dadosEstagio['vagasEstagio'] as $vagasEstagio) {
                                        ?>
                                            <tr>
                                                <td><?php echo $vagasEstagio->title; ?></td>
                                                <td><?php echo $vagasEstagio->activities; ?></td>
                                                <td><?php echo $vagasEstagio->files; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                /* }else{

                                 }*/
                                ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab3">
                                <?php print_r($dados['conteudo'][0]->description); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab4">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="col-xs-4">
                                            <div class="card text-center boxSite">
                                                <?php
                                                echo anchor(base_url('assets/files/estagioeconvenios/Guia do estagio_UniAtenas.pdf'), '
                                                             
                                            <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                                            </br>
                                            </br>
                                            <p>Guia do estágio</p>
                                            ');
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab5">


                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <!--<th>Cidade</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($dadosEstagio['empresas'] as $empresas) {
                                        ?>
                                            <tr>
                                                <td><?php echo $empresas->namecompany; ?></td>
                                                <!--<td><? php // echo $empresas->namecity; 
                                                        ?></td>-->
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                        </tfoot>
                                </table>

                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab6">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/files/estagioeconvenios/Orientacoes de preenchimento do TCE e plano de Atividades.pdf'), '
                                               
                                            <i class="fas fa-file-pdf fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Orientações de preenchimento do termo de compromisso</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/files/estagioeconvenios/documentos/01- Plano de Atividades.xlsx'), '
                                               
                                            <i class="fas fa-file-excel fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Plano de atividades</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/req/EstagionaoObrigatorio2021.docx'), '
                                               
                                            <i class="fas fa-file-word fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Termo de compromisso de Estágio Não Obrigatório</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/req/EstagioObrigatorio2021.docx'), '
                                               
                                            <i class="fas fa-file-word fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Termo de compromisso de Estágio Obrigatório</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/files/estagioeconvenios/documentos/03 - Controle de Frequencia.xlsx'), '
                                               
                                            <i class="fas fa-file-excel fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Controle de Frequência</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/files/estagioeconvenios/documentos/04 - Relatorio Semestral.xlsx'), '
                                               
                                            <i class="fas fa-file-excel fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Relatório Semestral</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/files/estagioeconvenios/documentos/05 - Relatorio Final de Estagio.doc'), '
                                               
                                            <i class="fas fa-file-word fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Relatório Final de Estágio</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-xs-6">
                                        <div class="card text-center boxSite">
                                            <?php
                                            echo anchor(base_url('assets/req/RESCISAODEESTAGIOMODELO.docx'), '
                                               
                                            <i class="fas fa-file-word fa-3x" id="icon-color" aria-hidden="true"></i>
                                            <p>Rescisão Contratual</p>
                                            ', array('target' => '_blank'));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab7">

                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <?php
            if ($campus->id == 1) {
            ?>
                <div class="col-lg-4 col-xs-6">
                    <?php if (!empty($contatos)) : ?>
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
                                            <?php foreach ($contatos as $phone) : ?>
                                                <small>
                                                    <div class=" ">
                                                        <?php if ($phone->email != "" || $phone->email != null) : ?>
                                                            <p>
                                                                <label>E-mail:</label>
                                                            <p>
                                                                <text class="Orange-label"><?= $phone->email ?></text>
                                                            </p>
                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if ($phone->phonesetor != "" || $phone->phonesetor != null) : ?>
                                                            <p class="Orange-label">
                                                                <label>Telefone: </label>
                                                                <text class="Orange-label"><?= $phone->phonesetor ?></text>
                                                            </p>
                                                        <?php endif; ?>
                                                        <p>
                                                            <label>Telefone: </label>
                                                            <text class="Orange-label"><?= $campus->phone; ?></text>
                                                        </p>
                                                        <?php if ($phone->ramal != "" || $phone->ramal != null) : ?>
                                                            <p>
                                                                <label>Ramal: </label>
                                                                <text class="Orange-label"><?= $phone->ramal; ?></text>
                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if ($phone->phone != "" || $phone->phone != null) : ?>
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
                        <h2 class="title-widget-sidebar"><?php echo $dados['conteudo'][3]->title; ?></h2>
                        <div class="content-widget-sidebar">
                            <ul>
                                <li class="recent-post-alunos">
                                    <div class="col-sm-3 col-xs-4">
                                        <a target="_blank" href="https://www.google.com.br/search?client=opera&hs=06a&sxsrf=ACYBGNRKHKySOw3joRpwnxcy8geUv-HM6Q:1569440790185&q=Rua%20Euridamas%20Avelino%20de%20Barros%2C%20n%C2%BA%2060%20%E2%80%93%20Lavrado%2C%20Paracatu%2FMG.&sa=X&ved=2ahUKEwiR2q3G3uzkAhXOEbkGHR6xD60QvS4wAHoECAoQEg&biw=1320&bih=658&dpr=1&npsic=0&rflfq=1&rlha=0&rllag=-17228203,-46888900,656&tbm=lcl&rldimm=17283646869125714587&rldoc=1&tbs=lrf:!2m1!1e2!3sIAE,lf:1,lf_ui:2#rlfi=hd:;si:7210518833530095322;mv:[[-17.2249028,-46.8805074],[-17.2304849,-46.8955299]]">
                                            <div class="ico-wrap">
                                                <i class="fas fa-map-marked-alt fa-2x"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-9 col-xs-8 ">
                                        <small>
                                            <div class=" "><?php echo $dados['conteudo'][3]->description; ?></div>
                                        </small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>