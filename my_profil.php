<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === '') {
    header('Location: login.php');
}
// session_destroy();

require 'doctype.template.php';
require 'Header.template.php';


?>

    <div class="h-full block text-white w-full xl:flex">
    <div class="w-full h-auto  xl:w-1/4 xl:h-screen xl:fixed flex flex-col text-center p-[1.5rem] bg-slate-800 pt-20">
        <iconify-icon icon="iconoir:profile-circled" class="justify-center flex text-[150px]"></iconify-icon>
        <?php
        echo '<h1>' . $_SESSION['user']['pseudo'] . ' ' . '</h1>';
        echo '<h3>' . $_SESSION['user']['email'] . ' ' . '</h3>';
        ?>
        <br>
        <div class="flex flex-col gap-5">
            <a href="logout.php" class="bg-slate-700  p-2 rounded-full">LogOut</a>
            <button class="btform bg-slate-600 rounded-full"->Crée un album</button>
        </div>
    </div> 
    <div class="block w-[70%]'">
    </div>
        <div class="block pt-20 xl:ml-[25%]">

        <div class="pb-[20px] items-center flex flex-col w-full ">
            <form method="GET">
                <label for="searchuser">Find a Friend :</label>
                <input class="text-black" type="text" id="searchuser" placeholder="Search a user" name="user" >

                <input type="submit" value="Look for" name="search">
            </form>
            <?php
            if ($_GET){
                $connection = new Connection();
                $results = $connection->searchuser($_GET['user']);
                if($results){
                    echo '<h2>Resultat de la recherche : </h2>';
                    foreach($results as $user){
                        echo '<a href="profil.php?id='. $user['id'] .'">'. $user['pseudo'] .'</a>';
                    }
                }else{
                    echo '<h2>Resultat de la recherche : </h2>';
                    echo '<h3> Aucun resultat </h3>';
                }
            };
            ?>
        </div>
        

        <div class="pb-[20px] items-center flex flex-col w-full ">
            <h2>Dernier Visionnage</h2>
            <section class=" block xl:flex gap-5 items-center  see_area  m-auto xl:m-0 ">

            </section>
            <a href="album.php?names=see">Voir Plus</a>
        </div>


        <div class="pb-[20px] items-center flex flex-col w-full ">
            <h2>Film à voir</h2>

            <section class=" block xl:flex gap-[25px] items-center m-auto  xl:-m-0 dream_area  flex-wrap">


            </section>
            <a href="album.php?names=dream">Voir Plus</a>

        </div>

        <div class="pb-4  overscroll-y-hidden items-center flex flex-col" >
            <h2>Mes Albums</h2>
            <section class=" xl:h-[260px] block xl:flex gap-5 wrap align-center  album_area  m-auto xl:m-0 " id="1">

            </section>
            <button onclick="upheight(1)">Voir plus D'album</button>
        </div>
            
        <div class="pb-4 overscroll-y-hidden items-center flex flex-col" >
            <h2>Album liker</h2>
            <section class=" xl:h-[26   0px] block xl:flex gap-5 wrap align-center  like_area  m-auto xl:m-0 " id="2">
            </section>
            <button onclick="upheight(1)">Voir plus D'album</button>

        </div>


    </div>
</div>
<section class="pop-up hidden">
    <div id="overlay"></div>
    <form method="POST" class="bg-gray-400 z-50 fixed left-[47.5%] top-[25%] w-auto h-auto p-10 flex flex-col">
        <label for="album_name">Nom: </label>
        <input type="text" name="album_name" id="album_name" placeholder="nom album">

        <label for="private">Type</label>
        <p>Public<input type="radio" id="public" name="private" value="0"></p>
        <p>Priver<input type="radio" id="prive" name="private" value="1"></p>
        <br>

        
        <button class=" bg-neutral-300" type="submit">Crée</button>
    </form>
</section>

<?php 
    if ($_POST){
    $connection = new Connection();
    $connection->creataalbum($_POST['album_name'], $_POST['private']);
    }
?>

<script>
    let CreeAlbum = document.querySelector('.btform')
    CreeAlbum.addEventListener('click', function () {
        document.querySelector('.pop-up').classList.remove('hidden')
    })      
    let overlay = document.querySelector('#overlay')
    overlay.addEventListener('click', function () {
        document.querySelector('.pop-up').classList.add('hidden')
    })

</script>
    <script src="script.js"></script>

<?php

/**
 * @param mixed $movie
 * @param string $class
 * @return void
 */
function getStr(mixed $movie, string $class): void
{
    echo "<script> 
    var filmvue;
    
        filmvue = " . implode('', $movie) . ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        let div = document . createElement('div')
        div . innerHTML = `<div class=' w-[250px] p-6 flex flex-col items-center  m-auto xl:m-0 '><h2 class='text-[0.8rem] lg:text-[1rem]'>" . '${data.original_title}' . "</h2><img class='xl:w-[100px] xl:h-[150px] w-[250px] h-350px]' src='https://image.tmdb.org/t/p/original" . '${data . poster_path}' . "'></div>
        `
        document . querySelector('" . $class . "') . appendChild(div)
        


    });

                </script > ";
}

function getMovieS(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GMovieS($_SESSION['id']);

    foreach ($lastsee as $movie) {
        getStr($movie, $class);
    }
}

function getMovieD(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GMovieD($_SESSION['id']);

    foreach ($lastsee as $movie) {
        getStr($movie, $class);
    }
}

getMovieS('.see_area');

getMovieD('.dream_area');



        function Writealbum($movie , $class , $id , $name){

            echo "<script> 
    var filmvue;
    
        filmvue = " . implode('', $movie) . ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        let div = document . createElement('div')
        div . innerHTML = `<a href='album.php?names=album&ids=".$id."'><div class=' w-[250px] p-6 flex flex-col items-center  m-auto xl:m-0 '><h2 class='text-[0.8rem] lg:text-[1rem]'>" . $name. "</h2><img class='xl:w-[100px] xl:h-[150px] w-[250px] h-350px]' src='https://image.tmdb.org/t/p/original" . '${data . poster_path}' . "'></div></a>
        `
        document . querySelector('". $class ."') . appendChild(div)
        


    });

                </script > ";

}

function getAlbum(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GAlbumid($_SESSION['id']);
    foreach ($lastsee as $albumid) {
        $album = $query->GAlbum($albumid['album_id']);
        foreach ($album as $Amovie) {
            $movie = $query->GMovie($Amovie['album_id']);
            foreach ($movie as $mov) {
                Writealbum($mov, $class , $Amovie['album_id'] , $Amovie['album_name']);
            }
        }
    }
}
getAlbum('.album_area');


function getAlbumL(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GAlbumLid($_SESSION['id']);
    foreach ($lastsee as $albumid) {
        $album = $query->GAlbum($albumid['album_id']);
        foreach ($album as $Amovie) {
            $movie = $query->GMovie($Amovie['album_id']);
            foreach ($movie as $mov) {
                Writealbum($mov, $class , $Amovie['album_id'] , $Amovie['album_name']);
            }
        }
    }
}
getAlbumL('.like_area');







