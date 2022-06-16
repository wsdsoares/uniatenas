<?php
$uricampus = $this->uri->segment(3);
?>
<section class="services-section p-b-70" >
    <div class="container">

        <div class="section-header text-center">
            <h3>Revistas e Periódicos <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
        <div class="btn-back">
            <?php echo anchor('site/biblioteca/'.$uricampus, '
            Voltar', array('class' => "btn btn-danger"));
            ?>
        </div>

        <div class="row">
            <?php
            foreach($areaslinks as $links){
                echo anchor("site/links_revistas/$uricampus/$links->id", "
                <div class='col-md-3 col-xs-12'>
                   <div class='magazines-newspapers'>
                       <h4>
                       $links->title   
                   </h4>
                   </div>
               </div>
             ");
            }
             ?>
        </div>

    </div>
</section>




