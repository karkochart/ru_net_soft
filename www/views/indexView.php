<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php foreach ($posts as $post): ?>
        <h2><?php echo $post['title']; ?></h2>
    <?php endforeach; ?>
</body>
</html>