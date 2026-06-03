<?php
declare(strict_types=1);

/**
 * Students must build a registration form on this page.
 *
 * Required behavior:
 * 1. Display an HTML form that collects at least name, email, and age.
 * 2. Use the POST method and submit to process.php.
 * 3. Preserve submitted values where appropriate after validation errors.
 * 4. Show user-friendly validation feedback near the relevant fields.
 * 5. Keep presentation markup in this file and business validation logic in src/FormValidator.php.
 */

session_start();

// Retrieve errors and old input from the session (if any), then clear them
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
</head>
<body>
    <h1>Student Registration</h1>

    <form action="process.php" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <?php if (!empty($errors['name'])): ?>
                <p style="color:red;"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <?php if (!empty($errors['email'])): ?>
                <p style="color:red;"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age"
                   value="<?= htmlspecialchars($old['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <?php if (!empty($errors['age'])): ?>
                <p style="color:red;"><?= htmlspecialchars($errors['age'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>
