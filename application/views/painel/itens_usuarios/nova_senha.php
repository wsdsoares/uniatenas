
	
		<div class="">
			<div id="wrapper">
				<div id="login" class="animate form">
					<section class="login_content">
					 	<?php 
					 		echo form_open('usuarios/nova_senha'); 
					 	?>
						<?php 
			            	//echo form_close();
							get_msg('errologin');
							get_msg('logoffok');
							erros_validacao();
						?>		
						
						
						<img src="<?php echo base_url();?>assets/img/logoPreto.png">
						<h1>Recuperar dados de acesso</h1>
						
						<div>
							<?php
								echo form_input(array('name' => 'email','type'=>'email' ,'class' => 'form-control', 'placeholder' => 'E-mail'), set_value('email'), 'autofocus required');
							?>
						</div>
						<div>
							<!--a class="btn btn-default submit" href="index.html">Log in</a-->
							<?php
							
								echo form_submit(array('name' => 'logar', 'class' => 'btn btn-success submit'), 'Recuperar acesso');	 
							?>
							
							<input type="button" value="Voltar" onClick="JavaScript: window.history.back();" class="btn btn-danger submit">
						</div>
						<div class="clearfix"></div>
						<?php 
		                    echo form_hidden('redirect', $this -> session -> userdata('redir_para'));
							
						?>
						
						<!--div class="separator">				
							<p class="change_link">New to site?
								<a href="#toregister" class="to_register"> Create Account </a>
							</p>
							<div class="clearfix"></div>
							
							<br />
							
							<div>
								<h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>						
								<p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
							</div>
						</div-->
				</section>
				<!-- content -->
			</div>
				<!--div id="register" class="animate form">
				<section class="login_content">
					<img src="<?php echo base_url();?>assets/img/logoPreto.png">
					<h1>Painel Administrativo</h1>
					<div>
						<input type="text" class="form-control" placeholder="Username" required="" />
					</div>
					<div>
						<input type="email" class="form-control" placeholder="Email" required="" />
					</div>
					<div>
						<input type="password" class="form-control" placeholder="Password" required="" />
					</div>
					<div>
						<a class="btn btn-default submit" href="index.html">Submit</a>
					</div>
					<div class="clearfix"></div>
					<div class="separator">
					
				 		<p class="change_link">Already a member ?
							<a href="#tologin" class="to_register"> Log in </a>
					  	</p>
					  	<div class="clearfix"></div>
					  	<br />
					</div>
				
				
				</section>
				
			  </div-->
			</div>
		</div>
	


