<script type="text/javascript" src="modules/page_products/view/js/jquery.bootpag.min.js"></script>
<script type="text/javascript" src="modules/page_products/view/js/pages_products.js" ></script>

<br><br><br><br><br><br><br><br>
<!--input de autocomplete añadida-->
<center>
<form name="search_prod" id="search_prod" class="search_prod">
    <input type="text" value="" placeholder="Search Product ..." class="input_search" id="keyword" list="datalist">
    <!-- <div id="results_keyword"></div> -->
    <input name="Submit" id="Submit" class="button_search" type="button" />

</form>
</center>

<!--aquí pintamos los resultados a paginar-->
<div id="results"></div>

<center>
  <!--aquí irá la paginación de productos,donde seleccionamos la página-->
    <div class="pagination"></div>

</center>

<!-- modal window details_product -->

<section id="product">

<!-- en este modal se pintarán los detalles del producto-->
    <!--<div id="details_prod" hidden>

        <div id="details">-->
            <div id="img_prod" class="prodImg"></div>

            <div id="container">

                <h4> <strong><div id="serial_number"></div></strong> </h4>
                <br />
                <p>
                  <p>
                  <div id="country"></div>
                  </p>
                  <p>
                  <div id="trademark"></div>
                  </p>
                  <p>
                  <div id="model"></div>
                  </p>
                <div id="description_prod"></div>
                </p>
                <h2> <strong><div id="sale_price"></div></strong> </h5>
            </div>

      <!--  </div>

    </div>-->
</section>
