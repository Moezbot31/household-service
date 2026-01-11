<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/includes/auth.php";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $client_name = trim($_POST['client_name'] ?? '');
  $client_email = strtolower(trim($_POST['client_email'] ?? ''));
  $requested_role = trim($_POST['requested_role'] ?? '');
  $message = trim($_POST['message'] ?? '');

  $allowed = ['Electrician', 'Plumber', 'Mechanic'];

  if ($client_name === '' || $client_email === '' || $requested_role === '') {
    $errors[] = "Client name, email, and engineer type are required.";
  }
  if (!filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }
  if (!in_array($requested_role, $allowed, true)) {
    $errors[] = "Invalid engineer type selected.";
  }

  if (!$errors) {
    $stmt = $pdo->prepare("
      INSERT INTO service_requests (client_name, client_email, requested_role, message)
      VALUES (:n, :e, :r, :m)
    ");
    $stmt->execute([
      'n' => $client_name,
      'e' => $client_email,
      'r' => $requested_role,
      'm' => $message
    ]);
    $success = "Request sent successfully. Admin will assign an engineer soon.";
  }
}

require_once __DIR__ . "/includes/header.php";
?>

<section class="grid lg:grid-cols-2 gap-8 items-start">
  <div class="bg-white border rounded-2xl p-6">
    <h1 class="text-2xl font-semibold">Request an Engineer</h1>
    <p class="text-sm text-zinc-600 mt-1">Tell us what you need and we will arrange a suitable expert.</p>

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
      <div>
        <label class="text-sm text-zinc-700">Which engineer do you want?</label>
        <select name="requested_role" class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400">
          <option value="">Select</option>
          <option value="Electrician" <?= (($_POST['requested_role'] ?? '') === 'Electrician') ? 'selected' : '' ?>>Electrician</option>
          <option value="Plumber" <?= (($_POST['requested_role'] ?? '') === 'Plumber') ? 'selected' : '' ?>>Plumber</option>
          <option value="Mechanic" <?= (($_POST['requested_role'] ?? '') === 'Mechanic') ? 'selected' : '' ?>>Mechanic</option>
        </select>
      </div>

      <div>
        <label class="text-sm text-zinc-700">Client name</label>
        <input name="client_name" value="<?= e($_POST['client_name'] ?? '') ?>"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>

      <div>
        <label class="text-sm text-zinc-700">Email</label>
        <input name="client_email" type="email" value="<?= e($_POST['client_email'] ?? '') ?>"
               class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400" />
      </div>

      <div>
        <label class="text-sm text-zinc-700">Message (optional)</label>
        <textarea name="message" rows="4"
          class="mt-1 w-full border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400"><?= e($_POST['message'] ?? '') ?></textarea>
      </div>

      <button class="w-full bg-teal-600 hover:bg-teal-500 text-white rounded-xl py-2 font-medium">
        Send request
      </button>
    </form>
  </div>

  <div class="bg-white border rounded-2xl p-6">
    <h2 class="text-xl font-semibold">How it works</h2>
    <ul class="mt-3 text-sm text-zinc-700 space-y-2">
      <li>• You submit a request for Electrician / Plumber / Mechanic.</li>
      <li>• Admin reviews your request and assigns an engineer.</li>
      <li>• Your account (client) will only see the engineer linked to you.</li>
      <li>• Engineer will only see the clients assigned to them.</li>
    </ul>
  </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
