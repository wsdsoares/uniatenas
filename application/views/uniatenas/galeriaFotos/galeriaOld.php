<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<style>
    * {box-sizing: border-box}

    /* Style the tab */
    .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        width: 30%;

    }

    /* Style the buttons inside the tab */
    .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current "tab button" class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;

    }
</style>

<section>
    <div class="container">
        <div class="row">
            <h3 class="col-xs-12">Galeria - Fotos UniAtenas</h3>
        </div>

        <div class="tab">
            <?php
            $count = 0;
            foreach ($catArray as $item) {

                if ($count == 0) {
                    $default = 'id="defaultOpen"';
                } else {
                    $default = '';
                }
                ?>
                <button class="tablinks" onclick="openCity(event, '<?php echo $item['categoria']; ?>')" <?php echo $default; ?>><?php echo $item['title']; ?></button>
                <?php
                $count++;
            }
            ?>
        </div>
        <?php
        foreach ($catArray as $item) {
            ?>
            <div id="<?php echo $item['categoria']; ?>" class="tabcontent">

                <div class="row">
                    
                    <?php
                    foreach ($item['fotos'] as $picture) {
                        ?>

                        <div class='list gallery'>
                            <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                <a class="thumbnail fancybox" rel="ligthbox" href="<?php echo base_url($picture->file); ?>">
                                    <img class="img-responsive" alt="" src="<?php echo base_url($picture->file); ?>" />
                                    <!--div class='text-right'>
                                        <small class='text-muted'>Image Title</small>
                                    </div--> 
                                </a>
                            </div>

                        </div> 
                        
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<br>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>

<script>
    $(document).ready(function () {
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
    });


</script>

