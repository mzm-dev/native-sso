<!-- src/Views/error.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ralat</title>
</head>
<body>
    <h1>Ralat!</h1>
    <p><?= htmlspecialchars($message ?? 'Error tidak diketahui.') ?></p>
</body>
</html>
