@include('partials/header')

<section class="section-view">
    <div class="container mt-5">
        <a class="back-link" href="/articles">&larrhk; Späť</a>
        <h1>{{ $article->title }}</h1>
        <div>
            <p> {!! nl2br(e($article->content)) !!}</p>
        </div>
    </div>
</section>
@include('partials/footer')
