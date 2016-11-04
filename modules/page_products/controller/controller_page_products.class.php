<?php
//controlador para el módulo de page products
//include  with absolute route
$path = $_SERVER['DOCUMENT_ROOT'];//ruta virtualhost

include $path . '/modules/page_products/utils/utils.inc.php';//utilidades de este módulopara pintar html por php
define('SITE_ROOT', $path);//definimos el valor de Site_root

include $path . '/paths.php';
include $path . '/classes/Log.class.singleton.php';
include $path . '/utils/common.inc.php';
include $path . '/utils/filters.inc.php';
include $path . '/utils/response_code.inc.php';

$_SESSION['module'] = "page_products";//guardamos el valor del módulo

//obtain num total pages
//obtenemos el número de páginas según los productos que hayan en base de datos
if ((isset($_GET["num_pages"])) && ($_GET["num_pages"] === "true")) {

    //definimos el número de productos por página
    $item_per_page = 4;
    //buscamos el modelo
    $path_model = SITE_ROOT . '/modules/page_products/model/model/';

    //change work error apache
    set_error_handler('ErrorHandler');

    try {
        //este load utilizara la función de buscar el número total de productos
        $arrValue = loadModel($path_model, "page_products_model", "total_products");
        $get_total_rows = $arrValue[0]["total"]; //total records
        $pages = ceil($get_total_rows / $item_per_page); //break total records into pages
    } catch (Exception $e) {
      //error en caso de que no funcione la base de datos, se pinta en el log
        showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
    }

    //change to defualt work error apache
    restore_error_handler();

    if ($get_total_rows) {
      //devolvemos al frontend el número de páginas mediante JSON
        $jsondata["pages"] = $pages;
        echo json_encode($jsondata);
        exit;
    } else {
      //si no hay productos lanzará el error de que no hay productos, se pinta en el log
        showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
    }

}


if ((isset($_GET["view_error"])) && ($_GET["view_error"] === "true")) {
  //esta función pintaría el error mediante un template de php en html
    showErrorPage(0, "ERROR - 503 BD Unavailable");
}
if ((isset($_GET["view_error"])) && ($_GET["view_error"] === "false")) {
  //esta función pintaría el error mediante un template de php en html
    showErrorPage(0, "ERROR - 404 NO DATA");
}

//Obtenemos según un id de producto seleccionado en el frontend los detalles del producto
if (isset($_GET["idProduct"])) {

    $arrValue = null;

    //anulo esta función ya que mi id es un string
    //filter if idProduct is a number
  /*  $result = filter_num_int($_GET["idProduct"]);

    if ($result['resultado']) {
        $id = $result['datos'];
    } else {
        $id = 1;
    }*/

    //modificación para que funcione con string
    $id = $_GET["idProduct"];

    set_error_handler('ErrorHandler');
    try {
      //obtenemos los datos del prodcuto con LoadModel de base de datos
        $path_model = SITE_ROOT . '/modules/page_products/model/model/';
        $arrValue = loadModel($path_model, "page_products_model", "details_products", $id);
    } catch (Exception $e) {
      //error en caso de no poder consultar en la base de datos, se pinta en el log
        showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
    }
    restore_error_handler();

    if ($arrValue) {
      //si hay datos en el array se los devolvemos al frontend mediante json
        $jsondata["product"] = $arrValue[0];
	      echo json_encode($jsondata);
        exit;
    } else {
      //error en caso de que no exista el producto, se pinta en el log
        showErrorPage(2, "ERROR - 404 NO DATA", 'HTTP/1.0 404 Not Found', 404);
    }

} else {

//si no hay un producto seleccionado paginará los productos
    $item_per_page = 6;

    //filter to $_POST["page_num"]
    if (isset($_POST["page_num"])) {
        $result = filter_num_int($_POST["page_num"]);
        if ($result['resultado']) {
            $page_number = $result['datos'];
        }
    } else {
        $page_number = 1;
    }

    set_error_handler('ErrorHandler');
    try {

      //esto se utiliza para no perder la posición al paginar
        $position = (($page_number - 1) * $item_per_page);
        $arrArgument = array(
            'position' => $position,
            'item_per_page' => $item_per_page
        );
        //utilizamos load model para consultar en bd los productos a paginar
        $path_model = SITE_ROOT . '/modules/page_products/model/model/';
        $arrValue = loadModel($path_model, "page_products_model", "page_products", $arrArgument);
    } catch (Exception $e) {
      //error si no se ha producido la consulta
      //esta función pintaría el error mediante un template de php en html
        showErrorPage(0, "ERROR - 503 BD Unavailable");
    }
    restore_error_handler();

    if ($arrValue) {
      //si hay valores en el array pintara por html hecho con php
        paint_template_products($arrValue);
    } else {
      //error si no hay productos
      //esta función pintaría el error mediante un template de php en html
        showErrorPage(0, "ERROR - 404 NO PRODUCTS");
    }

}
