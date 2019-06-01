<main class="page__main">
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Добро пожаловать <?= $name; ?>!</h2>
            <div class="profile__colums">
                <div class="profile__col">
                    <form>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Логин</legend>
                            <input class="input profile__input" type="text" name="login" value="<?= $login; ?>">
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Сменить пароль</legend>
                            <input class="input profile__input" type="password" name="password-old" value="" placeholder="Старый пароль">
                            <input class="input profile__input" type="password" name="password-new" value="" placeholder="Новый пароль">
                        </fieldset>
                        <fieldset class="profile__field">
                            <legend class="profile__title">Имя</legend>
                            <input class="input profile__input" type="text" name="name" value="<?= $name; ?>">
                        </fieldset>
                        <input type="submit" class="button" value="Обновить данные">
                    </form>
                </div>
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Информация</legend>
                        <ul class="profile__list">
                            <li class="profile__item">Дата регистрации: </li>
                            <li class="profile__item">Дата последней авторизации: </li>
                            <li class="profile__item">Статус: <?= $status; ?></li>
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
                        <ul class="profile__list gem__list">
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Хризолит</span>
                                    <input class="input" type="number" name="gem-name1" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Алмаз</span>
                                    <input class="input" type="number" name="gem-name2" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Цитрин</span>
                                    <input class="input" type="number" name="gem-name3" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Хризолит</span>
                                    <input class="input" type="number" name="gem-name1" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Алмаз</span>
                                    <input class="input" type="number" name="gem-name2" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                            <li class="gem__item">
                                <label>
                                    <span class="gem__text">Цитрин</span>
                                    <input class="input" type="number" name="gem-name3" value="0" min="0" max="1" step="0.01">
                                </label>
                            </li>
                        </ul>
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