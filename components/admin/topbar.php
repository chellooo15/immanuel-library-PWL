<?php
session_start();
$user = $_SESSION["user"];
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
      <span class="badge badge-member" style="margin-top:2px;"><?= ucfirst($user['role']) ?></span>
    </div>
  </div>
</header>
