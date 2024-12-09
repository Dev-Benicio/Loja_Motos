<div class="d-flex flex-column justify-content-between vh-100">
  <!-- HEADER -->
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render();
  ?>
  <!-- Mensagem de erro 404 -->
  <main class="d-flex flex-column align-items-center justify-content-center gap-3">
    <!-- Erro 404 -->
    <div
      class="d-flex align-items-center justify-content-center fw-semibold"
      style="font-size: 7.5rem; line-height: 1;">
      <span>4</span>
      <img
        class="d-block"
        src="./assets/icons/roda_de_moto.svg"
        alt="roda de moto representando o zero do erro 404"
        style="height: 8.5rem; width: auto;">
      <span>4</span>
    </div>
    <!-- Mensagem de erro -->
    <div class="error-message text-center d-flex flex-column gap-3 mb-4">
      <h1 class="h1 fw-semibold" style="font-size: 3rem;">
        Ops! Rota não encontrada
      </h1>
      <p class="fs-3 fw-normal text-secondary">
        Parece que você pegou a saída errada. Esta página não existe.
      </p>
    </div>
    <!-- Botão de voltar -->
    <a
      href="javascript:void(0)"
      onclick="history.back()"
      class="btn btn-dark rounded-5 px-4 py-3">
      Voltar para a página anterior
    </a>
  </main>
  <!-- Rodovia -->
  <footer
    class="d-flex justify-content-center align-items-center gap-5 bg-secondary-subtle w-100"
    style="height: 80px;">
    <div
      class="bg-secondary"
      style="height: 27px; width: 170px; opacity: 0.3;"></div>
    <div
      class="bg-secondary"
      style="height: 27px; width: 170px; opacity: 0.3;"></div>
    <div
      class="bg-secondary"
      style="height: 27px; width: 170px; opacity: 0.3;"></div>
  </footer>
</div>