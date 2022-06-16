
<section class="services-section p-b-70" >
    <div class="container">

        <div class="section-header text-center">
            <h3>Revistas e Periódicos</h3>
            <span class="double-border"></span>
        </div>


        <div class="row">
            <?php 
            foreach($areaslinks as $links){
                echo anchor("site/links_revistas/$links->id", "
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


