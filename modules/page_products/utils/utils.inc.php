<?php
//Plantillas para pintar en la vista errores o productos

//pintamos la página por html mediante php
function paint_template_error($message) {
    $log = Log::getInstance();
    //añadimos los errores al log general y de user
    $log->add_log_general("error paint_template_error", "page_products", "response" . http_response_code()); //$text, $controller, $function
    $log->add_log_user("error paint_template_error", "", "page_products", "response" . http_response_code()); //$msg, $username = "", $controller, $function

    $arrData = response_code(http_response_code());

    print ("<br><br><br><br><br><br>");
    print ("<div id='page'>");
    print ("<br><br>");
    print ("<div id='header_error' class='status4xx'>");
    //https://es.wikipedia.org/wiki/Anexo:C%C3%B3digos_de_estado_HTTP
    print("<h1>" . $message . "</h1>");
    print("</div>");
    print ("<div id='content'>");
    print ("<h2>The following error occurred:</h2>");
    print ("<p>The requested URL was not found on this server.</p>");
    print ("<P>Please check the URL or contact the <!--WEBMASTER//-->webmaster<!--WEBMASTER//-->.</p>");
    print ("</div>");
    print ("<div id='footer'>");
    print ("<p>Powered by <a href='http://www.ispconfig.org'>ISPConfig</a></p>");
    print ("</div>");
    print("</div>");


}

//pintamos el html por php los productos en el modal
function paint_template_products($arrData) {
    print ("<script type='text/javascript' src='modules/page_products/view/js/modal_products.js' ></script>");
    print ("<section >");
    print ("<div class='container'>");
    print ("<div id='list_prod' class='row text-center pad-row'>");
    print ("<ol class='breadcrumb'>");
    print ("<li class='active' >Products</li>");
    print ("</ol>");
    print ("<br>");
    print ("<br>");
    print ("<br>");
    print ("<br>");
  
    if (isset($arrData) && !empty($arrData)) {

        foreach ($arrData as $product) {

            print ("<div class='prod' serial_number='".$product['serial_number']."'>");
            print ("<img class='prodImg' src='" . $product['avatar'] . "'alt='product' >");
            print ("<p>Model: " . $product['model'] . "</p>");
            print ("<p id='p2'>" . $product['sale_price'] . "€</p>");
            print ("</div>");
        }
    }
    print ("</div>");
    print ("</div>");
    print ("</section>");
}
