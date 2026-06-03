<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\FormValidator;

$validator = new FormValidator();
$data = $_POST;
$errors = [];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$success = false;

if ($submitted) {
    $errors = $validator->validateAll($data);
    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Processing</title>
</head>
<body>
    <h1>Form Processing</h1>

    <?php if (!$submitted): ?>
        <p>No form data has been submitted yet. Go back to <a href="register.php">register.php</a>.</p>

    <?php elseif ($success): ?>
        <h2>Registration Successful</h2>
        <p>Name: <?= htmlspecialchars(trim($data['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
        <p>Email: <?= htmlspecialchars(trim($data['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
        <p>Age: <?= htmlspecialchars(trim((string)($data['age'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>

    <?php else: ?>
        <!-- Validation failed: show the form again with errors and old input -->
        <p>Please correct the following errors and resubmit:</p>
        <form action="process.php" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name"
                       value="<?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (!empty($errors['name'])): ?>
                    <span style="color:red;"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (!empty($errors['email'])): ?>
                    <span style="color:red;"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="18" max="100"
                       value="<?= htmlspecialchars($data['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (!empty($errors['age'])): ?>
                    <span style="color:red;"><?= htmlspecialchars($errors['age'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <button type="submit">Register</button>
        </form>
    <?php endif; ?>
</body>
</html>
