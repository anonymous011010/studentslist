<?php
require 'header.php';
?>
<body>
    <?php require 'navbar.php'; ?>
    <div class="container">
        <div class="row">
            <?php if (isset($data['CSRF-Error'])) : ?>
                <div class="alert alert-warning">
                    <strong>Запрос отклонен.</strong> Пожалуйста, проверьте, работают ли cookie файлы в вашем браузере, и повторите попытку снова.
                </div>
            <?php endif; ?>
            <?php if (isset($data['fail'])) : ?>
                <div class="alert alert-danger">
                    <strong>Ошибка.</strong> <?= isset($data['fail']['message']) ? $data['fail']['message'] : ''?>
                </div>
            <?php endif; ?>
            <div class="well bs-component">
                <form class="form-horizontal" method="post" action="<?= $navHelper->getFormLink() ?>">
                    <fieldset>

                        <!-- Название формы -->
                        <legend><?= $data['legend'] ?></legend>

                        <!-- Имя-->
                        <div <?= (!empty($data['errors']['fname'])) ? 'class="form-group has-error" id="warn-fname-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="fname">Имя</label>
                            <div class="col-md-4">
                                <input id="fname" name="fname" type="text" placeholder="Введите ваше имя" class="form-control input-md" required pattern="^[-'\sа-яёА-ЯЁ]{1,32}$"
                                       title="Допускаются только буквы русского алфавита, дефис, апостроф и пробел. От 1 до 32 символов." maxlength="32"
                                       value="<?= (!empty($data['student']['fname'])) ? htmlspecialchars($data['student']['fname'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['fname'])) ? "<span class=\"help-block\" id=\"warn-fname-span\">" . htmlspecialchars($data['errors']['fname'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Фамилия-->
                        <div <?= (!empty($data['errors']['sname'])) ? 'class="form-group has-error" id="warn-sname-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="sname">Фамилия</label>
                            <div class="col-md-4">
                                <input id="sname" name="sname" type="text" placeholder="Введите вашу фамилию" class="form-control input-md" required pattern="^[-'\sа-яёА-ЯЁ]{1,32}$"
                                       title="Допускаются только буквы русского алфавита, дефис, апостроф и пробел. От 1 до 32 символов." maxlength="32"
                                       value="<?= (!empty($data['student']['sname'])) ? htmlspecialchars($data['student']['sname'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['sname'])) ? "<span class=\"help-block\" id=\"warn-sname-span\">" . htmlspecialchars($data['errors']['sname'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Пол -->
                        <div <?= (!empty($data['errors']['gender'])) ? 'class="form-group has-error radiogn" id="warn-gender-div"' : 'class="form-group radiogn"' ?>>
                            <label class="col-md-4 control-label">Пол</label>
                            <div class="col-md-4">
                                <label class="radio-inline" for="male">
                                    <input type="radio" name="gender" id="male" value="male" required <?= (!empty($data['student']['gender']) && $data['student']['gender'] === 'male') ? 'checked' : '' ?>> Мужской
                                </label>
                                <label class="radio-inline" for="female">
                                    <input type="radio" name="gender" id="female" value="female" <?= (!empty($data['student']['gender']) && $data['student']['gender'] === 'female') ? 'checked' : '' ?>> Женский
                                </label>
                                <?= (!empty($data['errors']['gender'])) ? "<span class=\"help-block\" id=\"warn-gender-span\">" . htmlspecialchars($data['errors']['gender'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Название группы -->
                        <div <?= (!empty($data['errors']['group'])) ? 'class="form-group has-error" id="warn-group-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="group">Имя группы</label>
                            <div class="col-md-4">
                                <input id="group" name="group" type="text" placeholder="Введите имя вашей группы" class="form-control input-md" required pattern="^[а-яёА-ЯЁ0-9]{2,5}$"
                                       title="Допускаются только буквы русского алфавита и цифры. От 2 до 5 символов." maxlength="5"
                                       value="<?= (!empty($data['student']['group'])) ? htmlspecialchars($data['student']['group'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['group'])) ? "<span class=\"help-block\" id=\"warn-group-span\">" . htmlspecialchars($data['errors']['group'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Год рождения -->
                        <div <?= (!empty($data['errors']['byear'])) ? 'class="form-group has-error" id="warn-byear-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="byear">Год рождения</label>
                            <div class="col-md-4">
                                <input name="byear" id="byear" type="number" min="1905" max="2004" maxlength="4" class="form-control input-md" placeholder="Введите год вашего рождения" required
                                       title="Введите корректный год рождения. От 1905 до 2004." value="<?= (!empty($data['student']['byear'])) ? htmlspecialchars($data['student']['byear'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['byear'])) ? "<span class=\"help-block\" id=\"warn-byear-span\">" . htmlspecialchars($data['errors']['byear'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Email -->
                        <div <?= (!empty($data['errors']['email'])) ? 'class="form-group has-error" id="warn-email-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="email">E-mail</label>
                            <div class="col-md-4">
                                <input name="email" type="email" class="form-control" placeholder="Введите ваш E-mail" id="email" required
                                       title="Введите корректный E-mail адрес" value="<?= (!empty($data['student']['email'])) ? htmlspecialchars($data['student']['email'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['email'])) ? "<span class=\"help-block\" id=\"warn-email-span\">" . htmlspecialchars($data['errors']['email'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Сумма баллов ЕГЭ -->
                        <div <?= (!empty($data['errors']['examScore'])) ? 'class="form-group has-error" id="warn-examScore-div"' : 'class="form-group"' ?>>
                            <label class="col-md-4 control-label" for="examScore">Сумма баллов ЕГЭ</label>
                            <div class="col-md-4">
                                <input name="examScore" type="number" min="1" max="300" class="form-control input-md" id="examScore" placeholder="Введите вашу сумму баллов" required
                                       title="Введите корректную сумму баллов. От 1 до 300." value="<?= (!empty($data['student']['examScore'])) ? htmlspecialchars($data['student']['examScore'], ENT_QUOTES) : '' ?>">
                                       <?= (!empty($data['errors']['examScore'])) ? "<span class=\"help-block\" id=\"warn-examScore-span\">" . htmlspecialchars($data['errors']['examScore'], ENT_QUOTES) . "</span> " : '' ?>
                            </div>
                        </div>

                        <!-- Местный или иногородний -->
                        <div <?= (!empty($data['errors']['local'])) ? 'class="form-group last has-error" id="warn-local-div"' : 'class="form-group last"' ?>>
                            <label class="col-md-4 control-label">Место жительства</label>
                            <div class="col-md-4">
                                <label class="radio-inline" for="local">
                                    <input type="radio" name="local" id="local" value="true" required <?= (!empty($data['student']['local']) && $data['student']['local'] === 'true') ? 'checked' : '' ?>> Местный
                                </label>
                                <label class="radio-inline" for="non-local">
                                    <input type="radio" name="local" id="non-local" value="false" <?= (!empty($data['student']['local']) && $data['student']['local'] === 'false') ? 'checked' : '' ?>> Иногородний
                                </label>
                                <?= (!empty($data['errors']['local'])) ? "<span class=\"help-block\" id=\"warn-local-span\">" . htmlspecialchars($data['errors']['local'], ENT_QUOTES) . "</span> " : '' ?>

                            </div>
                        </div>

                        <!-- Анти-CSRF токен -->
                        <input type="hidden" value="<?= $data['AntiCSRF-TOKEN'] ?>" name="AntiCSRF-TOKEN">

                        <!-- Кнопка -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-4">
                                <button id="submit" name="submit" class="btn btn-primary">Отправить</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <?php
    require 'footer.php';
