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
                echo anchor('painel/cadastrar_itens_infraestrutura','CADASTRAR',array('class'=>'btn btn-primary m-t-15 waves-effect'));
                ?>
                
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Imagem Destque</th>
                                <th>Modificação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Imagem Destque</th>
                                <th>Modificação</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                           
                            /*foreach ($dados as $item):
                                ?>
                                <tr>
                                    <td><?php echo $item->id; ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php ?></td>

                                    <td><?php echo $item->img_destaque; ?></td>
                                    <td><?php echo $item->data_modify; ?></td>
                                    <td><?php
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            endforeach;*/
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->