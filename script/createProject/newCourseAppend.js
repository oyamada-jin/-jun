let courseCount = 1;
const courseDiv = document.getElementsByClassName("project_course");
let coursehiddenCount = document.getElementById("project_course_piece");

function addCourse() {
    
    courseCount=courseCount+1;//追加するサムネイルの番号に適応させる

    let project_Course_div = document.createElement("div");
    project_Course_div.id = "project_course_"+courseCount;
    courseDiv[0].appendChild(project_Course_div);

    let newCourseName = document.createElement("input");
    newCourseName.type = "text";
    newCourseName.id = "project_course_name_"+courseCount;
    newCourseName.className = "project_course_name";
    newCourseName.name = "project_course_name[]";
    newCourseName.setAttribute('required', 'required');
    project_Course_div.appendChild(newCourseName);

    let newCourseFile = document.createElement("input");
    newCourseFile.type = "file";
    newCourseFile.className = "noneDisplay";
    newCourseFile.name = "project_course_file[]";
    newCourseFile.id = "project_course_file_" + courseCount;
    newCourseFile.setAttribute('onchange',"handleFileSelectCourse('project_course_file_"+courseCount+"','project_course_img_"+courseCount+"')");
    newCourseFile.setAttribute('required', 'required');
    project_Course_div.appendChild(newCourseFile);

    let newcourseThumbnail = document.createElement("img");
    newcourseThumbnail.src = "img/project_course/default.png";
    newcourseThumbnail.className = "CourseImg";
    newcourseThumbnail.id = "project_course_img_" + courseCount;
    newcourseThumbnail.alt = "Image";
    newcourseThumbnail.setAttribute('onclick',"document.getElementById('project_course_file_"+courseCount+"').click()");
    project_Course_div.appendChild(newcourseThumbnail);

    let newCourseIntro = document.createElement("input");
    newCourseIntro.type = "text";
    newCourseIntro.id = "project_course_intro_"+courseCount;
    newCourseIntro.className = "project_course_intro";
    newCourseIntro.name = "project_course_intro[]";
    newCourseIntro.setAttribute('required', 'required');
    project_Course_div.appendChild(newCourseIntro);

    let newCourseValue = document.createElement("input");
    newCourseValue.type = "number";
    newCourseValue.name = "project_course_value[]";
    newCourseValue.id = "project_course_value_"+courseCount;
    newCourseValue.className = "project_course_value";
    newCourseValue.setAttribute('required', 'required');
    project_Course_div.appendChild(newCourseValue);

    let newDeletePTag = document.createElement("p");
    newDeletePTag.id = "DeleteCourseP_"+courseCount;
    newDeletePTag.setAttribute('onclick',"deleteCourse('"+courseCount+"')");
    newDeletePTag.textContent = "このコースを削除する";
    project_Course_div.appendChild(newDeletePTag);

    coursehiddenCount.value=String(Number(coursehiddenCount.value)+1);
}



function deleteCourse(deleteId) {
    if (courseCount >= 2) {
        let deleteElement = document.getElementById("project_course_"+ deleteId);
        if (deleteElement) {
            deleteElement.remove();

            for (let i = deleteId;  i <= courseCount; ++i) {
                // 囲む用のタグの変更
                let targetTag = document.getElementById("project_course_" + i);
                if (targetTag) {
                    targetTag.id = "project_course_" + (i - 1);
                    
                }


                //コース名入力欄の変更
                let courseName = document.getElementById("project_course_name_"+i);
                if (courseName) {
                    courseName.id="project_course_name_"+(i-1);
                }

                // 画像アップロードのfileタイプinputタグ変更
                let courseFile = document.getElementById("project_course_file_" + i);
                if (courseFile) {
                    courseFile.id = "project_course_file_" + (i - 1);
                    courseFile.setAttribute('onchange', "handleFileSelectCourse('project_course_file_" + (i - 1) + "','project_course_img_" + (i - 1) + "')");
                }

                // imgタグの変更
                let courseThumbnaiil = document.getElementById("project_course_img_" + i);
                if (courseThumbnaiil) {
                    courseThumbnaiil.id = "project_course_img_" + (i - 1);
                    courseThumbnaiil.setAttribute('onclick', "document.getElementById('project_course_file_" + (i - 1) + "').click()");
                }

                //コース内容入力欄の変更
                let courseIntro = document.getElementById("project_course_intro_"+i);
                if (courseIntro) {
                    courseIntro.id="project_course_intro_"+(i - 1);
                }

                let courseValue = document.getElementById("project_course_value_"+i);
                if(courseValue){
                    courseValue.id = "project_course_value_" + (i-1);
                }
                
                //Pタグの変更
                let DeleteP = document.getElementById("DeleteCourseP_" + i);
                if (DeleteP) {
                    DeleteP.id = "DeleteP_" + (i - 1);
                    DeleteP.setAttribute('onclick', "deleteCourse(" + (i - 1) + ")");
                }
            }
            coursehiddenCount.value=String(Number(coursehiddenCount.value)-1);

            courseCount--;
        }
    }
}





function handleFileSelectCourse(inputId,imgId) {
    const input = document.getElementById(inputId);
    const files = input.files;

    for (const file of files) {
        previewFileCourse(file,inputId,imgId);
    }
}

function previewFileCourse(file,inputId,imgId) {
    let reader = new FileReader();
    reader.onload = function(e) {
        let img = document.getElementById(imgId);
        let imageUrl = e.target.result;
        img.src = imageUrl;
    };

    reader.readAsDataURL(file);
}
