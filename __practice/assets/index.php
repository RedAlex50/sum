<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="styles/index.css">
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
                    <li><a href="Journal.php">Журнал заказов</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <?php
            if (!empty($_COOKIE['dishes'])) {
                echo '<div class="messages">';
                echo 'Заказ создан.<br>Cодержимое заказа:';
                $dishes = unserialize($_COOKIE['dishes']);
                echo '<ul>';
                foreach ($dishes as $dish) {
                    $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
                    $stmt->execute([$dish]);
                    $name = $stmt->fetchColumn();
                    echo '<li>' . $name . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                setcookie('dishes', '', time() + 24 * 60 * 60);
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

            if (empty($_COOKIE['dishes'])) {
        ?>

        <form action="" method="POST">
            <div class="main-content">
                <h2>Создать заказ</h2>
            </div>
            <div class="main-content">
                <?php 
                    echo '<ul>';
                    foreach ($values as $value) {
                        echo '<li>Название меню: ' . $value['name'];
                        $stmt = $db->prepare("SELECT dish_id FROM menu_dishes WHERE menu_id = ?");
                        $stmt->execute([$value['id']]);
                        $Dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        echo '<ul>';
                        foreach ($Dishes as $dish) {
                            $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
                            $stmt->execute([$dish['dish_id']]);
                            $name = $stmt->fetchColumn();
                            echo '  <li>
                                        <input type="checkbox" id="'.$dish['dish_id'].'" name="dishes[]" value='.$dish['dish_id'].'>
                                        <label for="'.$dish['dish_id'].'">'.$name.'</label>
                                    </li>';
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                    echo '</ul>';
                ?>
            </div>
            <div class="newdates-item">
                <input type="submit" name="create" value="Создать заказ">
            </div>
        </form>

         <?php 
         } else {
            echo '  <form action="" method="POST">
                        <div class="newdates-item">
                            <input type="submit" name="new" value="Создать новый заказ">
                        </div>
                    </form>
                ';
         }
         ?>
         
    </main>
</body>
</html>