
<!-- Start Page Header Section -->
<section class="bg-page-header bg-page-graduacao-ead">
    <div class="page-header-overlay">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <div class="page-title">

                    </div>
                    <div class="page-header-content">
                        <ol class="breadcrumb">

                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Page Header Section -->

<section class="course-content">
    <div class="container">
        <div class="row">
            <div class="our-courses">
                <div class="section-header title-principals">
                    <h2>Nossos Cursos</h2>
                    <span class="double-border"></span>
                    <p>Gradue-se nos melhores cursos do país.</p>
                </div>

                <div class="body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Graduação</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($cursos as $row) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i;?></th>
                                    <td><?php echo $row->name;?></td>
                                    <td>
                                        <a href=" <?php echo $row->links?>" class="btn btn-default" target="blank">
                                            Inscreva-se
                                        </a>
                                    </td>
                                </tr>

                                <?php
                                $i +=1;
                            }
                            ?>

                        </tbody>
                    </table>
                </div>


            </div>

        </div>
    </div>

</section>
<!-- End Recent Project Section -->
