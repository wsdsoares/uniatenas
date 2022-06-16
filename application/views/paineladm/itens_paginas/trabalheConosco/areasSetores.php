
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    EXPORTAR INFORMAÇÕES
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
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
                                <th>#</th>
                                <th>Nome</th>
                                <th>Página</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Ações</th>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Página</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                            foreach ($pages_content as $item) {
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

                                    <td><?php echo $item->id; ?></td>
                                    <td><?php echo $item->name; ?></td>
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