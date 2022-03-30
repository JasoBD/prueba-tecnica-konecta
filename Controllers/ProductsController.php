<?php
require_once('Models/Product.php');

class ProductsController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Product();
    }

    /** CARGAR LA VISTA
     */
    public function index()
    {
        include 'Views/templates/header.php';
        include 'Views/product/index.php';
        include 'Views/templates/footer.php';
    }

    /** LISTAR TODOS
     */
    public function getProdutAll()

    {
        $id = $_REQUEST['id'];
        $product = $this->model->getList();
        json_encode($product);

    }

    /** LISTAR POR ID
     */
    public function getProdut()
    {
        $id = $_REQUEST['id'];
        $product = $this->model->getListId($id);
        echo json_encode($product);
    }

    /** METODO DE CREAR
     */
    public function register()
    {
        try {
            if (isset($_POST["name"])) {
                $product = new Product();

                $product->name = $_REQUEST['name'];
                $product->reference = $_REQUEST['reference'];
                $product->price = $_REQUEST['price'];
                $product->weight = $_REQUEST['weight'];
                $product->category = $_REQUEST['category'];
                $product->stock = $_REQUEST['stock'];
                $this->model->create($product);
                $this->index();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    /** METODO DE ACTUALIZAR
     */
    public function update()
    {
        try {
            if (isset($_POST["id"])) {
                $product = new Product();

                $product->id = $_REQUEST['id'];
                $product->name = $_REQUEST['name'];
                $product->reference = $_REQUEST['reference'];
                $product->price = $_REQUEST['price'];
                $product->weight = $_REQUEST['weight'];
                $product->category = $_REQUEST['category'];
                $product->stock = $_REQUEST['stock'];
                $this->model->update($product);
                $this->index();
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /** METODO DE ELIMINAR
     */
    public function delete()
    {
        try {
            $id = $_REQUEST['id'];
            $this->model->delete($id);
            $this->index();

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


}

