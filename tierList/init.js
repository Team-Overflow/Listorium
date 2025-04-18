let data ={};

chargerData();

function chargerData(){
  fetch("autres/dataBase.json")
  .then(response =>{
    if(!response.ok){
      throw new Error("Erreur lors du chargement du fichier JSON");
    }
    return response.json();
  })
  .then(jsonData =>{
    data = jsonData;
    menuDeroulant();
  })
  .catch(error =>{
    console.error("Erreur:", error);
  });
}

function dupliquerBlock(){
  const container = document.getElementById("cadreTierlist");
  const firstBlock = document.getElementsByClassName("block")[0];
  const newBlock = firstBlock.cloneNode(true);
  let stockElements = newBlock.getElementsByClassName("stock");
  for (let i=0; i<stockElements.length; i++){
    stockElements[i].innerHTML = "";
  }
  container.appendChild(newBlock);
}

function menuDeroulant(){
  for(const key in data){
    if(data.hasOwnProperty(key)){
      const option = document.createElement("option");
      option.value = key;
      option.textContent = key;
      repertoire.appendChild(option);
    }
  }
}

repertoire.addEventListener("change", chargerImages);

function chargerImages(){
  const choix = repertoire.value;
  const cadreImage = document.getElementById("cadreImage");

  const dropZone = document.querySelectorAll(".dropZone")
  dropZone.forEach(element => {element.innerHTML = "";});

  if(choix !== "aucun"){
    for(let i=0; i<data[choix].length; i++){
      let imgElement = document.createElement("img");
      imgElement.src = data[choix][i];
      imgElement.title = data[choix][i].split("/").pop().split(".")[0];
      imgElement.id = "image" + i;
      imgElement.className = "image";
      imgElement.draggable = true;
      cadreImage.appendChild(imgElement);
    }
    manageImage();
  }
}