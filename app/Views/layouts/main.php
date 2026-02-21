<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'mvc - City College of San Fernando' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <link rel="icon" href="<?= $baseUrl ?? '' ?>/public/images/system/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $baseUrl ?? '' ?>/public/css/login.css">
</head>
<body>
    <?= $content ?>
    
    <?php if (isset($showScripts) && $showScripts): ?>
    <script src="<?= $baseUrl ?? '' ?>/public/js/login_index.js"></script>
    <?php endif; ?>
</body>
</html>