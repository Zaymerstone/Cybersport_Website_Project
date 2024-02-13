<?php
include("./includes/init.php");
?>
<?php
include("./classes/Validator.php");
?>
<?php
include("./classes/ValidationRule.php");
?>
<?php
include("./classes/FieldType.php");
?>
<?php
function create($connection)
{
    $result = [];
    //Creating validator object
    $prevalidator = new Validator([
        FieldType::Title => [
            ValidationRule::Required => true,
        ],
        FieldType::Description => [
            ValidationRule::Required => true
        ],
        FieldType::CoverImage => [
            ValidationRule::Required => true
        ],
    ]);
    $prevalidator->validate($_POST);
    $coverImagePath = $prevalidator->validateFile([$_FILES[FieldType::CoverImage]], "cover"); // getting file path using validation
    $errors = $prevalidator->getMessages();

    foreach ($errors as $error) {
        if (count($error) > 0) {
            $result["errors"] = $errors;
            return $result;
        }
    }

    try {
        $query = $connection->prepare('INSERT INTO blogs(user_id, title, description, cover_url) VALUES(?, ?, ?, ?)');
        $newPost = $query->execute([$_SESSION[FieldType::UserID], $_POST[FieldType::Title], $_POST[FieldType::Description], $coverImagePath]);
        if ($newPost) {
            $result["post_created"] = true;
            return $result;
        }
    } catch (Exception $e) {
        $errors["general"] = "Try again later";
        $result["errors"] = $errors;
    }
    return $result;
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    if ($action === 'logout') {
        session_unset();
        session_destroy();
        header('Location: ' . $BASE_URL);
        exit();
    } else if ($action === 'create_post') {
        $result = create($connection);
        if (!$result["errors"] && $result["post_created"] ) {
            $_SESSION['errors'] = [];
            header('Location: ' . $BASE_URL);
            exit();
        } else {
            $_SESSION['errors'] = $result["errors"];
        }
    }
}
