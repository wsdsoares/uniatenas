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
<style>
    .navbar-default {
        color: #000;
        border-color: #aca1a2;
    }
    .navbar-default .navbar-nav > li > a {
        color:#000;
    }
    .navbar-default .navbar-nav > .dropdown > a .caret {
        border-top-color: #000;
        border-bottom-color: #000;
    }
    .navbar-default .navbar-brand {
        color:#000;
    }
    .menu-large {
        position: static !important;
    }
</style>
<script>
    // Dropdown Menu Fade
    jQuery(document).ready(function () {
        $(".dropdown").hover(

            function () {
                $('.dropdown-menu', this).stop().fadeIn("fast");
            },

            function () {
                $('.dropdown-menu', this).stop().fadeOut("fast");
            });
    });
</script>




    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button> <a class="navbar-brand" href="#">Logo</a>

            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a>

                    </li>
                    <li class="dropdown menu-large"> <a href="# " class="dropdown-toggle" data-toggle="dropdown"> Product Listing <b class="caret "></b> </a>

                        <ul class="dropdown-menu megamenu row">
                            <li>
                                <div class="col-sm-6 col-md-3"> <a href="# " class="thumbnail">
                                        <img src="http://placehold.it/150x120" />
                                    </a>

                                </div>
                                <div class="col-sm-6 col-md-3">	<a href="# " class="thumbnail">
                                        <img src="http://placehold.it/150x120" />
                                    </a>

                                </div>
                                <div class="col-sm-6 col-md-3">	<a href="# " class="thumbnail">
                                        <img src="http://placehold.it/150x120" />
                                    </a>

                                </div>
                                <div class="col-sm-6 col-md-3"> <a href="# " class="thumbnail">
                                        <img src="http://placehold.it/150x120" />
                                    </a>

                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown menu-large ">	<a href="# " class="dropdown-toggle " data-toggle="dropdown ">Categories <b class="caret "></b></a>
                        <ul class="dropdown-menu megamenu row ">
                            <li class="col-sm-3 ">
                                <ul>
                                    <li class="dropdown-header ">Glyphicons</li>
                                    <li><a href="# ">Available glyphs</a>

                                    </li>
                                    <li class="disabled "><a href="# ">How to use</a>

                                    </li>
                                    <li><a href="# ">Examples</a>

                                    </li>
                                    <li class="divider "></li>
                                    <li class="dropdown-header ">Dropdowns</li>
                                    <li><a href="# ">Example</a>

                                    </li>
                                    <li><a href="# ">Aligninment options</a>

                                    </li>
                                    <li><a href="# ">Headers</a>

                                    </li>
                                    <li><a href="# ">Disabled menu items</a>

                                    </li>
                                </ul>
                            </li>
                            <li class="col-sm-3 ">
                                <ul>
                                    <li class="dropdown-header ">Button groups</li>
                                    <li><a href="# ">Basic example</a>

                                    </li>
                                    <li><a href="# ">Button toolbar</a>

                                    </li>
                                    <li><a href="# ">Sizing</a>

                                    </li>
                                    <li><a href="# ">Nesting</a>

                                    </li>
                                    <li><a href="# ">Vertical variation</a>

                                    </li>
                                    <li class="divider "></li>
                                    <li class="dropdown-header ">Button dropdowns</li>
                                    <li><a href="# ">Single button dropdowns</a>

                                    </li>
                                </ul>
                            </li>
                            <li class="col-sm-3 ">
                                <ul>
                                    <li class="dropdown-header ">Input groups</li>
                                    <li><a href="# ">Basic example</a>

                                    </li>
                                    <li><a href="# ">Sizing</a>

                                    </li>
                                    <li><a href="# ">Checkboxes and radio addons</a>

                                    </li>
                                    <li class="divider "></li>
                                    <li class="dropdown-header ">Navs</li>
                                    <li><a href="# ">Tabs</a>

                                    </li>
                                    <li><a href="# ">Pills</a>

                                    </li>
                                    <li><a href="# ">Justified</a>

                                    </li>
                                </ul>
                            </li>
                            <li class="col-sm-3 ">
                                <ul>
                                    <li class="dropdown-header ">Navbar</li>
                                    <li><a href="# ">Default navbar</a>

                                    </li>
                                    <li><a href="# ">Buttons</a>

                                    </li>
                                    <li><a href="# ">Text</a>

                                    </li>
                                    <li><a href="# ">Non-nav links</a>

                                    </li>
                                    <li><a href="# ">Component alignment</a>

                                    </li>
                                    <li><a href="# ">Fixed to top</a>

                                    </li>
                                    <li><a href="# ">Fixed to bottom</a>

                                    </li>
                                    <li><a href="# ">Static top</a>

                                    </li>
                                    <li><a href="# ">Inverted navbar</a>

                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
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
