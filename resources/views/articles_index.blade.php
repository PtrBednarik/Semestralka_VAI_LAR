@include('partials/header')

<script>
    var allArticles = [];
    var currentEditingArticleId = null;

    function setLoading(loading=true){
        const listWrapperEl = document.getElementById("articles_list_wrapper");
        listWrapperEl.setAttribute("data-loading", loading)
    }

    function appendArticleToList(listEl, article){

        let dateUpdated = new Date(article.updated_at).toLocaleDateString("sk")
        let creatorName = article.user && (article.user.first_name || article.user.last_name)
                        ? `${article.user.first_name} ${article.user.last_name}`
                        : "";

        let templateHtml = `
            <div class="blog-box" data-id="${article.id}">
                <div class="blog-text">
                    <a class="blog-title" href="/articles/show/${article.id}">${escapeString(article.title)}</a>
                    @can('article_edit')
                    <td><i class="fa fa-edit" data-bs-action="edit" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></td>
                    ${`<td><i class="fa fa-trash blog-delete" data-id="${article.id}"></i></td>`}
                    @endcan
                    <p>${escapeString(article.content)}...</p>
                    <div class="blog-footer">
                        <a href="/articles/show/${article.id}">Viac</a>
                        <span class="blog-creator-name">${escapeString(creatorName)} ${dateUpdated}</span>
                    </div>

                </div>
            </div>
            `
        listEl.insertAdjacentHTML('afterbegin', templateHtml);
    }

    async function fetchArticles(){
        const listEl = document.getElementById("articles_list");
        const listWrapperEl = document.getElementById("articles_list_wrapper");

        setLoading(true)
        try{
            const response = await fetch("api/articles/");
            allArticles = await response.json();
            console.log(allArticles);

            setLoading(false)
            listEl.innerHTML = "";  //zmaz vsetko, co bolo v liste, aby sa pri novom nacitani
                                    //len nepridavali

            allArticles.forEach(article=>{
                appendArticleToList(listEl, article)
            })
        }
        catch(err){
            setLoading(false)
            console.error(err);
        }
    }

    async function addArticle(data) {
        const response = await fetch('api/articles/', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // body data type must match "Content-Type" header
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    async function editArticle(id, data){
        const response = await fetch(`api/articles/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return response.json(); // parses JSON response into native JavaScript objects

    }

    async function removeArticle(id){
        const response = await fetch(`api/articles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }

    function buttonClickHandlers(){

        const modalEl = document.getElementById('exampleModal')
        const myModal = new bootstrap.Modal(modalEl,{keyboard: false})

        //potvrdenie modalu = vytvorenie alebo editacia clanku
        document.getElementById("send_article").addEventListener("click", async function(){
            const listWrapperEl = document.getElementById("articles_list_wrapper");
            const listEl = document.getElementById("articles_list");
            const titleEl = document.getElementById("article_title");
            const contentEl = document.getElementById("article_text");

            const confirmButton = document.getElementById("send_article");
            const action = confirmButton.getAttribute("data-action");
            setLoading(true);

            try{
                let response;

                //na zaklade akcie sa rozhodnut ci vytvarame alebo editujeme
                if (action == "create"){
                    response = await addArticle({
                        "title": titleEl.value,
                        "content": contentEl.value,
                        });
                }
                else{
                    response = await editArticle(currentEditingArticleId, {
                        "title": titleEl.value,
                        "content": contentEl.value,
                    });
                }

                //ak uspech, vynuluj hodnoty a zatvor modal
                if (response.success){
                    titleEl.value = "";
                    contentEl.value = "";
                    myModal.hide();
                    if (action == "create"){
                        const newArticle = response.article;
                        allArticles.push(newArticle);
                        console.log(allArticles);
                        appendArticleToList(listEl,newArticle);
                    }else{
                        fetchArticles(); //zjednodusene prekreslenie clankov
                    }
                }
                else{
                    const errors = response.error;
                    if (errors){
                        Object.keys(errors).forEach(errKey=>{
                            const errorEl = modalEl.querySelector(`.inputError[data-for='${errKey}']`);
                            if (errorEl){
                                errorEl.textContent = errors[errKey][0];
                            }
                        })
                    }
                }
                setLoading(false);
                console.log(response)
            }
            catch(err){
                console.log(err)
                setLoading(false)
            }

        });

        //mazanie clanku
        document.getElementById("articles_list").addEventListener("click", async function(ev){
            console.log(ev.target);
            if (ev.target.classList.contains("blog-delete")){
                const id = ev.target.getAttribute("data-id");
                try{
                    setLoading(true)
                    const response = await removeArticle(id)
                    if(response == 1){
                        const el = document.querySelector(`.blog-box[data-id="${id}"]`)
                        el.remove();
                        allArticles = allArticles.filter(article=>article.id != id);
                        console.log(allArticles)
                    }
                    setLoading(false)
                    console.log(response)
                }
                catch(err){
                    console.log(err)
                    setLoading(false)
                }
            }
        })
    }
    //kym sa nevygeneruju html elementy
    document.addEventListener("DOMContentLoaded", async () => {
        buttonClickHandlers()
        await fetchArticles();
    });

</script>

<div class="title-container">
    <h3>Aktuality</h3>
</div>

<div class="container mt-5">
    @can('article_create')
    <div class="text-center">
        <button type="button" class="btn create-button btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-action="create">+ Nový príspevok</button>
    </div>
    @endcan

    <section id="blog">
        <div id="articles_action">
            <div id="articles_list_wrapper" class="blog-container" data-loading="false">
                <div class="lds-dual-ring"></div>
                <div id="articles_list" class="blog-container"></div>
            </div>
        </div>
    </section>
</div>
{{---------------------------------------------------------------------------------------------------------------------------------------------------}}

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="h3 text-center">Pridať príspevok</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="title" class="col-form-label">Titulok:</label>
                        <input type="text" name="title" class="form-control" id="article_title">
                        <div class="inputError" data-for="title"></div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="col-form-label">Obsah:</label>
                        <textarea name="content" class="form-control" rows="4" id="article_text"></textarea>
                        <div class="inputError" data-for="content"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Späť</button>
                <button type="button" class="btn create-button btn-primary" id="send_article">Pridať</button>
            </div>
        </div>
    </div>
</div>

<script>
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {

        const confirmButton = document.getElementById("send_article");
        // debugger;
        const button = event.relatedTarget;
        const action = button.getAttribute('data-bs-action');
        if (action == "edit"){
            confirmButton.textContent = "Upraviť";
            confirmButton.setAttribute("data-action", "edit")
            const articleId = button.closest(".blog-box").getAttribute("data-id");
            const article = allArticles.find(article=>article.id == articleId);
            currentEditingArticleId = articleId;

            //nastavenie hodnot z article do inputov
            document.getElementById("article_title").value = article.title;
            document.getElementById("article_text").value = article.content;
        }
        else{
            confirmButton.textContent = "Pridať";
            confirmButton.setAttribute("data-action", "create")
            //reset hodnot pre novy prispevok
            document.getElementById("article_title").value = "";
            document.getElementById("article_text").value = "";
        }

        //reset validacnych chyb
        exampleModal.querySelectorAll(`.inputError`).forEach(el=>{
            el.textContent= "";
        })

    })
</script>

@include('partials/footer')


