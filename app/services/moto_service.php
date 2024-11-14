<?php
// Model/MotoService.php
class moto_service {
    $motoDAO;

    public function __construct(MotoDAO $motoDAO) {
        $this->motoDAO = $motoDAO;
    }

    public function cadastrarMoto(array $dados) {
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        $moto = new Moto($dados);
        return $this->motoDAO->inserir($moto);
    }

    public function validarDados($dados) {
        if (empty($dados['marca']) || empty($dados['modelo'])) {
            return false;
        }

        if (empty($dados['preco']) || !is_numeric($dados['preco']) || $dados['preco'] <= 0) {
            return false;
        }

        if (empty($dados['ano']) || !is_numeric($dados['ano']) || 
            $dados['ano'] < 1900 || $dados['ano'] > date('Y') + 1) {
            return false;
        }

        if (empty($dados['potenciaCavalos']) || !is_numeric($dados['potenciaCavalos']) || 
            $dados['potenciaCavalos'] <= 0) {
            return false;
        }

        if (em// Model/MotoService.php
class MotoService {
    $motoDAO;

    public function __construct(MotoDAO $motoDAO) {
        $this->motoDAO = $motoDAO;
    }

    public function cadastrarMoto(array $dados) {
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        $moto = new Moto($dados);
        return $this->motoDAO->inserir($moto);
    }

    public function validarDados($dados) {
        if (empty($dados['marca']) || empty($dados['modelo'])) {
            return false;
        }

        if (empty($dados['preco']) || !is_numeric($dados['preco']) || $dados['preco'] <= 0) {
            return false;
        }

        if (empty($dados['ano']) || !is_numeric($dados['ano']) || 
            $dados['ano'] < 1900 || $dados['ano'] > date('Y') + 1) {
            return false;
        }

        if (empty($dados['potenciaCavalos']) || !is_numeric($dados['potenciaCavalos']) || 
            $dados['potenciaCavalos'] <= 0) {
            return false;
        }

        if (empty($dados['consumo']) || !is_numeric($dados['consumo']) || $dados['consumo'] <= 0) {
            return false;
        }

        return true;
    }

    public function calcularCustoKm($modeloMoto, $precoLitro) {
        $moto = $this->motoDAO->buscarPorModelo($modeloMoto->marca, $modeloMoto->modelo);
        if (!$moto) {
            throw new Exception("Modelo de moto não encontrado");
        }

        return ($pty($dados['consumo']) || !is_numeric($dados['consumo']) || $dados['consumo'] <= 0) {
            return false;
        }

        return true;
    }

    public function calcularCustoKm($modeloMoto, $precoLitro) {
        $moto = $this->motoDAO->buscarPorModelo($modeloMoto->marca, $modeloMoto->modelo);
        if (!$moto) {
            throw new Exception("Modelo de moto não encontrado");
        }

        return ($precoLitro / $moto->consumo);
    }

    public function compararModelos($modelo1, $modelo2) {
        $moto1 = $this->motoDAO->buscarPorModelo($modelo1->marca, $modelo1->modelo);
        $moto2 = $this->motoDAO->buscarPorModelo($modelo2->marca, $modelo2->modelo);

        if (!$moto1 || !$moto2) {
            throw new Exception("Um ou mais modelos não encontrados");
        }

        return [
            'diferenca_preco' => $moto1->preco - $moto2->preco,
            'diferenca_potencia' => $moto1->potenciaCavalos - $moto2->potenciaCavalos,
            'diferenca_consumo' => $moto1->consumo - $moto2->consumo,
            'mais_economica' => $moto1->consumo > $moto2->consumo ? $moto1->modelo : $moto2->modelo,
            'mais_potente' => $moto1->potenciaCavalos > $moto2->potenciaCavalos ? $moto1->modelo : $moto2->modelo
        ];
    }

    public function buscarRecomendacoes($orcamento, $consumoMinimo = null) {
        $motos = $this->motoDAO->buscarPorFaixaPreco(0, $orcamento);
        $recomendadas = [];

        foreach ($motos as $moto) {
            if ($consumoMinimo === null || $moto->consumo >= $consumoMinimo) {
                $recomendadas[] = $moto;
            }
        }

        usort($recomendadas, function($a, $b) {
            return $b->consumo - $a->consumo;
        });

        return array_slice($recomendadas, 0, 5);
    }
}