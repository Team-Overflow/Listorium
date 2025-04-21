async function displayImages(){
    if(focusTemplate !== null){
        document.getElementById("focusTemplateName").textContent = document.querySelector(`div[templateId="${focusTemplate}"]`).querySelector('.templateName').querySelector('input').value;
    }
    else{
        document.getElementById("focusTemplateName").textContent = "Select Template"
    }
}