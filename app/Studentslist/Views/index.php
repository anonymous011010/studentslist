<?php
require 'header.php';
?>
<body>
<?php require 'navbar.php'; ?>
    <div class="container">
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><a href="<?= $tableHelper->getLinkForColumn('fname') ?>">Имя <?= ($tableHelper->isActiveColumn('fname')) ? '<i class="glyphicon  ' . $tableHelper->getChevron() . ' "\></i>' : '' ?></a></th>
                        <th><a href="<?= $tableHelper->getLinkForColumn('sname') ?>">Фамилия <?= ($tableHelper->isActiveColumn('sname')) ? '<i class="glyphicon  ' . $tableHelper->getChevron() . ' "\></i>' : '' ?></a></th>
                        <th><a href="<?= $tableHelper->getLinkForColumn('group') ?>">Группа <?= ($tableHelper->isActiveColumn('group')) ? '<i class="glyphicon  ' . $tableHelper->getChevron() . ' "\></i>' : '' ?></a></th>
                        <th><a href="<?= $tableHelper->getLinkForColumn('examScore') ?>">Баллы <?= ($tableHelper->isActiveColumn('examScore')) ? '<i class="glyphicon  ' . $tableHelper->getChevron() . ' "\></i>' : '' ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($data['students'])) :
                        foreach ($data['students'] as $student):
                            ?>
                            <tr>
                                <td class="<?= ($tableHelper->isActiveColumn('fname')) ? 'active' : '' ?>"><?php echo htmlspecialchars($student['fname'], ENT_QUOTES); ?></td>
                                <td class="<?= ($tableHelper->isActiveColumn('sname')) ? 'active' : '' ?>"><?php echo htmlspecialchars($student['sname'], ENT_QUOTES); ?></td>
                                <td class="<?= ($tableHelper->isActiveColumn('group')) ? 'active' : '' ?>"><?php echo htmlspecialchars($student['group'], ENT_QUOTES); ?></td>
                                <td class="<?= ($tableHelper->isActiveColumn('examScore')) ? 'active' : '' ?>"><?php echo htmlspecialchars($student['examScore'], ENT_QUOTES); ?></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
            <?php require 'pagination.php'; ?>
        </div>
    </div>
    <?php
    require 'footer.php';
