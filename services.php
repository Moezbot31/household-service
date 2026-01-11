<?php
require_once __DIR__ . "/includes/auth.php";
$u = current_user();
$role = $u['role'] ?? 'guest';

require_once __DIR__ . "/includes/header.php";
?>

<section class="bg-white border rounded-2xl p-6">
  <h1 class="text-2xl font-semibold">Services</h1>
  <p class="text-sm text-zinc-600 mt-1">
    Household repair services delivered by experienced engineers.
  </p>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
    <?php
      $services = [
        ["Electrician", "Wiring, sockets, lighting, breakers, safety checks.", "Fix electrical faults safely with a verified electrician."],
        ["Plumber", "Leak repair, taps, pipelines, water pressure issues.", "Stop leaks fast and protect your home from damage."],
        ["Mechanic", "Generator servicing, small motors, household equipment.", "Maintenance and repairs for home machinery and tools."],
        ["Electrician (Appliances)", "Fan, inverter, UPS troubleshooting.", "Restore power systems and appliance connections."],
        ["Plumber (Drainage)", "Drain blocks, sewer smell, bathroom drainage.", "Clear blockages and improve drainage performance."],
        ["Mechanic (Preventive)", "Regular servicing and inspection reports.", "Prevent breakdowns with scheduled maintenance."],
      ];
      foreach ($services as $s):
    ?>
      <div class="bg-zinc-50 border rounded-2xl p-5 hover:shadow-sm transition">
        <h3 class="font-semibold text-zinc-900"><?= e($s[0]) ?></h3>
        <p class="text-sm text-zinc-700 mt-2"><?= e($s[1]) ?></p>
        <p class="text-xs text-zinc-500 mt-2"><?= e($s[2]) ?></p>

        <div class="mt-4 flex gap-2">
          <a href="contact.php"
             class="px-3 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-medium">
            Request now
          </a>

          <?php if ($role === 'client'): ?>
            <a href="/client/engineers.php"
               class="px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium">
              My engineer
            </a>
          <?php elseif ($role === 'engineer'): ?>
            <a href="/engineer/clients.php"
               class="px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium">
              My clients
            </a>
          <?php elseif ($role === 'admin'): ?>
            <a href="/admin/dashboard.php"
               class="px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium">
              Dashboard
            </a>
          <?php else: ?>
            <a href="login.php"
               class="px-3 py-2 rounded-xl bg-zinc-900 hover:bg-zinc-800 text-white text-xs font-medium">
              Login
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
