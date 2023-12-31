<nav>
  <div class="row">
    <h2>HIMASAR</h2>
  </div>
  <div class="row">
    <ul>
      <a class="<?php echo $active == 'home' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>home">HOME</a>
    </ul>
    <ul>
      <a class="<?php echo $active == 'about' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>about">ABOUT</a>
    </ul>
    <ul>
      <a class="<?php echo $active == 'contact' ? 'active' : ''; ?>" href="<?= BASE_PATH ?>contact">CONTACT</a>
    </ul>
    </ul>
    <ul style="margin-left: 400px;">
      <a href="<?= BASE_PATH ?>login/logout">LOGOUT</a>
    </ul>
  </div>
</nav>