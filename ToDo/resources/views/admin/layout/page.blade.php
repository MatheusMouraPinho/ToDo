<nav style="margin-bottom:50px"class="text-center">
    <ul class="pagination">
        <li class="page-item">
            <?php
            if($pagina_anterior != 0){ ?>
                <a class="page-link" href="?pagina=<?php echo "1"; ?>" aria-label="Primeira">
                    <i class="fa fa-angle-double-left" style="font-size:18px"></i>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Primeira">
                    <i class="fa fa-angle-double-left" style="font-size:18px"></i>
                </a>
            <?php }  ?>
        </li>
        <?php $pagina_ant = $pagina - 1; ?>
        <?php $pagina_atual = $pagina; ?>
        <?php $pagina_pos = $pagina + 1; ?>

        <?php if($pagina_anterior - 1 > 0){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_ant - 1; ?>"><?php echo $pagina_ant - 1; ?></a></li>
        <?php }?>
        <?php if($pagina_anterior != 0){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_ant; ?>"><?php echo $pagina_ant; ?></a></li>
        <?php }?>

        <li class="page-item"><a style="color:black"class="page-link"><?php echo $pagina_atual; ?></a></li>

        <?php if($pagina_posterior <= $num_pagina){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_pos; ?>"><?php echo $pagina_pos; ?></a></li>
        <?php } ?>
        <?php if($pagina_posterior + 1 <= $num_pagina){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_pos + 1; ?>"><?php echo $pagina_pos + 1; ?></a></li>
        <?php } ?>
        <li>
            <?php
            if($pagina_posterior <= $num_pagina){ ?>
                <a class="page-link" href="?pagina=<?php echo $num_pagina; ?>" aria-label="Ultima">
                    <i class="fa fa-angle-double-right" style="font-size:18px"></i>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Ultima">
                    <i class="fa fa-angle-double-right" style="font-size:18px"></i>
                </a>
            <?php }  ?>
        </li>
    </ul>
</nav>