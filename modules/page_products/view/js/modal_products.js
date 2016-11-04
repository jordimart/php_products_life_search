//we do this so that  details_prod don't appear
$("#details_prod").hide();
$(document).ready(function() {
  //actúa cuando clicamos en un producto
  $('.prod').click(function() {
    //recogemos el atributo serial number
    var id = this.getAttribute('serial_number');


    $.get(
        //consultamos con el servidor según el serial number recogido
        "modules/page_products/controller/controller_page_products.class.php?idProduct=" +
        id,
        function(data, status) {
          //recibimoslarespuesta mediante JSON y ya seleccionamos losdatos delproductos que queramos mostrar
          var json = JSON.parse(data);
          var product = json.product;

          //insertaremos en cada etiqueta el valor que queremos del producto
          $("#img_prod").html('<img src="' + product.avatar +
            '" height="75" width="75"> ');
          $("#serial_number").html(
            "<strong>Serial_number: <br/></strong>" + product.serial_number
          );
          $("#country").html("<strong>Country: </strong>" + product.category);
          $("#trademark").html("<strong>Trademark: </strong>" + product
            .trademark);
          $("#model").html("<strong>Model: </strong>" + product.model);
          $("#description").html("<strong>Description: <br/></strong>" +
            product.description);

          $("#sale_price").html("Price: " + product.sale_price + " €");

          //we do this so that  details_prod  appear
          $("#details_prod").show();


          $("#product").dialog({

            width: 850, //<!-- ------------- ancho de la ventana -->
            height: 500, //<!--  ------------- altura de la ventana -->
            //show: "scale", <!-- ----------- animación de la ventana al aparecer -->
            //hide: "scale", <!-- ----------- animación al cerrar la ventana -->
            resizable: "false", //<!-- ------ fija o redimensionable si ponemos este valor a "true" -->
            //position: "down",<!--  ------ posicion de la ventana en la pantalla (left, top, right...) -->
            modal: "true", //<!-- ------------ si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
            buttons: {
              Ok: function() {
                $(this).dialog("close");
              }
            },
            show: {
              effect: "blind",
              duration: 1000
            },
            hide: {
              effect: "explode",
              duration: 1000
            }
          });
        })
      .fail(function(xhr) {
        //if  we already have an error 404
        if (xhr.status === 404) {
          $("#results").load(
            //En la etiqueta results pintariamos el template de error según el que sea
            "modules/page_products/controller/controller_page_products.class.php?view_error=false"
          );
        } else {
          $("#results").load(
            //En la etiqueta results pintariamos el template de error según el que sea
            "modules/page_products/controller/controller_page_products.class.php?view_error=true"
          );
        }

      });
  });
});
