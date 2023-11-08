let introCount = 0;
const introDiv = document.getElementsByClassName("project_intro");
let introhiddenCount = document.getElementById("project_intro_piece");

function addIntro(flag) {
    
    introCount=introCount+1;//追加するサムネイルの番号に適応させる

    let project_Intro_div = document.createElement("div");
    project_Intro_div.id = "project_intro_"+introCount;
    introDiv[0].appendChild(project_Intro_div);

    let newIntroFlag = document.createElement("input");
    newIntroFlag.type = "hidden";
    newIntroFlag.id = "project_intro_flag_"+introCount;
    newIntroFlag.name = "project_intro_flag[]";
    newIntroFlag.value = flag;
    project_Intro_div.appendChild(newIntroFlag);

    if (flag==0) { //テキストボックスを追加する

        let newIntroText = document.createElement("input");
        newIntroText.type = "text";
        newIntroText.id = "project_intro_content_"+introCount;
        newIntroText.name = "project_intro_text[]";
        project_Intro_div.appendChild(newIntroText);
    
    }else if(flag==1){ //画像を追加する

        let newIntroFile = document.createElement("input");
        newIntroFile.type = "file";
        newIntroFile.className = "noneDisplay";
        newIntroFile.name = "project_intro_file[]";
        newIntroFile.id = "project_intro_content_" + introCount;
        newIntroFile.setAttribute('onchange',"handleFileSelectIntro('project_intro_content_"+introCount+"','project_intro_img_"+introCount+"')");
        project_Intro_div.appendChild(newIntroFile);

        let newIntroThumbnail = document.createElement("img");
        newIntroThumbnail.src = "img/project_intro/default.png";
        newIntroThumbnail.className = "IntroImg";
        newIntroThumbnail.id = "project_intro_img_" + introCount;
        newIntroThumbnail.alt = "Image";
        newIntroThumbnail.setAttribute('onclick',"document.getElementById('project_intro_content_"+introCount+"').click()");
        project_Intro_div.appendChild(newIntroThumbnail);
    }

    let newDeletePTag = document.createElement("p");
    newDeletePTag.id = "DeleteIntroP_"+introCount;
    newDeletePTag.setAttribute('onclick',"deleteIntro("+introCount+")");
    newDeletePTag.textContent = "このコースを削除する";
    project_Intro_div.appendChild(newDeletePTag);

    introhiddenCount.value = String(Number(introhiddenCount.value)+1);


}



function deleteIntro(deleteId) {
    if (introCount >= 2) {
        let deleteElement = document.getElementById("project_intro_"+ deleteId);
        if (deleteElement) {
            deleteElement.remove();

            for (let i = deleteId;  i <= introCount; ++i) {
                // 囲む用のタグの変更
                let targetTag = document.getElementById("project_intro_" + i);
                if (targetTag) {
                    targetTag.id = "project_intro_" + (i - 1);
                    
                }


                //判別タグの変更
                let introFlag = document.getElementById("project_intro_flag_"+(i+1));
                // console.log(introFlag);
                // console.log(introFlag.value);
                if(introFlag){
                    introFlag.id = "project_intro_flag_"+(i);
                }else{
                    continue;
                }
                    
                if (Number(introFlag.value)==0) { //テキストボックスなら
                    let intro_text = document.getElementById("project_intro_content_" + (i+1));
                    if(intro_text){
                        intro_text.id = "project_intro_content_" + i;
                    }
                }else if(Number(introFlag.value) ==1){ //画像なら
                    // 画像アップロードのfileタイプinputタグ変更
                    let introFile = document.getElementById("project_intro_content_" + (i+1));
                    if (introFile) {
                        introFile.id = "project_intro_content_" + i;
                        introFile.setAttribute('onchange', "handleFileSelectIntro('project_intro_content_" + i + "','project_intro_img_" + i + "')");
                    }

                    // imgタグの変更
                    let introThumbnaiil = document.getElementById("project_intro_img_" + (i+1));
                    if (introThumbnaiil) {
                        introThumbnaiil.id = "project_intro_img_" + i;
                        introThumbnaiil.setAttribute('onclick', "document.getElementById('project_intro_content_" + i + "').click()");
                    }    
                }

                
                
                //Pタグの変更
                let DeleteP = document.getElementById("DeleteIntroP_" + (i+1));
                if (DeleteP) {
                    DeleteP.id = "DeleteP_" + i;
                    DeleteP.setAttribute('onclick', "deleteIntro(" + i + ")");
                }
            }
            introhiddenCount.value = String(Number(introhiddenCount.value)-1);
            introCount--;
        }
    }
}





function handleFileSelectIntro(inputId,imgId) {
    const input = document.getElementById(inputId);
    const files = input.files;

    for (const file of files) {
        previewFileIntro(file,inputId,imgId);
    }
}

function previewFileIntro(file,inputId,imgId) {
    let reader = new FileReader();
    reader.onload = function(e) {
        let img = document.getElementById(imgId);
        let imageUrl = e.target.result;
        img.src = imageUrl;
    };

    reader.readAsDataURL(file);
}
