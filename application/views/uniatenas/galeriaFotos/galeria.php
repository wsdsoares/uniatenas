<!--link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script-->
<style>
.containerX {

  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  width: 80vw;
  margin: auto;
}

.containerX h3 {
  -webkit-box-flex: 0;
  -ms-flex: none;
  flex: none;
  width: 100%;
  max-height: 120px;
  margin: 0 2% 2em 2%;
  color: #000000;
}

.cardList {
  max-width: 180px;
  max-height: 120px;
  position: relative;
  display: block;
  -webkit-box-flex: 1;
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  margin: 2%;
  -webkit-filter: none;
  filter: none;
  opacity: 1;
  -webkit-transition: 0.25s ease-in-out opacity, 0.25s ease-in-out filter;
  transition: 0.25s ease-in-out opacity, 0.25s ease-in-out filter;
  cursor: pointer;
}

.cardList__title {
  display: block;
  padding-top: 80%;
  text-align: center;
  font-size: 0.8em;
  opacity: 0.8;
  z-index: 0;
  color: #000000;
}

.cardList:hover .card {
  box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.5);
  -webkit-transition: 0.35s ease-out transform, 0.35s ease-out shadow;
  transition: 0.35s ease-out transform, 0.35s ease-out shadow;
}

.cardList:nth-child(2n + 1) .card:nth-child(1) {
  -webkit-transform: translate(-2%, -2%);
  transform: translate(-2%, -2%);
}

.cardList:nth-child(2n + 1) .card:nth-child(2) {
  -webkit-transform: translate(-2%, 2%) rotate(2deg);
  transform: translate(-2%, 2%) rotate(2deg);
}

.cardList:nth-child(2n + 1) .card:last-of-type {
  -webkit-transform: rotate(-2deg);
  transform: rotate(-2deg);
}

.cardList:nth-child(2n + 1):hover .card__bg {
  -webkit-filter: none;
  filter: none;
  opacity: 1;
}

.cardList:nth-child(2n + 1):hover .card:nth-child(1) {
  -webkit-transform: translate(30%, 45%) rotate(-2deg);
  transform: translate(30%, 45%) rotate(-2deg);
}

.cardList:nth-child(2n + 1):hover .card:nth-child(2) {
  -webkit-transform: translate(-50%, 35%) rotate(5deg);
  transform: translate(-50%, 35%) rotate(5deg);
}

.cardList:nth-child(2n + 1):hover .card:last-of-type {
  -webkit-transform: rotate(5deg) translate(0%, -40%);
  transform: rotate(5deg) translate(0%, -40%);
}

.cardList:nth-child(2n) .card:nth-child(1) {
  -webkit-transform: translate(2%, 2%);
  transform: translate(2%, 2%);
}

.cardList:nth-child(2n) .card:nth-child(2) {
  -webkit-transform: translate(2%, -2%) rotate(-2deg);
  transform: translate(2%, -2%) rotate(-2deg);
}

.cardList:nth-child(2n) .card:nth-child(3) {
  -webkit-transform: rotate(2deg);
  transform: rotate(2deg);
}

.cardList:nth-child(2n):hover .card:nth-child(1) {
  -webkit-transform: translate(2%, 50%) rotate(5deg);
  transform: translate(2%, 50%) rotate(5deg);
}

.cardList:nth-child(2n):hover .card:nth-child(2) {
  -webkit-transform: translate(50%, -30%) rotate(10deg);
  transform: translate(50%, -30%) rotate(10deg);
}

.cardList:nth-child(2n):hover .card:nth-child(3) {
  -webkit-transform: translate(-25%, -40%) rotate(-5deg);
  transform: translate(-25%, -40%) rotate(-5deg);
}

.card {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  padding-top: 60%;
  background-color: #ccc;
  -webkit-transition: 0.28s ease-out transform, 0.28s ease-out shadow;
  transition: 0.28s ease-out transform, 0.28s ease-out shadow;
  overflow: hidden;
  z-index: 5;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.2);
}

.card__bg {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-repeat: no-repeat;
  background-size: cover;
  background-color: #ccc;
}

.card:not(:last-of-type) .card__bg {
  background-blend-mode: multiply;
  -webkit-filter: grayscale(100%);
  filter: grayscale(100%);
  opacity: 0.25;
  -webkit-transition: 0.25s ease-in-out filter, 0.25s ease-in-out opacity;
  transition: 0.25s ease-in-out filter, 0.25s ease-in-out opacity;
}

.cardList:hover .card:not(:last-of-type) .card__bg {
  background-blend-mode: normal;
  -webkit-filter: none;
  filter: none;
  opacity: 1;
}

.container:hover .cardList {
  -webkit-filter: grayscale(100%);
  filter: grayscale(100%);
  opacity: 0.25;
  z-index: 1;
}

.container:hover .cardList:hover {
  -webkit-filter: none;
  filter: none;
  opacity: 1;
  z-index: 100;
}
</style>
<!--?php
echo "<pre>";
print_r($dados);
echo "</pre>";
?-->
<section>
  <!--div class="row"-->
  <div class="containerX">
    <div class="col-sm-12">
      <div class="row">
        <div class="section-header text-center">
          <h3>Galeria de Fotos - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
      </div>
      <div class="btn-back">
        <?php echo anchor('site/inicio/' . $city, '
            Voltar', array('class' => "btn btn-danger"));
                        ?>
      </div>
    </div>
    <?php
                $count = 0;
                foreach ($catArray as $item) {
                    ?>
    <div class="cardList col-xs-4">
      <?php
                        $count++;
                        foreach ($item['fotos'] as $foto) {
                            $id = $item['id'];
                            ?>
      <div class="card">
        <div class="card__bg">
          <a href="<?php
                                    echo base_url("/site/galeria_fotos/$city/$id");
                                    ?>">
            <img src="<?php echo base_url($foto->file); ?>">
          </a>
        </div>
      </div>
      <?php
                        }
                        ?>
      <span class="cardList__title"> <?php echo substr($item['title'],0,36); ?></span>
    </div>
    <?php
                }
                if($count > 11){
                ?>
    <div class="btn-back">
      <?php echo anchor('site/inicio/' . $city, '
            Voltar', array('class' => "btn btn-danger"));
                    ?>
    </div>
    <?php
                }
                ?>
  </div>
  </div>
</section>
<br>
<!------ Include the above in your HEAD tag ---------->
<!-- link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script-->