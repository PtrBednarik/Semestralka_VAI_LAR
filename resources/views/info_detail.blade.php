@include('partials/header')

<section class="section-view">
    <div class="container mt-5">
        <a class="back-link" href="/info">&larrhk; Späť</a>
        <h1>{{ $post->title }}</h1>
        <div>
            <p> {!! nl2br(e($post->content)) !!}</p>
        </div>
    </div>
</section>
@include('partials/footer')
