<?php

<?php
// Predefined arrays of book titles, genres, and prices
$bookTitles = array(
    "The Great Gatsby",
    "To Kill a Mockingbird",
    "1984",
    "Pride and Prejudice",
    "The Catcher in the Rye",
    "The Hobbit",
    "Fahrenheit 451",
    "The Lord of the Rings",
    "Animal Farm",
    "Brave New World"
);

$genres = array(
    "Fiction",
    "Mystery",
    "Science Fiction",
    "Romance",
    "Fantasy",
    "Thriller",
    "Horror",
    "Historical Fiction",
    "Biography",
    "Non-fiction"
);

$prices = array(
    10.99,
    12.50,
    9.75,
    15.20,
    8.99,
    11.49,
    14.75,
    13.99,
    10.25,
    9.99
);

// Function to select ten random items from an array
function selectRandomItems($array) {
    $randomItems = array_rand($array, 10);
    $selectedItems = array();
    foreach ($randomItems as $index) {
        $selectedItems[] = $array[$index];
    }
    return $selectedItems;
}

// Selecting random book titles, genres, and prices
$randomBookTitles = selectRandomItems($bookTitles);
$randomGenres = selectRandomItems($genres);
$randomPrices = selectRandomItems($prices);

// Displaying the data in columns
echo "<table border='1'>";
echo "<tr><th>Book Title</th><th>Genre</th><th>Price ($)</th></tr>";
for ($i = 0; $i < 10; $i++) {
    echo "<tr>";
    echo "<td>" . $randomBookTitles[$i] . "</td>";
    echo "<td>" . $randomGenres[$i] . "</td>";
    echo "<td>" . $randomPrices[$i] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

   session_start(); //otvorenie session

   unset($_SESSION["username"]); //vymazanie session
   
   echo 'You have loggout and cleaned session';

   header('Refresh: 2; URL = index.php'); // presmerovanie na prihlasenie
?>
