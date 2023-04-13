<style>
.ico-wrap {
  margin: auto;
}

text.Orange-label {
  color: Orange;
}
</style>
<div class="container">
  <div class="section-revistas text-center">
    <h2>Monografias do curso de <b><?php echo $curso->name; ?></b></h2>
    <h3><?php //echo $area->title; ?></h3>
    <span class="double-border"></span>
  </div>
  <div class="btn-back">
    <?php echo anchor('iniciacaoCientifica/trabalho_conclusao_curso/'.$campus->shurtName, '
    Voltar', array('class' => 'btn btn-danger'));
    ?>
  </div>
  <br />
  <style>
  .services-box {
    margin-bottom: 50px;
  }

  .years {
    background: #f88;

  }
  </style>
  <div class="row">
    <div class="containter">
      <?php 
    
  foreach ($dados['semestresTCC'] as $item) 
  {
  ?>
      <div class="col-xs-1">
        <div class="text-center years">
          <h4>
            <i class="pe-7s-bookmarks"></i><br />
            <?php echo anchor('iniciacaoCientifica/listaMonografias/'.$campus->shurtName.'/'.$curso->id.'/'.$item->year, $item->year);  ?>
            <div class="services-content">
          </h4>
        </div>
      </div>
      <?php
  }
  ?>
    </div>
  </div>
</div>