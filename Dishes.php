<?php

include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $db->prepare("SELECT id, name FROM dishes");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    
    include('assets/Dishes.php');
} else {
    $errors = array();
    $messages = array();

    if (!empty($_POST['addnewdate'])) {
        if (empty($_POST['name'])) {
            $errors['name'] = 'Заполните поле "Название блюда"';
        }
        if (empty($_POST['products'])) {
            $errors['products'] = 'Заполните поле "Список ингредиентов"';
        }
        if (empty($errors)) {
            $name = $_POST['name'];
            $stmt = $db->prepare("INSERT INTO dishes (name) VALUES (?)");
            $stmt->execute([$name]);

            $dish_id = $db->lastInsertId();
            $products = $_POST['products'];
            $stmt = $db->prepare("INSERT INTO dish_products (dish_id, product_id) VALUES (?, ?)");
            foreach ($products as $product) {
              $stmt->execute([$dish_id, $product]);
            }
            $messages['added'] = 'Блюдо "'.$name.'" успешно добавлено';
        }
    }

    foreach ($_POST as $key => $value) {
        if (preg_match('/^clear(\d+)_x$/', $key, $matches)) {

            $stmt = $db->prepare("DELETE FROM dish_products WHERE dish_id = ?");
            $stmt->execute([$id]);

            $stmt = $db->prepare("DELETE FROM dishes WHERE id = ?");
            $stmt->execute([$id]);



            $id = $matches[1]; 
            $stmt = $db->prepare("(SELECT id FROM menu_dishes WHERE dish_id = ?) UNION (SELECT id FROM journal_dishes WHERE dish_id = ?)");
            $stmt->execute([$id, $id]);
            $empty = $stmt->rowCount() === 0;
            if (!$empty) {
                $errors['delete'] = 'Поле с <b>id = '.$id.'</b> невозможно удалить, т.к. оно связанно с меню или журналом заказов';
            } else {
                $stmt = $db->prepare("DELETE FROM dish_products WHERE dish_id = ?");
                $stmt->execute([$id]);
    
                $stmt = $db->prepare("DELETE FROM dishes WHERE id = ?");
                $stmt->execute([$id]);

                $messages['deleted'] = 'Блюдо с <b>id = '.$id.'</b> успешно удалено';
            }

        }

        if (preg_match('/^edit(\d+)_x$/', $key, $matches)) {
            $id = $matches[1];
            setcookie('edit', $id, time() + 24 * 60 * 60);
        }

        if (preg_match('/^save(\d+)_x$/', $key, $matches)) {
            setcookie('edit', '', time() + 24 * 60 * 60);
            $id = $matches[1];
            $stmt = $db->prepare("SELECT name FROM dishes WHERE id = ?");
            $stmt->execute([$id]);
            $old_dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dates['name'] = $_POST['name' . $id];

            if (array_diff_assoc($dates, $old_dates[0])) {
                $stmt = $db->prepare("UPDATE dishes SET name = ? WHERE id = ?");
                $stmt->execute([$dates['name'], $id]);
            }
        }
    }
    if (!empty($messages)) {
        setcookie('messages', serialize($messages), time() + 24 * 60 * 60);
    }
    if (!empty($errors)) {
        setcookie('errors', serialize($errors), time() + 24 * 60 * 60);
    }
    header('Location: Dishes.php');
}