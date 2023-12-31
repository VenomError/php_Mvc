  <main>
    <?php
    if (isset($_SESSION['username'])) {
    ?><div style="text-align: center; width: 100%; ">
        <p> WELCOME <br>
        <p> username : <?= $_SESSION['username'] ?> </p>
        <p> Password : <?= $_SESSION['password'] ?> </p>
        <a href="<?= BASE_ASSETS ?>home">THANKS</a>
        </p>
      </div>
    <?php } ?>
    HOME PAGE <?= $msg ?>
  </main>