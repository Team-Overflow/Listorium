window.addEventListener('DOMContentLoaded', function(){
    const pageURL = 'structure/structure.html';
    fetch(pageURL)
    .then(response => response.text())
    .then(html => {
        /* crée un DOM temporaire pour lire le HTML */
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        /* récupère le header et le footer */
        const header = doc.body.querySelector('header');
        const footer = doc.body.querySelector('footer');

        /* injecte le contenu dans la page chargé */
        document.querySelector('header').innerHTML = header.innerHTML;
        document.querySelector('footer').innerHTML = footer.innerHTML;
    })
    .catch(err => {
        console.error('Erreur de chargement de page :', err);
    });
});