<main class="page__main">
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Добро пожаловать <?= $NAME; ?>!</h2>
            <div class="profile__colums">
                <div class="profile__col">
                        <fieldset class="profile__field">
                            <legend class="profile__title">Логин</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-login">
                                <input class="input profile__input" type="text" name="login" value=" <?= $login; ?> ">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Сменить пароль</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-password">
                                <input class="input profile__input" type="password" name="password-old" value=""
                                       placeholder="Старый пароль">
                                <input class="input profile__input" type="password" name="password-new" value=""
                                       placeholder="Новый пароль">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Имя</legend>
                            <form action="/control.php" method="post">
                                <input type="hidden" name="action" value="change-name">
                                <input class="input profile__input" type="text" name="name" value=" <?= $NAME; ?> ">
                                <input type="submit" class="button profile__button" value="Обновить">
                            </form>
                        </fieldset>
                </div>
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Информация</legend>
                        <ul class="profile__list">
                            <li class="profile__item">Дата регистрации: <?= $registration_date; ?> </li>
                            <li class="profile__item">Дата последней авторизации: </li>
                            <li class="profile__item">
                                Статус: <?php if($status == 'active') {
                                    print('Активен');
                                } else {
                                    print('Удалён');
                                } ?>
                            </li>
                            <?php if ($status == 'deleted') : ?>
                                <li class="profile__item">Дата удаления:
                                    <? $delete_date; ?>
                                </li>
                            <? endif; ?>
                        </ul>
                    </fieldset>
                </div>
            </div>
            <div class="profile__colums">
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Предпочтения</legend>
                        <form action="/control.php" method="POST">
                            <input type="hidden" name="action" value="update-prefs">
                            <ul class="profile__list gem__list">
                                <?php foreach ($gem_types as $type): ?>
                                    <li class="gem__item">
                                        <label>
                                            <span class="gem__text"><?= $type['name']; ?></span>
                                            <input class="input gem__input" type="number" name="<?= $type['id']; ?>" value="0"
                                                   min="0" max="1"
                                                   step="0.01">
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <input type="submit" class="button profile__button" value="Обновить">
                        </form>
                    </fieldset>
                </div>
                <section class="profile__col">
                    <h2 class="profile__title">Ожидающие подтверждения камни:</h2>
                    <ul class="profile__list">
                        <li class="gem__item">
                                <span class="gem__text">
                                    Хризолит
                                </span>
                            <a href="" class="button">Подтвердить</a>
                        </li>
                        <li class="gem__item">
                                <span class="gem__text">
                                    Хризолит
                                </span>
                            <a href="" class="button">Подтвердить</a>
                        </li>
                        <li class="gem__item">
                                <span class="gem__text">
                                    Хризолит
                                </span>
                            <a href="#" class="button">Подтвердить</a>
                        </li>
                    </ul>
                </section>
            </div>
        </section>
    </div>
</main>