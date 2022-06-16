<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="x_panel">
                	<div class="x_title">
                  		<h2>Dirigentes</h2>
                  		<ul class="nav navbar-right panel_toolbox">
	                    	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		                    </li>
                  		</ul>
                  <div class="clearfix"></div>
                </div>
				
                <!-- Large modal -->                
                <?php 
               		echo anchor('painel/cadastrar_dirigentes', 'Cadastrar Dirigente', array('class' => 'btn btn-primary'));
                ?>

                <div class="x_content">

					<!--  
                  <p>Add class <code>bulk_action</code></p>
					-->
                  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                      <tr class="headings">
                        <th>
                          <input type="checkbox" id="check-all" class="flat">
                        </th>
                        <th class="column-title">ID </th>
                        <th class="column-title">Nome</th>
                        <th class="column-title">Cargo </th>
                        <th class="column-title">Email</th>
                        <th class="column-title">Data Cadastro</th>
                        
                        <th class="column-title no-link last"><span class="nobr">Ação</span>
                        </th>
                        <th class="bulk-actions" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">Slide Show( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </thead>
                    
                    <?php 
		        		$dados = $this->painel->get_all('dirigentes','1')->result();
		        		
					?>

                    <tbody>
                     
						<?php			
						foreach ($dados as $linha):	?>
						
						<tr class="even pointer">
							<td class="a-center ">
	                        	<input type="checkbox" class="flat" name="table_records">
	                        </td>
	                        <td class=""><?php echo $linha->id;?></td>
	                        <td class=""><?php echo $linha->nome;?> </td>
	                        <td class=""><?php echo $linha->cargo;?></td>
	                        <td class=""><?php echo $linha->email;?></td>
	                        <td class=""><?php echo date('d/m/Y', strtotime($linha->data_registro))	; ?></td>
	                        <td class=" last"><a href="#">View</a>
	                        </td>
						</tr>
						
						<?php 
						endforeach; ?>
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
         
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>