<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Restaurant</title>
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
                        <a href="index.html">Главная</a>
                    </div>
                    <div class="link_products">
                        <a href="products.html">Продукты</a>
                    </div>
                    <div class="link_items">
                        <a href="items.html">Блюда</a>
                    </div>
                    <div class="link_menu">
                        <a href="menu.html">Меню</a>
                    </div>
                    <div class="link_journal">
                        <a href="journal.html">Журнал заказов</a>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="main">
            <!-- menu.html  -->
            <div class="main_context">
                <div class="context_header">
                    Меню доступных блюд
                </div>

                <div class="button_d">
                    <button class="btn_1" onclick="openFormMenu()" id="btn_openMenuForm">
                        Добавить блюдо в меню
                    </button>
                </div>
                <div class="context_form" id="menu_form">
                    <form action="">
                        <div class="menu_add_item">
                            <div>Название блюда, которое вы хотите добавить:</div>
                            <div class="add_item_input"><input type="text" name="menu_item" id=""></div>
                        </div>
                        
                        <div class="menu_item_comp">
                            <div class="picker_heading">Выберите продукты:</div>
                            <div class="picker_context">
                                <select name="comp_picker" id="comp_picker" multiple size="4">
                                    <option value="comp1">картошка</option>
                                    <option value="comp2">говядина</option>
                                    <option value="comp3">макароны</option>
                                    <option value="comp4">сыр</option>
                                    <option value="comp5">хлеб</option>
                                    <option value="comp6">икра</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="menu_item_active">
                            Блюдо доступно для заказа сегодня:
                            <input type="checkbox" name="item_active" id="item_active">
                            <label for="item_active">да</label>
                        </div>

                        <div class="form_ready">
                            Подтверить состав
                            <input type="checkbox" name="item_ready" id="item_ready">
                            <label for="item_ready">Да, все верно</label>
                        </div>

                        <div class="button_d">
                            <button class="btn_1">
                                Добавить в меню
                            </button>
                            <button class="btn_1"  onclick="closeFormMenu()">
                                Закрыть форму
                            </button>
                            <div class="todo">[TODO: актив на кнопки]</div>
                        </div>
                    </form>
                </div>

                <div class="product_list">
                    <div class="list">
                        <div class="list_header">
                            Меню первых блюд:
                        </div>
                        <table>
                            <thead>
                                <th>id меню</th>
                                <th>id блюда</th>
                                <th>название</th>
                                <th>состав</th>
                                <th><i class="fa fa-plus" aria-hidden="true"></i></th>
                            </thead>
                                <tr>
                                    <td>1</td>
                                    <td>4</td>
                                    <td>борщик</td>
                                    <td>говядина, свекла, картошка, лук, чеснок, зелень</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>5</td>
                                    <td>суп-лапша</td>
                                    <td>курица, макароны, картошка, зелень</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="list_header">
                            Меню вторых блюд:
                        </div>
                        <table>
                            <thead>
                                <th>id меню</th>
                                <th>id блюда</th>
                                <th>название</th>
                                <th>состав</th>
                                <th><i class="fa fa-plus" aria-hidden="true"></i></th>
                            </thead>
                                <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>котлекти с пюрешкой</td>
                                    <td>говядина, картошка</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>6</td>
                                    <td>плов</td>
                                    <td>рис, говядина, морковь, чеснок, специи</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="list_header">
                            Меню завтраков:
                        </div>
                        <table>
                            <thead>
                                <th>id меню</th>
                                <th>id блюда</th>
                                <th>название</th>
                                <th>состав</th>
                                <th><i class="fa fa-plus" aria-hidden="true"></i></th>
                            </thead>
                                <tr>
                                    <td>3</td>
                                    <td>1</td>
                                    <td>бутер с икрой</td>
                                    <td>хлеб, икра</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>3</td>
                                    <td>индийский чай</td>
                                    <td>чайный лист</td>
                                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            Данное web-приложение создано, как задача для летней практики, студентом 2 курса Моисеевым А.С.
        </div>
    </div>

    
    <script src="script.js"></script>
</body>
</html>