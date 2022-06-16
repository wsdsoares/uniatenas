<style>
.foundation {
  border: 1px solid #ccc;
  padding: 0 0 5px;
}

.foundation h3 {
  border-bottom: 1px solid #ccc;
  padding-left: 3%;
  margin-top: 0px;
  padding-top: 5px;
  padding-bottom: 5px;
  font-size: 16px;
}

.foundation_sm ul {
  margin: 0px;
  padding: 0px;
}

.foundation_sm li {
  list-style: none;
}

.foundation_sm li i {
  padding-right: 6px;
}

.mapsBtn {
  text-align: center;
}

.mapsBtn a {
  background: #f1f1f1;
  border: 1px solid #f1f1f1;
  text-align: center;
}

.mapsBtn a:hover {
  background: #fff;
  border: 1px solid #000;
  text-align: center;
}

.mapsBtn a p {
  padding: 10px
}
</style>

<div class="container">
  <div class="locationCampus">
    <div class="row">
      <div class="section-header">

        <h3 class="text-center">Localização Campus -
          <?php echo $dados['campus']->name . '-' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?></h3>

      </div>
      <div class="col-md-4 center-block">
        <div class="section-box-four">
          <figure>
            <h4>
              <?php echo $dados['campus']->name . ' <br/>' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?>
            </h4>
            <p><?php echo $dados['campus']->description; ?></p>
            <a href="<?php echo $dados['campus']->locationMaps; ?>" class="btn btn-read" target="_blank">Ver
              Localização.</a>
          </figure>
          <img src="<?php echo base_url($dados['campus']->iconeCampus); ?>" class="img-responsive" />
        </div>
      </div>
      <div class="col-md-8">
        <div class="col-md-12 foundation">
          <h3><?php 
                    
                    echo $dados['campus']->name . ' ' . $dados['campus']->city . ' (' . $dados['campus']->uf . ')'; ?>
          </h3>
          <div class="col-md-12 foundation_sm">
            <ul>
              <li>
                <p><i class="fas fa-archway"></i><?php echo $dados['campus']->description; ?></p>
              </li>
              <br>
              <li><i class="fas fa-map-marked-alt"></i><?php echo $dados['campus']->street ?></li>
              <br>
              <div class="mapsBtn">
                <a href="<?php echo $dados['campus']->locationMaps; ?>" target="_blank">
                  <img src="https://developers.google.com/maps/images/lhimages/api/icon_placesapi.svg" height="48"
                    width="48" />
                  <p>
                    Acessar à localização do campus.
                  </p>
                </a>
              </div>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="outherCampusBottom">
      <div class="row">
        <div class="section-header">
          <h3 class="text-center">Veja abaixo os campus que fazem parte do grupo UniAtenas</h3>
        </div>
        <div class="col-md-offset-4"></div>
        <?php
                foreach ($dados['outherCampus'] as $local) {
                    if ($local->city != $dados['campus']->city) {
                        ?>
        <div class="col-md-4 center-block">
          <div class="section-box-four">
            <figure>
              <h4><?php echo $local->name . ' <br/>' . $local->city . ' (' . $dados['campus']->uf . ')'; ?></h4>
              <p><?php echo $local->description; ?></p>
              <a href="<?php echo $local->locationMaps; ?>" class="btn btn-read" target="_blank">Ver
                Localização.</a>
            </figure>
            <img src="<?php echo base_url($local->iconeCampus); ?>" class="img-responsive" />
          </div>
        </div>
        <?php
                    }
                }
                ?>
      </div>
    </div>
  </div>
</div>


<style>
.section-box-four h4,
.section-box-four h4 {
  color: #fff;
}

.outherCampusBottom {
  margin: 30px 0 20px 0;
}

.locationCampus {
  margin-bottom: 20px;
}

figure p {
  color: #fafafa;
  margin-bottom: 10px;
}

.btn-read {
  background: transparent;
  border-radius: 0;
  border: 1px solid #ffffff;
  color: #fff;
}

.section-box-four {
  height: 255px;
  background: radial-gradient(#6e6e6e, #2f2f2f);
  background: -webkit-radial-gradient(#6e6e6e, #2f2f2f);
  background: -moz-radial-gradient(#6e6e6e, #2f2f2f);
  color: #fff;
  position: relative;
  overflow: hidden;
}

.section-box-four figure {
  position: absolute;
  text-align: center;
  padding: 19px;
  width: 100%;
  height: 100%;
}

.section-box-four img {
  height: 100%;
  position: absolute;
  transition: ease-in-out .5s;
  -webkit-transition: ease-in-out .5s;
  -moz-transition: ease-in-out .5s;
}

.section-box-four:hover img {
  transform: translate(-100%, 0);
  -webkit-transform: translate(-100%, 0);
  -moz-transform: translate(-100%, 0);
}
</style>