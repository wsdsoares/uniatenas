<li>
  <a href="javascript:void(0);" class="menu-toggle">
    <i class="material-icons">assignment</i>
    <span>PESQUISA</span>
  </a>
  <ul class="ml-menu">
    <li>
      <a href="javascript:void(0);" class="menu-toggle">
        <span>Publicações</span>
      </a>
      <ul class="ml-menu">
        <li>
          <?php
                    echo anchor('publicacoes/revistas', '
                                                <span>Revistas</span>');
                    ?>
        </li>
        <li>
          <?php
                    echo anchor('publicacoes/cursosMonografia', '
                                                <span>Monografias</span>');
                    ?>
        </li>
        <li>
          <?php
                    //comentado até a definição correta do processo
                    /*echo anchor('publicacoes/anaisMonografia', '
                                                <span>Anais</span>');*/
                    ?>
        </li>

      </ul>
    </li>
  </ul>
</li>