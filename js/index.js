function createDirectory(link){
    let dname = prompt('Enter the name of the directory (only ASCII):');
    if(dname!=null)
        location.href = '?link='+encodeURIComponent(link)+
                        '&cDir='+encodeURIComponent(dname);
}

function createFile(link){
    let dname = prompt('Enter the name of the file (only ASCII):');
    if(dname!=null)
        location.href = '?link='+encodeURIComponent(link)+
                        '&cFile='+encodeURIComponent(dname);
}

function deleteFile(link, fileName){
    if(confirm('Do you really want to delete the '+fileName+' file?'))
        location.href = '?link='+encodeURIComponent(link)+
                        '&dFileName='+encodeURIComponent(fileName);
}

function deleteDirectory(link, dirName){
    if(confirm('Do you really want to delete the '+dirName+' directory?'))
        location.href = '?link='+encodeURIComponent(link)+
                        '&dDirName='+encodeURIComponent(dirName);
}

function dwldDirectory(link, dirName){
    location.href = '?link='+encodeURIComponent(link)+
                    '&dwldDirName='+encodeURIComponent(dirName);
}

function getFileText(link){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', link, false);
    xhr.send();
    if (xhr.status != 200) {
        alert(xhr.status+': '+xhr.statusText);
    } else {
        document.getElementById('taEditor').innerHTML = xhr.responseText;
    }
}

function closeEditor(){
    document.getElementById('taEditor').innerHTML = '';
    document.getElementById('inpEditor').value = '';
    document.getElementById('divEditor').style.display = 'none';
    document.getElementById('saveEditorBtn').onclick = function() {};
}

function editFile(link, fileName){
    closeEditor();
    getFileText('?dwld=/dir'+link+'/'+fileName);
    document.getElementById('inpEditor').value = fileName;
    document.getElementById('divEditor').style.display = 'block';
    document.getElementById('saveEditorBtn').onclick = function() { saveFile(link, fileName); };
}

function saveFile(link, fileName){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(
        'link='+encodeURIComponent(link)+
        '&sFile='+encodeURIComponent(fileName)+
        '&text='+encodeURIComponent(document.getElementById('taEditor').value)
    );
}

function uploadFile(link){
    document.getElementById('uploadFile').style.display = 'block';
}

function closeUploader(link){
    document.getElementById('uploadFile').style.display = 'none';
}