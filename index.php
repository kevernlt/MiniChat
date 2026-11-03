<?php

try {
    $pdo = new PDO(
        'mysql:host=mysql-etu.unicaen.fr;dbname=ernault251_0',
        'ernault251',
        'XXXX'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'alert("Pas conecté bdd")';
}

$pseudo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["pseudo"]) && !empty($_POST["message"])) {
        $pseudo = htmlspecialchars($_POST["pseudo"]);
        $message = htmlspecialchars($_POST["message"]);
        $stmt = $pdo->prepare('insert into messages values(:message,sysdate(),:pseudo)');
        $stmt->execute(array('pseudo' => $pseudo, 'message' => $message));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniChat</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form">
        <form action="index.php" method="post">
            Pseudo : <input id="pseudo" name="pseudo" type="text" placeholder="Pseudo" value="<?php echo $pseudo ?>"><br>
            Message : <input id="message" name="message" type="text" placeholder="Message"><br>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <div class="messages">
        <h1>Messages</h1>
        <?php

        $stmt = $pdo->query('select * from messages order by mdate desc limit 5');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<p class="message">' . $row['mdate'] . ' ' . $row['pseudo'] . ' : ' . $row['text'] . '</p>' . '<br>';

        }
        ?>
    </div>
</body>

</html>