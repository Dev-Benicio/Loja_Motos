<link rel="stylesheet" href="./assets/CSS/dashboard.css">

<div class="d-flex flex-column vh-100">
  <!-- HEADER -->
  <?php
  use App\Components\navbar;
  $navbar = new navbar();
  echo $navbar->render('Relatórios');
  ?>
  <!-- Bento Grid com cards de relatórios -->
  <main class="container mt-4">
    <!-- Primeira linha -->
    <div class="row">
      <div
        class="col-12 position-relative mb-4"
        style="min-height: 300px; max-height: 350px;">
        <img
          src="./assets/images/motocross_dashboard.jpg"
          alt="Pessoa em uma motocicleta de motocross fazendo uma manobra no alto, depois de uma rampa"
          class="object-fit-cover w-100 h-100 rounded-3 shadow-sm">
        <!-- Top 3 funcionários -->
        <ul
          class="d-flex flex-column justify-content-start gap-3 list-group position-absolute top-0 end-0 me-3 h-100"
          style="scale: 0.9;">
          <li class="list-group-item active bg-black border-0 text-white pt-1 pb-2 px-4 rounded-3">
            <span class="fw-medium fs-4">
              Os mais Thunders!
            </span>
            <p class="fs-6 mb-0 text-white-50">
              Esses são os vendedores destaque do mês.
            </p>
          </li>
          <?php
          if (!empty($vendedores_com_mais_vendas) && is_array($vendedores_com_mais_vendas)) {
            $posicao_rank = 1;
            for ($i = 0; $i < 3; $i++) {
              $vendedor = $vendedores_com_mais_vendas[$i];
              echo <<<HTML
                <li
                  class="d-flex align-items-center gap-3 list-group-item border-0 rounded-3"
                  style="padding: 0.8rem 0.75rem;">
                  <!-- Avatar -->
                  <div class="position-relative">
                    <div
                      class="d-flex align-items-center justify-content-center bg-body-secondary rounded-circle p-2"
                      style="height: 50px; width: 50px;"
                    >
                      <i class="bi bi-person fs-2 text-secondary"></i>
                    </div>
                    <div class="position-absolute top-50 start-50 ms-1 d-flex align-items-center justify-content-center">
                      <i class="bi bi-award fs-3"></i>
                    </div>
                  </div>
                  <!-- Informações do funcionário -->
                  <div class="d-flex justify-content-between w-100">
                    <div class="d-flex flex-column justify-content-center">
                      <span class="fw-semibold" style="font-size: 1.15rem; line-height: 1.15rem;">
                        {$vendedor['vendedor_nome']}
                      </span>
                      <p class="mb-0 text-secondary">
                        {$posicao_rank}° Lugar
                      </p>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-end me-2">
                      <span class="fw-semibold fs-6">
                        Vendas
                      </span>
                      <p class="mb-0" style="font-size: 1.05rem;">
                        R$ {$vendedor['total_valor_vendas']}
                      </p>
                    </div>
                  </div>
                </li>
                HTML;
              $posicao_rank++;
            }
          } else {
            echo '<li class="list-group-item border-0 rounded-3">Nenhum vendedor encontrado.</li>';
          }
          ?>
        </ul>
      </div>
    </div>
    <!-- Segunda linha -->
    <div class="row" style="min-height: 300px; max-height: 400px;">
      <!-- Relatório de ocupação do estoque-->
      <div class="col-12 col-md-3 mb-3">
        <div class="card rounded-4 shadow-sm h-100">
          <div class="card-header bg-transparent border-0 d-flex align-items-center gap-2 mt-3">
            <img
              src="./assets/icons/caragem_estoque.svg"
              alt="Caragem de estoque"
              height="30px"
              width="30px">
            <h5 class="card-title mb-0">Ocupação do estoque</h5>
          </div>
          <!-- Gráfico de meio círculo -->
          <div class="card-body mt-2">
            <div class="position-relative d-flex justify-content-center">
              <svg class="svg-icon w-75 h-75" viewBox="0 0 120 60">
                <!-- Background (cinza) -->
                <path
                  d="M 10,60 A 50,50 0 1,1 110,60"
                  stroke-width="7"
                  fill="none"
                  stroke="#ccc" />
                <!-- Indicador (azul) -->
                <path
                  class="animate"
                  d="M 10,60 A 50,50 0 1,1 110,60"
                  stroke-width="10"
                  fill="none"
                  stroke="#0d6efd"
                  stroke-dasharray="157" />
              </svg>
              <?php
              $total_estoque = 200;
              $ocupacao_estoque = ($estoque_motos * 100) / $total_estoque;
              $ocupacao_estoque = round($ocupacao_estoque, 2);
              ?>
              <!-- Texto central -->
              <span class="fs-3 fw-semibold position-absolute translate-middle-x start-50 top-50 mt-2">
                <?= strval($ocupacao_estoque) ?>%
              </span>
            </div>
            <p class="text-center mb-3 mt-4">
              O estoque está com <?= $ocupacao_estoque ?>% de ocupação
            </p>
            <script>
              // Altera o valor da variável CSS --percent-half-circle
              document.documentElement.style.setProperty(
                '--percent-half-circle', <?= $ocupacao_estoque ?>
              );
            </script>
            <!-- legenda -->
          </div>
          <legend class="card-footer mt-3 mb-0">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-primary" style="height: 10px; width: 10px;"></div>
              <span class="fs-6 text-body">Motos dentro do estoque</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <div class="bg-secondary" style="height: 10px; width: 10px;"></div>
              <span class="fs-6 text-body">Espaço livre do estoque</span>
            </div>
          </legend>
        </div>
      </div>
      <!-- Chart.js, biblioteca para criar gráficos -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <!-- Relatório de motores com maior rotação -->
      <div class="col-12 col-md-4 mb-3">
        <div class="card rounded-4 shadow-sm h-100">
          <div class="card-header bg-transparent border-0 mt-2 d-flex align-items-center gap-3">
            <i class="bi bi-arrow-repeat fs-3" style="-webkit-text-stroke: 0.5px;"></i>
            <h5 class="card-title mb-0">Motos mais vendidas</h5>
          </div>
          <!-- Gráfico de torta -->
          <div class="card-body h-75 w-100">
            <canvas id="motos-maior-rotacao"></canvas>
          </div>
          <legend class="card-footer mb-0">
            <div class="d-flex align-items-center gap-3">
              <span class="fs-6 text-body">
                Moto com maior rotatividade: <?= $modelos_mais_vendidos[0]['modelo'] ?>
              </span>
            </div>
          </legend>
        </div>
        <!-- Script javascript para o gráfico de torta -->
        <script>
          // Dados de exemplo para o gráfico de rotação de motos 
          const dataMotos = {
            labels: [
              <?php
                foreach ($modelos_mais_vendidos as $modelo_mais_vendido) {
                  echo "'{$modelo_mais_vendido['modelo']}', ";
                }
              ?>
            ],
            datasets: [{
              label: 'Quantidade de vendas',
              data: [
                <?php
                foreach ($modelos_mais_vendidos as $modelo_mais_vendido) {
                  echo "'{$modelo_mais_vendido['total_vendas']}', ";
                }
              ?>
              ],
              hoverOffset: 4
            }]
          };

          // Configuração do gráfico de rotação de motos
          const configMotos = {
            type: 'pie',
            data: dataMotos,
            options: {
              responsive: true,
              maintainAspectRatio: true,
              aspectRatio: 1.7,
              plugins: {
                legend: {
                  position: 'right',
                  labels: {
                    font: {
                      family: 'Poppins'
                    }
                  }
                },
              }
            },
          };

          // Cria o gráfico de rotação de motos
          const ctx = document.querySelector('#motos-maior-rotacao').getContext('2d');
          const motosComMaiorRotatividade = new Chart(ctx, configMotos);
        </script>
      </div>
      <!-- Relatório de Vendas por mês -->
      <div class="col-12 col-md-5 mb-3">
        <div class="card rounded-4 shadow-sm h-100">
          <div class="card-header bg-transparent border-0 mt-2 d-flex align-items-center gap-3">
            <i class="bi bi-basket fs-3" style="-webkit-text-stroke: 0.5px;"></i>
            <h5 class="card-title mb-0">Vendas por mês</h5>
          </div>
          <div class="card-body">
            <canvas id="vendas-por-mes"></canvas>
          </div>
          <legend class="card-footer mb-0">
            <div class="d-flex align-items-center gap-3">
              <span class="fs-6 text-body">Total de vendas: 155 motos</span>
            </div>
          </legend>
        </div>
        <script>
          // Dados de exemplo para o gráfico de vendas
          const dadosVendas = {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
              label: 'Vendas Mensais',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          };

          // Configuração do gráfico de vendas
          const configVendas = {
            type: 'bar',
            data: dadosVendas,
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom',
                },
              },
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          };

          // Inicialização do gráfico
          const ctx2 = document.querySelector('#vendas-por-mes').getContext('2d');
          new Chart(ctx2, configVendas);
        </script>
      </div>
    </div>
  </main>
</div>