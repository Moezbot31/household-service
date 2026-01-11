<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/plumber2.jpg">
  <title>Household Services</title>
</head>
<body>
<?php 
 require_once "includes/header.php"; 
?>
  
  <section class="relative overflow-hidden rounded-3xl min-h-[420px] flex items-center">
  <img src="/assets/hero.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Hero">
  <div class="absolute inset-0 bg-gradient-to-r from-zinc-900/80 via-zinc-900/50 to-transparent"></div>

  <div class="relative p-8 sm:p-12 max-w-2xl">
    <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight">
      <span class="inline-block animate-pulse">Fast</span> household repair services by
      <span class="text-teal-300">trusted engineers</span>
    </h1>
    <p class="mt-4 text-white/90">
      Book electricians, plumbers, and mechanics based on real experience, expertise, and service history.
    </p>
    <div class="mt-6 flex gap-3">
      <a href="services.php" class="bg-teal-500 hover:bg-teal-400 text-white px-5 py-2 rounded-xl font-medium">Explore Services</a>
      <a href="contact.php" class="bg-white/15 hover:bg-white/20 text-white px-5 py-2 rounded-xl font-medium">Request an Engineer</a>
    </div>
  </div>
</section>

<section class="mt-10">
  <h2 class="text-xl font-semibold text-zinc-800">Popular roles</h2>
  <p class="text-zinc-600 mt-1">Choose the right expert for the job.</p>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-6">
    <?php
      $cards = [
        ["Electrician", "Wiring, sockets, breakers, lighting fixes.", "/assets/electritian1.jpg"],
        ["Electrician (Emergency)", "Quick checks for sudden power faults.", "/assets/electritian2.jpg"],
        ["Plumber", "Leaks, taps, pipelines, water pressure issues.", "/assets/plumber1.jpg"],
        ["Plumber (Drainage)", "Drain blocks, sewer smell, bathroom drainage.", "/assets/plumber2.jpg"],
        ["Mechanic", "Home generator, small motor repairs, tools.", "/assets/mechanic1.jpg"],
        ["Mechanic (Maintenance)", "Regular servicing and safety checks.", "/assets/mechanic2.jpg"],
      ];
      foreach ($cards as $c):
        ?>
      <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="h-36 bg-zinc-100">
          <img src="<?= e($c[2]) ?>" class="w-full h-full object-cover" alt="">
        </div>
        <div class="p-5">
          <h3 class="font-semibold text-zinc-900"><?= e($c[0]) ?></h3>
          <p class="text-sm text-zinc-600 mt-2"><?= e($c[1]) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
  </div>
</section>

<section class="mt-12 bg-white border rounded-3xl p-6 sm:p-10 grid lg:grid-cols-2 gap-8 items-center">
  <div>
    <h2 class="text-2xl font-semibold">Why HomeFix Engineers?</h2>
    <p class="text-zinc-600 mt-3">
      We connect households with verified service engineers. Clients get service based on expertise and real service history.
      Admin manages engineers, and each role only sees their own relevant data.
    </p>
    <ul class="mt-4 text-sm text-zinc-700 space-y-2">
      <li>• Role-based access: client / engineer / admin</li>
      <li>• Secure login with hashed passwords</li>
      <li>• JOIN-based views: you only see what you should</li>
    </ul>
  </div>

  <div class="rounded-2xl overflow-hidden border bg-zinc-100">
    <img src="/assets/hero.jpg" class="w-full h-72 object-cover" alt="">
  </div>
 <?php 
 if ($role === 'client'): 
  require_once __DIR__ . "/client/home.php";
  
  elseif ($role === 'engineer'): 
    require_once __DIR__ . "/engineer/home.php";
    ?>
  <?php endif; ?>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
</body>