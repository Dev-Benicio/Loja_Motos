<?php
// Model/VendasService.php
class VendasService {
    $vendasDAO;

    public function __construct(VendasDAO $vendasDAO) {
        $this->vendasDAO = $vendasDAO;
    }

    public function registrarVenda(array $dados) {
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        if ($this->notaFiscalExiste($dados['notaFiscal'])) {
            throw new Exception("Nota fiscal já registrada");
        }

        $venda = new Vendas($dados);
        return $this->vendasDAO->inserir($venda);
    }

    public function validarDados($dados) {
        if (empty($dados['notaFiscal'])) {
            return false;
        }

        if (empty($dados['valor']) || !is_numeric($dados['valor']) || $dados['valor'] <= 0) {
            return false;
        }

        if (empty($dados['metodoPagamento'])) {
            return false;
        }

        if (empty($dados['dataVenda'])) {
            return false;
        }

        return true;
    }

    public function notaFiscalExiste($notaFiscal) {
        $venda = $this->vendasDAO->buscarPorNotaFiscal($notaFiscal);
        return $venda !== null;
    }

    public function calcularTotalVendas($dataInicio, $dataFim) {
        $vendas = $this->vendasDAO->listarTodas();
        $total = 0;

        foreach ($vendas as $venda) {
            $dataVenda = new DateTime($venda->dataVenda);
            if ($dataVenda >= new DateTime($dataInicio) && $dataVenda <= new DateTime($dataFim)) {
                $total += $venda->valor;
            }
        }

        return $total;
    }

    public function gerarRelatorioVendas($dataInicio, $dataFim) {
        $vendas = $this->vendasDAO->listarTodas();
        $relatorio = [
            'total_vendas' => 0,
            'vendas_por_metodo' => [],
            'periodo' => [
                'inicio' => $dataInicio,
                'fim' => $dataFim
            ]
        ];

        foreach ($vendas as $venda) {
            $dataVenda = new DateTime($venda->dataVenda);
            if ($dataVenda >= new DateTime($dataInicio) && $dataVenda <= new DateTime($dataFim)) {
                $relatorio['total_vendas'] += $venda->valor;
                
                if (!isset($relatorio['vendas_por_metodo'][$venda->metodoPagamento])) {
                    $relatorio['vendas_por_metodo'][$venda->metodoPagamento] = 0;
                }
                $relatorio['vendas_por_metodo'][$venda->metodoPagamento] += $venda->valor;
            }
        }

        return $relatorio;
    }
}
?>
