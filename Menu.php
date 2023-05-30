<?php

include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $stmt = $db->prepare("SELECT id, name FROM menu");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    
    include('assets/Menu.php');
} else {
    $errors = array();
    $messages = array();

    if (!empty($_POST['addnewdate'])) {
        if (empty($_POST['name'])) {
            $errors['name'] = 'Заполните поле "Название меню"';
        }
        if (empty($_POST['dishes'])) {
            $errors['dishes'] = 'Заполните поле "Список блюд"';
        }
        if (empty($errors)) {
            $name = $_POST['name'];
            $stmt = $db->prepare("INSERT INTO menu (name) VALUES (?)");
            $stmt->execute([$name]);

            $menu_id = $db->lastInsertId();
            $dishes = $_POST['dishes'];
            $stmt = $db->prepare("INSERT INTO menu_dishes (menu_id, dish_id) VALUES (?, ?)");
            foreach ($dishes as $dish) {
              $stmt->execute([$menu_id, $dish]);
            }
            $messages['added'] = 'Меню "'.$name.'" успешно добавлено';
        }
    }

    foreach ($_POST as $key => $value) {
        if (preg_match('/^clear(\d+)_x$/', $key, $matches)) {
            $id = $matches[1];
            $stmt = $db->prepare("DELETE FROM menu_dishes WHERE menu_id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM menu WHERE id = ?");
            $stmt->execute([$id]);
            $messages['deleted'] = 'Меню с <b>id = '.$id.'</b> успешно удалено';
        }

        if (preg_match('/^edit(\d+)_x$/', $key, $matches)) {
            $id = $matches[1];
            setcookie('edit', $id, time() + 24 * 60 * 60);
        }

        if (preg_match('/^save(\d+)_x$/', $key, $matches)) {
            setcookie('edit', '', time() + 24 * 60 * 60);
            $id = $matches[1];
            $stmt = $db->prepare("SELECT name FROM menu WHERE id = ?");
            $stmt->execute([$id]);
            $old_dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $dates['name'] = $_POST['name' . $id];

            if (array_diff_assoc($dates, $old_dates[0])) {
                $stmt = $db->prepare("UPDATE menu SET name = ? WHERE id = ?");
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
    header('Location: Menu.php');
}