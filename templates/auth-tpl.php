<main class="page__main">
    <section class="auth">
        <div class="auth__wrapper">
            <form class="auth__form" action="/index.php" method="POST">
                <label class="auth__label" for="login">Логин</label>
                <input id="login" class="input auth__input" type="text" name="login">
                <p class="auth__error">
                    <?php if (isset($errors['login'])) : ?>
                        <?= $errors['login']; ?>
                    <?php endif ?>
                </p>
                <label class="auth__label" for="password">Пароль</label>
                <input id="password" class="input auth__input" type="password" name="password">
                <p class="auth__error">
                    <?php if (isset($errors['password'])) : ?>
                        <?= $errors['password']; ?>
                    <?php endif ?>
                </p>
                <input class="auth__button button button--block" type="submit" value="Войти">
                <input class="auth__button button button--block" type="reset">
            </form>
        </div>
    </section>
</main>