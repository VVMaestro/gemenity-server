<main>
    <div class="container">
        <section class="page__section">
            <div class="page__columns">
                <h2 class="page__title">Список драгоценностей</h2>
                <?php if (isUserMaster($user)): ?>
                    <a href="/gem-assign.php" class="button">Распределить драгоценности</a>
                <?php endif ?>
            </div>
            <div class="gem-info__filter filter">
                <h3 class="filter__title">Отфильтровать по: </h3>
                <form action="/gems.php" method="POST">
                    <div class="filter__wrapper">
                        <select id="gem-filter" name="filter" class="input filter__input">
                            <option value="elf">Назначены эльфу</option>
                            <option value="dwarf">Добыты гномом</option>
                            <option value="master-dwarf">Распределены Мастер гномом</option>
                            <option value="assign-before">Назначено до</option>
                            <option value="assign-after">Назначено после</option>
                            <option value="confirmed-before">Подтверждено до</option>
                            <option value="confirmed-after">Подтверждено после</option>
                            <option value="type">Соответствуют типу</option>
                            <option value="status">Соответствуют статусу</option>
                        </select>
                        <input type="date" name="date" class="input filter__input" id="js-date">
                        <input type="text" name="text" class="input filter__input" id="js-text">
                        <select name="type" class="input filter__input" id="js-type">
                            <?php foreach ($gem_types as $type) : ?>
                            <option value="<?= $type['name']; ?>"><?= $type['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status" class="input filter__input" id="js-status">
                            <option value="assigned">Назначена</option>
                            <option value="confirmed">Подтверждена</option>
                            <option value="not_assigned">Не назначена</option>
                        </select>
                        <input type="submit" class="button" value="Фильтровать">
                    </div>
                </form>
            </div>
            <ul class="gem-info__list">
                <?php foreach ($gems as $gem) : ?>
                <li class="gem-info__item">
                    <ul class="gem-info__info">
                        <li><?=$gem['NAME']; ?></li>
                        <li>Добыто: <?=$gem['mine_date']; ?></li>
                        <li>Назначено: <?=$gem['assign_date']; ?></li>
                        <li>Подтверждено: <?=$gem['confirmation_date']; ?></li>
                        <li>Гном-добытчик: <?=$gem['dwarf_name']; ?></li>
                        <li>Мастер-распределитель: <?=$gem['master_name']; ?></li>
                        <li>Распределено:
                            <?php if($gem['assigned_by'] == 'manually') print('Вручную');
                            elseif ($gem['assigned_by'] == 'algorithm') print('Алгоритмом'); ?>
                        </li>
                        <li>Эльф-владелец: <?=$gem['elf_name']; ?></li>
                        <li>Статус:
                            <?php if($gem['gem_status'] == 'assigned') print('Назначено');
                            elseif ($gem['gem_status'] == 'not_assigned') print('Неназначено');
                            elseif ($gem['gem_status'] == 'confirmed') print('Подтверждено'); ?>
                        </li>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</main>

<script type="text/javascript" src="js/gem-filter.js"></script>