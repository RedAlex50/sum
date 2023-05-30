<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles/style.css">
    <link type="image/x-icon" href="images/logo.png" rel="shortcut icon">
    <link type="Image/x-icon" href="images/logo.png" rel="icon">
    <title>Столовая</title>
</head>
<body>
    <header>
        <div class="header-items">
            <a href="index.php" class="logo">
                <!-- <img src="images/logo.png" alt="logo" width="37" height="37"> -->
                <h1>Столовая</h1>
            </a>
            <nav>
                <ul>
                    <li><a href="Products.php">Список продуктов</a></li>
                    <li><a href="Dishes.php">Список блюд</a></li>
                    <li><a href="Menu.php">Меню</a></li>
                    <li><a class="active" href="#">Журнал заказов</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <?php
            if (!empty($_COOKIE['messages'])) {
                echo '<div class="messages">';
                $messages = unserialize($_COOKIE['messages']);
                foreach ($messages as $message) {
                    echo $message . '</br>';
                }
                echo '</div>';
                setcookie('messages', '', time() + 24 * 60 * 60);
            }
            if (!empty($_COOKIE['errors'])) {
                echo '<div class="errors">';
                $errors = unserialize($_COOKIE['errors']);
                foreach ($errors as $error) {
                    echo $error . '</br>';
                }
                echo '</div>';
                setcookie('errors', '', time() + 24 * 60 * 60);
            }
        ?>
        <form action="" method="POST">
            <div class="main-content">
                <h2>Журнал заказов</h2>
            </div>
            <div class="main-content">
                <div class="top-table">
                    <div class="newdates">
                        <div class="newdates-item">
                            <label for="name">Дата заказа:</label>
                        </div>
                        <div class="newdates-item">
                            <input type="date" name="order_date" placeholder="дата">
                        </div>
                        <div class="newdates-item">
                            <label for="dishes">Список блюд:</label>
                        </div>
                        <div class="newdates-item">
                            <select name="dishes[]" id="dishes" multiple>
                                <?php
                                    $stmt = $db->prepare("SELECT id, name FROM dishes");
                                    $stmt->execute();
                                    $Dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($Dishes as $dish) {
                                        printf('<option value="%d">%s</option>', $dish['id'], $dish['name']);
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="newdates-item">
                            <input type="submit" name="addnewdate" value="Добавить">
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">
            <?php
                echo    '<table class="table-mobile">
                            <tr>
                                <th>id</th>
                                <th>Дата</th>
                                <th>Список блюд</th>
                                <th colspan=2>&nbsp;</th>
                            <tr>';
                foreach ($values as $value) {
                    echo    '<tr>';
                    echo        '<td>'; print($value['id']); echo '</td>';
                    echo        '<td>
                                    <input'; if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) print(" disabled ");
                                    else print(" "); echo 'type="date" name="order_date'.$value['id'].'" value="'.$value['order_date'].'">
                                </td>';
                    echo        '<td>';
                                    $stmt = $db->prepare("SELECT dish_id FROM journal_dishes WHERE journal_id = ?");
                                    $stmt->execute([$value['id']]);
                                    $Dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($Dishes as $dish) {
                                        $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
                                        $stmt->execute([$dish['dish_id']]);
                                        $name = $stmt->fetchColumn();
                                        print($name . '<br>');
                                    }
                    echo        '</td>';
                if (empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) {
                    echo        '<td> <input name="edit'.$value['id'].'" type="image" src="https://static.thenounproject.com/png/2185844-200.png" width="20" height="20" alt="submit"/> </td>';
                    echo        '<td> <input name="clear'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="20" height="20" alt="submit"/> </td>';
                } else {
                    echo        '<td colspan=2> <input name="save'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/84/84138.png" width="20" height="20" alt="submit"/> </td>';
                }
                    echo    '</tr>';
                }
                echo '</table>';
            ?>
            </div>
        </form>
    </main>
</body>
</html>