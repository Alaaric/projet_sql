<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <title><?= $title ?? 'My App' ?></title>
</head>

<body>
    <?php include __DIR__ . '/./partials/navbar.php'; ?>

    <main>
        <?= $content ?>
    </main>

    <?php include __DIR__ . '/./partials/footer.php'; ?>
</body>

</html>