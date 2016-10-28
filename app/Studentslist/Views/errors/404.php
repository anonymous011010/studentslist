<?php
require __DIR__ . '/../header.php';
?>
<body>
    <?php require __DIR__ . '/../navbar.php'; ?>
    <div class="container">
        <div class="row">
            <h1 id="errorMessage"><?= $data['title'] ?> </h1>
            <h3>Запрашиваемая страница не найдена.</h3>
            <p><a href="<?= $data['host'] ?>">Вернуться на главную</a></p>
        </div>
    </div>
    <?php
    require __DIR__ . '/../footer.php';
    