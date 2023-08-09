<div class="main-container">
  <form class="box login" action="" method="post" autocomplete="off">
    <img src="./img/logo.png" width="112" height="28">
    <div class="field">
      <p class="control has-icons-left has-icons-right">
        <input class="input" type="text" placeholder="Usuario" name="usuario"
               pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
        <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
        <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control has-icons-left">
        <input class="input" type="password" placeholder="Password" name="password"
               pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control">
        <button type="submit" class="button is-success">
          Login
        </button>
      </p>
    </div>
    <?php
      if (isset($_POST['usuario']) && isset($_POST['password'])) {
        require_once './php/main.php';
        require_once './php/verify_user.php';
      }
    ?>
  </form>
</div>