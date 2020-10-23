<nav class="text-center">
    <ul class="pagination">
        <li class="page-item">
            <?php
            if($pagina_anterior != 0){ ?>
                <a class="page-link" href="?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
                    <svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-arrow-left-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5.5a.5.5 0 0 0 0-1H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5z"/>
                    </svg>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Previous">
                    <svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-arrow-left-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5.5a.5.5 0 0 0 0-1H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5z"/>
                    </svg>
                </a>
            <?php }  ?>
        </li>
        <?php $pagina_ant = $pagina - 1; ?>
        <?php $pagina_atual = $pagina; ?>
        <?php $pagina_pos = $pagina + 1; ?>
        <?php if($pagina_anterior != 0){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_ant; ?>"><?php echo $pagina_ant; ?></a></li>
        <?php }?>
        <li class="page-item"><a style="color:black"class="page-link"><?php echo $pagina_atual; ?></a></li>
        <?php if($pagina_posterior <= $num_pagina){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_pos; ?>"><?php echo $pagina_pos; ?></a></li>
        <?php } ?>
        <li>
            <?php
            if($pagina_posterior <= $num_pagina){ ?>
                <a class="page-link" href="?pagina=<?php echo $pagina_posterior; ?>" aria-label="Next">
                    <svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"/>
                    </svg>
                </a>
            <?php }else{ ?>
                <a class="page-link" aria-label="Next">
                    <svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"/>
                    </svg>
                </a>
            <?php }  ?>
        </li>
    </ul>
</nav>