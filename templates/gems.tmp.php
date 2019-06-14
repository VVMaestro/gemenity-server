<main>
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Список драгоценностей</h2>
            <div class="gem-info__filter filter">
                <h3 class="filter__title">Отфильтровать по: </h3>
                <form action="#" method="POST">
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
                            <option value="hrizolit">Хризолит</option>
                            <option value="opal">Опал</option>
                        </select>
                        <select name="status" class="input filter__input" id="js-status">
                            <option value="assign">Назначена</option>
                            <option value="confirmed">Подтверждена</option>
                            <option value="not-assign">Не назначена</option>
                        </select>
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
                        <li>Гном-добытчик: <?=$gem['mined_dwarf']; ?></li>
                        <li>Мастер-распределитель: <?=$gem['confirm_by']; ?></li>
                        <li>Распределено:
                            <?php if($gem['assign_by'] == 'manually') print('Вручную');
                            elseif ($gem['assign_by'] == 'algorithm') print('Алгоритмом'); ?>
                        </li>
                        <li>Эльф-владелец: <?=$gem['assign_elf']; ?></li>
                        <li>Статус:
                            <?php if($gem['status'] == 'assigned') print('Назначено');
                            elseif ($gem['status'] == 'not_assigned') print('Неназначено');
                            elseif ($gem['status'] == 'confirmed') print('Подтверждено'); ?>
                        </li>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>
</main>