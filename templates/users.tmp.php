<main>
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Пользователи</h2>
            <div class="users__filter filter">
                <h3 class="filter__title">Отфильтровать по: </h3>
                <ul class="filter__list">
                    <li class="filter__item">
                        <a href="/users.php?sortby=status">Статусу</a>
                    </li>
                    <li class="filter__item">
                        <a href="/users.php?sortby=name">Имени</a>
                    </li>
                </ul>
            </div>
            <div class="users__colums">
                <div class="users__wrapper">
                    <h3 class="page__title">Эльфы:</h3>
                    <ul class="users__list">
                        <?php foreach ($all_users as $user) : ?>
                            <?php if (isUserElf($user)): ?>
                                <?php
                                    $elf_data = [];
                                    foreach ($elves as $elf) {
                                        if ($user['login'] == $elf['login']) $elf_data = $elf;
                                    }
                                ?>
                                <li class="users__item users__item--elf">
                                    <a href="/<?=get_user_page($user);?>" class="users__link">
                                        <span class="users__name"><?= $user['NAME']; ?></span>
                                        <div class="users__data">
                                            <span class="users__gems">Получено: <?= $elf_data['assigned_gems'] ?> </span>
                                            <span class="users__gems">Любимые: </span>
                                            <ul class="users__like-list">
                                                <?php
                                                    $elf_prefs = get_elf_prefs($user['login'], $prefs);
                                                    sort_prefs($elf_prefs);
                                                ?>
                                                <?php for ($i = 0; $i < 3; $i++) : ?>
                                                    <li class="users__like-item"><?= $elf_prefs[$i]['name']; ?></li>
                                                <?php endfor; ?>
                                            </ul>
                                            <span class="users__gems">Статус: <?=$user['status'];?></span>
                                        </div>
                                    </a>
                                    <?php if($user['status'] == 'active') : ?>
                                        <?php $link = '/control.php?action=delete_user&login=' . $user['login'];?>
                                        <a href="<?= $link ?>" class="users__delete">Удалить</a>
                                    <?php endif;?>
                                </li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="users__wrapper">
                    <h3 class="page__title">Гномы:</h3>
                    <ul class="users__list">
                        <?php foreach ($all_users as $user) : ?>
                            <?php if ((isUserDwarf($user) || isUserMaster($user))): ?>
                                <?php
                                    $dwarf_data = [];
                                    foreach ($dwarfs as $dwarf) {
                                        if ($user['login'] == $dwarf['login']) $dwarf_data = $dwarf;
                                    }
                                ?>
                                <li class="users__item users__item--dwarf">
                                    <a href="/<?=get_user_page($user);?>" class="users__link">
                                        <span class="users__name"><?= $user['NAME']; ?></span>
                                        <div class="users__data">
                                            <span class="users__gems">Добыто: <?= $dwarf_data['mined_gems']; ?></span>
                                            <span class="users__gems">Статус: <?=$user['status'];?></span>
                                        </div>
                                    </a>
                                    <?php if (isUserMaster($user)) : ?>
                                        <span class="users__master-icon">М</span>
                                    <?php endif; ?>
                                    <?php if($user['status'] == 'active') : ?>
                                        <?php $link = '/control.php?action=delete_user&login=' . $user['login'];?>
                                        <a href="<?= $link ?>" class="users__delete">Удалить</a>
                                    <?php endif;?>
                                </li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="users__wrapper">
                    <div class="users__errors">
                        <?php
                            if (isset($messages)) {
                                foreach ($messages as $message) {
                                    print ($message);
                                };
                            }
                        ?>
                    </div>
                    <h3 class="page__title">Создать пользователя:</h3>
                    <form action="control.php" method="POST">
                        <input type="hidden" name="action" value="create_user">
                        <label for="new-name" class="users__label">
                            Имя нового пользователя:
                        </label>
                        <input class="input users__input" id="new-name" name="name" type="text" placeholder="Имя">
                        <label for="new-login" class="users__label">
                            Логин нового пользователя:
                        </label>
                        <input class="input users__input" id="new-login" name="login" type="text" placeholder="Логин">
                        <label for="new-pass" class="users__label">
                            Пароль нового пользователя:
                        </label>
                        <input class="input users__input" id="new-pass" name="password" type="password" placeholder="Пароль">
                        <label class="users__label">
                            <input type="radio" name="role" value="elf" checked>
                            Эльф
                        </label>
                        <label class="users__label">
                            <input type="radio" name="role" value="dwarf">
                            Гном
                        </label>
                        <input type="submit" class="button" value="Создать">
                        <input type="reset" class="button" value="Отмена">
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
