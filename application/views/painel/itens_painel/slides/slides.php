
<div class="container body">


	<div class="main_container">
    	<!-- page content -->
      	<div class="right_col" role="main">
        	<div class="">
          		<div class="page-title">
            		<div class="title_left">
              			<h3>
                    		Slide Show
                    		<small>
                        		Registrados no sistema
                    		</small>
                		</h3>
            		</div>

          		</div>
          		<div class="clearfix"></div>
				
				<div class="row">
				 	<div class="col-md-12 col-sm-12 col-xs-12">
				 	<?php 
				 		echo anchor('painel/cadastrar_slides', '<i class="btn btn btn-primary margin10px"><i class="fa fa-picture-o"></i> Cadastrar Slide</i>')
				 	?>
						
					</div>
          		</div>
          		<div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Lista de imagens cadastradas</h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <!--p class="text-muted font-13 m-b-30">
                          Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                        </p-->
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>Usuário</th>
                              <th>Data Cadastro</th>
                              <th>Status</th>
                              <th>Foto</th>
                              <th>Download</th>
                              <th>Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                          
                          	<?php
								$status = '0';
								$registros = $this -> painel -> get_all('midia','slideshow') -> result();
								
								
								foreach ($registros as $linha) :
									if ($linha -> status == 0) :
										$status = 'Inativo';
									else :
										$status = 'Ativo';
									endif;
									echo '<tr>';
									printf('<td>%s</td>', $linha -> id);

									printf('<td>%s</td>', $linha->codusuario);

									printf('<td>%s</td>', date('d/m/Y H:i:s', strtotime($linha -> data)));
									printf('<td>%s</td>', $status);
									printf('<td>%s</td>', thumb($linha->arquivo));
									
									if(!empty($linha->arquivo)):
										printf('<td>%s</td>', 
											anchor('painel/uploads/'.$linha->arquivo, '<i class="btn btn-warning margin10px"><i class="fa fa-download"></i> Download Arquivo</i>')
										);
											 
										else:
											printf('<td>%s</td>', 
												anchor('painel', '<i class="btn btn-warning margin10px" disabled><i class="fa fa-download"></i> Não há Arquivo</i>')
											);
										endif;
										
									//Verificação para não exibir o botão de encaminhar caso o chamado esteja finalizado
									echo '<td style="text-align:center">'; 
									echo anchor("avisos/editar/$linha->id", '<i class="fa fa-sign-out"></i>');
									echo ' <i> - </i>';
									echo anchor("painel/viewimg/$linha->id",' <i class="fa fa-eye"></i>');
									
									echo '</tr>';
								endforeach;
								?>
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- footer content -->
              <footer>
                <div class="copyright-info">
                  <!--p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                  </p-->
                </div>
                <div class="clearfix"></div>
              </footer>
              <!-- /footer content -->

            </div>
            <!-- /page content -->
          </div>

        </div>

        <div id="custom_notifications" class="custom-notifications dsp_none">
          <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
          </ul>
          <div class="clearfix"></div>
          <div id="notif-group" class="tabbed_notifications"></div>
        </div>

        <script src="<?php echo base_url()?>assets/painel/js/bootstrap.min.js"></script>

        <!-- bootstrap progress js -->
        <script src="<?php echo base_url()?>assets/painel/js/progressbar/bootstrap-progressbar.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/nicescroll/jquery.nicescroll.min.js"></script>
        <!-- icheck -->
        <script src="<?php echo base_url()?>assets/painel/js/icheck/icheck.min.js"></script>

        <script src="<?php echo base_url()?>assets/painel/js/custom.js"></script>


        <!-- Datatables -->
        <!-- <script src="<?php echo base_url()?>assets/painel/js/datatables/js/jquery.dataTables.js"></script>
  <script src="<?php echo base_url()?>assets/painel/js/datatables/tools/js/dataTables.tableTools.js"></script> -->

        <!-- Datatables-->
        <script src="<?php echo base_url()?>assets/painel/js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/painel/js/datatables/dataTables.scroller.min.js"></script>


        <!-- pace -->
        <script src="<?php echo base_url()?>assets/painel/js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>
