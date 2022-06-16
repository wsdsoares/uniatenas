<?php 
$portal_totvs = 'http://177.69.195.6/corpore.net/Login.aspx';
$portal_blackboard = 'https://atenas.brightspace.com/';
?>
 <div class="row informativos text-center portais">     
		<div class="container">	
			<h3>Portais - UniAtenas</h3>
			<div class="col-md-2">
					
			</div>
	    	<div class="col-md-4">
					<?php echo anchor($portal_totvs,'<img class="icon_pdf"src="'. base_url().'assets/img/portal_totvs.png">','target="_blank"');?>
				<p><a  href="<?php echo $portal_totvs;?>" target="_blank" title="Portal de">Acessar portal TOTVS</a></p>
			</div>
       		<div class="col-md-4">
					<?php echo anchor($portal_blackboard,'<img class="icon_pdf"src="'. base_url().'assets/img/portal_blackboard.png">','target="_blank"');?>
					
						
				<p><a  href="<?php echo $portal_blackboard;?>" target="_blank" title="Portal do professor e Aluno">Acessar Blackboard</a></p>
			</div>
			<div class="col-md-2">
					
			</div>
		</div>
	</div>