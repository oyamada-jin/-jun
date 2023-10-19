let thumbnailCount = 1;
const thumbnailDiv = document.getElementsByClassName("project_Thumbnail");

function addThumbnail() {
    
    thumbnailCount=thumbnailCount+1;//追加するサムネイルの番号に適応させる

    let project_Thumbnail_div = document.createElement("div");
    project_Thumbnail_div.id = "project_thumbnail_"+thumbnailCount;
    thumbnailDiv[0].appendChild(project_Thumbnail_div);

    let newInput = document.createElement("input");
    newInput.type = "file";
    newInput.className = "noneDisplay";
    newInput.name = "project_thumbnail[]";
    newInput.id = "project_thumbnail_input_" + thumbnailCount;
    newInput.setAttribute('onchange',"handleFileSelectThumbnail('project_thumbnail_input_"+thumbnailCount+"','project_thumbnail_img_"+thumbnailCount+"')");
    project_Thumbnail_div.appendChild(newInput);

    let newImage = document.createElement("img");
    newImage.src = "img/project_thumbnail/default.png";
    newImage.className = "ThumbnailImg";
    newImage.id = "project_thumbnail_img_" + thumbnailCount;
    newImage.alt = "Image";
    newImage.setAttribute('onclick',"document.getElementById('project_thumbnail_input_"+thumbnailCount+"').click()");
    project_Thumbnail_div.appendChild(newImage);

    let newDeletePTag = document.createElement("p");
    newDeletePTag.id = "DeleteP_"+thumbnailCount;
    newDeletePTag.setAttribute('onclick',"deleteThumbnail('"+thumbnailCount+"')");
    newDeletePTag.textContent = "このサムネイルを削除する";
    project_Thumbnail_div.appendChild(newDeletePTag);

}



// function deleteThumbnail(deleteId) {
//     if (thumbnailCount >= 2) {
//         let deleteElement = document.getElementById("project_thumbnail_" + deleteId);
//         if (deleteElement) {
//             deleteElement.remove();

//             for (let i = deleteId; i <= thumbnailCount; ++i) {
//                 // 囲む用のタグの変更
//                 let targetTag = document.getElementById("project_thumbnail_" + (i + 1));
//                 if (targetTag) {
//                     targetTag.id = "project_thumbnail_" + i;
                    
//                 }

//                 // inputタグの変更
//                 let Input = document.getElementById("project_thumbnail_input_" + (i + 1));
//                 if (Input) {
//                     Input.id = "project_thumbnail_input_" + i;
//                     Input.setAttribute('onchange', "handleFileSelectThumbnail('project_thumbnail_input_" + i + "','project_thumbnail_img_" + i + "')");
//                 }

//                 // imgタグの変更
//                 let Image = document.getElementById("project_thumbnail_img_" + (i + 1));
//                 if (Image) {
//                     Image.id = "project_thumbnail_img_"+i;
//                     Image.setAttribute('onclick', "document.getElementById('project_thumbnail_input_"+i+"').click()");
//                 }
                
//                 //Pタグの変更
//                 let DeleteP = document.getElementById("DeleteP_"+ i + 1);
//                 if(DeleteP){
//                     DeleteP.id = "DeleteP_"+i;
//                     DeletePTag.setAttribute('onclick',''+i+"')");
//                 }
                
//             }

//             thumbnailCount--;
//         }
//     }
// }

function deleteThumbnail(deleteId) {
    if (thumbnailCount >= 2) {
        let deleteElement = document.getElementById("project_thumbnail_" + deleteId);
        if (deleteElement) {
            deleteElement.remove();

            for (let i = deleteId;  i <= thumbnailCount; ++i) {
                // 囲む用のタグの変更
                let targetTag = document.getElementById("project_thumbnail_" + i);
                if (targetTag) {
                    targetTag.id = "project_thumbnail_" + (i - 1);
                    
                }

                // inputタグの変更
                let Input = document.getElementById("project_thumbnail_input_" + i);
                if (Input) {
                    Input.id = "project_thumbnail_input_" + (i - 1);
                    Input.setAttribute('onchange', "handleFileSelectThumbnail('project_thumbnail_input_" + (i - 1) + "','project_thumbnail_img_" + (i - 1) + "')");
                }

                // imgタグの変更
                let Image = document.getElementById("project_thumbnail_img_" + i);
                if (Image) {
                    Image.id = "project_thumbnail_img_" + (i - 1);
                    Image.setAttribute('onclick', "document.getElementById('project_thumbnail_input_" + (i - 1) + "').click()");
                }
                
                //Pタグの変更
                let DeleteP = document.getElementById("DeleteP_" + i);
                if (DeleteP) {
                    DeleteP.id = "DeleteP_" + (i - 1);
                    DeleteP.setAttribute('onclick', "deleteThumbnail(" + (i - 1) + ")");
                }
            }

            thumbnailCount--;
        }
    }
}





function handleFileSelectThumbnail(inputId,imgId) {
    const input = document.getElementById(inputId);
    const files = input.files;

    for (const file of files) {
        previewFileHowTo(file,inputId,imgId);
    }
}

function previewFileHowTo(file,inputId,imgId) {
    let reader = new FileReader();
    reader.onload = function(e) {
        let img = document.getElementById(imgId);
        let imageUrl = e.target.result;
        img.src = imageUrl;
    };

    reader.readAsDataURL(file);
}
