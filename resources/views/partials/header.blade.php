<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nebeský šramot</title>
    <meta charset="UTF-8">
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
<!------------------------------------------BOOTSTRAP------------------------------------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!----------------------------------FONTS-------------------------------------------------->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Moon+Dance&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="{{ asset('script.js') }}"> </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2_5soo06q4-R3o7pHsU5tKTewtPcuEII&callback=initMap&v=weekly"
        defer
    ></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0,
     maximum-scale=1.0, user-scalable=no">

</head>

<body>

<header>
    <nav class="navigation">
        <ul class="menu">
            <div class="logo">
                <a href="/">
                    <img class="logo-img" src="{{ asset('Images/music.png') }}" alt="Home_page_noticka">
                </a>
            </div>
            <li><a href="/">Domov</a></li>
            <li><a href="/articles">Aktuality</a></li>
            <li><a href="/gallery">Galéria</a></li>
            <li><a href="/history">História</a></li>
            <li><a href="/about">O nás</a></li>
            <li><a href="/contact">Kontakt</a></li>

            @auth
            <li><a href="/info">Informácie</a></li>
{{------------------------ADMIN--------------------------}}
            @can('users_manage')
            <li><a href="/users">Použivatelia</a></li>
            @endcan

            <li class="current-user-wrapper"><a class="login_title" href="/logout">Odhlásiť</a> <span class="current-user">({{auth()->user()->username}})</span></li>
{{--            <li><a href="/users">Uzivatelia</a></li>--}}
            @endauth

            @guest
            <li><a class="login_title" href="/login">Prihlásenie</a></li>
            @endguest

            <img class="hamburger-icon" src="{{ asset('Images/hamburger.png') }}" alt="Hamburger_menu" onclick="showMobMenu()">
        </ul>
    </nav>

            <!--Progress bar Script-->
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>
</header>
<!----------------------------------MOBILNE MENU--------------------------->
<header>
    <nav class="navigation-Mob">
        <ul class="menu-Mob" id="menuMob">
            <img class="iksko-icon" src="{{ asset('Images/xButton.png') }}" alt="Hamburger_menu" onclick="hideMobMenu()">
            <li><a href="/">Domov</a></li>
            <li><a href="/articles">Aktuality</a></li>
            <li><a href="/gallery">Galéria</a></li>
            <li><a href="/history">História</a></li>
            <li><a href="/about">O nás</a></li>
            <li><a href="/contact">Kontakt</a></li>

            <!---------Co sa zobrazi po prihlaseni, SEM :------------->

            @auth
            <li><a href="/info">Informácie</a></li>
            {{------------------------ADMIN--------------------------}}
            @can('users_manage')
                <li><a href="/users">Použivatelia</a></li>
            @endcan

            <li><a class="login_title" href="/logout">Odhlásiť</a></li>
            @endauth

            @guest
            <li><a class="login_title" href="/login">Prihlásenie</a></li>
            @endguest
        </ul>
    </nav>
</header>
