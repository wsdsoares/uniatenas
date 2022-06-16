<?php
$page = $this->uri->segment(2);
?>
<div class="block-header">
    <h2></h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    ITENS <?php echo strtoupper($page); ?>
                </h2>
                <?php
               // echo anchor('painel/cadastrar_itens_infraestrutura','CADASTRAR',array('class'=>'btn btn-primary m-t-15 waves-effect'));
                ?>
                
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Ações</th>
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Página</th>
                                <th>Descrição</th>
                                <th>Modificação</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Ações</th>
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Página</th>
                                <th>Imagem Destque</th>
                                <th>Modificação</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $i=1;
                            foreach ($pages_content as $item):
                                ?>
                                <tr>
                                     <td class="center">
                                        <?php
                                        
                                        echo '<a href="#">'
                                        . '<i class="material-icons">edit</i>'
                                        . '</a> ';
                                        /*. '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                                        . '<i class="material-icons">delete</i>'
                                        . '</a>';*/
                                        ?>
                                    </td>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $item->titulo; ?></td>
                                    <td><?php echo $item->pagina; ?></td>
                                    <td><?php
                                        echo mb_strimwidth(to_html($item->descricao), 0, 100, "...");
                                        ?>
                                    </td>

                                    <td><?php echo $item->dataModificacao; ?></td>
                                    <td><?php //echo $item->data_modify; ?></td>
                                   

                                </tr>
                                <?php
                                $i++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->