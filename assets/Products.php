<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="image/x-icon" href="assets/logo.png" rel="icon">
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
                    <img src="assets/logo.png" alt="logo" height="120px" style="margin-left: 50px">
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
            <!-- products.html -->
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
            <div class="main_context">
                <div class="context_header">
                    Склад продуктов
                </div>

                <form action="" method="POST">
                    <div class="context_form" id="products_form">
                        <div class="menu_add_item">
                            <div>Название продукта:</div>
                            <div class="add_item_input"><input name="name" placeholder="qwerty"></div>
                            <br>
                            <div>Кол-во продукта:</div>
                            <div class="add_item_input"><input name="quantity" placeholder="1234"></div>
                        </div>
                        <div class="button_d">
                            <input class="btn_1" type="submit" name="addnewdate" value="Добавить">
                            <button class="btn_1"  onclick="closeProductsMenu()">
                                Закрыть форму
                            </button>
                        </div>
                    </div>



                    <div class="product_list">
                        <div class="list_header">
                            Список продуктов на складе:
                        </div>
                        <div class="list">
                            <?php 
                                echo '<table>
                                        <thead>
                                            <th style="width: 50px">id</th>
                                            <th style="width: 250px">название</th>
                                            <th style="width: 150px">кол-во</th>
                                            <th colspan=2><i class="fa fa-plus" aria-hidden="true" onclick="openProductsMenu()"></i></th>
                                        </thead>
                                        <tbody>';
                                foreach ($values as $value) {
                                    echo '<tr>';
                                    echo    '<td>'; print($value['id']); echo '</td>';
                                    echo    '<td>';
                                    if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) echo $value['name'];
                                    else echo '<input name="name'.$value['id'].'" value="'.$value['name'].'">';
                                    echo '</td>';
                                    echo '<td>';
                                    if(empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) echo $value['quantity'];
                                    else echo '<input name="quantity'.$value['id'].'" value="'.$value['quantity'].'">';
                                    echo '</td>';
                                if (empty($_COOKIE['edit']) || ($_COOKIE['edit'] != $value['id'])) {
                                    echo        '<td> <input name="edit'.$value['id'].'" type="image" src="https://static.thenounproject.com/png/2185844-200.png" width="20" height="20" alt="submit"/> </td>';
                                    echo        '<td> <input name="clear'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="20" height="20" alt="submit"/> </td>';
                                } else {
                                    echo        '<td colspan=2> <input name="save'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/84/84138.png" width="20" height="20" alt="submit"/> </td>';
                                }
                                    echo    '</tr>';
                                }
                                echo '</tbody>
                                </table>';
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