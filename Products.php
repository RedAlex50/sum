<?php

include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $db->prepare("SELECT id, name, quantity FROM products");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    include('assets/Products.php');
} else {

    $errors = array();

    if (!empty($_POST['addnewdate'])) {

        if (empty($_POST['name'])) {
            $errors['name'] = 'Заполните поле "Название продукта"';
        }

        if (empty($_POST['quantity'])) {
            $errors['quantity'] = 'Заполните поле "Кол-во продукта"';
        } 
        
        if (empty($errors)) {
            $name = $_POST['name'];
            $quantity = $_POST['quantity'];
            $stmt = $db->prepare("INSERT INTO products (name, quantity) VALUES (?, ?)");
            $stmt->execute([$name, $quantity]);
            $messages['added'] = 'Продукт "'.$name.'" успешно добавлен';
        }


    }

    foreach ($_POST as $key => $value) {
        if (preg_match('/^clear(\d+)_x$/', $key, $matches)) {
    
            $id = $matches[1];
            $stmt = $db->prepare("SELECT id FROM dish_products WHERE product_id = ?");
            $stmt->execute([$id]);
            $empty = $stmt->rowCount() === 0;
            if (!$empty) {
                $errors['delete'] = 'Продукт с <b>id = '.$id.'</b> невозможно удалить, т.к. оно используется в каком-то блюде';
            } else {
                $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $messages['deleted'] = 'Продукт с <b>id = '.$id.'</b> успешно удалён';
            }

        }

        if (preg_match('/^edit(\d+)_x$/', $key, $matches)) {
            $id = $matches[1];
            setcookie('edit', $id, time() + 24 * 60 * 60);
        }

        if (preg_match('/^save(\d+)_x$/', $key, $matches)) {
            setcookie('edit', '', time() + 24 * 60 * 60);
            $id = $matches[1];
            $stmt = $db->prepare("SELECT name, quantity FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $old_dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dates['name'] = $_POST['name' . $id];
            $dates['quantity'] = $_POST['quantity' . $id];

            if (array_diff_assoc($dates, $old_dates[0])) {
                $stmt = $db->prepare("UPDATE products SET name = ?, quantity = ? WHERE id = ?");
                $stmt->execute([$dates['name'], $dates['quantity'], $id]);
            }
        }
    }

    if (!empty($messages)) {
        setcookie('messages', serialize($messages), time() + 24 * 60 * 60);
    }
    if (!empty($errors)) {
        setcookie('errors', serialize($errors), time() + 24 * 60 * 60);
    }
    header('Location: Products.php');
}