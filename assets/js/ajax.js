

function ajaxRequest() {

    const keyword = document.getElementById('search_q');

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange =
        function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("container_jp").innerHTML = xmlhttp.responseText;
            }
            let searchInput = document.getElementById('search_q').value;
            // console.log(searchInput)
            let newUrl = window.location.origin + window.location.pathname + "?keywords=" + searchInput;

            // Mettre à jour l'URL avec les paramètres de recherche
            history.pushState(null, null, newUrl);

        }



    xmlhttp.open("GET", "result?keywords=" + keyword.value, true);
    xmlhttp.send();


}

let input = document.getElementById("search_q");
input.onkeyup = (e) => ajaxRequest();
// console.log(search_q);