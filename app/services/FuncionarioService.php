<?php
// Model/FuncionarioService.php

namespace App\Service;

use App\Database\banco_de_dados;

class FuncionarioService {
    $funcionarioDAO;

    public function __construct(FuncionarioDAO $funcionarioDAO) {
        $this->funcionarioDAO = $funcionarioDAO;
    }

    public function cadastrarFuncionario(array $dados) {
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        if ($this->cpfExiste($dados['cpf'])) {
            throw new Exception("CPF já cadastrado");
        }

        $funcionario = new Funcionario($dados);
        return $this->funcionarioDAO->inserir($funcionario);
    }

    public function validarDados($dados) {
        if (empty($dados['nome']) || strlen($dados['nome']) > 60) {
            return false;
        }

        if (!$this->validarCPF($dados['cpf'])) {
            return false;
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!empty($dados['salario']) && !is_numeric($dados['salario'])) {
            return false;
        }

        return true;
    }

    public function validarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        return true;
    }

    public function cpfExiste($cpf) {
        return false;
    }

    public function atualizarStatus($id, $novoStatus) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            throw new Exception("Funcionário não encontrado");
        }

        $funcionario->status = $novoStatus;
        return $this->funcionarioDAO->atualizar($funcionario);
    }

    public function calcularTempoServico($id) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            return 0;
        }

        $admissao = new DateTime($funcionario->dataAdmissao);
        $demissao = $funcionario->dataDemissao 
            ? new DateTime($funcionario->dataDemissao)
            : new DateTime();

        $intervalo = $admissao->diff($demissao);
        return $intervalo->y;
    }
}
?>
