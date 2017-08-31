
export function AddToList() {
	var entry = document.getElementById('entry').value;
	var cat = document.getElementById('cat').value;
	var expl = document.getElementById('expl').value;
	var def = document.getElementById('def').value;

	var listRes = document.getElementById('content-entry');
	var mainglob = document.getElementById('registerResourceglob');
	var main = document.getElementById('registerResource');

	listRes.innerHTML += `<li class="list-group-item" id="autre"><span class="pointer" onclick="EntryAction('autre')">`+entry+`</span></li>`;
	main.remove();
	mainglob.remove();
}


export function Cancel(){
	var mainglob = document.getElementById('registerResourceglob');
	var main = document.getElementById('registerResource');
	main.remove();
	mainglob.remove();
}

export function Research() {
	var main = document.getElementById('row-search');
	if(main.childNodes[3]){
		main.childNodes[3].remove();
		main.innerHTML += `<span class="form-inline"><input type="text" name="" value="" placeholder="Rechercher une entrée" class="form-control" style=""></span>`;
	}
}


export function contentLoad() {
	// alert("c'est ok pour moi !!!");
	var parameters = location.search.substring(1).split("&");

    var temp   = parameters[0].split("=");
    var temp2  = parameters[1].split("=");
    var temp3  = parameters[2].split("=");
    var title  = '';
    var type   = '';
    var auteur = '';
    title = unescape(decodeURIComponent(temp[1])).replace(/'/, "").replace(/'/, "");
    type = unescape(decodeURIComponent(temp2[1])).replace(/'/, "").replace(/'/, "");
    auteur = unescape(decodeURIComponent(temp3[1])).replace(/'/, "").replace(/'/, "");

    var nav_act = document.getElementById('nav-action');
	var titre = document.getElementById('titre');
	var foot = document.getElementById('left');
    nav_act.innerHTML += '<li class="active">'+title+'</li>';
	titre.innerHTML = title; 
	foot.innerHTML += type + ' : '+title+' >  Auteur : '+auteur;
}	


export function EntryAction(entry) {
	var content = document.getElementById('entry-content');
	var li_entry = document.getElementById(entry);
	if(!li_entry.childNodes[2]) {
		li_entry.innerHTML += `
						<ul class="pagination" style="margin-left:15pt; font-size:7pt; float:right">
							<li onclick="ShareAction()"><a><span class="fa fa-share"></span></a></li>
							<li onclick="alert('Voulez vous vraiment supprimer cette entrée ?');this.parentElement.parentElement.remove()"><a><span class="fa fa-trash"></span></a></li>
						</ul>`;
	}

	content.innerHTML = `<div class="panel" onclick="EditEntry()"><div class="panel"><span style="font-size:15pt; margin-right:5pt">`+entry+`</span><span style="color: #396696; font-style:italic"> nom masculin</span></div>
	<div class="panel"><span>abdomen superior <span style="color: #396696; font-style:italic"> m.</span> → abdomen supérieur <span style="color: #396696; font-style:italic"> m. </span></div>
	<div class="panel"><span>cirugía estética de abdomen <span style="color: #396696; font-style:italic"> f. </span> → plastie du ventre <span style="color: #396696; font-style:italic"> f.</span></div>
	<div class="panel"><span>región del abdomen <span style="color: #396696; font-style:italic"> f. </span> → région abdominale <span style="color: #396696; font-style:italic"> f.</span> →  zone abdominale <span style="color: #396696; font-style:italic"> f.</span></div></div>`;
}


export function EditEntry() {
	var content = document.getElementById('entry-content');
	var content_value = document.getElementById('entry-content').innerText;
	content.innerHTML = `<textarea name="content-article" value="" id="article" rows="8" class="form-control" style="width:500pt">`+content_value+`</textarea> <button type="button" class="btn btn-primary" onclick="OkAction2()" style="float:left">OK</button>`;
	
}


export function TitleAction() {
	var content = document.getElementById('titre-up');
	var content_value_titre = document.getElementById('titre').innerText;
	content.innerHTML = `<br><div class="row form-inline">
	<textarea name="content-titre" value="" id="titre-edit" rows="1" class="form-control" style="width:230pt">`+content_value_titre+`</textarea><button type="button" class="btn btn-primary" onclick="OkAction()">OK</button></div>`;
}


export function OkAction() {
	var content = document.getElementById('titre-up');
	var content_value_titre = document.getElementById('titre-edit').value;
	content.innerHTML = `<h1 id="titre" onclick="TitleAction()">`+content_value_titre+`</h1>`;
}


export function OkAction2() {
	var content = document.getElementById('entry-content');
	var content_value = document.getElementById('article').value;
	content.innerHTML = `<div id="titre" onclick="EditEntry()">`+content_value+`</div>`;
}



