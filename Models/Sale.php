<?php

class Sale
{

    private $pdo;

    public $id;
    public $id_product;
    public $quantity;
    public $created_at;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Connection::getConnect();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** ME TRAE LA LISTA DE VENTAS
     */
    public function getList()
    {
        try {
            $result = array();

            $stm = $this->pdo->prepare("SELECT s.*, p.name as name FROM sales s  INNER JOIN products p ON s.id_product = p.id");

            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());


        }
    }
    /** ME TRAE LA LISTA DE VENTAS POR ID
     */
    public function getStock($id, $stock)
    {
        try {

            $stm = $this->pdo->prepare("SELECT stock FROM products where stock >= :stock and id = :id  ");
            $stm->bindValue('id', $id);
            $stm->bindValue('stock', $stock);
            $stm->execute();


            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** ME TRAE LA LISTA DE VENTAS POR ID
     */
    public function getListId($id)
    {
        try {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM sales where id = :id");
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
            $insert = $this->pdo->prepare('INSERT INTO sales VALUES(NULL,:id_product,:quantity,:created_at)');
            $insert->bindValue('id_product', $product->id_product);
            $insert->bindValue('quantity', $product->quantity);
            $insert->bindValue('created_at', $currentTime);
            $insert->execute();

            $update = $this->pdo->prepare('UPDATE products SET stock = stock - :stock WHERE id=:id');
            $update->bindValue('stock', $product->quantity);
            $update->bindValue('id', $product->id_product);
            $update->execute();


            $this->transaction('Salida', $product);

        } catch (Exception $e) {

        }


    }

    public function transaction($type, $product)
    {
        try {
            $dtz = new DateTimeZone("America/Bogota");
            $dt = new DateTime("now", $dtz);
            $currentTime = $dt->format("Y-m-d");
            $insert = $this->pdo->prepare('INSERT INTO transtion VALUES(NULL,:id_product,:quantity, :trasn_type,:created_at)');
            $insert->bindValue('id_product', $product->id_product);
            $insert->bindValue('quantity', $product->quantity);
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
            $update = $this->pdo->prepare('UPDATE sales SET id_product=:id_product, quantity=:quantity WHERE id=:id');
            $update->bindValue('id', $product->id);
            $update->bindValue('id_product', $product->id_product);
            $update->bindValue('quantity', $product->quantity);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE ELIMINAR
     */
    public function delete($id)
    {

        try {

            $delete = $this->pdo->prepare('DELETE FROM sales  WHERE id=:id');
            $delete->bindValue('id', $id);
            $delete->execute();

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}