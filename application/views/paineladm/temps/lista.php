<div class="block-header">
  <h2></h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()){
        echo $msg;
      }
      ?>
      <div class="header">
        <h2>
          Gestão de Arquivos/ Links Temporários
        </h2>
        <div class="col-sm-4">
          <?php
          echo anchor('Painel_arquivos_temporarios/cadastrar_tempArg/'.$campus->id, '<i class="material-icons">add_box</i> CADASTRAR ', array('class' => 'btn btn-primary m-t-15 waves-effect'));
          ?>
        </div>
        <div class="col-sm-4 col-sm-offset-4">
          <?php 
          echo anchor('Painel_arquivos_temporarios/lista_campus_temps', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-danger m-t-15 waves-effect'));
          ?>
        </div>
      </div>
      <br />
      <br />
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título</th>
                <th>Link</th>
                <th>Data de criação</th>
                <th>Data de Modificação</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título</th>
                <th>Link</th>
                <th>Data de criação</th>
                <th>Data de Modificação</th>
              </tr>
            </tfoot>
            <script>
            var listaLink = []
            </script>
            <tbody>
              <?php
            if(!empty($listagem)){ 
                
              foreach ($listagem as $item){?>
              <tr>
                <td class="center">
                  <?php
                      echo anchor($item->files, '<i class="material-icons">insert_drive_file</i>', array('title' => "arquivo"));
                      // if (in_array("regTempsArgs", $permissionCampusArray['campus-1'])) {
                          echo '<a  href=' . base_url("Painel_arquivos_temporarios/editar_tempArg/$campus->id/$item->id") .'>'
                              . '<i class="material-icons">edit</i>'
                              . '</a> ';
                          // if ($item->status == 1) {
                          //     echo '<a href=' . base_url("Painel_arquivos_temporarios/statusAlter_tempArg/$item->id/0") . '>'
                          //         . '<i class="material-icons">visibility</i>'
                          //         . '</a>';
                          // } elseif ($item->status == 0) {
                          //     echo '<a href=' . base_url("Painel_arquivos_temporarios/statusAlter_tempArg/$item->id/1") . '>'
                          //         . '<i class="material-icons">visibility_off</i>'
                          //         . '</a>';
                          // }
                      // }
                      // if(in_array("delTempsArgs", $permissionCampusArray['campus-1'])){
                          // echo '<a href=' . base_url("Painel_arquivos_temporarios/delete_tempArg/$item->id/$campus->id") . '>'
                          //     . '<i class="material-icons">delete</i>'
                          //     . '</a> ';
                      // }

                      ?>
                </td>
                <td><?php echo $item->id; ?></td>
                <td><?php echo $item->title; ?></td>
                <td>
                  <?php echo '<span data-toggle="tooltip" data-placement="right" title="click para copiar o texto" class=" btn btn-primary btn-sm glyphicon glyphicon-link" onclick="copiar('.$item->id.')"><small>Copiar</small></span>'.'<small class="text">'.$item->link.'</small>';?>
                </td>
                <script>
                listaLink["<?php echo $item->id;?>"] = "<?php echo $item->link; ?>"
                </script>
                <td><?php echo $item->datacreated; ?></td>
                <td><?php echo $item->dateupdate; ?></td>
              </tr>
              <?php
              }
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>