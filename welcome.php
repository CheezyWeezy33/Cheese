<!DOCTYPE html>
<html lang="sk">
<head>
<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitaj na stránke</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .filter-form {
            padding: 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }

        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: flex-start;
        }

        .product-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            width: calc(33.33% - 20px);
            max-width: 300px;
        }

        .product-image-name {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .product-image-name img {
            max-width: 100px;
            height: auto;
        }

        .product-price,
        .product-button {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Vitaj na stránke</h1>
    <div class="filter-form">
        <form method="get">
        <input type="text" name="search" placeholder="Hľadať podľa názvu" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                
                
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

            // Construct SQL query
            $sql = "SELECT ID, Nazov, Cena, Obrazok FROM product WHERE 1=1";
            
            // Add filters based on user input
            if (!empty($search)) {
                $search_condition = " AND Nazov LIKE '%" . $conn->real_escape_string($search) . "%'";
                $sql .= $search_condition;
            }
            
            if (!empty($category)) {
                $category_condition = " AND kategoria = '" . $conn->real_escape_string($category) . "'";
                $sql .= $category_condition;
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-item">';
                    echo '<div class="product-image-name">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['Obrazok']) . '" alt="Product Image">';
                    echo '<div class="product-name">' . htmlspecialchars($row['Nazov']) . '</div>';
                    echo '</div>';
                    echo '<div class="product-price">€' . htmlspecialchars($row['Cena']) . '</div>';
                    echo '<div class="product-button"><button>Kúpiť</button></div>';
                    echo '</div>';
                }
            } else {
                echo "No results found";
            }
            $conn->close();
        ?>
    </div>

    <script>
        // You can include JavaScript here if needed
    </script>
</body>
</html>