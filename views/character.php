<?php
// Use connection
include(__DIR__ . "/../conn/conn.php");

// Get stored id
$id = $_SESSION['id'];
$slide = false;

// Get first or last id
function getId($conn, $query)
{
    $sql = "SELECT $query(id) AS id FROM characters;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return (int)$row['id'];
}

$min_id = getId($conn, "MIN"); // Get the lowest id number
$max_id = getId($conn, "MAX"); // Get the highest id number

// Check if previous or next id exists
function existingId($conn, $initial, $operation)
{
    global $max_id;

    $id = $initial;

    do {
        if ($operation === "increment") $id++;
        if ($operation === "decrement") $id--;

        $sql = "SELECT id FROM characters WHERE id = $id LIMIT 1;";      
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    } while ($row < 1 and $id <= $max_id);

    return (int)$id;
}

$previous = "/character/id/" . (string)($id === $min_id ? $max_id : existingId($conn, $id, "decrement")); // Link to previous character
$next = "/character/id/" . (string)($id === $max_id ? $min_id : existingId($conn, $id, "increment")); // Link to next character

// Select all columns with matching id
$sql = "SELECT * FROM characters WHERE id = '$id';";
$query = mysqli_query($conn, $sql);
// Check number of rows y assign variables
if (mysqli_num_rows($query) > 0) {
    foreach ($query as $row) {
        $name = $row['display_name'];
        $full_name = $row['full_name'];
        $alias = $row['alias'];
        $description = $row['description'];
        $gender = $row['gender'];
        $species = $row['species'];
        $homeworld = $row['homeworld'];
        $born = $row['birth_year'];
        $died = $row['death_year'];

        $image_1 = $row['image_1'];
        $image_2 = $row['image_2'];
        $image_3 = $row['image_3'];

        $portrayed_1 = $row['portrayed_image_1'];
        $portrayed_2 = $row['portrayed_image_2'];
        $portrayed_3 = $row['portrayed_image_3'];
        // Slide images only if there are 3 of them
        ($row['image_2'] !== "" || $row['image_3'] !== "") ? $slide = true : $slide = false;
        // Separate name and full name into arrays
        $separated_name = explode(" ", $name);
        $separated_full_name = explode(" ", $full_name);
        // Check if name and full name have some duplicates
        $some_name_matches = array_intersect($separated_name, $separated_full_name);
    }
}

function getImages($query)
{
    if (mysqli_num_rows($query) > 0) {
        foreach ($query as $row) {
            $images = array();
            $no_picture = "https://res.cloudinary.com/dizcz3fgi/image/upload/v1733415277/no_picture_ix5lmr.png";

            $image_1 = ($row['image_1'] !== "") ? $row['image_1'] : $no_picture;
            array_push($images, $image_1); // Add an image to images array

            if ($row['image_2'] !== "") {
                $image_2 = $row['image_2'];
                array_push($images, $image_2);
            }

            if ($row['image_3'] !== "") {
                $image_3 = $row['image_3'];
                array_push($images, $image_3);
            }

            $images_length = count($images); // Get length of images array
        }
        // Loop throughout images
        for ($i = 1; $i <= $images_length; $i++) {
            $image_number = "image_" . $i;
            $image = ($row[$image_number] !== "") ? $row[$image_number] : $no_picture;
            $portrayed_number = "portrayed_image_" . $i;
            $portrayed = ($row[$portrayed_number] !== "") ? htmlspecialchars($row[$portrayed_number], ENT_QUOTES) : "";
            echo '<div class="slide">
                <img
                    class="slide-image"
                    src="' . $image . '"
                    alt="' . $row['display_name'] . '"
                    title="' . $portrayed . '"
                />
            </div>';
        }
    }
}

$conn->close(); // Close connection
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include(__DIR__ . "/../templates/meta.php");  ?>
        <link rel="stylesheet" href="/assets/styles/character.css" type="text/css">
    </head>
    <body>
        <?php include(__DIR__ . "/../templates/header.php");  ?>
        <div class="slider-container">
            <?php if ($slide): ?>
            <div class="slider">
            <?php else: ?>
            <div class="no-slider">
            <?php
                endif;
                getImages($query);
            ?>
            </div>
        </div>
        <div class="character-details">
            <table>
            <?php if ($name === $full_name || !$some_name_matches) : ?>
                <tr>
                    <td class="info-title">Name:</td>
                    <td class="info"><?= $name ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($name !== $full_name) : ?>
                <tr>
                    <td class="info-title">Full Name:</td>
                    <td class="info"><?= $full_name ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($alias !== "") : ?>
                <tr>
                    <td class="info-title">Other Names:</td>
                    <td class="info"><?= ucwords($alias) ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($description !== "") : ?>
                <tr>
                    <td class="info-title">Description:</td>
                    <td class="info description"><?= $description ?></td>
                </tr>
            <?php endif; ?>
                <tr>
                    <td class="info-title">Gender:</td>
                    <td class="info"><?= ($gender === "n/a" ? strtoupper($gender) : ucfirst($gender)) ?></td>
                </tr>
                <tr>
                    <td class="info-title">Species:</td>
                    <td class="info"><?= ucfirst($species) ?></td>
                </tr>
                <tr>
                    <td class="info-title">Homeworld:</td>
                    <td class="info"><?= ($homeworld === "unknown" ? ucfirst($homeworld) : ucwords($homeworld)) ?></td>
                </tr>
                <tr>
                    <td class="info-title">Birth Year:</td>
                    <td class="info"><?= ($born === "unknown" ? ucfirst($born) : strtoupper($born)) ?></td>
                </tr>
            <?php if ($died !== "") : ?>
                <tr>
                    <td class="info-title">Death Year:</td>
                    <td class="info"><?= ($died === "unknown") ? ucfirst($died) : strtoupper($died) ?></td>
                </tr>
            <?php endif; ?>
            </table>
            <div class="controls">
                <a href=<?= $previous ?>>previous</a>
                <a href=<?= $next ?>>next</a>
            </div>
        </div>
        <?php include(__DIR__ . "/../templates/footer.php");  ?>
    </body>
</html>