
document.getElementById("recherche").addEventListener("onchange",request(this.value));

    



function request(id_recherche) {

    var  httpRequest = new XMLHttpRequest();
    //    requête en mode GET, construction de l'URL en récupérant l'id_product et l'id_statut directement, rendre la requête asynchrone
// let id_recherche=document.getElementById('recherche').value;

    httpRequest.open('GET', 'http://localhost/annonces/recherche/'+id_recherche, true);

    // httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');//encapsule la requête dans une entête que l'on définit dans une URL
    
    httpRequest.onreadystatechange = function() {
        console.log('variable à transmettre :'+id_recherche);
        window.alert('variable à transmettre :'+id_recherche);
        //Si la requête a été reçu (statut 200 : réseau) et 4 : traité
        if (httpRequest.readyState == 4 && httpRequest.status == 200) {

           // Response
           var response = httpRequest.responseText; 
   console.log(response);  
 
    }};
    
     httpRequest.send();
     window.alert("requête traitée avec "+id_recherche);


}

