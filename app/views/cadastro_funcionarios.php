<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render("Funcionários");
  ?>
  <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">
    <form method="POST" class="w-50 border border-1 border-secondary-subtle rounded-3 shadow-sm p-4">
      <!-- Cabeçalho do formulário -->
      <header class="d-flex gap-3 mb-4">
        <img
          src="../assets/icons/cliente_cadastro.svg"
          alt="Cadastro de Clientes"
          class="brand-icon"
          style="height: 80px; width: 80px;" />
        <div class="lh-sm">
          <h1 class="brand-name fw-semibold fs-2 mt-1 d-flex flex-column gap-3">
            Cadastro de funcionários
          </h1>
          <p class="fs-5 text-secondary">
            Insira as informações do funcionário para cadastrá-lo
          </p>
        </div>
      </header>
      <div class="d-grid gap-4">
        <!-- Primeira linha do formulário -->
        <div class="row">
          <div class="col-md-8">
            <label for="nome" class="form-label">Nome completo</label>
            <input required type="text" class="form-control bg-body-tertiary" id="nome">
          </div>
          <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input required type="text" class="form-control bg-body-tertiary" id="telefone">
          </div>
        </div>
        <!-- Segunda linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" required class="form-control bg-body-tertiary" id="cpf">
          </div>
          <div class="col-md-8">
            <label for="email" class="form-label">Email</label>
            <input type="email" required class="form-control bg-body-tertiary" id="email">
          </div>
        </div>
        <!-- Terceira linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input
              type="date"
              required
              class="form-control bg-body-tertiary"
              id="data_nascimento"
              max="<?= date('Y-m-d') ?>">
          </div>
          <div class="col-md-4">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" name="cep" required class="form-control bg-body-tertiary" id="cep">
          </div>
          <div class="col-md-4">
            <label for="numero" class="form-label">Número</label>
            <input type="number" required class="form-control bg-body-tertiary" id=numero>
          </div>
        </div>
        <!-- Quarta linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" required class="form-control bg-body-tertiary" id="cargo">
          </div>
          <div class="col-md-4">
            <label for="salario" class="form-label">Salário</label>
            <input type="number" required class="form-control bg-body-tertiary" id=salario min="1200">
          </div>
          <div class="col-md-4">
            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
            <input type="file" required class="form-control bg-body-tertiary" id="foto_perfil" class="form-label">
          </div>
        </div>
      </div>
      <!-- Footer do formulário -->
      <footer class="d-flex justify-content-between align-items-start mt-5">
        <span class="text-secondary fw-light">
          * Certifique-se que os dados estão corretos antes de prosseguir.
          <?php /* Mensagem de erro */ ?>
        </span>
        <div class="d-flex gap-3">
          <button
            type="button"
            class="btn outline-btn px-5 rounded-pill"
            onclick="history.back()">
            Cancelar
          </button>
          <button class="btn btn-dark px-5 rounded-pill">
            Cadastrar
          </button>
        </div>
      </footer>
    </form>
  </main>
</div>