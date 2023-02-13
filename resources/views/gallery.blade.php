@include('partials/header')

<div class="title-container">
    <h3>Galéria</h3>
</div>

<div class="gallery-menu">
    <div>
        <ul>
            <li>
                <a href="/gallery/2022">2022</a>
            </li>
            <li>
                <a href="/gallery/2021">2021</a>
            </li>
            <li>
                <a href="/gallery/2020">2020</a>
            </li>
            <li>
                <a href="/gallery/2019">2019</a>
            </li>
            <li>
                <a href="/gallery/2018">2018</a>
            </li>
            <li>
                <a href="/gallery/2017">2017</a>
            </li>
            <li>
                <a href="/gallery/2016">2016</a>
            </li>
            <li>
                <a href="/gallery/2015">2015</a>
            </li>
            <li>
                <a href="/gallery/2014">2014</a>
            </li>
            <li>
                <a href="/gallery/2013">2013</a>
            </li>
            <li>
                <a href="/gallery/2012">2012</a>
            </li>
            <li>
                <a href="/gallery/2011">2011</a>
            </li>
            <li>
                <a href="/gallery/2010">2010</a>
            </li>
            <li>
                <a href="/gallery/2009">2009</a>
            </li>
            <li>
                <a href="/gallery/2008">2008</a>
            </li>
            <li>
                <a href="/gallery/2007">2007</a>
            </li>
            <li>
                <a href="/gallery/2006">2006</a>
            </li>
            <li>
                <a href="/gallery/2005">2005</a>
            </li>
            <li>
                <a href="/gallery/2004">2004</a>
            </li>
            <li>
                <a href="/gallery/2003">2003</a>
            </li>
            <li>
                <a href="/gallery/2002">2002</a>
            </li>
            <li>
                <a href="/gallery/2001">2001</a>
            </li>
            <!--            <li>-->
            <!--                <a href="2000">2000</a>-->
            <!--            </li>-->
            <li>
                <a href="/gallery/1999">1999</a>
            </li>
        </ul>
    </div>
</div>

<section class="gallery min-vh-100">
    <div class="container-lg">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
        @if (isset($images))
            @foreach($images as $image)
            <div class="col">
                <img src="{{ asset('Images/Zbor_fotky/'.$image->year.'/'.$image->filepath) }}" class="gallery-item" data-title="{{$image->title}}" data-id="{{$image->id}}" alt="">
            </div>
            @endforeach
        @endif
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby=
    "exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <span id="image-modal-title"></span>
                @can('photo_edit')
                <input type="text" id="image-modal-title-input" class="hidden">
                @endcan
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" class="modal-img" alt="modal img">
            </div>
        </div>
    </div>
</div>

<script>

    async function changeImageTitle(id, title){
        let url = "{{ route('gallery-patch', ':id') }}";
	    url = url.replace(':id', id);
        const response = await fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({title:title})
        });
        return response.json();
    }

    const modalEl = document.getElementById('gallery-modal');
    const titleEl =  modalEl.querySelector("#image-modal-title");
    const titleInputEl =  modalEl.querySelector("#image-modal-title-input");

    document.addEventListener("click", function (e){
        if(e.target.classList.contains("gallery-item")) {

            const src = e.target.getAttribute("src");
            const title = e.target.getAttribute("data-title");
            const id = e.target.getAttribute("data-id");

            modalEl.querySelector(".modal-img").src = src;
            titleEl.textContent = title;
            titleEl.setAttribute("data-id", id);
            if (titleInputEl) {
                titleInputEl.value = title;
            }

            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }
    })

    modalEl.addEventListener("click", function (e){
        if(e.target.getAttribute("id") == "image-modal-title") {
            if (titleInputEl) {
                titleEl.classList.add("hidden");
                titleInputEl.classList.remove("hidden");
                titleInputEl.focus();
            }
        }
    })
    modalEl.addEventListener("change", async function (e){
        if(e.target.getAttribute("id") == "image-modal-title-input") {
            //nastavit do nadpisu novy text
            titleEl.textContent=titleInputEl.value;
            //nastavit novy text aj do html obrazku data-title
            const imageId = titleEl.getAttribute("data-id");
            const imageElInList = document.querySelector(`.gallery-item[data-id="${imageId}"]`)
            imageElInList.setAttribute("data-title", titleInputEl.value);

            const response = await changeImageTitle(imageId, titleInputEl.value);
            console.log(response)
        }
    })
    modalEl.addEventListener("focusout", function (e){
        if(e.target.getAttribute("id") == "image-modal-title-input") {
            titleEl.classList.remove("hidden");
            titleInputEl.classList.add("hidden");
        }
    })
</script>

@include('partials/footer')
