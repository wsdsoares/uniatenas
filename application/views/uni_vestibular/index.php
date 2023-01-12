<body style='padding: 0;'>
  <style>
  img.logo-atenas {
    max-width: 200px;

  }

  .card-header {
    height: 130px !important;
  }
  </style>

  <div class="py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <img class="logo-atenas img-fluid" src="http://atenas.edu.br/uniatenas/assets/images/@principal/tocha.png">
  </div>

  <div class="py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Informações e Resultados</h1>
  </div>

  <div class="container">
    <div class="card-deck mb-3 text-center" style="background: #f2f2f2;">
      <?php
       /**TO DO - fazer uma programação para mostrar apenas os vestibulares que estiverem com status 5  */

        foreach ($dados['campus'] as $rows) {
            //if($rows->idCampus ==8){
            ?>
      <div class="card mb-4 box-shadow">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal" style="font-size:20px"><?php echo $rows->name;?></h4>

          <h4 class="my-0 font-weight-normal" style="font-size:20px"><?php echo $rows->city;?></h4>
        </div>
        <div class="card-body">

          <?php
                    echo form_open("Vestibular/resultado_geral/");
                    
                    
                    
                    echo form_hidden('actionQuery', 'actionQuery');
                    echo form_hidden('idCampus', $rows->id);
                    echo form_hidden('idVestibular', $rows->idVestibular);
                    echo form_submit(array('class' => 'btn btn-info btn-lg', 'value' => 'Resultados', 'target="_blank"'));
                    echo form_close();
                    
                    ?>

        </div>
      </div>
      <?php
            //}
        }
        
        ?>
    </div>
  </div>