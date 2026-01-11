<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

if (is_logged_in()) {
  $u = current_user();
  if ($u['role'] === 'admin') header("Location: /admin/dashboard.php");
  if ($u['role'] === 'client') header("Location: /client/home.php");
  if ($u['role'] === 'engineer') header("Location: /engineer/home.php");
  exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $role  = $_POST['role'] ?? 'client'; // admin/client/engineer
  $email = strtolower(trim($_POST['email'] ?? ''));
  $pass  = $_POST['password'] ?? '';

  if ($email === '' || $pass === '') {
    $errors[] = "Email and password are required.";
  } elseif (!in_array($role, ['admin', 'client', 'engineer'], true)) {
    $errors[] = "Invalid role selected.";
  } else {
    if ($role === 'admin') {
      $stmt = $pdo->prepare("SELECT id, name, email, password_hash FROM admins WHERE email = :email LIMIT 1");
    } elseif ($role === 'client') {
      $stmt = $pdo->prepare("SELECT id, first_name, last_name, email, password_hash FROM clients WHERE email = :email LIMIT 1");
    } else {
      $stmt = $pdo->prepare("SELECT id, first_name, last_name, email, password_hash FROM engineers WHERE email = :email LIMIT 1");
    }

    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($pass, $row['password_hash'])) {
      $errors[] = "Invalid login details.";
    } else {
      if ($role === 'admin') {
        $_SESSION['user'] = [
          'role' => 'admin',
          'id'   => (int)$row['id'],
          'name' => $row['name']
        ];
        header("Location: /admin/dashboard.php");
        exit;
      }

      $fullName = trim(($row['first_name'] ?? '') . " " . ($row['last_name'] ?? ''));
      $_SESSION['user'] = [
        'role' => $role,
        'id'   => (int)$row['id'],
        'name' => $fullName
      ];

      if ($role === 'client') header("Location: /index.php");
      if ($role === 'engineer') header("Location: /indexp.php");
      exit;
    }
  }
}

require_once __DIR__ . "/includes/header.php";
?>

<section class="max-w-lg mx-auto bg-white border rounded-2xl p-6 shadow-sm">
  <h1 class="text-2xl font-semibold">Login</h1>
  <p class="text-sm text-zinc-600 mt-1">Choose your role and login securely.</p>

  <?php if ($errors): ?>
    <div class="mt-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
      <ul class="list-disc pl-5 space-y-1">
        <?php foreach ($errors as $er): ?>
          <li><?= e($er) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="mt-5 space-y-4">
    <div>
      <label class="text-sm text-zinc-700">Login as</label>
      <select name="role" class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
        <option value="client" <?= (($_POST['role'] ?? '') === 'client') ? 'selected' : '' ?>>Client</option>
        <option value="engineer" <?= (($_POST['role'] ?? '') === 'engineer') ? 'selected' : '' ?>>Engineer</option>
        <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>

    <div>
      <label class="text-sm text-zinc-700">Email</label>
      <input name="email" type="email" value="<?= e($_POST['email'] ?? '') ?>"
             class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
    </div>

    <div>
      <label class="text-sm text-zinc-700">Password</label>
      <input name="password" type="password"
             class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
    </div>

    <button class="w-full bg-blue-600 hover:bg-blue-500 text-white rounded-xl py-2 font-medium">
      Login
    </button>

    <p class="text-sm text-zinc-600 text-center">
      New client?
      <a class="text-blue-600 hover:underline" href="signup.php">Create account</a>
    </p>
  </form>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
