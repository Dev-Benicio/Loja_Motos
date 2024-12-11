<script src="/loja_motos/assets/javascript/previewImage.js"></script>

<div class="d-flex flex-column vh-100">
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Meu Perfil");
  ?>
  <main class="container d-flex flex-column align-items-center justify-content-center gap-4 pb-4 h-100">
    <div class="card flex-row gap-4 p-4 rounded-4 shadow-sm w-75">
      <!-- Informações do usuário -->
      <div class="w-100 d-flex flex-column gap-4">
        <header>
          <div class="d-flex align-items-center gap-2 mb-2">
            <h1 class="fs-2 fw-semibold mb-0">Meu Perfil</h1>
            <span>•</span>
            <span class="bg-primary-subtle rounded-pill px-4 py-1">
              <?= $funcionario['cargo'] ?>
            </span>
          </div>
          <p class="text-secondary">Informações da minha conta de usuário</p>
        </header>
        <div class="card-body p-0 d-flex gap-4">
          <form
            class="d-flex flex-column gap-3 w-100"
            method="POST"
            enctype="multipart/form-data"
            id="user-form"
          >
            <div class="row ps-0">
              <div class="mb-3 col-12">
                <label for="nome" class="form-label">Nome</label>
                <input
                  disabled
                  type="text"
                  class="form-control bg-secondary-subtle text-secondary"
                  id="nome"
                  name="nome"
                  value="<?= $funcionario['nome'] ?>">
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-12">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control bg-body-tertiary"
                  id="email"
                  name="email"
                  value="<?= $funcionario['email'] ?>">
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-6">
                <label for="senha_antiga" class="form-label">Senha antiga</label>
                <input
                  type="password"
                  class="form-control bg-body-tertiary"
                  id="senha_antiga"
                  name="senha_antiga">
              </div>
              <div class="mb-3 col-6">
                <label for="senha_nova" class="form-label">Senha nova</label>
                <input
                  type="password"
                  class="form-control bg-body-tertiary"
                  id="senha_nova"
                  name="senha_nova">
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="telefone" class="form-label">Telefone</label>
                <input
                  type="tel"
                  class="form-control bg-body-tertiary"
                  id="telefone"
                  name="telefone"
                  value="<?= $funcionario['telefone'] ?>">
              </div>
              <div class="col-6">
                <label for="endereco" class="form-label">Endereço</label>
                <input
                  disabled
                  type="text"
                  class="form-control bg-secondary-subtle text-secondary"
                  id="endereco"
                  name="endereco"
                  value="<?= $funcionario['endereco'] ?>">
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Foto do usuário -->
      <div class="d-flex flex-column justify-content-between gap-4">
        <div style="width: 300px; height: 300px;">
          <img
            class="rounded-circle object-fit-cover h-100 w-100 shadow border border-1 border-dark"
            src="<?= $funcionario['foto_perfil'] ?>"
            id="foto_perfil"
            title="Preview da foto de perfil"
            onerror="this.src='/loja_motos/images/funcionarios/default_user.png'"
            alt="foto de perfil">
        </div>
        <div class="d-grid gap-3">
          <div class="d-flex flex-column gap-2 mb-3">
            <label for="foto_funcionario" class="form-label">Foto de perfil</label>
            <input 
              type="file" 
              name="foto_funcionario" 
              id="foto_funcionario" 
              class="form-control"
              onchange="previewImage(this)"
              accept="image/*">
          </div>
          <!-- Botão de salvar -->
          <button
            type="submit"
            class="btn btn-dark rounded-pill px-3"
            form="user-form">
            Salvar Alterações
          </button>
        </div>
      </div>
    </div>
  </main>
</div>