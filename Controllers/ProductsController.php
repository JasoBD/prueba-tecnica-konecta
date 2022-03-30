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
        json_encode($product);
    }

    /** METODO DE CREAR
     */
    public function register()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                header("Content-Type: application/json");
                $array_devolver = [];
                $product = new Product();
                $captcha = $_POST['g-recaptcha-response'];

                $secret = '6Ldrm1waAAAAAKEiG-hg9_l5qIFn_-XXYpXJidWV';

                if (!$captcha) {

                    echo "Por favor verifica el captcha";

                } else {

                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");

                    $arr = json_decode($response, TRUE);

                    if ($arr['success']) {
                        $product->name = $_REQUEST['name'];
                        $product->reference = $_REQUEST['reference'];
                        $product->price = $_REQUEST['price'];
                        $product->weight = $_REQUEST['weight'];
                        $product->category = $_REQUEST['category'];
                        $product->stock = $_REQUEST['stock'];
                        $this->model->create($product);
                    } else {
                        $array_devolver['error'] = "Error al comprobar Captcha";
                    }
                }
                echo json_encode($array_devolver);

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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                header("Content-Type: application/json");
                $array_devolver = [];
                $product = new Sale();
                $captcha = $_POST['g-recaptcha-response'];

                $secret = '6Ldrm1waAAAAAKEiG-hg9_l5qIFn_-XXYpXJidWV';

                if (!$captcha) {

                    echo "Por favor verifica el captcha";

                } else {

                    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");

                    $arr = json_decode($response, TRUE);

                    if ($arr['success']) {

                        $product->id = $_REQUEST['id'];
                        $product->name = $_REQUEST['name'];
                        $product->reference = $_REQUEST['reference'];
                        $product->price = $_REQUEST['price'];
                        $product->weight = $_REQUEST['weight'];
                        $product->category = $_REQUEST['category'];
                        $product->stock = $_REQUEST['stock'];
                        $this->model->update($product);
                    } else {
                        $array_devolver['error'] = "Error al comprobar Captcha";
                    }

                }
                echo json_encode($array_devolver);
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


        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


}

