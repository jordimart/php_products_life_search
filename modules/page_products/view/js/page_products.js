$(document).ready(function() {
  $.get(
    //consultamos alservidor el número de páginas
    "modules/page_products/controller/controller_page_products.class.php?num_pages=true",
    function(data, status) {
      var json = JSON.parse(data);
      var pages = json.pages;
      //obtenemos el resultado mediante JSON
      //aqui obtengo el número de páginas
      //console.log(data);

      $("#results").load(
        //en la clase results pintamos los productos a paginar
        "modules/page_products/controller/controller_page_products.class.php"
      ); //load initial records

      // init bootpag
      //esto pinta el paginador dependiendo del número de páginas
      //no me funciona bien esta paginación, no coge lasconfiguraciones
      $(".pagination").bootpag({

        //total de páginas
        total: pages,
        //iniciamos en la página 1
        page: 1,
        //número maximo de páginas visibles
        maxVisible: 10,
        //pintamos botones de próximo y anterior
        next: 'next',
        prev: 'prev'
      }).on("page", function(e, num) {
        //alert(num);
        e.preventDefault();
        //$("#results").prepend('<div class="loading-indication"><img src="modules/services/view/img/ajax-loader.gif" /> Loading...</div>');
        $("#results").load(
          //en la clase results pintamos los productos a paginar dependiendo de la página
          "modules/page_products/controller/controller_page_products.class.php", {
            'page_num': num
          });

        // ... after content load
        /*$(this).bootpag({
         total: pages,
         maxVisible: 7
         });*/
      });

    }).fail(function(xhr) {
    //console.log(xhr.status);
    //die();
    //var json = JSON.parse(xhr.responseText);
    //alert(json.error);

    //if (xhr.responseText !== undefined && xhr.responseText !== null) {
    //var json = JSON.parse(xhr.responseText);
    //if (json.error !== undefined && json.error !== null) {
    //$("#results").text(json.error);

    //if  we already have an error 404
    if (xhr.status === 404) {
      $("#results").load(
        //decidimos que error pintar en caso del error que nos devulevan
        "modules/page_products/controller/controller_page_products.class.php?view_error=false"
      );
    } else {
      $("#results").load(
        //decidimos que error pintar en caso del error que nos devulevan
        "modules/page_products/controller/controller_page_products.class.php?view_error=true"
      );
    }

    //}
    //}
  });
});
