<?php
include("./includes/init.php");
?>
<?php
include("./classes/FieldType.php");
?>
<?php
function formatDate($date)
{
    $dateTime = new DateTime($date);
    $formattedDate = $dateTime->format('d.m.Y, H:i');
    return $formattedDate;
}


function fetchData($conn)
{
    try {

        $query = $conn->prepare(' SELECT blogs.*, users.email, users.avatar_url
                                    FROM blogs
                                    JOIN users ON blogs.user_id = users.id
                                    ORDER BY blogs.created_at DESC');
        $query->execute();
        return $query->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}


?>
<?php
$posts = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    if ($action === 'logout') {
        session_unset();
        session_destroy();
        header('Location: ' . $BASE_URL);
        exit();
    }
} else if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $posts = fetchData($connection);
}

