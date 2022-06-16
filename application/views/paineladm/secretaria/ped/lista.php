<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    PED - Campus <?php echo $campus->city; ?>
                </h2>
            </div>

                <div class="register">
                    <?php
                    /*echo anchor("Painel_secretaria/cadastrar_calendariosSemestre/$curso", '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                   */
                    echo anchor("Painel_secretaria/ped/$campus->id", '
                    <i class = "material-icons">
                    keyboard_backspace
                    </i> <span>Voltar</span>', array('class' => 'btn btn-danger m-t-15 waves-effect'));
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
                            <th>Ações</th>
                            <th>Titulo</th>
                            <th>Periodo</th>
                            <th>Data Criação</th>
                            <th>usuario</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Ações</th>
                            <th>Titulo</th>
                            <th>Periodo</th>
                            <th>Data Criação</th>
                            <th>usuario</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        foreach ($listagem as $row) {
                            ?>
                            <tr>
                                <td class="center">
                                    <?php
                                    echo anchor($row->file, '<i class="material-icons">picture_as_pdf</i>', array('title' => "arquivo", "target" => "_blank"));
                                    //if (in_array("regProvasGab", $permissionCampusArray['campus-1'])) {
                                    //echo '<a href=' . base_url("Painel_secretaria/editar_calendariosSemestre/$campus/$row->id/$table") . '>'
                                    //  . '<i class="material-icons">edit</i>'
                                    // . '</a> ';
                                    /*if ($row->status == 1 ) {
                                        echo '<a href=' . base_url("painel_secretaria/statusAlter/$row->id/0/$table/painel_secretaria-calendarios_semestre/$campus") . '>'
                                            . '<i class="material-icons">visibility</i>'
                                            . '</a>';
                                    } elseif ($row->status == 0 ) {
                                        echo '<a href=' . base_url("painel_secretaria/statusAlter/$row->id/1/$table/painel_secretaria-calendarios_semestre/$campus") . '>'
                                            . '<i class="material-icons">visibility_off</i>'
                                            . '</a>';
                                    }*/

                                    //}
                                    ?>
                                </td>
                                <td><?php echo $row->discipline; ?></td>
                                <td><?php echo $row->period . 'º'; ?></td>
                                <td><?php
                                    echo date('d/m/Y H:i:s', strtotime($row->datecreated));
                                    ?></td>
                                <td>
                                    <?php
                                    echo $row->usersid;
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
        </
        --div>
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
                <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os dados
                    ligados a esse item serão removidos <span class="text-danger" style="font-weight: bold">PERMANENTEMENTE</span>.
                </p>
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
        $(this).find('#btnCerteza').attr('href', '<?php echo base_url("publicacoes/deletarMagazine/"); ?>' + id);
    });
</script>
<!-- #END# Exportable Table -->

