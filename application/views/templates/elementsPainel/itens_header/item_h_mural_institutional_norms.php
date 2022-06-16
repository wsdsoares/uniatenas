<?php
// $permissionCampusArray = $_SESSION['permissionCampus'];
?>

<li>
  <a href="javascript:void(0);" class="menu-toggle">
    <i class="material-icons">desktop_windows</i>
    <span>Mural - TV Digital</span>
  </a>

  <ul class="ml-menu">
    <?php
                    //if (in_array("visNormasIns", $permissionCampusArray['campus-1'])) {
                        ?>

    <li>
      <?php
                            echo anchor('Painel_mural_digital/normas_institucionais', '<span>Arquivos</span>');
                            ?>
    </li>
    <?php
                   // }
        ?>
  </ul>
</li>