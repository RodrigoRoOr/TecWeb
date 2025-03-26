<?php
require_once 'DataBase.php';

/**
 * Clase para manejar operaciones de productos en la base de datos
 */
class Products extends DataBase {
    protected array $data = [];

    public function __construct(string $db, string $user = 'root', string $pass = 'password') {
        parent::__construct($db, $user, $pass);
        $this->data = [];
    }

    public function add(object $product): void {
        $stmt = $this->conexion->prepare("INSERT INTO productos VALUES (
            null, ?, ?, ?, ?, ?, ?, ?, 0
        )");
        
        $imagen = $product->imagen ?? 'img/default.jpg';
        $stmt->bind_param(
            "sssdsss",
            $product->nombre,
            $product->marca,
            $product->modelo,
            $product->precio,
            $product->detalles,
            $product->unidades,
            $imagen
        );
        
        $this->setResult($stmt->execute(), $stmt->error);
        $stmt->close();
    }

    public function delete(int $id): void {
        $stmt = $this->conexion->prepare("UPDATE productos SET eliminado=1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        $this->setResult($stmt->execute(), $stmt->error);
        $stmt->close();
    }

    public function edit(int $id, array $productData): void {
        // Verificar si el producto existe primero
        $this->single($id);
        if (empty($this->data)){
            $this->data = ['error' => 'No se encontró el producto'];
            return;
        }

        $stmt = $this->conexion->prepare("UPDATE productos SET 
            nombre=?, marca=?, modelo=?, precio=?, detalles=?, unidades=?, imagen=? 
            WHERE id=?"
        );
        
        $stmt->bind_param(
            "sssdsssi",
            $productData['nombre'],
            $productData['marca'],
            $productData['modelo'],
            $productData['precio'],
            $productData['detalles'],
            $productData['unidades'],
            $productData['imagen'],
            $id
        );
        
        $this->setResult($stmt->execute(), $stmt->error);
        $stmt->close();
    }

    public function list(): void {
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        $this->executeQuery($query);
    }

    public function search(string $criteria): void {
        $query = "SELECT * FROM productos WHERE 
                 (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) 
                 AND eliminado = 0";
        
        $searchParam = "%$criteria%";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isss", $criteria, $searchParam, $searchParam, $searchParam);
        
        $this->executeStatement($stmt);
    }

    public function single(int $id): void {
        $query = "SELECT * FROM productos WHERE id = ? AND eliminado = 0";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        $this->executeStatement($stmt, true);
    }

    public function singleByName(string $name): void {
        $query = "SELECT * FROM productos WHERE nombre = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $name);
        
        $this->executeStatement($stmt, true);
    }

    public function getData(): string {
        return json_encode($this->data);
    }

    // Métodos protegidos para reutilización

    protected function setResult(bool $result, string $error = ''): void {
        $this->data = $result ? ['success' => true] : ['error' => $error];
    }

    protected function executeQuery(string $query): void {
        $result = $this->conexion->query($query);
        
        if ($result) {
            $this->data = [];
            while ($row = $result->fetch_assoc()) {
                $this->data[] = $row;
            }
            
            if (empty($this->data)) {
                $this->data = ['error' => 'No se encontraron registros'];
            }
            $result->free();
        } else {
            $this->data = ['error' => $this->conexion->error];
        }
    }

    protected function executeStatement(mysqli_stmt $stmt, bool $single = false): void {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($single) {
                $this->data = $result->fetch_assoc() ?: ['error' => 'No se encontró el registro'];
            } else {
                $this->data = $result->fetch_all(MYSQLI_ASSOC) ?: ['error' => 'No se encontraron registros'];
            }
            
            $result->free();
        } else {
            $this->data = ['error' => $stmt->error];
        }
        
        $stmt->close();
    }
}
?>