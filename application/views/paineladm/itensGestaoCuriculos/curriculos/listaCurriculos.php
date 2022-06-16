<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Currículos Recebidos
                </h2>
            </div>

            <!--div class="register">
                    <?php
            echo anchor('TrabalheConosco/cadastrarVagas', '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>

                </div-->


            <div class="body">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                        <tr>
                            <th>Ações</th>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Email - Curriculo</th>
                            <th>Telefone/Whatsapp</th>
                            <th>Vaga</th>
                            <th>Data Currículo</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Ações</th>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Email - Curriculo</th>
                            <th>Telefone/Whatsapp</th>
                            <th>Vaga</th>
                            <th>Data Currículo</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        foreach ($resumeRecived as $item) {
                            ?>
                            <tr>
                                <td class="center">

                                    <?php

                                    echo '<a href="#">'
                                        . '<i class="material-icons">edit</i>'
                                        . '</a> ';
                                    /* . '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                                      . '<i class="material-icons">delete</i>'
                                      . '</a>'; */
                                    ?>
                                </td>

                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->name; ?></td>
                                <td><?php echo $item->email.' - ';

                                    echo anchor($item->files, '
                                        <i class="material-icons">picture_as_pdf</i>', array("target" => 'blank')
                                    );
                                    ?>
                                </td>
                                <td><?php echo $item->celphone; ?></td>
                                <td><?php echo $item->vacancy; ?></td>
                                <td><?php echo $item->datecreated; ?></td>


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
</div>
<!-- #END# Exportable Table -->