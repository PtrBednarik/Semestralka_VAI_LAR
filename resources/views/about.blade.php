@include('partials/header')

<div class="title-container">
    <h3>O nás</h3>
</div>
<section>
    <div class="about-div">
        <div class="about-container">
            <h3 class="about-text-h3">
                Nebeský šramot (1999)
            </h3>
            <p class="about-text">
                Zbor Nebeský šramot je mládežnícky gospelový zbor vo farnosti Dobrého pastiera
                v Žiline na Solinkách. Už niekoľko rokov sprevádza farskú liturgiu na sv.
                omšiach, adoráciách, procesiách a iných udalostiach.
                Založený bol v roku 1999, krátko po zriadení farnosti a postavení kostola.
                Počas vyše 20 rokov svojho pôsobenia absolvoval množstvo koncertov na domácej
                pôde farnosti, no i v zahraničí. V roku 2006 bol nahratý album Nevieš kam?, išlo
                o prvý album zložený z piesní vlastnej tvorby.
                Momentálne sa zbor skladá z druhej generácie spevákov a hudobníkov, ktorí
                prebrali štafetu od svojich predchodcov.
            </p>
        </div>
        <div class="about-container">
            <img class="img-fluid" src="{{ asset('Images/zbor_about.jpg') }}"
                 alt="Zbor spolocna fotka">
        </div>
    </div>
</section>

@include('partials/footer')
