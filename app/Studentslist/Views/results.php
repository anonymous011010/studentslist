<?php
require 'header.php';
?>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <div class="row">
            <?php if (!isset($data['search'])) : ?>
                <div class="alert alert-warning" role="alert"><p>Вы ввели пустой запрос.</p>
                    <p><a href="<?= $data['host'] ?>">Показать всех студентов</a></p></div><?php else : ?>
                <div class="alert alert-info" role="alert">
                    <p>Показаны только абитуриенты, найденные по запросу «<?= htmlspecialchars($data['search']) ?>».</p>
                    <p><a href="<?= $data['host'] ?>">Показать всех студентов</a></p>
                </div>
                <?php require 'table.php'; ?>
                <?php require 'pagination.php'; ?>
            </div>
        </div>
    <?php
    endif;
    require 'footer.php';
    