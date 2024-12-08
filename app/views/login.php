<?php 
  $has_campos_invalidos = isset($_GET['error']) && $_GET['error'] === 'true';
?>
<div class="d-flex flex-column justify-content-center vh-100">
  <main class="d-flex h-100 w-100 p-1">
    <!-- Formulário de cadastro-->
    <div class="d-flex flex-column justify-content-center align-items-center w-50">
      <div class="d-flex flex-column position-absolute top-0 start-0 py-3 px-4">
        <span class="status-text fw-light mb-0 fs-6">
          Login - Área Restrita
        </span>
        <h2 class="brand-name fw-semibold fs-5 mt-1">
          Thunder Gears
        </h2>
      </div>
      <!-- Título do formulário -->
      <h1 class="brand-name fw-semibold fs-1 mt-1">Área Restrita</h1>
      <p class="fs-5">Entre com sua conta para continuar</p>
      <!-- Formulário de Login -->
      <form
        class="d-grid gap-2 flex-column w-75 px-3"
        method="POST"
      >
        <div class="mb-3">
          <label for="user" class="form-label">Login</label>
          <input
            value="<?= App\Helpers\env::get_env('LOGIN') ?? '' ?>"
            type="text"
            class="form-control bg-body-tertiary<?= $has_campos_invalidos ? ' is-invalid' : '' ?>"
            id="user"
            name="user"
            aria-describedby="loginHelp"
            title="Esse campo aceita apenas letras"
            autofocus>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input
            value="<?= App\Helpers\env::get_env('SENHA_LOGIN') ?? '' ?>"
            type="password"
            class="form-control bg-body-tertiary<?= $has_campos_invalidos ? ' is-invalid' : '' ?>"
            id="password"
            name="password"
            minlength="8"
            autocomplete="off">
        </div>
        <?php
        if ($has_campos_invalidos) {
          echo "
            <!-- Mensagem de erro -->
            <span class=\"status-text mb-0 fs-6 text-center text-danger\">
              Campo login e/ou senha estão incorretos...
            </span>
          ";
        }
        ?>
        <div class="col-12 mt-3">
          <button
            class="btn btn-dark w-100 rounded-5"
            type="submit">
            Entrar
          </button>
        </div>
      </form>
    </div>
    <!-- Imagem de um motociclista em sua moto -->
    <div class="h-100 w-50">
      <img src="assets/images/moto_login.jpg"
        alt="Foto de uma pessoa em cima de uma moto"
        class="object-fit-cover border rounded h-100 w-100 rounded-4">
    </div>
  </main>
</div>