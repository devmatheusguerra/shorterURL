<?php
$uri = explode('/', $_SERVER['REQUEST_URI']);
if ($uri[1] == 'short') {
    $db = new SQLite3('data.db');
    $result = $db->query('SELECT * FROM arrow WHERE hash="' . $uri[2] . '"');

    $row = $result->fetchArray();
    $db->query("UPDATE arrow SET user_click=" . ($row['user_click'] + 1) . " WHERE hash='{$uri[2]}'");
    header('Location:' . $row['url']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortly</title>
    <style>
    body {
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: white;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        background: rgb(155, 6, 255);
        background: -moz-linear-gradient(90deg, rgba(155, 6, 255, 1) 0%, rgba(210, 0, 0, 1) 50%, rgba(255, 191, 100, 1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(155, 6, 255, 1) 0%, rgba(210, 0, 0, 1) 50%, rgba(255, 191, 100, 1) 100%);
        background: linear-gradient(90deg, rgba(155, 6, 255, 1) 0%, rgba(210, 0, 0, 1) 50%, rgba(255, 191, 100, 1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#9b06ff", endColorstr="#ffbf64", GradientType=1);
    }

    .container>label {
        font-size: 1.5rem;
        text-align: left;
        width: 60vw;
        font-weight: lighter;
    }

    .container>input {
        width: 60vw;
        border: 0;
        height: 30px;
        margin-top: 20px;
        border-radius: 10px;
        outline: 0;
        text-indent: 15px;
        color: #000000f0;
        background-color: rgba(255, 255, 255, 0.8)
    }

    .container>button {
        width: fit-content;
        height: fit-content;
        padding: 8px 30px;
        margin-top: 40px;
        background-color: transparent;
        border: 0;
        outline: 0;
        border: solid 2px rgba(255, 255, 255, 0.7);
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <?php
    if (!isset($_POST['url'])) {
        echo '<form action="" method="post">
            <div class="container">
                <label for="url">Fill the empty field with website URL: </label>
                <input id="url" autocomplete="off" type="url" name="url">
                <button>Gerar</button>
            </div>
        </form>';
    } else {
        require_once 'Database.php';
        $link = add($_POST['url']) or die(false);
        if ($link) {
            echo '<div class="container">
                <label for="url">Short Link:</label>
                <input data-clipboard-target="#url" id="url" autocomplete="off" type="url" name="url" value="http://localhost:8000/short/' . $link . '">    
                </div>
            <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
            ';

            echo "
                        <script>
                            var clipboard = new ClipboardJS('#url');

                clipboard.on('success', function(e) {
                    alert('Copiado para a área de transferência');

                    e.clearSelection();
                });
                </script>";
        }
    }

    ?>

</body>









</html>