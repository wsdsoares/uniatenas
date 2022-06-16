
<div class="block-header">
    <h2></h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <?php
            if ($msg = getMsg()):
                echo $msg;
            endif;
            ?>
            <div class="header">
                <h2>
                    ITENS <?php echo strtoupper($page); ?>
                </h2>

            </div>
            <?php
            echo '<pre>';
            //print_r($dados);
            echo '</pre>';
            ?>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Modificação</th>
                            <th>Campus</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Modificação</th>
                            <th>Campus</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        foreach ($dados['contents'] as $content):
                            ?>
                            <tr>
                                <td class="center">
                                    <?php
                                        $idcontent = $content['idcontent'];
                                    echo '<a href=' . base_url("Painel/editarBiblioteca/$idcontent") . '>'
                                        . '<i class="material-icons">edit</i>'
                                        . '</a> ';
                                    ?>
                                </td>
                                <td><?php echo $content['titulo']; ?></td>
                                <td><?php
                                    echo($content['descriptionpage']);
                                    ?>
                                </td>
                                <td><?php echo $content['last_change']; ?></td>
                                <td><?php echo $content['campus']; ?></td>


                            </tr>
                        <?php
                        endforeach;
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

        $(this).find('.nomeItem').text(nomeItem);
        $(this).find('#btnCerteza').attr('href', '<?php echo base_url("Paginas/deletarSlideShow/"); ?>' + id);

        console.log()

    });
</script>