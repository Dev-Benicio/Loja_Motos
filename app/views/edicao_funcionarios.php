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
        <div style="width: 80px; height: 80px;">
          <img
            class="rounded-circle object-fit-cover h-100 w-100 shadow-sm"
            src="<?= $funcionario['foto_perfil'] ?>"
            onerror="this.src='/loja_motos/images/funcionarios/default_user.png'"
            alt="foto de funcionário">
        </div>
        <div class="lh-sm">
          <h1 class="brand-name fw-semibold fs-2 mt-1 d-flex flex-column gap-3">
            Atualizar funcionários
          </h1>
          <p class="fs-5 text-secondary">
            Atualize as informações do funcionário
          </p>
        </div>
      </header>
      <div class="d-grid gap-4">
        <!-- Primeira linha do formulário -->
        <div class="row">
          <div class="col-md-8">
            <label for="nome" class="form-label">Nome completo</label>
            <input required type="text" class="form-control bg-body-tertiary" id="nome" value="<?= $funcionario['nome'] ?>">
          </div>
          <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input required type="text" class="form-control bg-body-tertiary" id="telefone" value="<?= $funcionario['telefone'] ?>">
          </div>
        </div>
        <!-- Segunda linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" required class="form-control bg-body-tertiary" id="cpf" value="<?= $funcionario['cpf'] ?>">
          </div>
          <div class="col-md-8">
            <label for="email" class="form-label">Email</label>
            <input type="email" required class="form-control bg-body-tertiary" id="email" value="<?= $funcionario['email'] ?>">
          </div>
        </div>
        <!-- Terceira linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" required class="form-control bg-body-tertiary" id="cep" value="<?= $funcionario['cep'] ?? "" ?>">
          </div>
          <div class="col-md-4">
            <label for="numero" class="form-label">Número</label>
            <input type="number" required class="form-control bg-body-tertiary" id=numero value="<?= $funcionario['numero'] ?>">
          </div>
        </div>
        <!-- Quarta linha do formulário -->
        <div class="row">
          <div class="col-md-4">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" required class="form-control bg-body-tertiary" id="cargo" value="<?= $funcionario['cargo'] ?>">
          </div>
          <div class="col-md-4">
            <label for="salario" class="form-label">Salário</label>
            <input type="number" required class="form-control bg-body-tertiary" id=salario min="1200" value="<?= $funcionario['salario'] ?>">
          </div>
          <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select required class="form-select bg-body-tertiary" id="status" name="status_funcionario">
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
              <option value="demitido">Demitido</option>
              <option value="ferias">Férias</option>
              <option value="licenca">Licença</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="data_demissao" class="form-label">Data de admissão</label>
            <input type="date" required class="form-control bg-body-tertiary" id="data_demissao" value="<?= $funcionario['data_demissao'] ?>">
          </div>
          <div class="col-md-8">
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
            Atualizar
          </button>
        </div>
      </footer>
    </form>
  </main>
</div>