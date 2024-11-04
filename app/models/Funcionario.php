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

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
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
            ':nome' => $funcionario->nome,
            ':cpf' => $funcionario->cpf,
            ':data_nascimento' => $funcionario->dataNascimento,
            ':endereco' => $funcionario->endereco,
            ':telefone' => $funcionario->telefone,
            ':email' => $funcionario->email,
            ':cargo' => $funcionario->cargo,
            ':data_admissao' => $funcionario->dataAdmissao,
            ':data_demissao' => $funcionario->dataDemissao,
            ':salario' => $funcionario->salario,
            ':num_carteira_trabalho' => $funcionario->numCarteiraTrabalho,
            ':horario_trabalho' => $funcionario->horarioTrabalho,
            ':status' => $funcionario->status,
            ':foto_perfil' => $funcionario->fotoPerfil
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
            ':id' => $funcionario->id,
            ':nome' => $funcionario->nome,
            ':cpf' => $funcionario->cpf,
            ':data_nascimento' => $funcionario->dataNascimento,
            ':endereco' => $funcionario->endereco,
            ':telefone' => $funcionario->telefone,
            ':email' => $funcionario->email,
            ':cargo' => $funcionario->cargo,
            ':data_admissao' => $funcionario->dataAdmissao,
            ':data_demissao' => $funcionario->dataDemissao,
            ':salario' => $funcionario->salario,
            ':num_carteira_trabalho' => $funcionario->numCarteiraTrabalho,
            ':horario_trabalho' => $funcionario->horarioTrabalho,
            ':status' => $funcionario->status,
            ':foto_perfil' => $funcionario->fotoPerfil
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
