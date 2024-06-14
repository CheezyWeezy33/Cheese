<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nad3a2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $image = $_FILES["image"]["tmp_name"];
    $imgContent = addslashes(file_get_contents($image));
    
    $sql = "INSERT INTO product (Nazov, Cena, Obrazok) VALUES ('$name', '$price', '$imgContent')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nový produkt bol úspešne pridaný";
    } else {
        echo "Chyba: " . $sql . "<br>" . $conn->error;
    }
}

// Delete product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    $id = $_POST["id"];
    
    $sql = "DELETE FROM product WHERE ID=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Produkt bol úspešne odstránený";
    } else {
        echo "Chyba: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    <div class="filter-form">
        <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Názov produktu" required>
            <input type="number" name="price" placeholder="Cena" required>
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" name="add_product" value="Pridať">
        </form>
    </div>

    <h2>Zoznam produktov</h2>
    <div class="product-grid">
    <?php
        $sql = "SELECT ID, Nazov, Cena, Obrazok FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Obrazok']) . '" alt="Product Image">';
                echo '<div class="product-name">' . htmlspecialchars($row['Nazov']) . '</div>';
                echo '<div class="product-price">€' . htmlspecialchars($row['Cena']) . '</div>';
                echo '<form class="delete-form" action="admin.php" method="post">';
                echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['ID']) . '">';
                echo '<input type="submit" name="delete_product" value="Odstrániť">';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "No results found";
        }
        $conn->close();
    ?>
    </div>
</body>
</html>