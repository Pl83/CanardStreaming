<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === '') {
    header('Location: login.php');
}

require 'doctype.template.php';
require 'Header.template.php';

$id_user = $_GET['id'];
?>

    <div class="h-full block text-white w-full xl:flex">
    <div class="w-full h-auto xl:w-1/4 xl:h-screen xl:fixed flex flex-col text-center p-[1.5rem] bg-slate-800 pt-20">
        <iconify-icon icon="iconoir:profile-circled" class="justify-center flex text-[150px]"></iconify-icon>
        <?php
        $query = new Connection();
        $user = $query->getuser($id_user);
        foreach ($user as $user) {
            echo '<h1>' . $user['pseudo'] . ' ' . '</h1>';
            //echo '<h3>' . $user['email'] . ' ' . '</h3>';
        }
        ?>
    </div>
        <div class="block pt-20 xl:ml-[25%]">

        <div class="pb-[20px] items-center flex flex-col w-full ">
            <h2>Dernier Visionnage</h2>
            <section class=" block xl:flex gap-5 items-center  see_area  m-auto xl:m-0 ">

            </section>
            <a href="album.php?names=see"Voir Plus></a>
        </div>


        <div class="pb-[20px] items-center flex flex-col w-full ">
            <h2>Film à voir</h2>

            <section class=" block xl:flex gap-[25px] items-center m-auto  xl:-m-0 dream_area  flex-wrap">


            </section>
            <a href="album.php?names=dream">Voir Plus</a>

        </div>

        <div class="pb-4  overscroll-y-hidden items-center flex flex-col" >
            <h2>Ces Albums</h2>
            <section class=" xl:h-[280px] block xl:flex gap-5 wrap align-center  album_area  m-auto xl:m-0 " id="1">

            </section>
            <button onclick="upheight(1)">Voir plus D'album</button>
        </div>
        <div class="pb-4 xl:h-[280px] overscroll-y-hidden items-center flex flex-col" >
            <h2>Album liker</h2>
            <section class=" xl:h-[280px] block xl:flex gap-5 wrap align-center  like_area  m-auto xl:m-0 " id="2">
            </section>
            <button onclick="upheight(1)">Voir plus D'album</button>

        </div>

    </div>
</div>
    <script src="js/script.js"></script>

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
        div . innerHTML = `<div class=' w-[250px] p-6 flex flex-col items-center  m-auto xl:m-0 '><h2 class='text-[0.8rem]'>" . '${data.original_title}' . "</h2><img class='w-[100px] h-[150px]' src='https://image.tmdb.org/t/p/original" . '${data . poster_path}' . "'></div>
        `
        document . querySelector('" . $class . "') . appendChild(div)
        


    });

                </script > ";
}

function getMovieS(string $class): void
{

    $query = new Connection();
    $lastsee = $query->GMovieS($_GET['id']);

    foreach ($lastsee as $movie) {
        getStr($movie, $class);
    }
}

function getMovieD(string $class): void
{

    $query = new Connection();
    $lastsee = $query->GMovieD($_GET['id']);

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
        div . innerHTML = `<a href='album.php?names=album&ids=".$id."'><div class=' w-[250px] p-6 flex flex-col items-center  m-auto xl:m-0 '><h2 class='text-[0.8rem]'>" . $name. "</h2><img class='w-[100px] h-[150px]' src='https://image.tmdb.org/t/p/original" . '${data . poster_path}' . "'></div></a>
        `
        document . querySelector('". $class ."') . appendChild(div)
        


    });

                </script > ";

}

function getAlbum(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GAlbumid($_GET['id']);
    foreach ($lastsee as $albumid) {
        $album = $query->GAlbum($albumid['album_id']);
        foreach ($album as $Amovie) {
            $movie = $query->GMovie($Amovie['album_id'],0);
            if( $Amovie['private'] == 0){
            foreach ($movie as $mov) {
                Writealbum($mov, $class , $Amovie['album_id'] , $Amovie['album_name']);
            }
            }
        }
    }
}
getAlbum('.album_area');


function getAlbumL(string $class): void
{
    $query = new Connection();
    $lastsee = $query->GAlbumLid($_GET['id']);
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







