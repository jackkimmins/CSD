<?php

function doStuff($term, $category, $available_only) {
    echo "DEBUG: search called with " . $term . " " . $category . " " . $available_only . "\n";

    $query = "SELECT * FROM books WHERE 1=1";

    if ($term != "") {
        $query = $query . " AND (title LIKE '%" . $term . "%' OR author LIKE '%" . $term . "%')";
    }

    if ($category != "") {
        $query = $query . " AND category = '" . $category . "'";
    }

    if ($available_only == true) {
        $query = $query . " AND status = 'available'";
    }

    $conn = get_db_connection();
    $result = mysqli_query($conn, $query);

    $output = array();
    while ($row = mysqli_fetch_row($result)) {
        $book = array();
        $book["id"] = $row[0];
        $book["title"] = $row[1];
        $book["author"] = $row[2];
        $book["category"] = $row[3];
        $book["status"] = $row[4];
        $output[] = $book;
    }

    mysqli_close($conn);

    return $output;
}

function search_route() {
    $term = isset($_GET["q"]) ? $_GET["q"] : "";
    $category = isset($_GET["cat"]) ? $_GET["cat"] : "";
    $available_only = isset($_GET["avail"]) && $_GET["avail"] == "true";

}

search_route();
