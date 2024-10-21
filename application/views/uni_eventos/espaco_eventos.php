<?php
$uricampus = $this->uri->segment(3);
?>
<style>
.card {
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 6px;
}

.card>.card-link .card-img img {
  border-radius: 6px 6px 0 0;
}

.card .card-img {
  position: relative;
  padding: 0;
  display: table;
}

.card .card-img .card-caption {
  position: absolute;
  right: 0;
  bottom: 16px;
  left: 0;
}

.card .card-body {
  display: table;
  width: 100%;
  padding: 12px;
}

.card .card-body h1:first-child,
.card .card-body h2:first-child,
.card .card-body h3:first-child,
.card .card-body h4:first-child,
.card .card-body .lead {
  text-align: center;
}

.card-default>.card-body {}

.card-default>.card-img:first-child img {
  border-radius: 6px 6px 0 0;
}

.card-default p:last-child {
  margin-bottom: 0;
}

.card-default .card-caption {
  color: #fff;
  text-align: center;
  text-transform: uppercase;
}


/* -- price theme ------ */
.card-price {
  border-color: #999;
  background-color: #ededed;
  margin-bottom: 24px;
}

.card-price>.card-img:first-child img {
  border-radius: 6px 6px 0 0;
}

.card-price .card-caption {
  color: #fff;
  text-align: center;
  text-transform: uppercase;
}

.card-price p:last-child {
  margin-bottom: 0;
}

.card-price .price {
  text-align: center;
  color: #337ab7;
  font-size: 3em;
  text-transform: uppercase;
  line-height: 0.7em;
  margin: 24px 0 16px;
}

.card-price .price small {
  font-size: 0.4em;
  color: #66a5da;
}

.card-price .details {
  list-style: none;
  margin-bottom: 24px;
  padding: 0 18px;
}

.card-price .details li {
  text-align: center;
  margin-bottom: 8px;
}

.card-price .buy-now {
  text-transform: uppercase;
}

.card-price table .price {
  font-size: 1.2em;
  font-weight: 700;
  text-align: left;
}

.card-price table .note {
  color: #666;
  font-size: 0.8em;
}

.description {
  text-align: justify;
  min-height: 150px;
}
</style>
<script>
$(document).ready(function() {
  $('#carouselEvents').carousel({
    interval: 5000
  });

  var clickEvent = false;
  $('#carouselEvents').on('click', '.nav a', function() {
    clickEvent = true;
    $('.nav li').removeClass('active');
    $(this).parent().addClass('active');
  }).on('slid.bs.carousel', function(e) {
    if (!clickEvent) {
      var count = $('.nav').children().length - 1;
      var current = $('.nav li.active');
      current.removeClass('active').next().addClass('active');
      var id = parseInt(current.data('slide-to'));
      if (count == id) {
        $('.nav li').first().addClass('active');
      }
    }
    clickEvent = false;
  });
});
</script>
<div class="container">
  <div class="row about-container">
    <div class="section-header text-center">
      <h3>Espaço para eventos</h3>
    </div>

    <?php
        if (isset($dados['conteudoPag'][0]->link_redir) and $dados['conteudoPag'][0]->link_redir != '') {
        ?>
    <div class="col-lg-5 col-md-5 col-sm-5">
      <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item"
          src="https://www.youtube.com/embed/<?php echo $dados['conteudoPag'][0]->link_redir; ?>" frameborder="0"
          allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
      </div>
      </br>
      </br>
    </div>
    <?php
        }
        ?>
    <?php
        if (isset($dados['conteudoPag'][0]->description) and $dados['conteudoPag'][0]->description != '') {
        ?>
    <div class="col-lg-7 col-md-7 col-sm-7">
      <div class="information-library-campus text-justify">

        <p>
          <?php echo $dados['conteudoPag'][0]->description; ?>
        </p>
      </div>
    </div>
    <?php
        }
        ?>

  </div>
</div>
<?php

?>
<div class="container">

  <div id="carouselEvents" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <?php
            for ($i = 0; $i < count($dados['fotosEspaco']); $i++) {
            ?>
      <div class="item <?php
                                    if ($i == 0) {
                                        echo 'active';
                                    }
                                    ?>">
        <img src="<?php echo base_url($dados['fotosEspaco'][$i]['photocape']); ?>">
      </div>
      <?php
            }
            ?>
    </div>

    <ul class="nav nav-pills nav-justified">
      <?php
            for ($i = 0; $i < count($dados['fotosEspaco']); $i++) {
                if ($i == 0) {
                    $class = 'active';
                } else {
                    $class = "null";
                }
            ?>
      <li data-target="#carouselEvents" data-slide-to="<?php echo $i; ?>" class="<?php echo $class; ?>">
        <a href="#"><?php echo $dados['fotosEspaco'][$i]['name']; ?>
        </a>
      </li>
      <?php
            }
            ?>
    </ul>
  </div>
</div>
<br />
<br />

<div class="container">
  <?php
    if (!empty($dados['fotosEspaco'])) {
    ?>
  <div class="section-header text-center">
    <h3>Informações sobre os espaços para eventos</h3>
  </div>
  <?php
    }
    ?>
  <div class="row">
    <?php
        for ($i = 0; $i < count($dados['fotosEspaco']); $i++) {
        ?>
    <div class="col-sm-3">
      <h4 class="text-center"><?php echo $dados['fotosEspaco'][$i]['name']; ?></h4>
      <div class="card card-price">
        <div class="card-img">
          <a href="#">
            <img src="<?php echo base_url($dados['fotosEspaco'][$i]['photos'][0]->files); ?>" class="img-responsive">
          </a>
        </div>
        <div class="card-body">
          <!--div class="lead">Sobre.</div>
                        <ul class="details">
                            <li>A stitch in time saves nine.</li>
                            <li>All good things come to those who wait.</li>
                            <li>There's a pony in that pile.</li>
                        </ul-->
          <table class="table">
            <p class="description">
              <?php
                                echo $dados['fotosEspaco'][$i]['description'];
                                ?>

            </p>
            <tr>
              <th class="text-center">Informações</th>
            </tr>
            <tr>
              <td>
                <?php
                                    echo $dados['fotosEspaco'][$i]['capacity'];
                                    ?>
              </td>
            </tr>
          </table>
          <?php echo anchor(
                            'site/fotos_espaco_eventos/' . $uricampus . '/' . $dados['fotosEspaco'][$i]['id'],
                            'Mais fotos <span class="glyphicon glyphicon-triangle-right"></span>',
                            array('class' => "btn btn-primary btn-lg btn-block buy-now")
                        );
                        ?>
          </a>
        </div>
      </div>
    </div>
    <?php
        }
        ?>
  </div>
</div>
<?php

?>