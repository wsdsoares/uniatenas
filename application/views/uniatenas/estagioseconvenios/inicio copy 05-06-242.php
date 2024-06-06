<style>
    text.Orange-label {
        color: Orange;
    }

    .estagiosConvenios>p {
        text-align: justify !important;
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
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><i class="fas fa-home"></i>
                                    Estágios e Convênios</a>
                            </li>
                            <?php

                            if (!empty($dadosEstagio['vagasEstagio'])) {
                            ?>
                                <li role="presentation" class="brand-nav">
                                    <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Oportunidade de
                                        Estágios</a>
                                </li>
                            <?php
                            }
                            ?>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab3" aria-controls="tab4" role="tab" data-toggle="tab">Modalidades de
                                    Estágio</a>
                            </li>
                            <li role="presentation" class="brand-nav">

                                <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Guia do estágio</a>
                            </li>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab5" aria-controls="tab4" role="tab" data-toggle="tab">Instituições
                                    Convêniadas</a>
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
            <div class="col-md-3">
                <?php
                if (!empty($dados['contatosPagina'])) {
                ?>
                    <div class="widget-sidebar">
                        <h2 class="title-widget-sidebar">Contatos</h2>
                        <div class="content-widget-sidebar">
                            <ul>
                                <li class="recent-post-alunos">
                                    <div class="col-sm-2 col-xs-2">
                                        <i class="far fa-address-card fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 ">
                                        <?php
                                        // foreach ($contatos as $phone){
                                        foreach ($contatosPagina as $informacoesContato) {
                                        ?>
                                            <small>
                                                <?php
                                                echo $informacoesContato->description;
                                                ?>
                                            </small>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>