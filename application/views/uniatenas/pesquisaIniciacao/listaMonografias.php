<?php

$idCurso = $this->uri->segment(3);
$yearMonography = $this->uri->segment(4);
$quantidade = count($listasMonografias);
$cont = intval($quantidade/2);

?>

<div class="section-revistas text-center">
  <h2>Monografias do curso de <b><?php echo $curso->name; ?></b></h2>
  <span class="double-border"></span>
</div>
<div class="btn-back">
  <?php echo anchor('iniciacaoCientifica/listaSemestresTCC/'.$campus->shurtName.'/'.$curso->id, '
            Voltar', array('class' => 'btn btn-danger'));
            ?>
</div>
<br />

<div class="row">
  <div class="list-itens-magazines">
    <div class="col-md-6">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Monografia</th>
            <th scope="col">Acesso/Link</th>

          </tr>
        </thead>
        <tbody>
          <?php
                            for ($i = 0; $i < $cont; ++$i) {
                                ?>
          <tr>
            <td><?php echo $listasMonografias[$i]->title; ?></td>
            <td>
              <?php echo anchor(base_url($listasMonografias[$i]->files), 'Acessar', array('class' => 'btn btn-info')); ?>
            </td>
          </tr>
          <?php
                            }
                            $j=$i;
                            ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Monografia</th>
            <th scope="col">Acesso/Link</th>

          </tr>
        </thead>
        <tbody>
          <?php
                            for ($i; $i < $quantidade; ++$i) {
								
                                ?>
          <tr>
            <td><?php echo $listasMonografias[$i]->title; ?></td>
            <td>
              <?php echo anchor(base_url($listasMonografias[$i]->files), 'Acessar', array('class' => 'btn btn-info')); ?>
            </td>
          </tr>
          <?php
                            }
                            ?>
        </tbody>
      </table>
    </div>

  </div>
</div>