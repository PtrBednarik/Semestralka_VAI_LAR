@include('partials/header')

<div class="title-container">
    <h3>História</h3>
</div>
<div class="timeline">

    @if(isset($events))
        @php($count = 0)
        @foreach($events as $event)
            @if($count%2 == 0)
                <div class="history-container left">
                    <div class="content">
                        <h2> {{ $event->year }}</h2>
                        <p class="podnadpis">{{ $event->title }}</p>
                        <p>{{ $event->content }}</p>
                    </div>
                </div>
            @else
                <div class="history-container right">
                    <div class="content">
                        <h2> {{ $event->year }}</h2>
                        <p class="podnadpis">{{ $event->title }}</p>
                        <p>{{ $event->content }}</p>
                    </div>
                </div>
            @endif
            @php($count++)
        @endforeach
     @endif
{{--    <div class="history-container left">--}}
{{--        <div class="content">--}}
{{--            <h2>1999</h2>--}}
{{--            <p class="podnadpis">Založenie zboru Nebeský šramot.</p>--}}
{{--            <p>Tu sa začal písať náš príbeh.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container right">--}}
{{--        <div class="content">--}}
{{--            <h2>2002</h2>--}}
{{--            <p class="podnadpis">Prvé sústredenie zboru.</p>--}}
{{--            <p>Prvé cielené cvičenie nových piesní mimo--}}
{{--                bežného sveta a v kruhu spoločenstva zboru.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container left">--}}
{{--        <div class="content">--}}
{{--            <h2>2003</h2>--}}
{{--            <p class="podnadpis">Prvý festival "Pane zjednoť nás".</p>--}}
{{--            <p>Prvý festival žilinských gospelových zborov, ktorý--}}
{{--                sa konal v Sade SNP, za účasti viacerých zborov--}}
{{--                z rôznych farností v Žiline.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container right">--}}
{{--        <div class="content">--}}
{{--            <h2>2006</h2>--}}
{{--            <p class="podnadpis">Nahranie albumu "Nevieš kam?" a--}}
{{--                zahraničný koncert v Karlových Varoch.</p>--}}
{{--            <p>Azda najvýraznejší rok pre nás. Nahrali sme album, zložený z našich piesní,--}}
{{--                s názvom "Nevieš kam?" a dostali sme sa až do ďalekých Karlových Varov,--}}
{{--                kde sme odohrali viacero koncertov.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container left">--}}
{{--        <div class="content">--}}
{{--            <h2>2009</h2>--}}
{{--            <p class="podnadpis">Festival Pane zjednoť nás na domácej pôde.</p>--}}
{{--            <p>Tento ročník festivalu Pane zjednoť nás sme mali tú česť--}}
{{--                hostiť v našej farnosti na Solinkách.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container right">--}}
{{--        <div class="content">--}}
{{--            <h2>2012</h2>--}}
{{--            <p class="podnadpis">Koncert Spevom k srdcu, srdcom k Bohu.</p>--}}
{{--            <p>Regionálne predstavenie spevokolov Žilinského kraja,--}}
{{--                ktoré sa konalo pod záštitou podpredsedu vlády Jána Figeľa.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container left">--}}
{{--        <div class="content">--}}
{{--            <h2>2018</h2>--}}
{{--            <p class="podnadpis">Vysielanie sv. omše v TV Lux.</p>--}}
{{--            <p>Dostali sme sa až do telky.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="history-container right">--}}
{{--        <div class="content">--}}
{{--            <h2>2019</h2>--}}
{{--            <p class="podnadpis">1.Nebeská šramotica.</p>--}}
{{--            <p>Prvá chata so zameraním na utuženie vzťahov v lone divokej prírody.</p>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
<button onclick="topFunction()" id="toTopBtn">Hore</button>

@include('partials/footer')
