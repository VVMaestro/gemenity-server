<main>
    <div class="container">
        <section class="page__section">
            <h1 class="page__title">Рапределить драгоценности</h1>
            <form action="/gem-assign.php" method="POST">
                <ul class="gem-info__list">
                    <?php foreach ($unassign_gems as $gem) : ?>
                        <li class="gem-info__item">
                            <ul class="gem-info__info js-unassign-gem" data-gemtype="<?=$gem['type_id'];?>">
                                <li><?= $gem['type']; ?></li>
                                <li>Гном-добытчик: <?= $gem['mine_dwarf']; ?></li>
                                <li>Дата добычи: <?= $gem['mine_date']; ?></li>
                                <li>Эльф-владелец: <input type="text" name="<?= $gem['gem_id']; ?>" value="" class="input">
                                </li>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if (isset($messages)) : ?>
                    <ul>
                        <?php foreach ($messages as $message) : ?>
                            <li><?= $message; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="gem-info__btn-wrapper">
                    <input class="button" type="submit" value="Подтвердить распределение">
                </div>
            </form>
            <div class="gem-info__btn-wrapper">
                <button class="button" id="js-assign-button">Распределить</button>
            </div>
        </section>
    </div>
</main>
<script type="text/javascript" src="../js/gem-assignment.js"></script>