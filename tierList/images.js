let draggedImage = null;
let dragging = null;

function manageImage(){
    const images = document.querySelectorAll(".image");

    for(let i=0; i<images.length; i++){
        const img = images[i];
        img.addEventListener("mousedown", downImage);
    }
    document.addEventListener("mousemove", moveImage);
    document.addEventListener("mouseup", upImage);
}

function downImage(e){
    if(e.button !== 0) return;
    draggedImage = e.target;
    e.preventDefault();
    document.body.appendChild(draggedImage);
    draggedImage.style.position = "absolute";
    draggedImage.style.zIndex = 100000;
    draggedImage.style.left = e.pageX - draggedImage.width / 2 + 'px';
    draggedImage.style.top = e.pageY - draggedImage.height / 2 + 'px';
}
    
function moveImage(e){
    if(!draggedImage) return;
    draggedImage.style.left = e.pageX - draggedImage.width / 2 + 'px';
    draggedImage.style.top = e.pageY - draggedImage.height / 2 + 'px';
    selectStock(e, 1);
}

function upImage(e){
    if(!draggedImage) return;

    const elementUnderMouse = document.elementsFromPoint(e.clientX, e.clientY)
    .filter(el => el.classList.contains("stock"));
    if(elementUnderMouse.length > 0){
        elementUnderMouse[0].appendChild(draggedImage);
    }
    else{
        const cadreImage = document.getElementById("cadreImage");
        cadreImage.appendChild(draggedImage);
    }
    selectStock(e, 0);
    draggedImage.style.position = "static";
    draggedImage.style.zIndex = "";
    draggedImage = null;
}

function selectStock(e, i){
    if(i === 0){
        if(dragging !== null){dragging.classList.remove("dragging");}
        dragging = null;
    }
    else{
        const elementUnderMouse = document.elementsFromPoint(e.clientX, e.clientY)
        .filter(el => el.classList.contains("stock"));
        if(elementUnderMouse.length > 0){
            if(dragging !== elementUnderMouse[0]){
                if(dragging !== null){dragging.classList.remove("dragging");}
                dragging = elementUnderMouse[0];
                dragging.classList.add("dragging");
            }
        }
    } 
}