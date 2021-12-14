<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="styles.css">
</head>
<body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<?php
//require 'flight/Flight.php';
require_once('vendor/autoload.php');
require_once('rb-mysql.php');

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function write_to_file($data) {
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    fwrite($myfile, $output);
    fclose($myfile);
}


// Flight::route('/', function(){
//   echo 'hello world!';
// });

// Flight::start();
$stripe = new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
$customer = $stripe->customers->create([
    'description' => 'MKD task',
    'email' => 'sohaib_baqai3@yahoo.com',
    'payment_method' => 'pm_card_visa',
    "balance" => 1230,
]);

R::setup('mysql:host=127.0.0.1;dbname=mkd_shoppingcart', 'root', '');
$listOfTables = R::inspect();

//write_to_file($customer);
debug_to_console($customer['id']);

$is_connected = R::getDatabaseAdapter()->getDatabase()->isConnected();

$items =  R::getAll( 'SELECT * FROM products' );

if(isset($_POST['submit']))
{
    
    $stripe = new \Stripe\StripeClient('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
$customer = $stripe->customers->create([
    'description' => 'MKD task',
    'email' => 'sohaib_baqai3@yahoo.com',
    'payment_method' => 'pm_card_visa',
    "balance" => 1230,
]);
    if ($customer){
        R::exec( 'INSERT INTO order (product_id, total, stripe_id, status)
        VALUES(2,300, ' . $customer['id'] . ', "p")' );
    }
} 
?>

<div class="card">
    <div class="row">
        <div class="col-md-8 cart">
            <div class="title">
                <div class="row">
                    <div class="col">
                        <h4><b>Shopping Cart</b></h4>
                    </div>
                    <div class="col align-self-center text-right text-muted"><?php echo count($items);?> items</div>
                </div>
            </div>
            <?php 
                for($i = 0; $i < count($items); $i++) {
                    echo '<div class="row border-top border-bottom">';
                        echo '<div class="row main align-items-center">';
                            echo '<div class="col-2"><img class="img-fluid" src="' . $items[$i]['image'] .'"></div>';
                            echo '<div class="col">';
                                echo '<div class="row text-muted">' . $items[$i]['title'] .'</div>';
                                echo '<div class="row">' . $items[$i]['description'] .'</div>';
                            echo '</div>';
                            //echo '<div class="col"> <a href="#">-</a><a href="#" class="border">1</a><a href="#">+</a> </div>';
                            echo '<input class="col" type="checkbox" id="' . $items[$i]['id'] .'" name="' . $items[$i]['id'] .'" value="' . $items[$i]['price'] .'">';
                            echo '<div class="col">&dollar; ' . $items[$i]['price'] .' </div>';
                        echo '</div>';
                    echo '</div>';
                    // echo $keys[$i] . "{<br>";
                    // foreach($superheroes[$keys[$i]] as $key => $value) {
                    //     echo $key . " : " . $value . "<br>";
                    // }
                    // echo "}<br>";
                }
            ?>
        </div>
        <form class="col-md-4 summary" method="post" action="home.php">
            <div>
                <h5><b>Summary</b></h5>
            </div>
            <hr>
            <div class="row">
                <div class="col" style="padding-left:0;">ITEMS: <?php echo count($items);?></div>
                <!-- <div class="col text-right">&dollar; 132.00</div> -->
            </div>
            <form>
                <p>SHIPPING</p> <select>
                    <option class="text-muted">Standard-Delivery- &dollar;5.00</option>
                    <!-- <option class="text-muted">Express-Delivery- &dollar;20.00</option> -->
                </select>
                <!-- <p>GIVE CODE</p> <input id="code" placeholder="Enter your code"> -->
            </form>
            <!-- <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                <div class="col">TOTAL PRICE</div>
                <div class="col text-right">&dollar; 137.00</div> -->
            </div> <button type="submit" class="btn" name="submit" value="submit">PROCEED</button>
            </form>
    </div>
</div> 

<div class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



</body>
</html>