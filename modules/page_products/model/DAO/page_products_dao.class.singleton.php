<?php
class page_products_dao {

    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

//selecciona todos los producto de la db
    public function list_products_DAO($db) {
        $sql = "SELECT * FROM products";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);

    }
    //Consulta losdatos de un producto según un id pasado previamente
    public function details_products_DAO($db,$id) {
          $sql = "SELECT * FROM products WHERE serial_number LIKE '".$id."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);

    }
    //Pagina los productos segun la posición en la página y los productos por página
    public function page_products_DAO($db,$arrArgument) {
        $position = $arrArgument['position'];
        $item_per_page = $arrArgument['item_per_page'];
        $sql = "SELECT * FROM products ORDER BY serial_number ASC LIMIT ".$position." , ".$item_per_page;

        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);

    }
    //consulta el número de productos
    public function total_products_DAO($db) {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);

    }

}
