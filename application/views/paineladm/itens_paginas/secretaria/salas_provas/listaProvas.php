
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   Salas de Provas - <?php echo $curso->name;?>
                </h2>
            </div>

            <div class="register">
                <?php
                echo anchor('secretaria/cadastrarLista/'.$curso->id, '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                ?>

          
                <?php
                echo anchor('secretaria/salasProvas', '
                    <i class = "material-icons">
                    assignment_return
                    </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
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
                                <th>Nome</th>
                                <th>Arquivo</th>
                                <th>Campus - Cidade</th>
                                <th>Início em</th>
                                <th>Término em</th>
                                <th>Modificado em</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Ações</th>
                                <th>Nome</th>
                                <th>Arquivo</th>
                                <th>Campus - Cidade</th>
                                <th>Início em</th>
                                <th>Término em</th>
                                <th>Modificado em</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($files as $item) {
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php
                                        echo anchor('Secretaria/editarCartilha/'.$item->id,'<i class="material-icons">edit</i>');
                                        echo '<a href="#" title="visualizar"><i class="material-icons">pageview</i></a> ';
                                        echo anchor(base_url().$item->files,'<i class="material-icons">insert_drive_file</i>',array('title'=>"arquivo"));
                                        echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $item->name . '" data-id="' . $item->id . '" >'
                                            .'<i class="material-icons">delete</i>'
                                            .'</a>';
                                        ?>
                                    </td>
                                    <td><?php echo $item->name .' - '.strtoupper ($item->tipoalunos); ?></td>
                                    <td><?php echo anchor(base_url($item->files),'Visualizar arquivo',array('target'=>'_blank')); ?></td>
                                    <td><?php echo $item->campusname.' - '.$item->city; ?></td>
                                    
                                    
                                    <td><?php echo date('d/m/Y H:i:s',strtotime($item->datestart));?></td>
                                    <td><?php echo date('d/m/Y H:i:s',strtotime($item->dateend));?></td>
                                    <td><?php //echo date('d/m/Y H:i:s',strtotime($item->datemodifIed));?></td>
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
        $(this).find('#btnCerteza').attr('href', '<?php echo base_url("Secretaria/deletar/files/pagSecretaria/"); ?>' + id);
    });
</script>