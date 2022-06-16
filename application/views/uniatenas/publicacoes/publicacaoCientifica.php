<?php
$uricampus = $this->uri->segment(3);
?>
<section class="services-section p-b-70">
    <div class="container">
        <div class="dados_gerais">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h3>
                              <?php echo $revistas->titulo; ?> - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="services-option">
                <div class="btn-back">
                    <?php echo anchor("iniciacaoCientifica/revista_cientifica/$uricampus/$revistas->id", '
                    Voltar', array('class' => "btn btn-danger"));
                    ?>
                </div>
                <br>
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Titulo</th>
                                <th scope="col">Informações</th>
                                <th scope="col">Visualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($publicacoes as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row->title; ?></td>
                                    <td><?php echo "VOL.:" . $row->volume . " - N" . $row->number_vol . '<br/> Ano - ' . $row->year; ?></td>
                                    <td><?php echo anchor($row->files, 'Acessar', array('class' => 'btn btn-info','target'=>'blank')); ?></td>

                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
            <!-- .our-services-option -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</section>



