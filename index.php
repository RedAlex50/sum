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
    include('assets/index.php');
} else {
    if (!empty($_POST['create'])) {
        if (empty($_POST['dishes'])) {
            $errors['order_date'] = 'Выберите хотя бы одно блюдо';
            setcookie('errors', serialize($errors), time() + 24 * 60 * 60);
        }
        if (empty($errors)) {
            $order_date = date('Y-m-d');
            $stmt = $db->prepare("INSERT INTO journal (order_date) VALUES (?)");
            $stmt->execute([$order_date]);

            $journal_id = $db->lastInsertId();
            $dishes = $_POST['dishes'];
            $stmt = $db->prepare("INSERT INTO journal_dishes (journal_id, dish_id) VALUES (?, ?)");
            foreach ($dishes as $dish) {
              $stmt->execute([$journal_id, $dish]);
            }
            setcookie('dishes', serialize($dishes), time() + 24 * 60 * 60);
        }
    }
    if (!empty($_POST['new'])) {
        header('Location: index.php');
    }
    header('Location: index.php');
}