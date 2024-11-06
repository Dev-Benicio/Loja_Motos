<?php
namespace services;

require_once __DIR__ . '/../database/BancoDeDados.php';
require_once __DIR__ . '/../models/Funcionario.php';

use database\BancoDeDados;
use models\Funcionario;

class FuncionarioService {
    private const TABLE_NAME = 'funcionarios';

    $funcionario;

    public function __construct(Funcionario $funcionario) {
        $this->funcionario = $funcionario;
    }
            
    public function cadastrarFuncionario(Funcionario $funcionario): bool {
        // Define as colunas da tabela que correspondem aos dados do funcionário
        $columns = [
            'nome',
            'cpf',
            'email',
            'telefone',
            'cargo',
            'salario'
            // Adicione outras colunas conforme necessário
        ];

        // Obtém os valores do objeto funcionário na mesma ordem das colunas
        $values = [
            $funcionario->getNome(),
            $funcionario->getCpf(),
            $funcionario->getEmail(),
            $funcionario->getTelefone(),
            $funcionario->getCargo(),
            $funcionario->getSalario()
            // Adicione outros getters conforme necessário
        ];

        // Chama o método cadastrar do BancoDeDados
        return BancoDeDados::cadastrar(
            self::TABLE_NAME,
            $columns,
            $values
        );
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
