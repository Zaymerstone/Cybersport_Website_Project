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
function login($connection)
{
    $result = [];
    //Creating validator object
    $loginRules = [
        FieldType::Email => [
            ValidationRule::Required => true,
            ValidationRule::Email => true
        ],
        FieldType::Password => [
            ValidationRule::Required => true
        ]
    ];

    //Validation before sending to the server
    $prevalidator = new Validator($loginRules);
    $prevalidator->validate($_POST);
    $errors = $prevalidator->getMessages();

    foreach ($errors as $error) {
        if (count($error) > 0) {
            $result["errors"] = $errors;
            return $result;
        }
    }

    try {
        $query = $connection->prepare('SELECT * FROM users WHERE email = ?');
        $query->execute([$_POST[FieldType::Email]]);
        $user = $query->fetch();
        if (!$user) {
            $errors["general"] = "Invalid email or password";
            $result["errors"] = $errors;
            return $result;
        }
    } catch (Exception $e) {
        $errors["general"] = "Try again later";
        $result["errors"] = $errors;
        return $result;
    }

    //Rules for password
    $loginRules[FieldType::Password] = [
        ValidationRule::Required => true,
        ValidationRule::ValidPassword => $user[FieldType::Password]
    ];
    //Validation for checking the password
    $postvalidator = new Validator($loginRules);
    $postvalidator->validate($_POST);
    $errors = $postvalidator->getMessages();

    if ($errors[FieldType::Password]) {
        $errors["general"] = "Invalid email or password";
        $result["errors"] = $errors;
        return $result;
    }

    $result[FieldType::Email] = $user[FieldType::Email];
    $result[FieldType::UserID] = $user[FieldType::UserID];
    $result[FieldType::UserAvatar] = $user[FieldType::UserAvatar];
    return $result;
}

function register($connection)
{
    $result = [];
    //Creating validator object
    $registerRules = [
        FieldType::Email => [
            ValidationRule::Required => true,
            ValidationRule::Email => true
        ],
        FieldType::Password => [
            ValidationRule::Required => true
        ],
        FieldType::PasswordRepeat => [
            ValidationRule::Required => true,
            ValidationRule::MatchPassword => $_POST[FieldType::Password]
        ]
    ];
    $prevalidator = new Validator($registerRules);
    $prevalidator->validate($_POST);
    $errors = $prevalidator->getMessages();

    foreach ($errors as $error) {
        if (count($error) > 0) {
            if (count($errors[FieldType::PasswordRepeat])) {
                $errors["general"] = "Passwords don't match";
            }
            $result["errors"] = $errors;
            return $result;
        }
    }

    $query = $connection->prepare('INSERT INTO users(email, password) VALUES(?, ?)');
    try {
        $res = $query->execute([$_POST[FieldType::Email], password_hash($_POST[FieldType::Password], PASSWORD_DEFAULT)]);
        if ($res) {

            $query = $connection->prepare('SELECT * FROM users WHERE email = ?');
            $query->execute([$_POST[FieldType::Email]]);
            $user = $query->fetch();

            $result[FieldType::Email] = $user[FieldType::Email];
            $result[FieldType::UserID] = $user[FieldType::UserID];
        }
    } catch (Exception $e) {
        $errors["general"] = "Try again later";
        $result["errors"] = $errors;
    }
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    if ($action === 'login') {
        $result = login($connection);
        if (!$result["errors"]) {
            $_SESSION['authorized'] = true;
            $_SESSION[FieldType::Email] = $result[FieldType::Email];
            $_SESSION[FieldType::UserID] = $result[FieldType::UserID];
            $_SESSION[FieldType::UserAvatar] = $result[FieldType::UserAvatar];
            $_SESSION['errors'] = [];
            header('Location: ' . $BASE_URL);
            exit();
        } else {
            $_SESSION['authorized'] = false;
            $_SESSION['errors'] = $result["errors"];
        }
    } elseif ($action === 'register') {
        $result = register($connection);
        if (!$result["errors"]) {
            $_SESSION['authorized'] = true;
            $_SESSION[FieldType::Email] = $result[FieldType::Email]; // save result to session
            $_SESSION[FieldType::UserID] = $result[FieldType::UserID];
            $_SESSION['errors'] = [];
            header('Location: ' . $BASE_URL);
            exit();
        } else {
            $_SESSION['authorized'] = false;
            $_SESSION['errors'] = $result["errors"];
        }
    } elseif ($action === 'logout') {
        session_unset();
        session_destroy();
        header('Location: ' . $BASE_URL);
        exit();
    }
}
