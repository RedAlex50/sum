<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Столовая</title>
</head>
<body>
    <div class="main_frame">
        <div class="header">
            <div class="header_heading">
                <div class="heading_name">
                    Очень удобная столовая
                </div>
                <div class="heading_logo">
                    <img src="" alt="">
                </div>
            </div>
            
            <div class="nav_bar">
                <div class="header_links">
                    <div class="link_main">
                        <a href="index.php">Главная</a>
                    </div>
                    <div class="link_products">
                        <a href="Products.php">Продукты</a>
                    </div>
                    <div class="link_items">
                        <a href="Dishes.php">Блюда</a>
                    </div>
                    <div class="link_menu">
                        <a href="Menu.php">Меню</a>
                    </div>
                    <div class="link_journal">
                        <a href="Journal.php">Журнал заказов</a>
                    </div>
                    
                </div>
            </div>
        </div>

        
        <div class="main">
            <!-- order.html -->
            <div class="main_context">
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

                <div class="context_header">
                    Выбор заказа
                </div>
                <div class="context_form">
                    <form action="" method="POST">
                        <?php
                        echo '<div class="form_menu_picker">
                            <div class="picker_heading">Выберите блюдо из меню:</div>
                            <div class="picker_context">
                                <select name="item_picker" id="item_picker" multiple size="5">';
                                
                                foreach ($values as $value) {
                                    echo '<optgroup label="' . $value['name'] . ':">';
                                    $stmt = $db->prepare("SELECT dish_id FROM menu_dishes WHERE menu_id = ?");
                                    $stmt->execute([$value['id']]);
                                    $Dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($Dishes as $dish) {
                                        $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
                                        $stmt->execute([$dish['dish_id']]);
                                        $name = $stmt->fetchColumn();
                                        echo '<option id="'.$dish['dish_id'].'" name="dishes[]" value="'.$dish['dish_id'].'">'.$name.'</option>';
                                    }
                                    echo '</optgroup>';
                                }
                                echo '</select>
                            </div>
                        </div>';
                        ?>
                        <div class="newdates-item button_b">
                            <input type="submit" name="create" value="Создать заказ">
                        </div>
                    </form>
                </div>
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
            </div>
        </div>


        <div class="footer">
            Данное web-приложение создано, как задача для летней практики, студентом 2 курса Моисеевым А.С.
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>