<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,600;1,600&family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geotag-photo@0.5.1/dist/Leaflet.GeotagPhoto.css" />
    <link href="{{ asset('dist/css/styles.css') }}" rel="stylesheet">
    <link rel="icon" href="/dist/images/siteImg/RoadLensOnWebWhite.png">
    <title>RoadLens</title>
</head>

<body>
    <header>
        
        <div class="header-contaner">
            <div class="side_menu">
                <div class="burger_box">
                    <div class="menu-icon-container">
                        <a href="#" class="menu-icon js-menu_toggle closed">
                            <span class="menu-icon_box">
                                <span class="menu-icon_line menu-icon_line--1"></span>
                                <span class="menu-icon_line menu-icon_line--2"></span>
                                <span class="menu-icon_line menu-icon_line--3"></span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="px-5">
                    <div class="header_login-img">
                        <img src="https://i.imgur.com/hczKIze.jpg" alt="">
                    </div>
                    <ul class="list_load">
                        <li class="list_item"><a href="#">Главная</a></li>
                        <li class="list_item"><a href="#">Фильтр</a></li>
                        <li class="list_item"><a href="#">Типы камер</a></li>
                        <li class="list_item"><a href="#">О проекте</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" class="header-logo">
                <img src="/dist/images/siteImg/RoadLensOnWebWhite.png" alt="logo">
                <h1>RoadLens</h1>
            </a>
        </div>
    </header>
    <main>
        <div class="container-map-edit">
            <section>
                <form class="edit-form" method="POST" action="#">
                <div class="name-block">
                    <div class="name-block_container">
                        <h3 class="name-block_h3">Редактор</h3>
                    </div>
                </div>
                <div class="flex-form">
                    <div class="edit-text-block mb-3">
                        <p>id: </p>
                    </div>
                    <div class="edit-text-block mb-3">
                        <p>uuid:</p>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Страна:</label><br>
                        <select name="type" id="type">
                            <option value="">--Выберите--</option>
                            <option value="1">Silent radar</option>
                            <option value="2">Radar</option>
                            <option value="3">Video Block</option>
                            <option value="4">Stop monitoring</option>
                            <option value="5">Dummy</option>
                            <option value="6">Traffic light</option>
                            <option value="7">Mobile Camera</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Регион:</label><br>
                        <select name="type" id="type">
                            <option value="">--Выберите--</option>
                            <option value="1">Silent radar</option>
                            <option value="2">Radar</option>
                            <option value="3">Video Block</option>
                            <option value="4">Stop monitoring</option>
                            <option value="5">Dummy</option>
                            <option value="6">Traffic light</option>
                            <option value="7">Mobile Camera</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Тип:</label><br>
                        <select name="type" id="type">
                            <option value="">--Выберите--</option>
                            <option value="1">Silent radar</option>
                            <option value="2">Radar</option>
                            <option value="3">Video Block</option>
                            <option value="4">Stop monitoring</option>
                            <option value="5">Dummy</option>
                            <option value="6">Traffic light</option>
                            <option value="7">Mobile Camera</option>
                        </select>
                    </div>
                    <div class="select">
                        <label class="select-label" for="type">Модель:</label><br>
                        <select name="type" id="type">
                            <option value="">--Выберите--</option>
                            <option value="1">Silent radar</option>
                            <option value="2">Radar</option>
                            <option value="3">Video Block</option>
                            <option value="4">Stop monitoring</option>
                            <option value="5">Dummy</option>
                            <option value="6">Traffic light</option>
                            <option value="7">Mobile Camera</option>
                        </select>
                    </div>
                    
                    <div class="input-box">
                        <input id="latitude" class="input-fixed" type="text" name="latitude" required="">
                        <label>Широта</label>
                    </div>
                    <div class="input-box">
                        <input id="longitude"class="input-fixed" type="text" name="longitude" required="">
                        <label>Долгота</label>
                    </div>
                    <div class="input-box">
                        <input id="direction" class="input-fixed" type="text" name="direction" required="">
                        <label>Направление</label>
                    </div>
                    <div class="input-box">
                        <input id="distance"class="input-fixed" type="text" name="distance" required="">
                        <label>Длина луча</label>
                    </div>
                    <div class="input-box">
                        <input id="angle" class="input-fixed" type="text" name="angle" required="">
                        <label>Ширина луча</label>
                    </div>
                    <div class="input-box">
                        <input id="speed" class="input-fixed" type="text" name="speed" required="">
                        <label>Скорость</label>
                    </div>
                    <div class="input-box">
                        <input id="source" class="input-fixed" type="text" name="source" required="">
                        <label>Источник</label>
                    </div>
                    <div class="input-box">
                        <input id="moderator" class="input-fixed" type="text" name="moderator" required="">
                        <label>Модератор</label>
                    </div>
                    <div class="edit-text-block">
                        <p>Дата создания: 18.02.2024</p>
                    </div>
                    <div class="chekbox-block">
                            <div class="container">
                                <ul class="ks-cboxtags">
                                    <li><input type="checkbox" id="checkboxOne" value="Rear"><label for="checkboxOne">В спину</label></li>
                                    <li><input type="checkbox" id="checkboxTwo" value="Markup"><label for="checkboxTwo">Разметка</label></li>
                                    <li><input type="checkbox" id="checkboxThree" value="Crosswalk"><label for="checkboxThree">Пешеходный</label></li>
                                    <li><input type="checkbox" id="checkboxFour" value="Roadside"><label for="checkboxFour">Обочина</label></li>
                                    <li><input type="checkbox" id="checkboxFive" value="Bus lane"><label for="checkboxFive">Автобусная</label></li>
                                    <li><input type="checkbox" id="checkboxSix" value="Stop monitoring"><label for="checkboxSix">Контроль остановки</label></li>
                                    <li><input type="checkbox" id="checkboxSeven" value="Cargo control"><label for="checkboxSeven">Грузовой контроль</label></li>
                                    <li><input type="checkbox" id="checkboxEight" value="Additional"><label for="checkboxEight">Дополнительный</label></li>
                                    <li><input type="checkbox" id="checkboxNine" value="Verified" checked><label for="checkboxNine" >Подтвержден</label></li>
                                </ul>
                            </div>
                        </div>
                        <div class="edit-submit">
                            <a href="#">
                                Отправить
                            </a>
                        </div>
                    <!-- <h5 class="form-block-name">Flags</h5>
                    <div class="flex-block flags">

                        
                    </div> -->
                </div>
            </form>
            </section>
            <div id="map" class="map" style=""></div>
        </div>
    </main>
    
    
    

    <footer></footer>

    <script type="module" src="{{ asset('dist/js/edit.js') }}"></script>
</body>
</html>