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
            <!-- journal.html -->
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
                <div class="main_context">
                    <div class="context_header">
                        Журнал заказов
                    </div>

                    <div class="journal_list">
                        <div class="list_header">
                            Текущие заказы:
                        </div>
                        <div class="list">
                            <?php 
                            echo '<table>
                                    <thead>
                                        <th style="width: 50px">id</th>
                                        <th style="width: 150px">дата</th>
                                        <th style="width: 250px">название</th>
                                        <th><a href="index.php"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                    </thead>
                                    <tbody>';
                                    foreach ($values as $value) {
                                        echo    '<tr>';
                                        echo        '<td>'; print($value['id']); echo '</td>';
                                        echo        '<td>'.$value['order_date'].'</td>';
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
                                        echo '</td>';
                                        echo '<td> <input name="clear'.$value['id'].'" type="image" src="https://cdn-icons-png.flaticon.com/512/860/860829.png" width="20" height="20" alt="submit"/> </td>';
                                        echo    '</tr>';
                                    }
                                    echo '</tbody>
                                    </table>';

                            ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="footer">
            Данное web-приложение создано, как задача для летней практики, студентом 2 курса Моисеевым А.С.
        </div>
    </div>

    
    <script src="script.js"></script>
</body>
</html>