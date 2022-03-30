<?php
require_once('Models/Sale.php');

class SalesController

{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Sale();
    }

    public function index()
    {
        include 'Views/templates/header.php';
        include 'Views/sale/index.php';
        include 'Views/templates/footer.php';

    }

    public function getSale()
    {
        $id = $_REQUEST['id'];
        $product = $this->model->getListId($id);
        echo json_encode($product);
    }

    public function register()
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

                        $product->id_product = $_REQUEST['id_product'];

                        $product->quantity = $_REQUEST['quantity'];

                        $stock = $this->model->getStock($_POST["id_product"],$_REQUEST['quantity']);

                        if ($stock === false) {
                            $array_devolver['error'] = "No hay la suficiente cantidad del producto en bodega";


                        } else {
                            $this->model->create($product);
                        }
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
                        $product->id_product = $_REQUEST['id_product'];
                        $product->quantity = $_REQUEST['quantity'];
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