window.addEventListener('load', function(){
    /* exécution une fois que toute la page est chargée */
    displayUser();
    displayTemplates();
});

async function displayUser(){
    try{
        const response = await fetch('myData/getItems.php?item=user');
        const user = await response.json();

        if(user.error){
            console.error(user.error);
            return;
        }
        document.getElementById('userName').value = user[0].userName;
        document.getElementById('userSurname').value = user[0].userSurname;
    } 
    catch(error){
        console.error('Erreur réseau ou serveur:', error);
    }
}

function renameUser(){

    fetch('/myData/renameItems.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            item: 'user',
            userName: document.getElementById('userName').value,
            userSurname: document.getElementById('userSurname').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log("Le nom de l\'utilisateur a été mis à jour avec succès.");
        }
        else{
            console.error("Échec de la mise à jour du nom de l\'utilisateur.");
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}

function resetAccount(){
    lockInteraction();
    fetch('myData/deleteItem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            item: 'reset'
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data === true){
            console.log('Le compte à été rénitialisé avec succès !');
            displayUser();
            displayTemplates();
            unlockInteraction();
        } 
        else{
            console.error('Échec de la rénitialisation du compte.');
        }
    })
    .catch(error => {
        console.error('Erreur réseau ou serveur :', error);
    });
}