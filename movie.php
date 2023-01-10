<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === ''){
    header('Location: login.php');
}
require 'doctype.template.php';
require 'Header.template.php';

echo "<script> let film = " .$_GET['ids'] . " 
</script>";

if($_POST){
    header("refresh:0");
}
?>
<main class="pt-20">
<div class="h-1/2 p-12">

    <section class="film_area text-white flex flex-row-reverse pb-8">


        <div class="flex flex-col justify-around items-center  w-11/12">
            <?php
            //liste souhait
            $query = new Connection();
            $result = $query -> SfD($_GET['ids'] , $_SESSION['id']);
            if($result){
                echo'
                <form method="POST">
                <input type="hidden" value="' .$_GET['ids'].'" name="id">
                <input type="submit" value="supprimé de la liste de souhait" name="Ddream" class="bg-slate-700 p-2 pl-4 pr-4 rounded-full" >
            </form>';
            }
            else{
                echo'<form method="POST">
                <input type="hidden" value= "' .$_GET['ids'].'" name="id">
                <input type="submit" value="Mettre dans la liste de souhait" name="dream" class="bg-slate-700 p-2 pl-4 pr-4 rounded-full" >
            </form>';
            }
            //liste vue
            $query = new Connection();
            $result = $query -> SfS($_GET['ids'] , $_SESSION['id']);
            if($result){
                echo'<form method="POST">
                <input type="hidden" value="' .$_GET['ids'].' " name="id">
                <input type="submit" value="film pas vu" name="Dseen" class="bg-slate-700 p-2 pl-4 pr-4 rounded-full">
            </form>';

            }
            else{
                echo'<form method="POST">
                <input type="hidden" value="' .$_GET['ids'].'" name="id">
              <input type="submit" value="film vue" name="seen" class="bg-slate-700 p-2 pl-4 pr-4 rounded-full">
            </form>';

            }

            echo'<p class="addalbum bg-slate-700 p-2 pl-4 pr-4 rounded-full">Ajouter à un album </p>';
            ?>
            <section class="pop-up hidden">
                <div id="overlay"></div>
                <div class="bg-white text-black z-50 absolute top-96 left-96 w-52 h-48">
                    <h2>A quel album ajouter le film : </h2>
                <form method="POST" >
                <?php
               $connection = new connection();
                                  $Myalbums = $connection->getmyalbum();
                                  foreach($Myalbums as $Myalbum){
                                      echo '<br>';
                                      echo '<label for="'. $Myalbum['album_id'] .'"> Ajouter a '. $Myalbum['album_name'] .'</label>';
                                      echo '<input type="checkbox" id="'. $Myalbum['album_id'] .'" name="checkbox[]" value="'. $Myalbum['album_id'] .'">';
                                  }
                                   ?>


                    <br>
                    <input class=" bg-slate-700 p-2 pl-4 pr-4 rounded-full" type="submit" value="Ajouter">
                </form>
            </section>

        </div>
    </section>
    <section class="film_areas flex flex-wrap gap-[25px] text-white"> </section>


</div>
</main>
<script>
    let listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ film +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console.log("listMovPop")
    listMovPop.then(function (response) {
        return response.json();
    }).then(function (data) {
        console.log(data);
        let div = document.createElement('div')
        div.innerHTML = `<div class=" flex w-full flex-col items-center"><h2>${data.original_title}</h2><img class="w-[250px] h-[350px]" src="https://image.tmdb.org/t/p/original${data.poster_path}"><p>${data.overview}</p></div>
        `
        document.querySelector('.film_area').appendChild(div)


    });
    let listact = fetch('https://api.themoviedb.org/3/movie/'+ film +'/credits?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console.log("bonjour")
    listact.then(function (response) {
        return response.json();
    }).then(function (data) {
        console.log(data);
        for (let i = 0; i < 6; i++) {
            let div = document.createElement('div')
            div.innerHTML = `<h2>${data.cast[i].name}</h2><img class="w-[200px] h-[300px]" src="https://image.tmdb.org/t/p/original${data.cast[i].profile_path}">`
            document.querySelector('.film_areas').appendChild(div)
        }
    });

    //auclick sur la classe addalbum 
    let addalbum = document.querySelector('.addalbum')
    addalbum.addEventListener('click', function () {
        document.querySelector('.pop-up').classList.remove('hidden')
    }) 
    let overlay = document.querySelector('#overlay')
    overlay.addEventListener('click', function () {
        document.querySelector('.pop-up').classList.add('hidden')
    })
</script>

<?php
if ($_POST){
    if(isset($_POST['seen'])){
        $id = $_POST['id'];
        $connection = new Connection();
        $connection -> Newview($id , $_SESSION['id']);
        //header("refresh:1");
    }

    if(isset($_POST['dream'])){
        $id = $_POST['id'];
        $connection = new Connection();
        $connection -> Newdream($id , $_SESSION['id']);
        //header("Location: movie.php?ids=$id");

    }

    if(isset($_POST['Dseen'])){
        $id = $_POST['id'];
        $connection = new Connection();
        $connection -> Dview($id , $_SESSION['id']);


    }

    if(isset($_POST['Ddream'])){
        $id = $_POST['id'];
        $connection = new Connection();
        $connection -> dreamD($id , $_SESSION['id']);
        //header("refresh:1");

    }

    $checkboxes = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();
    foreach ($checkboxes as $checkbox) {
        // Traitement des valeurs cochées
        $connection = new connection();
        $connection->addfilmtoalbum($checkbox, $_GET['ids']);
    }


}
?>