<main>
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Добро пожаловать <?=$NAME;?>!</h2>
            <div class="profile__colums">
                <div class="profile__col">
                        <fieldset class="profile__field">
                            <legend class="profile__title">Логин</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-login">
                                <input type="hidden" name="changed_user" value="<?=$login;?>">
                                <input class="input profile__input" type="text" name="login" value="<?=$login;?>">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Сменить пароль</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-password">
                                <input type="hidden" name="changed_user" value="<?=$login;?>">
                                <input class="input profile__input" type="password" name="password-new" value=""
                                       placeholder="Новый пароль">
                                <input class="input profile__input" type="password" name="password-repeat" value=""
                                       placeholder="Повторите пароль">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Имя</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-name">
                                <input type="hidden" name="changed_user" value="<?=$login;?>">
                                <input class="input profile__input" type="text" name="name" value="<?=$NAME;?>">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                </div>
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Информация</legend>
                        <ul class="profile__list">
                            <li class="profile__item">Дата регистрации: <?= $registration_date; ?></li>
                            <li class="profile__item">Дата последней авторизации: </li>
                            <li class="profile__item">
                                Статус:
                                <?php if($status == 'active') {
                                    print('Активен');
                                } else {
                                    print('Удалён');
                                }
                                ?>
                            </li>
                            <?php if ($status == 'deleted') : ?>
                                <li class="profile__item">Дата удаления:
                                    <? $delete_date; ?>
                                </li>
                            <? endif; ?>
                        </ul>
                    </fieldset>
                    <fieldset class="profile__field">
                        <legend class="profile__title">Метка мастера</legend>
                        <form action="/control.php" method="post">
                            <input type="hidden" name="action" value="change-master">
                            <label class="profile__checkbox">
                                <input type="checkbox"
                                       name="master-dwarf" <?php if ($role == 'master-dwarf') print('checked') ?>>
                                Мастер гном
                            </label>
                            <input type="submit" class="button profile__button" value="Обновить">
                        </form>
                    </fieldset>
                    <div>
                        <?php if (isset($messages['change'])) print ($messages['change']) ?>
                    </div>
                </div>
            </div>
            <div class="profile__colums">
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Добытые камни</legend>
                            <ul class="profile__list gem__list">
                                <?php foreach ($dwarf_gems as $gem): ?>
                                    <li class="gem__item">
                                        <label>
                                            <span class="gem__text"><?= $gem['name']; ?></span>
                                            <input class="input input--readonly gem__input" type="number" value="<?= $gem['num']; ?>" min="0" readonly>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                    </fieldset>
                </div>
            </div>
        </section>
    </div>
</main>
