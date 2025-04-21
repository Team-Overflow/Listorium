async function displayTemplates(){
    try {
        const response = await fetch('myData/getItems.php?item=template');
        const templates = await response.json();

        if(templates.error){
            console.error(templates.error);
            return;
        }

        const favoriteTemplate = document.getElementById('favoriteTemplate');
        const noFavoriteTemplate = document.getElementById('noFavoriteTemplate');
        favoriteTemplate.innerHTML = '';
        noFavoriteTemplate.innerHTML = '';

        templates.forEach(template => {
            const div = document.createElement('div');
            div.classList.add('template');
            div.setAttribute('templateId', template.templateId);
            div.addEventListener('click', function(e){isFocus(e, template.templateId);});
            div.innerHTML = `
                <div class="data templateName">
                    <input type="text" value="${template.templateName}" maxlength="20" oninput="renameTemplate(event)" onblur="getOutFocus()">
                </div>
                <div class="data">${template.nbImages}</div>
                <div class="data">${template.templateCreate}</div>
                <div class="data">${template.templateUpdate}</div>
                <div class="data favorite">
                    <input type="checkbox" value="${template.favorite}" onchange="favoriteTemplate(event)">
                </div>
            `;
            if(template.favorite === 1){
                div.querySelector(".favorite").querySelector("input").checked = true;
                favoriteTemplate.appendChild(div);
            }
            else{
                noFavoriteTemplate.appendChild(div);
            }
        });
        if(focusTemplate !== null){
            document.querySelector(`div[templateId="${focusTemplate}"]`).style.backgroundColor = colorFocus;
            document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.templateName').querySelector('input').style.backgroundColor = colorFocus;
        }
        displayImages();
        console.log('L\'affichage des templates à été fait avec succès !');
    } 
    catch(error){
        console.error('Erreur :', error);
    }
}

function addTemplate(){
    fetch('myData/addItem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            item: 'template',
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log('Le template a été ajouter avec succès !');
            displayTemplates();
        } 
        else{
            console.error('Échec de l\'ajout du template.');
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}

function deleteTemplate(){

    if(focusTemplate !== null){
        if(document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.favorite').querySelector('input').checked === false){
            fetch('myData/deleteItem.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    item: 'template',
                    templateId: focusTemplate
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data === true){
                    console.log('La template non favorites a été supprimé avec succès !');
                    focusTemplate = null;
                    displayTemplates();
                } 
                else{
                    console.error('Échec de la suppression de la template.');
                }
            })
            .catch(error => {
                console.error('Erreur réseau ou serveur :', error);
            });
        }
    }
}

function deleteAllTemplates(){

    fetch('myData/deleteItem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            item: 'allTemplates'
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log('Les templates non favorites ont été supprimé avec succès !');
            displayTemplates();
        } 
        else{
            console.error('Échec de la suppression des templates.');
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}

function renameTemplate(e){
    e.target.setAttribute("value", e.target.value);

    /* récupérer l'ID du template */
    let templateId = e.target.closest('.template').getAttribute('templateId');

    fetch('/myData/renameItems.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            item: 'template',
            templateId: templateId,
            templateName: e.target.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log("Le nom du template a été mis à jour avec succès.");
        }
        else{
            console.error("Échec de la mise à jour du nom du template.");
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}

function favoriteTemplate(e){

    /* récupérer l'ID du template */
    let templateId = e.target.closest('.template').getAttribute('templateId');

    /* enregistrer la valeur du checkbox */
    let value = e.target.checked ? 1 : 0;

    fetch('/myData/favoriteTemplate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            templateId: templateId,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log("Le favori a été mis à jour avec succès.");
            displayTemplates();
        }
        else{
            console.error("Échec de la mise à jour du favori.");
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}

let focusTemplate = null;
const colorFocus = 'rgb(210, 198, 30)';
function isFocus(e, id){
    if(e.button === 0){
        if(focusTemplate !== null){
            document.querySelector(`div[templateId="${focusTemplate}"]`).style.backgroundColor = '';
            document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.templateName').querySelector('input').style.backgroundColor = '';
        }
        focusTemplate = id;
        document.querySelector(`div[templateId="${focusTemplate}"]`).style.backgroundColor = colorFocus;
        document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.templateName').querySelector('input').style.backgroundColor = colorFocus;
        displayImages();
    }
}

function getOutFocus(){
    focusTemplate = null;
    displayTemplates();
}

document.body.addEventListener('click', function(e){
    const eltUnderMouse = document.elementsFromPoint(e.clientX, e.clientY);
    const nbGoodElt = eltUnderMouse.filter(elt => 
        elt.classList.contains('template') || elt.id === 'deleteTemplate'
    );
    if(focusTemplate !== null && nbGoodElt.length === 0){
        document.querySelector(`div[templateId="${focusTemplate}"]`).style.backgroundColor = '';
        document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.templateName').querySelector('input').style.backgroundColor = '';
        focusTemplate = null;
    }
    displayImages();
});

document.getElementById("searchBar").addEventListener("input", function(){
    let filtre = this.value.toLowerCase();
    let elts = document.querySelectorAll(".template");
    elts.forEach(elt =>{
        let nameElt = elt.querySelector(".templateName").querySelector("input").value.toLowerCase();
        if(nameElt.includes(filtre)){
            elt.style.display = "";
        }
        else{
            elt.style.display = "none";
        }
    });
});