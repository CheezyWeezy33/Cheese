<!DOCTYPE html>
<html lang="sk">
<head>
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitaj na stránke</title>
   
</head>
<body>
    <h1>Vitaj na stránke</h1>
    <div class="filter-form">
        <form method="get">
            <input type="text" name="search" placeholder="Hľadať podľa názvu" value="<?php echo $_GET['search'] ?? ''; ?>">
                <select name="category">
                    <option value="">Všetky kategórie</option>
                    <option value="Mobily" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Mobil') ? 'selected' : ''; ?>>Mobily</option>
                    <option value="Pocitace" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Pocitac') ? 'selected' : ''; ?>>Počítače</option>
                    <option value="Tablety" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Tablet') ? 'selected' : ''; ?>>Tablety</option>
                </select>
            <input type="submit" value="Filter">
        </form>

    </div>

    <div class="product-grid">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nad3a2";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        $sql = "SELECT ID, Nazov, Cena, Obrazok FROM product WHERE 1=1" .
            ($search ? " AND Nazov LIKE '%" . $conn->real_escape_string($search) . "%'" : "") .
            ($category ? " AND kategoria = '" . $conn->real_escape_string($category) . "'" : "");
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-item">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Obrazok']) . '" alt="Product Image">';
                echo '<div class="product-name">' . htmlspecialchars($row['Nazov']) . '</div>';
                echo '<div class="product-price">€' . htmlspecialchars($row['Cena']) . '</div>';
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
