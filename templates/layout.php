<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="page-header">
        <h1 class="page-header__site-title">gemenity</h1>
        <?php if (isset($user)): ?>
            <nav>
                <ul class="page-header__main-nav">
                    <li class="page-header__item"><a href="/users.php">Пользователи</a></li>
                    <li class="page-header__item"><a href="/gems.php">Драгоценности</a></li>
                    <?php if (isUserDwarf($user) || isUserMaster($user)): ?>
                        <li class="page-header__item"><a href="/add-gems.php">Добавить драгоценности</a></li>
                    <?php endif ?>
                    <li class="page-header__item"><a href="/<?= get_user_page($user) ?>">Профиль</a></li>
                    <?php if (isUserMaster($user)): ?>
                        <li class="page-header__item"><a href="/settings.php">Настройки</a></li>
                    <?php endif ?>
                    <li class="page-header__item"><a href="/index.php">Выйти</a></li>
                </ul>
            </nav>
        <?php endif ?>
    </header>
    <?= $page_content; ?>
    <footer class="page-footer"></footer>
</body>
</html>
