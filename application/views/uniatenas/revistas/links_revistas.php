

<section class="services-section p-b-70" >
    <div class="container">

        <div class="section-revistas text-center">
            <h2>Revistas e Periódicos</h2>
            <h3><?php echo $area->title; ?></h3>
            <span class="double-border"></span>
        </div>
        <div class="btn-back">
            <?php echo anchor('site/revistas_periodicos', '
            Voltar', array('class' => "btn btn-danger"));
            ?>
        </div>

        <div class="row">
            <div class="list-itens-magazines">

                <?php
                $quantidade = count($areaslinks);

                $cont = intval($quantidade / 2);
                ?>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Revista</th>
                                <th scope="col">Acesso/Link</th>
                                <th scope="col">Classificação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $cont; $i++) {
                                ?>
                                <tr>
                                    <td><?php echo $areaslinks[$i]->title; ?></td>
                                    <td><?php echo anchor('', 'Acessar', array('class' => 'btn btn-info')); ?></td>
                                    <td><?php
                                        
                                        if ($areaslinks[$i]->classification == 'nenhum') {
                                            echo '--';
                                        } else {
                                            echo strtoupper($areaslinks[$i]->classification);
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Revista</th>
                                <th scope="col">Acesso/Link</th>
                                <th scope="col">Classificação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = $cont; $i < $quantidade; $i++) {
                                ?>
                                <tr>
                                    <td><?php echo $areaslinks[$i]->title; ?></td>
                                    <td><?php echo anchor($areaslinks[$i]->link, 'Acessar', array('class' => 'btn btn-info')); ?></td>
                                    <td><?php
                                        
                                        if ($areaslinks[$i]->classification == 'nenhum') {
                                            echo '--';
                                        } else {
                                            echo strtoupper($areaslinks[$i]->classification);
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>






