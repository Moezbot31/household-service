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
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first = trim($_POST['first_name'] ?? '');
  $last  = trim($_POST['last_name'] ?? '');
  $email = strtolower(trim($_POST['email'] ?? ''));
  $pass  = $_POST['password'] ?? '';
  $pass2 = $_POST['password2'] ?? '';

  if ($first === '' || $last === '' || $email === '' || $pass === '' || $pass2 === '') {
    $errors[] = "All fields are required.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }
  if (strlen($pass) < 6) {
    $errors[] = "Password must be at least 6 characters.";
  }
  if ($pass !== $pass2) {
    $errors[] = "Passwords do not match.";
  }

  if (!$errors) {
    // unique email check in clients
    $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
      $errors[] = "This email is already registered.";
    } else {
      $hash = password_hash($pass, PASSWORD_DEFAULT);
      $ins = $pdo->prepare("INSERT INTO clients (first_name, last_name, email, password_hash) VALUES (:f, :l, :e, :h)");
      $ins->execute(['f' => $first, 'l' => $last, 'e' => $email, 'h' => $hash]);

      $success = "Account created successfully. You can login now.";
    }
  }
}

require_once __DIR__ . "/includes/header.php";
?>

<section class="max-w-lg mx-auto bg-white border rounded-2xl p-6 shadow-sm">
  <h1 class="text-2xl font-semibold">Client Signup</h1>
  <p class="text-sm text-zinc-600 mt-1">Create your account to request engineers and view your service engineer.</p>

  <?php if ($success): ?>
    <div class="mt-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
      <?= e($success) ?>
    </div>
  <?php endif; ?>

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
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="text-sm text-zinc-700">First name</label>
        <input name="first_name" value="<?= e($_POST['first_name'] ?? '') ?>"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>
      <div>
        <label class="text-sm text-zinc-700">Last name</label>
        <input name="last_name" value="<?= e($_POST['last_name'] ?? '') ?>"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>
    </div>

    <div>
      <label class="text-sm text-zinc-700">Email</label>
      <input name="email" type="email" value="<?= e($_POST['email'] ?? '') ?>"
             class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <label class="text-sm text-zinc-700">Password</label>
        <input name="password" type="password"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>
      <div>
        <label class="text-sm text-zinc-700">Confirm password</label>
        <input name="password2" type="password"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>
    </div>

    <button class="w-full bg-teal-600 hover:bg-teal-500 text-white rounded-xl py-2 font-medium">
      Create account
    </button>

    <p class="text-sm text-zinc-600 text-center">
      Already have an account?
      <a class="text-blue-600 hover:underline" href="/login.php">Login</a>
    </p>
  </form>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
