<main>
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Пользователи</h2>
            <div class="users__filter filter">
                <h3 class="filter__title">Отфильтровать по: </h3>
                <ul class="filter__list">
                    <li class="filter__item">
                        <a href="#">Статусу</a>
                    </li>
                    <li class="filter__item">
                        <a href="#">Имени</a>
                    </li>
                </ul>
            </div>
            <div class="users__colums">
                <div class="users__wrapper">
                    <h3 class="page__title">Эльфы:</h3>
                    <ul class="users__list">
                        <?php foreach ($elves as $elf) : ?>
                            <li class="users__item users__item--elf">
                                <a href="#" class="users__link">
                                    <span class="users__name"><?= $elf['NAME']; ?></span>
                                    <div class="users__data">
                                        <span class="users__gems">Получено: <?= $elf['assigned_gems'] ?> </span>
                                        <span class="users__gems">Любимые: </span>
                                        <ul class="users__like-list">
                                            <?php
                                                $elf_prefs = get_elf_prefs($elf['login'], $prefs);
                                                $sorted_prefs = sort_prefs($elf_prefs);
                                            ?>
                                            <?php foreach ()
                                            <li class="users__like-item">Хризолит</li>
                                        </ul>
                                    </div>
                                </a>
                                <a href="#" class="users__delete">Удалить</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="users__wrapper">
                    <h3 class="page__title">Гномы:</h3>
                    <ul class="users__list">
                        <?php foreach ($dwarfs as $dwarf) : ?>
                            <li class="users__item users__item--dwarf">
                                <a href="#" class="users__link">
                                    <span class="users__name"> <?= $dwarf['NAME']; ?> </span>
                                    <div class="users__data">
                                        <span class="users__gems">Добыто: <?= $dwarf['mined_gems']; ?></span>
                                    </div>
                                </a>
                                <?php if ($dwarf['role'] == 'master_dwarf') : ?>
                                    <span class="users__master-icon">М</span>
                                <?php endif; ?>
                                <a href="#" class="users__delete">Удалить</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="users__wrapper">
                    <h3 class="page__title">Создать пользователя:</h3>
                    <form action="" method="post">
                        <label for="new-name" class="users__label">
                            Имя нового пользователя:
                        </label>
                        <input class="input users__input" id="new-name" type="text" placeholder="Имя">
                        <label for="new-login" class="users__label">
                            Логин нового пользователя:
                        </label>
                        <input class="input users__input" id="new-login" type="text" placeholder="Логин">
                        <label for="new-pass" class="users__label">
                            Пароль нового пользователя:
                        </label>
                        <input class="input users__input" id="new-pass" type="password" placeholder="Пароль">
                        <input type="submit" class="button" value="Создать">
                        <input type="reset" class="button" value="Отмена">
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>
