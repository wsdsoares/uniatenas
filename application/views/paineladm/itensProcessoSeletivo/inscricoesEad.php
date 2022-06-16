
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
                                <th>#</th>
                                <th>Nome</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Curso</th>
                                <th>Data Contato</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Curso</th>
                                <th>Data Contato</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            
                            foreach ($dados['inscricoesEad'] as $row) {
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php
                                        
                                        /*echo '<a href="#">'
                                        . '<i class="material-icons">edit</i>'
                                        . '</a> '
                                        /*. '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                                        . '<i class="material-icons">delete</i>'
                                        . '</a>';*/
                                        ?>
                                    </td>

                                    <td><?php echo $row->nome; ?></td>
                                    <td><?php echo $row->celular; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->courses_id; ?></td>
                                    <td><?php echo $row->data_contato; ?></td>

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