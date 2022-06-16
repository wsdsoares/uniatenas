<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="x_panel">
                	<div class="x_title">
                  		<h2>Notícias <small>itens cadastrados</small></h2>
                  		<ul class="nav navbar-right panel_toolbox">
	                    	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		                    </li>
                  		</ul>
                  <div class="clearfix"></div>
                </div>
				
                <!-- Large modal -->                
                <?php 
               		echo anchor('painel/cadastrar_noticias', 'Cadastrar Notícia', array('class' => 'btn btn-info'));
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
                        <th class="column-title">Nº </th>
                        <!-- 
                        <th class="column-title">Titulo</th>
                         -->
                        <th class="column-title">Imagem destaque </th>
                        <th class="column-title">Data Cadastro</th>
                        
                        <th class="column-title no-link last"><span class="nobr">Ação</span>
                        </th>
                        <th class="bulk-actions" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">Slide Show( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </thead>
                    
                    <?php 
                   /* $lista_noticias = $this->noticias->get_all_noticias()->result();
					?>

                    <tbody>
                     
						<?php		
						foreach ($lista_noticias as $linha):	?>
							<?php 
							if($linha->status==0):
					  			$status = 'inativo';
					  			$img = 'un_block.png';
					  			$title_icon = 'desbloquear';
					  		else:
					  			$status='';
					  			$img = 'block.png';
					  			$title_icon = 'bloquear';
					  		endif;
					  		?>
						
						<tr class="even pointer">
							<td class="a-center ">
	                        	<input type="checkbox" class="flat" name="table_records">
	                        </td>
	                        <td class=""><?php echo $linha->id?></td>
	                     
	                        <?php 
	                        
	                        printf('<td>%s</td>', thumb($linha->img_destaque));
	                        ?>
	                        <td>
	                       	<?php 
	                       	printf('<td class="text-center">%s%s%s%s</td>',
	                       		anchor("noticias/cadastrarFotos/$linha->id", '<img src="'.base_url().'assets/img/painel/photos.png">',array('title'=>'Cadastrar Fotos')),
				  				anchor("noticias/editar_noticia/$linha->id", '<img src="'.base_url().'assets/img/painel/edit.png">',array('title'=>'Editar')),
				  				anchor("noticias/modificar/$title_icon/$linha->id", '<img src="'.base_url().'assets/img/painel/'.$img.'">',array('title'=>$title_icon)),
				  				anchor("noticias/excluir_noticia/$linha->id", '<img src="'.base_url().'assets/img/painel/delete.png">',array('title'=>'Excluir'))
				  				
				  				);
				  				?>
	                        </td>
						</tr>
						
						<?php 
						endforeach; 
						*/
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
            <p class="pull-right">Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>