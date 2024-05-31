<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mysite');
$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Объявления</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ad-form {
            display: none;
        }
        .ad-card {
            margin-bottom: 30px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Объявления</h1>
        <div>
            <span class="mr-3">Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</span>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Выйти</button>
        </div>
    </div>
    <button class="btn btn-success mb-3" onclick="document.querySelector('.ad-form').style.display='block'">Опубликовать объявление</button>

    <div class="ad-form border p-3 mb-3">
        <form id="postAdForm">
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок" required>
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="description" class="form-control" placeholder="Описание" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <div class="row" id="ads">
        <!-- Здесь будут отображаться объявления -->
    </div>
</div>

<script>
document.getElementById('postAdForm').onsubmit = function(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById('postAdForm'));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'post_ad.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            loadAds();
            document.querySelector('.ad-form').style.display = 'none'; // Скрыть форму после отправки
            document.getElementById('postAdForm').reset(); // Очистить форму
        }
    };
    xhr.send(formData);
};

function loadAds() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_ads.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('ads').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

window.onload = loadAds;
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>