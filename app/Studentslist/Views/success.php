<?php
require 'header.php';
?>
<body>
<?php require 'navbar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="alert alert-success">
                <p><strong><?= $data['title'] ?></strong></p>
                <p><a href="<?= $data['host'] ?>">Вернуться на главную страницу</a></p>
                <p class="text-muted">Вы будете автоматически перемещены на главную страницу через 5 секунд</p>
            </div>
        </div>
    </div>
    <?php
    require 'footer.php';
