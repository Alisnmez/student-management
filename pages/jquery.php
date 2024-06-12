<?php

include "../dbConnection.php";
$todos = $connection->query('SELECT * FROM todo ORDER BY id ')->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="popup">
        <form action="">
            <input type="text" name="todo" placeholder="Todo">
            <select name="type" id="">
                <option value="">Tipi Seçin</option>
                <option value="1">Ders</option>
                <option value="2">Her gün yapılacaklar</option>
                <option value="3">Sorumluluklarım</option>
            </select><br>
            <label >
                <input type="checkbox" name="done" value="1">
                Bunu yaptım olarak işaretle
            </label><br>
            <button>ekle</button>
        </form>
    </div>
    <br>
    <button class="new-todo">Yeni Ekle</button>

    <table border="1">
        <thead>
            <tr>
                <th>Todo</th>
                <th>Tip</th>
                <th>Yapıldı mı?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todos as $todo) : ?>

                <tr>
                    <td><?=$todo['todo'] ?></td>
                    <td><?=$todo['type'] ?></td>
                    <td><?=$todo['done'] ?></td>
                    <td>
                        <button>Düzenle</button>
                        <button>Sil</button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('.new-todo').on('click',function(e) {
        const data={
            type : 'new-todo'
        }
        $.post('api.php',data,function(response){

        })
    });
</script>
</body>

</html>