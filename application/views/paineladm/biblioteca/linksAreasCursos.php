<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>

                </h2>
            </div>

            <div class="register">
                <?php
                echo anchor('biblioteca/cadastrarAreasLinks', '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                ?>
                <?php
                echo anchor('biblioteca/linksAreasCursos', '
                    <i class = "material-icons">
                    arrow_back
                    </i> <span>Voltar</span>', array('class' => 'btn btn-danger btn-system m-t-15 btn-viewer'));
                ?>


            </div>


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
                            <th>#</th>
                            <th>Titulo</th>
                            <th>Data Modificação</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>

                            <th>#</th>
                            <th>Titulo</th>
                            <th>Data Modificação</th>
                            <th>Status</th>


                        </tr>
                        </tfoot>
                        <tbody>

                        <?php
                        foreach ($areaslinks as $row) {
                            ?>
                            <tr>
                                <td class="center">
                                    <?php

                                    echo '<a href=' . base_url("biblioteca/editarAreasLinks/$row->id") . '>'
                                        . '<i class="material-icons">edit</i>'
                                        . '</a> '
                                        . '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                                        . '<i class="material-icons">delete</i>'
                                        . '</a>';
                                    ?>
                                </td>


                                <td><?php echo $row->title; ?></td>

                                <td><?php
                                    echo date('d/m/Y H:i:s', strtotime($row->datemodified));
                                    ?></td>
                                <td>
                                    <?php
                                    if ($row->status == 1) {
                                        echo 'Ativo';
                                    } else {
                                        echo 'Inativo';
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
</div>


<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Você tem certeza?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><p>Você tem certeza que deseja realizar essa ação de deletar o item abaixo?</p>
                <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os dados ligados a esse item serão removidos <span class="text-danger" style="font-weight: bold">PERMANENTEMENTE</span>.</p>
                <p>O item selecionado é: <span class="text-info nomeItem" style="font-weight: bold"></span></p></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a id="btnCerteza" class="btn btn-danger" href="">Sim, tenho certeza!</a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/elementsPainel/footers/footerDelete'); ?>

<script type="text/javascript">
    $('#modalDelete').on('show.bs.modal', function (e) {
        var nomeItem = $(e.relatedTarget).attr('data-nome');
        var id = $(e.relatedTarget).attr('data-id');
        console.log(id);
        $(this).find('.nomeItem').text(nomeItem);
        $(this).find('#btnCerteza').attr('href', '<?php echo base_url("biblioteca/deletarAreaLinks/"); ?>' + id);
    });
</script>


