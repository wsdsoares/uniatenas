<?php 
$arquivo = $this->uri->segment(3);
$tabela = 'avisos';
$consulta = $this->painel->get_byid($arquivo,$tabela)->row();

$arquivo = base_url('assets/uploads').'/'.$consulta->arquivo;
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);

if($ext != 'pdf'):
	redirect('painel/avisos');
endif;

?>

  <div class="container body">
    <div class="main_container">
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Aviso</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>VIZUALIZAÇÃO DO AVISO <strong class="blue"><?php echo $consulta->titulo;?></strong></h2>
                 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />

                <?php 
			 		echo form_open('#',array('id'=>'demo-form2','class'=>'form-horizontal form-label-left')); 
			 	?>
				                

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Título 
							<span class="required">*</span>
						</label>
						<div class="col-md-9 col-sm-9 col-xs-9">
							<?php
								echo form_input(array('name' => 'titulo', 'class' => 'form-control', 'disabled' => 'disabled'), set_value('titulo',$consulta->titulo), 'autofocus');
							?>
							<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
						</div>
					</div>
					
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div id="gender" class="btn-group" data-toggle="buttons">
                          <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                          	
                          	<?php
                          	$data = array(
							    'name'        => 'situacao',
							    'value'       => 'ativo',
							    'style'       => 'margin:10px',
							    );
                          		
                          	?>
                          	
                          	<?php
                          		echo form_radio($data).'&nbsp; Ativo &nbsp;';
                          	?>
                          </label>
                          <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                      		<?php
                          		echo form_radio($data).'Inativo';
                          	?>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">
                      	Data do aviso 
                      	<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      	<?php echo form_input(array('name' => 'data_aviso', 'class' => 'form-control col-md-7 col-xs-12','id'=>'datas','disabled'=>'disabled','data-inputmask'=>"'mask': '99/99/9999'"), set_value('data_aviso',$consulta->data_aviso)); ?>
                        <!--input name="data_aviso" id="datas" class="form-control col-md-7 col-xs-12" required="required" data-inputmask="'mask': '99/99/9999'"-->
                      </div>
                    </div>
                    <div class="form-group">
		              <div class="x_title">
		                <h2>Decrição <small> - INFORMAÇÕES DO AVISO</small></h2>
		                <div class="clearfix"></div>
		              </div>
		                <div >
							<?php
			                	echo form_textarea(array('name'=>'descricao','id'=>'editor','class'=>'maximizarElemento textarea_pequeno'), 
			                	set_value('descricao',$consulta->descricao),'readonly')
			                ?>
		                </div>
                    </div>
                     <h2>Arquivo <small> - Visualização do arquivo</small></h2>
                 	<div class="form-group">
                 		 <div class="maximizarElemento" style="height:400px">
                 		 	<iframe readonly="readonly" class="maximizarElemento"src="<?php echo base_url();?>assets/uploads/<?php echo $consulta->arquivo?>"></iframe>
                 		 </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      		<input type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-danger submit">
                    </div>

                  <?php
                 	 echo form_close();
                  ?>
                </div>
              </div>
            </div>
          </div>


   
        </div>

      </div>

    </div>
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


<?php
		/*	$arquivo = $this->uri->segment(3);		
			
		?>
		<div class="container">
			<div class="row">
				<div class="voltar">
					<?php
				  	echo anchor('painel/inicio/',' <strong><img src="'.base_url().'assets/img/home.png"><span style="color:#fff;"> INÍCIO </span><strong> ', array('class' => 'btn btn-info'));
				 	?>
				 	
					<?php
				  echo anchor('painel/cursos/'.$cod_curso,' <strong><img src="'.base_url().'assets/img/back.png"><span style="color:#fff;">Voltar </span><strong> ', array('class' => 'btn btn-success'));
				 ?>
				 <div style="margin-bottom: 20px;">
				 </div>
				</div>
				<div class="big-box">
					<div class="col-md-12">
						<!--div class="col-lg-3">
							<div sytle="float:left" width="800px" >
								
								Portaria - <?php //echo $nome;?>
							</div>
						</div-->
							<?php
								if($cod_curso != 9) :
								?>
						
						<div class="col-lg-3">
							
							<div style="margin-bottom: 20px;"></div>
						</div>
						<?php
						endif;
						?>
					</div>
				</div>
				<br/>
					<?php
					if($cod_curso == 9) :
					?>
				<div class="big-box">
					<div class="col-md-12">
						<div class="col-lg-3">
							<div sytle="float:left" width="800px" >
								<iframe src="<?php echo base_url('').$reconhecimento_licenciatura;?>" width="600px" height="600px"></iframe>
								Portaria Reconhecimento - <?php echo $nome;?>
							</div>
						</div>
					</div>
				</div>
				<?php
				endif;
				?>
			</div>
			<br />
			<br />	
		</div>	*/
?>


