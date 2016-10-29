<?php if ($paginator->pagesNum > 1) : ?>
    <ul class="pagination">
        <li class="<?= ($paginator->currentPage == 1) ? 'disabled' : '' ?>">
            <a href="<?= ($paginator->currentPage == 1) ? '#' : $paginator->getLinkForPreviousPage() ?>">&laquo;</a>
        </li>
        <li class="<?= ($paginator->currentPage == 1) ? 'active' : '' ?>">
            <a href="<?= $paginator->getLinkForPage(1) ?>"><?= 1 ?> <span class="sr-only"></span></a>
        </li>
        <?= ($paginator->getEllipsis('right')) ? '<li class="disabled"><a href="#">…</a></li>' : '' ?>
        <?php
        if ($paginator->pagesNum >= 3) :
            for ($i = $paginator->startPage; $i <= $paginator->visiblePages; $i++) :
                if ($i < $paginator->pagesNum) :
                    ?>
                    <li class="<?= ($i == $paginator->currentPage) ? 'active' : '' ?>">
                        <a href="<?= $paginator->getLinkForPage($i) ?>"><?= $i ?> <span class="sr-only"></span></a>
                    </li>
                    <?php
                endif;
            endfor;
        endif;
        ?>
        <?= ($paginator->getEllipsis('left')) ? '<li class="disabled"><a href="#">…</a></li>' : '' ?>
        <li class="<?= ($paginator->currentPage == $paginator->pagesNum) ? 'active' : '' ?>">
            <a href="<?= $paginator->getLinkForPage($paginator->pagesNum) ?>"><?= $paginator->pagesNum ?> <span class="sr-only"></span></a>
        </li>
        <li class="<?= ($paginator->currentPage == $paginator->pagesNum) ? 'disabled' : '' ?>">
            <a href="<?= ($paginator->currentPage == $paginator->pagesNum) ? '#' : $paginator->getLinkForNextPage() ?>">&raquo;</a>
        </li>
    </ul>
    <?php
 endif;