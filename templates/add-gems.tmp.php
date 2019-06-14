<main>
    <div class="container">
        <section class="page__section">
            <h2 class="page__title">Добавить драгоценности</h2>
            <div class="add-gems__colums">
                <form action="/add-gems.php" method="POST" id="add-gems">
                    <ul class="add-gems__list">
                        <?php foreach ($gem_types as $type) : ?>
                            <li class="add-gems__item">
                                <span class="add-gems__name"> <?= $type['name']; ?> </span>
                                <input type="number" name="<?= $type['id']; ?>" class="input add-gems__input" value="0" min="0">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </form>
                <input type="submit" class="button button--big" form="add-gems" value="Добавить камни">
            </div>
        </section>
    </div>
</main>
