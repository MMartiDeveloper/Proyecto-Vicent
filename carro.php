<?php
  session_start();
  include("./include/funciones.php");
  $connect = connect_db();

  $title = "Maderas.de -> ";
  require './include/ElCaminas/Carrito.php';
  require './include/ElCaminas/Producto.php';
  require './include/ElCaminas/Productos.php';
  use ElCaminas\Carrito;


  $carrito = new Carrito();
  //Falta comprobar qué acción: add, delete, empty
  $action = "view";
if (($_SERVER["REQUEST_METHOD"] == "POST")){
  //Por javascript siempre llamamos con método POST
  if (isset($_POST["action"])){
      $action = $_POST["action"];
  }
  if ($action == "add"){
    //Pero accedo al 'id' mediante GET (ya que está en la url)
    if (!$carrito->itemExists($_GET["id"])){
      //Cuando es add, siempre añadimos 1 pero sólo si no estaba ya antes en el carro
      $carrito->addItem($_GET["id"], 1);
    }
    //Siempre devolvemos en itemCount los que ya hay ahora en el carro de ese producto
    echo json_encode(array("HOME"=> "/", "itemCount"=>$carrito->getItemCount($_GET["id"]), "cuantos"=> $carrito->howMany(), "total"=> $carrito->getTotal()));
    exit();
  }elseif ($action == "update"){
      //Cuando es update (desde el botón de actualizar de la ventana modal, la cantidad es la que introduce el usuario)
      $carrito->addItem($_GET["id"], $_POST["cantidad"]);
      echo json_encode(array("HOME"=> "/", "itemCount"=>$carrito->getItemCount($_GET["id"]), "cuantos"=> $carrito->howMany(), "total"=> $carrito->getTotal()));
      exit();
  }
}else {
  include("./include/header.php");

  if (isset($_GET["action"])){
      $action = $_GET["action"];
  }
  if ($action == "add")
    $carrito->addItem($_GET["id"], 1);
  else if ($action == "delete")
    $carrito->deleteItem($_GET["id"]);
  else if ($action == "empty")
      $carrito->empty();
?>
  <div class="row carro woodbar">
    <h2 class='subtitle darkwood' style='margin:0'>Carrito de la compra</h2>
    <?php  echo $carrito->toHtml();?>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content woodbar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel darkwood"></h4>
      </div>
      <div class="modal-body">
        <iframe src='#' width="100%" height="600px" frameborder=0 style='padding:8px'></iframe>
      </div>
    </div>
  </div>
</div>
  <?php
    $bottomScripts = array();
    $bottomScripts[] = "modalIframeProducto.js";
  ?>
  <script src="https://www.paypalobjects.com/api/checkout.js"></script>
  <script>
       paypal.Button.render({

           env: 'sandbox', // sandbox | production

           // PayPal Client IDs - replace with your own
           // Create a PayPal app: https://developer.paypal.com/developer/applications/create
           client: {
               sandbox:    'AURtFahgo3cuV-8J35gOhzh0AhTk36fnkHRkuGs-ZBiDoRdzd4NGvRDFFvzkCqmoU3puoZ3FOyS2zkDX',
               production: '<insert production client id>'
           },

           // Show the buyer a 'Pay Now' button in the checkout flow
           commit: true,

           // payment() is called when the button is clicked
           payment: function(data, actions) {

               // Make a call to the REST api to create the payment
               return actions.payment.create({
                   payment: {
                       transactions: [
                           {
                               amount: { total: '<?php echo $carrito->getTotal();?>', currency: 'EUR' }
                           }
                       ]
                   }
               });
           },

           // onAuthorize() is called when the buyer approves the payment
           onAuthorize: function(data, actions) {

               // Make a call to the REST api to execute the payment
               return actions.payment.execute().then(function() {
                   window.alert('Payment Complete!');
                   document.location.href = 'gracias.php';
               });
           }

       }, '#paypal-button-container');

   </script>
<?php
include("./include/footer.php");
}
?>
