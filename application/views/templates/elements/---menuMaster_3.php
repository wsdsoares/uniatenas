<?php
$queryPtu = "SELECT
campus_has_courses.id idCourseCAmpus,
courses.id as courseId,
courses.name as nameCourse,
campus.id as campusId,
campus.name as campusName

FROM
at_site.campus_has_courses
inner join campus on campus.id = campus_has_courses.campus_id
inner join courses on courses.id = campus_has_courses.courses_id
WHERE campus.id = 1
ORDER BY courses.name";

$queryPassos = "SELECT
campus_has_courses.id idCourseCAmpus,
courses.id as courseId,
courses.name as nameCourse,
campus.id as campusId,
campus.name as campusName

FROM
at_site.campus_has_courses
inner join campus on campus.id = campus_has_courses.campus_id
inner join courses on courses.id = campus_has_courses.courses_id
WHERE campus.id = 2";


$querySeteL = "SELECT
campus_has_courses.id idCourseCAmpus,
courses.id as courseId,
courses.name as nameCourse,
campus.id as campusId,
campus.name as campusName

FROM
at_site.campus_has_courses
inner join campus on campus.id = campus_has_courses.campus_id
inner join courses on courses.id = campus_has_courses.courses_id
WHERE campus.id = 3";
$cursosParacatu = $this->bancosite->getQuery($queryPtu)->result();
$cursosPassos = $this->bancosite->getQuery($queryPassos)->result();
$cursosSeteLagoas = $this->bancosite->getQuery($querySeteL)->result();
?>
<script>
    $('.dropdown-toggle').click(function (e) {
        if ($(document).width() > 768) {
            e.preventDefault();

            var url = $(this).attr('href');


            if (url !== '#') {

                window.location.href = url;
            }

        }
    });
</script>

<div data-container="menu" class="headermenu">

    <header class="header navbar navbar-fixed-top">
        <!-- Start Menu -->
        <div class="bg-main-menu">
            <div class="container-fluid">
                <div class="row">

                    <div class="bg-header-top">
                        <div class="container">
                            <div class="row">
                                <ul class="header-contact">

                                    <li><a href="https://www.facebook.com/uniatenasoficial/"><i
                                                class="fab fa-facebook-f"></i> <span
                                                class="top-page">Facebook</span></a></li>
                                    <li><a href="https://www.instagram.com/uniatenas/"><i
                                                class="fab fa-instagram"></i><span
                                                class="top-page"> Instagram</span></a></li>
                                    <li><a href="https://www.youtube.com/user/tvatenas"><i
                                                class="fab fa-youtube"></i><span
                                                class="top-page">TV - UniAtenas</span></a></li>
                                </ul>
                                <div class="log-reg">
                                    <a href="https://webmail-seguro.com.br/atenas.edu.br/"><i
                                            class="fa fa-envelope"></i> <span class="top-page">Webmail</span></a>
                                        <?php
                                        echo anchor('PortalAlunos/portais', '<i class="fas fa-user-lock"></i><span class="top-page-alunos"> Portal Acadêmico</span></a>');
                                        ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">

                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <ul class="exo-menu">


                                <div class="collapse navbar-collapse js-navbar-collapse">
                                    <ul class="nav navbar-nav">
                                        <li>
                                            <div class="logooficial">
                                                <?php echo anchor('site', '<img src="' . base_url() . 'assets/images/logo.png" alt="logo" class="img-fluid" />', array('class' => 'logooficial')); ?>
                                            </div>
                                        </li>
                                        <li class="dropdown mega-dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>

                                            <ul class="dropdown-menu mega-dropdown-menu row">
                                                <li class="col-sm-3">
                                                    <ul>
                                                        <li class="dropdown-header">New in Stores</li>                            
                                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <div class="item active">
                                                                    <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
                                                                    <h4><small>Summer dress floral prints</small></h4>                                        
                                                                    <button class="btn btn-primary" type="button">&#163;49,99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>       
                                                                </div><!-- End Item -->
                                                                <div class="item">
                                                                    <a href="#"><img src="http://placehold.it/254x150/ef5e55/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
                                                                    <h4><small>Gold sandals with shiny touch</small></h4>                                        
                                                                    <button class="btn btn-primary" type="button">&#163;9,99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>        
                                                                </div><!-- End Item -->
                                                                <div class="item">
                                                                    <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
                                                                    <h4><small>Denin jacket stamped</small></h4>                                        
                                                                    <button class="btn btn-primary" type="button">&#163;49,99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>      
                                                                </div><!-- End Item -->                                
                                                            </div><!-- End Carousel Inner -->
                                                        </div><!-- /.carousel -->
                                                        <li class="divider"></li>
                                                        <li><a href="#">View all Collection <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-3">
                                                    <ul>
                                                        <li class="dropdown-header">Dresses</li>
                                                        <li><a href="#">Unique Features</a></li>
                                                        <li><a href="#">Image Responsive</a></li>
                                                        <li><a href="#">Auto Carousel</a></li>
                                                        <li><a href="#">Newsletter Form</a></li>
                                                        <li><a href="#">Four columns</a></li>
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Tops</li>
                                                        <li><a href="#">Good Typography</a></li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-3">
                                                    <ul>
                                                        <li class="dropdown-header">Jackets</li>
                                                        <li><a href="#">Easy to customize</a></li>
                                                        <li><a href="#">Glyphicons</a></li>
                                                        <li><a href="#">Pull Right Elements</a></li>
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Pants</li>
                                                        <li><a href="#">Coloured Headers</a></li>
                                                        <li><a href="#">Primary Buttons & Default</a></li>
                                                        <li><a href="#">Calls to action</a></li>
                                                    </ul>
                                                </li>
                                                <li class="col-sm-3">
                                                    <ul>
                                                        <li class="dropdown-header">Accessories</li>
                                                        <li><a href="#">Default Navbar</a></li>
                                                        <li><a href="#">Lovely Fonts</a></li>
                                                        <li><a href="#">Responsive Dropdown </a></li>							
                                                        <li class="divider"></li>
                                                        <li class="dropdown-header">Newsletter</li>
                                                        <form class="form" role="form">
                                                            <div class="form-group">
                                                                <label class="sr-only" for="email">Email address</label>
                                                                <input type="email" class="form-control" id="email" placeholder="Enter email">                                                              
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                        </form>                                                       
                                                    </ul>
                                                </li>
                                            </ul>

                                        </li>
                                    </ul>

                                </div>
                            </ul>

                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </header>
</div>

<?php
$pagina = $this->uri->segment(2);
$controller = $this->uri->segment(1);

if ((isset($pagina)) and $controller != 'Site') {
    ?>
    <nav aria-label="breadcrumb" class="topbreadcrumb">
        <ol class="breadcrumb ">
            <div class="container">
                <?php
                echo breadcrumb();
                ?>
            </div>
        </ol>
    </nav>
    <?php
}
?>
