<?php
function select($connection){ //функция выборки данных из БД
    $sql = "select * from comments order by comment_date desc";
    $result = $connection->query($sql);
    while ($row = $result->fetch()) {
        $response[] = $row;
    }
    return $response;
}
$json = file_get_contents('php://input'); //получаем данные, отправленные через axios
$obj = json_decode($json, TRUE); //разбираем json в ассоциативный массив
$user = "root";
$password = "test";
$conn = new PDO("mysql:dbname=commentsdb;host=localhost", $user, $password); //создаем подключение к БД
if (!$conn) {
    die("Error connection to database.");
}
else {
    $name=$obj[0]["name"]; //имя
    $text=$obj[0]["comment"]; //текст комментария
    $date=$obj[0]["date"]; //и дата, отправленные из формы
    $id=$obj['id']; //id будет существовать, только если нажата кнопка "Удалить"
    $date=date('Y-m-d G:i:s', $date); //переведем дату в формат, удобный для вставки в БД
    if($name && $text && $date !== null) { //если все переменные получены
        $sql = "insert into comments (author_name, comment_text, comment_date) values ('$name','$text','$date')";
        $stmt = $conn->prepare($sql); //подготавливаем и выполняем запрос на добавление новой строки в БД
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            die("Ошибка при добавлении комментария!!!");
        }
        $response=select($conn); //проводим выборку из БД
        echo json_encode($response); //возвращаем массив (объект) в виде JSON
    }
    elseif ($id!==null){ //если id проинициализирована(нажата кнопка "Удалить")
        $sql = "delete from comments where comment_id='$id'";
        $stmt = $conn->prepare($sql); //подготавливаем и выполняем запрос на удаление строки из БД
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            die("Ошибка при удалении комментария!!!");
        }
        $response=select($conn); //также проводим выборку из БД
        echo json_encode($response); //и возвращаем массив (объект) в виде JSON
    }
    else //по умолчанию (при загрузке страницы)
    {
        $response=select($conn); //также проводим выборку из БД
        echo json_encode($response); //и возвращаем массив (объект) в виде JSON
    }
    $conn=null;
}
?>
