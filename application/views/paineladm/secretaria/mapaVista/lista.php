<?php
$page = $this->uri->segment(2);

//if (in_array("admTempsArgs", $permissionCampusArray['campus-1']) || in_array("tempsArgs", $permissionCampusArray['campus-1'])) {

    ?>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        LISTA DOS <?php echo 'MAPAS DE VISTA DE PROVA'; ?>
                    </h2>
                    <?php
                    $page = $this->uri->segment(2);
                    //if (in_array("regTempsArgs", $permissionCampusArray['campus-1'])) {
                        echo anchor('Mural/mapaDeVista_cadastrar/'.$id, '<i class="material-icons">add_box</i> CADASTRAR ', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                    //}?>

                </div>
                <br>
                <div class="body">
                    <?php
                    if ($msg = getMsg()):
                        echo $msg;
                    endif
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                            <tr>
                                <th>Ações</th>
                                <th>#</th>
                                <th>Título</th>
                                <th>Data de criação</th>
                                <th>Data de Modificação</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Ações</th>
                                <th>#</th>
                                <th>Título</th>
                                <th>Data de criação</th>
                                <th>Data de Modificação</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            if(!empty($listagem)){
                            foreach ($listagem as $item):
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php
                                        echo anchor($item->file, '<i class="material-icons">insert_drive_file</i>', array('title' => "arquivo"));
                                        //if(in_array("delTempsArgs", $permissionCampusArray['campus-1'])){
                                            echo '<a href=' . base_url("Mural/mapaDeVista_deletar/$id/$item->id") . '>'
                                                . '<i class="material-icons">delete</i>'
                                                . '</a> ';
                                        //}

                                        ?>
                                    </td>
                                    <td><?php echo $item->id; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td><?php echo $item->datecreated; ?></td>
                                    <td><?php echo $item->datemodified; ?></td>
                                    <td><?php
                                        ?>
                                    </td>

                                </tr>
                            <?php
                            endforeach;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Você tem certeza?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><p>Você tem certeza que deseja realizar essa ação de deletar o item abaixo?</p>
                    <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os
                        dados ligados a esse item serão removidos <span class="text-danger" style="font-weight: bold">PERMANENTEMENTE</span>.
                    </p>
                    <p>O item selecionado é: <span class="text-info nomeItem" style="font-weight: bold"></span></p>
                </div>
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
            $(this).find('#btnCerteza').attr('href', '<?php echo base_url("publicacoes/deletarMagazine/"); ?>' + id);
        });
    </script>
    <?php
//} else
     /*{
    ?>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="alert alert-warning" role="alert">
                    Infelizmente você não tem permissões para acessar essa página. Caso precise entre em contato com o
                    administraor.
                </div>
            </div>
        </div>
    <?php
}*/
?>

