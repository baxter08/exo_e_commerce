
function ajaxRequest() {

    const keyword = document.getElementById('search_q');
    
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange =
        function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("container").innerHTML = xmlhttp.responseText;
        }else{

                document.getArticleBymore("container").innerHTML = smlhttp.responseText;

        }
            

        }
   
    xmlhttp.open("GET", "result?keywords="+keyword.value,true);
    xmlhttp.send();

}