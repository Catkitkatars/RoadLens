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
    <link rel="icon" href="images/siteImg/RoadLensOnWebWhite.png">
    <title>RoadLens</title>
</head>

<body>
    <header>
        
        <div class="header-contaner">
            <a href="#" class="header-logo">
                <img src="images/siteImg/RoadLensOnWebWhite.png" alt="logo">
                <h1>RoadLens</h1>
            </a>
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
                <div class="px-3">
                    <div class="header_login-img">
                        <img src="https://i.imgur.com/hczKIze.jpg" alt="">
                    </div>
                    <ul class="list_load">
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">home</span>Главная</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">filter_alt</span>Фильтр</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">videocam</span>Типы камер</a></li>
                        <li class="list_item"><a href="#"><span class="menu-icon white-icon material-symbols-outlined">developer_guide</span>О проекте</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container-map-edit">
            <section class="section_camera_info">
                
            </section>
            <div id="map" class="map" style=""></div>
        </div>
    </main>
    
    
    

    <footer></footer>

    <script type="module" src="{{ asset('dist/js/home.js') }}"></script>
</body>
</html>