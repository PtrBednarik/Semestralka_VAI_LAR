@include('partials/header')

<script>
    var allPosts = [];
    var currentEditingPostId = null;

    function setLoading(loading=true) {
        const listWrapperEl = document.getElementById("posts_list_wrapper");
        listWrapperEl.setAttribute("data-loading", loading);
    }

    function appendPostToList(listEl, post) {

        let templateHtml = `
            <div class="blog-box" data-id="${post.id}">
                <div class="blog-text">
                    <a class="blog-title" href="/info/show/${post.id}">${post.title}</a>
                    @can('admin_post_edit')
                    <td><i class="fa fa-edit" data-bs-action="edit" data-bs-toggle="modal" data-bs-target="#exampleModalPosts"></i></td>
                    ${`<td><i class="fa fa-trash blog-delete" data-id="${post.id}"></i></td>`}
                    @endcan
                    <p>${post.content}...</p>
                    <a href="/info/show/${post.id}">Viac</a>
                </div>
            </div>
            `
        listEl.insertAdjacentHTML('afterbegin', templateHtml);
    }

    async function fetchPosts() {
        const listEl = document.getElementById("posts_list");
        const listWrapperEl = document.getElementById("posts_list_wrapper");

        setLoading(true)
        try {
            const response = await fetch("api/info/");
            allPosts = await response.json();
            console.log(allPosts);

            setLoading(false)
            listEl.innerHTML = "";

            allPosts.forEach(post=>{
                appendPostToList(listEl, post)
            })
        }
        catch (err) {
            setLoading(false)
            console.error(err);
        }
    }

    async function addPost(data) {
        const response = await fetch('api/info/', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log("ADD-POST")
        return response.json();
    }

    async function editPost(id, data) {
        const response = await fetch(`api/info/${id}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        console.log("EDIT-POST")
        return response.json();
    }

    async function removePost(id) {
        const response = await fetch(`api/info/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });
        return response.json();
    }
    function modalConfirmButtonClickHandler() {
        const modalEl = document.getElementById("exampleModalPosts")
        const myModal = new bootstrap.Modal(modalEl, {keyboard: false})
        //potvrdenie modalu = vytvorenie alebo editacia clanku
        document.getElementById("send_post").addEventListener("click", async function() {
            const listWrapperEl = document.getElementById("posts_list_wrapper");
            const listEl = document.getElementById("posts_list");
            const titleEl = document.getElementById("post_title");
            const contentEl = document.getElementById("post_text");
            const confirmButton = document.getElementById("send_post");
            const action = confirmButton.getAttribute("data-action");
            setLoading(true);
            try {
                let response;
                //na zaklade akcie sa rozhodnut ci vytvarame alebo editujeme
                if(action == "create") {
                    response = await addPost({
                        "title":  titleEl.value,
                        "content": contentEl.value,
                    });
                }
                else {
                    response = await editPost(currentEditingPostId, {
                        "title":  titleEl.value,
                        "content": contentEl.value,
                    });
                }
                //ak uspech, vynuluj hodnoty a zatvor modal
                if (response.success) {
                    titleEl.value = "";
                    contentEl.value = "";
                    myModal.hide();
                    if (action == "create") {
                        const newPost = response.post;
                        allPosts.push(newPost);
                        console.log(allPosts);
                        appendPostToList(listEl,newPost);
                    }
                    else {
                        fetchPosts();   //Prekresli posty
                    }
                }
                else {
                    const errors = response.error;
                    if (errors) {
                        Object.keys(errors).forEach(errKey=>{
                            const errorEl = modalEl.querySelector(`.inputError[data-for='${errKey}']`);
                            if (errorEl) {
                                errorEl.textContent = errors[errKey][0];
                            }
                        })
                    }
                }
                setLoading(false);
                console.log(response)
            }
            catch (err) {
                console.log(err)
                setLoading(false)
            }
        });
        //mazanie
        document.getElementById("posts_list").addEventListener("click", async function(ev) {
            console.log(ev.target);
            if (ev.target.classList.contains("blog-delete")){
                const id = ev.target.getAttribute("data-id");
                try {
                    setLoading(true)
                    const response = await removePost(id)
                    if (response == 1) {
                        const el = document.querySelector(`.blog-box[data-id="${id}"]`)
                        el.remove();
                        allPosts = allPosts.filter(post=>post.id != id);
                        console.log(allPosts)
                    }
                    setLoading(false)
                    console.log(response)
                }
                catch (err){
                    console.log(err)
                    setLoading(false)
                }
            }
        })
    }
    document.addEventListener("DOMContentLoaded", async () => {
        modalConfirmButtonClickHandler()
        await fetchPosts();
    })
</script>

<div class="title-container">
    <h3>Informácie</h3>
</div>

<div class="container mt-5">
    @can('admin_post_create')
        <div class="text-center">
            <button type="button" class="btn create-button btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalPosts" data-bs-action="create">+ Nový príspevok</button>
        </div>
    @endcan

    <section id="blog">
        <div id="posts_action">
            <div id="posts_list_wrapper" class="blog-container" data-loading="false">
                <div class="lds-dual-ring"></div>
                <div id="posts_list" class="blog-container"></div>
            </div>
        </div>
    </section>
</div>

{{---------------------------------------------------------------------------------------------------------------------------------------------------}}

<div class="modal fade" id="exampleModalPosts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
{{--                                <a class="back-link" href="/articles">&larrhk; Späť</a>--}}
                <h1 class="h3 text-center">Pridať príspevok</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="title" class="col-form-label">Titulok:</label>
                        <input type="text" name="title" class="form-control" id="post_title">
                        <div class="inputError" data-for="title"></div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="col-form-label">Obsah:</label>
                        <textarea name="content" class="form-control" rows="4" id="post_text"></textarea>
                        <div class="inputError" data-for="content"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Späť</button>
                <button type="button" class="btn create-button btn-primary" id="send_post">Pridať</button>
            </div>
        </div>
    </div>
</div>

<script>
    var exampleModal = document.getElementById("exampleModalPosts")
    exampleModal.addEventListener("show.bs.modal", function (event) {

        const confirmButton = document.getElementById("send_post");

        const button = event.relatedTarget;
        const action = button.getAttribute("data-bs-action");
        if (action == "edit") {
            confirmButton.textContent = "Upraviť";
            confirmButton.setAttribute("data-action", "edit")
            const postId = button.closest(".blog-box").getAttribute("data-id");
            const post = allPosts.find(post=>post.id == postId);
            currentEditingPostId = postId;

            //nastavenie hodnot z postu do inputov
            document.getElementById("post_title").value = post.title;
            document.getElementById("post_text").value = post.content;
        }
        else {
            confirmButton.textContent = "Pridať";
            confirmButton.setAttribute("data-action", "create")
            //reset hodnot pre novy prispevok
            document.getElementById("post_title").value = "";
            document.getElementById("post_text").value = "";
        }

        //reset validacnych chyb
        exampleModal.querySelectorAll(`.inputError`).forEach(el=>{
            el.textContent= "";
        })
    })
</script>

@include('partials/footer')

