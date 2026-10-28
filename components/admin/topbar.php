<?php

require_once __DIR__ . "/../../middleware/auth.php";

$user = getAuthUser();
?>

<header class="app-topbar">
  <div class="page-title">
    <h1><?= $pageTitle ?></h1>
    <p><?= $pageSubtitle ?></p>
  </div>
  <div class="topbar-user">
    <span class="avatar"><?= substr($user['name'], 0, 2) ?></span>
    <div>
      <?= $user['name'] ?><br>
      <span class="badge badge-<?= $user['role'] ?>" style="margin-top:2px;"><?= ucfirst($user['role']) ?></span>
    </div>
  </div>
</header>
