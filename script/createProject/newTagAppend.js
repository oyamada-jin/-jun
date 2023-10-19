let tagCount = 0;
const tagDiv = document.getElementsByClassName("project_tag");

function addTag(flag) {
    
    tagCount=tagCount+1;//追加するサムネイルの番号に適応させる

    let project_Tag_div = document.createElement("div");
    project_Tag_div.id = "project_tag_"+tagCount;
    tagDiv[0].appendChild(project_Tag_div);

    let newTagText = document.createElement("input");
    newTagText.type = "text";
    newTagText.id = "project_tag_Text"+tagCount;
    newTagText.name = "project_tag_Text[]";
    project_Tag_div.appendChild(newTagText);

    let newDeletePTag = document.createElement("p");
    newDeletePTag.id = "DeleteTagP_"+tagCount;
    newDeletePTag.setAttribute('onclick',"deleteTag('"+tagCount+"')");
    newDeletePTag.textContent = "このコースを削除する";
    project_Tag_div.appendChild(newDeletePTag);

}



function deleteTag(deleteId) {
    if (tagCount >= 2) {
        let deleteElement = document.getElementById("project_tag_"+ deleteId);
        if (deleteElement) {
            deleteElement.remove();

            for (let i = deleteId;  i <= tagCount; ++i) {
                // 囲む用のタグの変更
                let targetTag = document.getElementById("project_tag_" + i);
                if (targetTag) {
                    targetTag.id = "project_tag_" + (i - 1);
                    
                }


                //タグ名入力欄の変更
                let tagText = document.getElementById("project_tag_Text"+i);
                if (tagText) {
                    tagText.id="project_tag_Text_"+i;
                }

                //Pタグの変更
                let DeleteP = document.getElementById("DeleteTagP_" + i);
                if (DeleteP) {
                    DeleteP.id = "DeleteTagP_" + (i - 1);
                    DeleteP.setAttribute('onclick', "deleteTag(" + (i - 1) + ")");
                }
            }

            tagCount--;
        }
    }
}

