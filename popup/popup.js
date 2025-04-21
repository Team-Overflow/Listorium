function lockInteraction(){
    document.getElementById("loading").style.display = "block";
}

function unlockInteraction(){
    document.getElementById("loading").style.display = "none";
}

window.addEventListener('DOMContentLoaded', function(){
    const pageURL = 'popup/popup.html';
    fetch(pageURL)
    .then(response => response.text())
    .then(html => {
        /* crée un DOM temporaire pour lire le HTML */
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        /* récupère le body */
        const body = doc.body;

        /* injecte le contenu dans la page chargé (dans la div dont l'id est "popup" */
        document.getElementById("popup").innerHTML = body.innerHTML;
    })
    .catch(err => {
        console.error('Erreur de chargement de page :', err);
    });
});