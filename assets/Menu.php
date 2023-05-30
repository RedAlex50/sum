<!DOCTYPE html>
<html lang="en">
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
            <!-- menu.html  -->
            <div class="main_context">
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
                <div class="context_header">
                    Меню
                </div>

                <div class="button_d">
                    <button class="btn_1" onclick="openFormMenu()" id="btn_openMenuForm">
                        Создать новое меню
                    </button>
                </div>
                
                <form action="" method="POST">
                    <div class="context_form" id="menu_form">
                        <div class="menu_add_item">
                            <div>Название меню:</div>
                            <div class="add_item_input"><input name="name" placeholder="qwerty"></div>
                        </div>
                        
                        <div class="menu_item_comp">
                            <div class="picker_heading">Выберите блюда:</div>
                            <div class="picker_context">
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
                        </div>
                        <div class="button_d">
                            <input class="btn_1" type="submit" name="addnewdate" value="Добавить">
                            <button class="btn_1"  onclick="closeFormMenu()">
                                Закрыть форму
                            </button>
                        </div>
                    </div>

                    <div class="product_list">
                        <div class="list">
                            <?php 
                                foreach ($values as $value) {
                                    echo '
                                    <div class="list_header">
                                        '.$value['name'].'
                                    </div>
                                    <table>
                                        <thead>
                                            <th>id</th>
                                            <th>список</th>
                                            <th><input name="clear'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="20" height="20" alt="submit"/></th>
                                        </thead>';
                                    echo '<tbody>';
                                    $stmt = $db->prepare("SELECT dish_id FROM menu_dishes WHERE menu_id = ?");
                                    $stmt->execute([$value['id']]);
                                    $Dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($Dishes as $dish) {
                                        $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
                                        $stmt->execute([$dish['dish_id']]);
                                        $name = $stmt->fetchColumn();
                                        echo '<tr>
                                            <td>'.$dish['dish_id'].'</td>
                                            <td colspan=2>'.$name.'</td>
                                            </tr>';
                                    }
                                    echo '</tbody>
                                    </table>';
                                }                        
                            ?>
                                
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="footer">
            Данное web-приложение создано, как задача для летней практики, студентом 2 курса Моисеевым А.С.
        </div>
    </div>

    
    <script src="script.js"></script>
</body>
</html>