<?php
// Use connection
include(__DIR__ . "/../conn/conn.php");

if (isset($_POST['getData'])) {
    $index = $conn->real_escape_string($_POST['index']); // First item showed
    $limit = $conn->real_escape_string($_POST['limit']); // Last item showed
    // Perform query with limits
    $sql = $conn->query(query: "SELECT * FROM characters LIMIT $index, $limit;");
    // Check if number of rows is greater than 0
    if ($sql->num_rows > 0) {
        $response = "";
        $no_picture = "https://res.cloudinary.com/dizcz3fgi/image/upload/v1733415277/no_picture_ix5lmr.png";
        // Loop throughout rows
        while ($data = $sql->fetch_array()) {
            if ($data['image_1'] !== "") {
                $image = $data['image_1'];
            } else if ($data['image_2'] !== "") {
                $image = $data['image_2'];
            } else if ($data['image_3'] !== "") {
                $image = $data['image_3'];
            } else {
                $image = $no_picture;
            }
            $name = $data['display_name'];
            $response .= '<div class="card">
                <a href="/character/id/' . $data['id'] . '">
                    <img
                        class="card-image"
                        alt="' . ucwords($name) . '"
                        src="' . $image . '"
                        title="' . ucwords($name) . '"
                    />
                </a>
                <p>' . mb_strtoupper($name) . '</p>
            </div>';
        }
        exit($response); // Terminate script with response. This is important to ajax request in home.php
    } else {
        exit("Maximum reached"); // Terminate script with message. This is important on scroll events in home.php
    }
}
?>