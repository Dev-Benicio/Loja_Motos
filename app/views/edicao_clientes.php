<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <?php

  use App\Components\navbar;

  $navbar = new navbar();
  echo $navbar->render("Clientes");
  ?>
  <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">
    <form method="POST" class="w-50 border border-1 border-secondary-subtle rounded-3 shadow-sm p-4">
      <!-- Cabeçalho do formulário -->
      <header class="d-flex gap-3 mb-4">
        <img
          src="/loja_motos/assets/icons/cliente_cadastro.svg"
          alt="Cadastro de Clientes"
          class="brand-icon"
          style="height: 80px; width: 80px;" />
        <div class="lh-sm">
          <h1 class="brand-name fw-semibold fs-2 mt-1 d-flex flex-column gap-3">
            Atualizar cliente
          </h1>
          <p class="fs-5 text-secondary">
            Atualize as informações do cliente
          </p>
        </div>
      </header>
      <div class="d-grid gap-4">
        <!-- Primeira linha do formulário -->
        <div class="row">
          <div>
            <input
              value="<?= $cliente['id_endereco'] ?>"
              type="hidden"
              id="id_endereco">
          </div>
          <div class="col-md-4">
            <label for="nome" class="form-label">Nome</label>
            <input
              value="<?= $cliente['nome'] ?>"
              required
              type="text"
              class="form-control bg-body-tertiary"
              id="nome">
          </div>
          <div class="col-md-4">
            <label for="sobrenome" class="form-label">Sobrenome</label>
            <input
              value="<?= $cliente['nome'] ?>"
              required type="text"
              class="form-control bg-body-tertiary"
              id="sobrenome">
          </div>
          <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input
              value="<?= $cliente['telefone'] ?>"
              required
              type="text"
              class="form-control bg-body-tertiary"
              id="telefone">
          </div>
        </div>
        <!-- Segunda linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cpf" class="form-label">CPF</label>
            <input
              value="<?= $cliente['cpf'] ?>"
              required
              type="text"
              class="form-control bg-body-tertiary"
              id="cpf">
          </div>
          <div class="col-md-8">
            <label for="email" class="form-label">Email</label>
            <input
              value="<?= $cliente['email'] ?>"
              required
              type="email"
              class="form-control bg-body-tertiary"
              id="email">
          </div>
        </div>
        <!-- Terceira linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input
              value="<?= $cliente['data_nascimento'] ?>"
              type="date"
              required
              class="form-control bg-body-tertiary"
              id="data_nascimento"
              max="<?= date('Y-m-d') ?>">
          </div>
          <div class="col-md-4">
            <label for="cep" class="form-label">CEP</label>
            <input
              value="<?= $cliente['cep'] ?? "" ?>"
              required
              type="text"
              class="form-control bg-body-tertiary"
              id="cep">
          </div>
          <div class="col-md-4">
            <label for="numero" class="form-label">Número</label>
            <input
              value="<?= $cliente['numero'] ?>"
              required
              type="number"
              class="form-control bg-body-tertiary"
              id=numero>
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
            Alterar
          </button>
        </div>
      </footer>
    </form>
  </main>
</div>