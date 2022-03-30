<?php
require_once('Config/connection.php');

class Product
{
    private $pdo;

    public $id;
    public $name;
    public $reference;
    public $price;
    public $weight;
    public $category;
    public $stock;
    public $created_at;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Connection::getConnect();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE LISTAR TODOS LOS DATOS
     */
    public function getList()
    {
        try {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM products");

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE LISTAR POR ID
     */
    public function getListId($id)
    {
        try {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM products where id = :id");
            $stm->bindValue('id', $id);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE CREAR
     */
    public function create($product)
    {

        try {
            $dtz = new DateTimeZone("America/Bogota");
            $dt = new DateTime("now", $dtz);
            $currentTime = $dt->format("Y-m-d");
            $insert = $this->pdo->prepare('INSERT INTO products VALUES(NULL,:name,:reference, :price,:weight , :category,:stock,:created_at)');
            $insert->bindValue('name', $product->name);
            $insert->bindValue('reference', $product->reference);
            $insert->bindValue('price', $product->price);
            $insert->bindValue('weight', $product->weight);
            $insert->bindValue('category', $product->category);
            $insert->bindValue('stock', $product->stock);
            $insert->bindValue('created_at', $currentTime);
            $insert->execute();
            $id = $this->pdo->lastInsertId();

            $this->transaction('Entrada',$product, $id);


        } catch (Exception $e) {
            echo $e;
            // echo json_encode($e);
        }

    }

    public function transaction($type, $product, $id)
    {
        try {
            $dtz = new DateTimeZone("America/Bogota");
            $dt = new DateTime("now", $dtz);
            $currentTime = $dt->format("Y-m-d");
            $insert = $this->pdo->prepare('INSERT INTO transtion VALUES(NULL,:id_product,:quantity, :trasn_type,:created_at)');
            $insert->bindValue('id_product', $id);
            $insert->bindValue('quantity', $product->stock);
            $insert->bindValue('trasn_type', $type);
            $insert->bindValue('created_at', $currentTime);
            $insert->execute();


        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    /** METODO DE ACTUALIZAR
     */
    public function update($product)
    {
        try {

            $update = $this->pdo->prepare('UPDATE products SET name=:name, reference=:reference, price=:price, 
                    weight=:weight,category=:category,  stock=:stock WHERE id=:id');
            $update->bindValue('id', $product->id);
            $update->bindValue('name', $product->name);
            $update->bindValue('reference', $product->reference);
            $update->bindValue('price', $product->price);
            $update->bindValue('weight', $product->weight);
            $update->bindValue('category', $product->category);
            $update->bindValue('stock', $product->stock);
            $update->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE ELIMINAR
     */
    public function delete($id)
    {

        try {

            $delete = $this->pdo->prepare('DELETE FROM products  WHERE id=:id');
            $delete->bindValue('id', $id);
            $delete->execute();

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}