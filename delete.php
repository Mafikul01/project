<?php
$con = mysqli_connect("localhost", "root", "", "crud");
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else {
    echo "Connected to MySQL successfully!<br>";
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . mysqli_error($con);
    }
}
?>
<hr>
<a href="products.php">See Remaining Products</a>