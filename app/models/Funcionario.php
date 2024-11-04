<?php
// Model/Funcionario.php
class Funcionario {
     $id;
     $nome;
     $cpf;
     $dataNascimento;
     $endereco;
     $telefone;
     $email;
     $cargo;
     $dataAdmissao;
     $dataDemissao;
     $salario;
     $numCarteiraTrabalho;
     $horarioTrabalho;
     $status;
     $fotoPerfil;

    // Construtor
    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    // Método para hidratar o objeto com dados
     function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}

// Model/FuncionarioDAO.php
class FuncionarioDAO {
     $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function inserir(Funcionario $funcionario) {
        $sql = "INSERT INTO funcionarios (
            nome, cpf, data_nascimento, endereco, telefone, 
            email, cargo, data_admissao, data_demissao, salario, 
            num_carteira_trabalho, horario_trabalho, status, foto_perfil
        ) VALUES (
            :nome, :cpf, :data_nascimento, :endereco, :telefone,
            :email, :cargo, :data_admissao, :data_demissao, :salario,
            :num_carteira_trabalho, :horario_trabalho, :status, :foto_perfil
        )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $funcionario->getNome(),
            ':cpf' => $funcionario->getCpf(),
            ':data_nascimento' => $funcionario->getDataNascimento(),
            ':endereco' => $funcionario->getEndereco(),
            ':telefone' => $funcionario->getTelefone(),
            ':email' => $funcionario->getEmail(),
            ':cargo' => $funcionario->getCargo(),
            ':data_admissao' => $funcionario->getDataAdmissao(),
            ':data_demissao' => $funcionario->getDataDemissao(),
            ':salario' => $funcionario->getSalario(),
            ':num_carteira_trabalho' => $funcionario->getNumCarteiraTrabalho(),
            ':horario_trabalho' => $funcionario->getHorarioTrabalho(),
            ':status' => $funcionario->getStatus(),
            ':foto_perfil' => $funcionario->getFotoPerfil()
        ]);
    }

    public function atualizar(Funcionario $funcionario) {
        $sql = "UPDATE funcionarios SET
            nome = :nome,
            cpf = :cpf,
            data_nascimento = :data_nascimento,
            endereco = :endereco,
            telefone = :telefone,
            email = :email,
            cargo = :cargo,
            data_admissao = :data_admissao,
            data_demissao = :data_demissao,
            salario = :salario,
            num_carteira_trabalho = :num_carteira_trabalho,
            horario_trabalho = :horario_trabalho,
            status = :status,
            foto_perfil = :foto_perfil
            WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $funcionario->getId(),
            ':nome' => $funcionario->getNome(),
            ':cpf' => $funcionario->getCpf(),
            ':data_nascimento' => $funcionario->getDataNascimento(),
            ':endereco' => $funcionario->getEndereco(),
            ':telefone' => $funcionario->getTelefone(),
            ':email' => $funcionario->getEmail(),
            ':cargo' => $funcionario->getCargo(),
            ':data_admissao' => $funcionario->getDataAdmissao(),
            ':data_demissao' => $funcionario->getDataDemissao(),
            ':salario' => $funcionario->getSalario(),
            ':num_carteira_trabalho' => $funcionario->getNumCarteiraTrabalho(),
            ':horario_trabalho' => $funcionario->getHorarioTrabalho(),
            ':status' => $funcionario->getStatus(),
            ':foto_perfil' => $funcionario->getFotoPerfil()
        ]);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM funcionarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            return new Funcionario($resultado);
        }
        return null;
    }

    public function listarTodos() {
        $sql = "SELECT * FROM funcionarios";
        $stmt = $this->db->query($sql);
        
        $funcionarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $funcionarios[] = new Funcionario($row);
        }
        return $funcionarios;
    }

    public function deletar($id) {
        $sql = "DELETE FROM funcionarios WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

// Model/FuncionarioService.php
class FuncionarioService {
     $funcionarioDAO;

    public function __construct(FuncionarioDAO $funcionarioDAO) {
        $this->funcionarioDAO = $funcionarioDAO;
    }

    public function cadastrarFuncionario(array $dados) {
        // Validações
        if (!$this->validarDados($dados)) {
            throw new Exception("Dados inválidos");
        }

        // Verifica CPF duplicado
        if ($this->cpfExiste($dados['cpf'])) {
            throw new Exception("CPF já cadastrado");
        }

        $funcionario = new Funcionario($dados);
        return $this->funcionarioDAO->inserir($funcionario);
    }

     function validarDados($dados) {
        // Validações básicas
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

     function validarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        return true; // Adicione mais validações conforme necessário
    }

     function cpfExiste($cpf) {
        // Implementar lógica para verificar CPF duplicado
        return false;
    }

    public function atualizarStatus($id, $novoStatus) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            throw new Exception("Funcionário não encontrado");
        }

        $funcionario->setStatus($novoStatus);
        return $this->funcionarioDAO->atualizar($funcionario);
    }

    public function calcularTempoServico($id) {
        $funcionario = $this->funcionarioDAO->buscarPorId($id);
        if (!$funcionario) {
            return 0;
        }

        $admissao = new DateTime($funcionario->getDataAdmissao());
        $demissao = $funcionario->getDataDemissao() 
            ? new DateTime($funcionario->getDataDemissao())
            : new DateTime();

        $intervalo = $admissao->diff($demissao);
        return $intervalo->y; // retorna anos de serviço
    }
}
