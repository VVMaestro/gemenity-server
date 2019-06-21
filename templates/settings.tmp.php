<main class="page__main">
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Страница настроек</h2>
            <div class="profile__colums">
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Значимость требований</legend>
                        <form action="/control.php" method="post">
                            <input type="hidden" name="action" value="update-signific">
                            <label>
                                <span class="gem__text">Справедливое распределение</span>
                                <input class="input gem__input" type="number" name="equally" value="<?=$signific['assign_equally'];?>" min="0" max="1"
                                       step="0.01">
                            </label>
                            <label>
                                <span class="gem__text">Соблюдение предпочтений</span>
                                <input class="input gem__input" type="number" name="prefs" value="<?=$signific['assign_prefs'];?>" min="0" max="1"
                                       step="0.01">
                            </label>
                            <label>
                                <span class="gem__text">Еженедельная радость</span>
                                <input class="input gem__input" type="number" name="byone" value="<?=$signific['assign_byone'];?>" min="0" max="1"
                                       step="0.01">
                            </label>
                            <input type="submit" class="button" value="Обновить">
                        </form>
                    </fieldset>
                    <?php if (isset($messages)): ?>
                        <ul>
                            <?php foreach ($messages as $message) : ?>
                            <li><?=$message;?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif ?>
                </div>
                <div class="profile__col">
                    <fieldset class="profile__field">
                        <legend class="profile__title">Существующие типы камней</legend>
                        <ul class="gem__list">
                            <?php foreach ($gem_types as $type) : ?>
                                <li class="gem__text">
                                    <?=$type['name'];?>
                                    <a href="<?='/control.php?action=delete-type&type-id=' . $type['id'];?>" class="users__delete">Удалить</a></li>
                            <?php endforeach; ?>
                        </ul>
                    </fieldset>
                    <fieldset class="profile__field">
                        <legend class="profile__title">Добавить новый тип</legend>
                        <form action="/control.php" method="post">
                            <input type="hidden" name="action" value="add-type">
                            <label>
                                Имя нового типа камня
                                <input class="input" type="text" name="type-name" value="">
                                <input class="button" type="submit" value="Добавить">
                            </label>
                        </form>
                    </fieldset>
                </div>
            </div>
        </section>
    </div>
</main>