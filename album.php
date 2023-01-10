<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === ''){
    header('Location: login.php');
}
require 'doctype.template.php';
require 'Header.template.php';

echo '<script>  var listMovPop </script>';
$name = $_GET['names'];
print_r($name);

?>

<main class="p-20 items-center flex flex-col w-full text-white ">
    <?php

    if ($name == 'see'){
    echo'<h2 class="pb-10">Film à voir</h2>
    <section class=" block xl:flex gap-[25px] items-center m-auto  xl:-m-0 flex-wrap mov_areas">';

        $query = new Connection();

        $lastsee = $query->GMovieSA($_SESSION['id']);
        echo '<script>  var listMovPop </script>';
        foreach ($lastsee as $movie) {

            echo "<script> 
    var filmvue = '';
    
        filmvue = " . implode('' ,$movie). ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        
        let div = document . createElement('div')
        div . innerHTML = `<a href='movie.php?ids=".implode('' ,$movie). "'><div><h2 class='p-1 h-[75px]'>". '${data.original_title}'. "</h2><img src='https://image.tmdb.org/t/p/original".'${data . poster_path}'."'></div></a>
        `
        document . querySelector('.mov_areas') . appendChild(div)
        


    });

                </script > ";
        }
    };




    if ($name == 'dream'){
        echo'<h2 class="pb-10">Film à voir</h2>
    <section class=" block xl:flex gap-[25px] items-center m-auto mt-[30px] xl:-m-0 flex-wrap mov_areas ">';

        $query = new Connection();

        $lastsee = $query->GMovieDA($_SESSION['id']);
        echo '<script>  var listMovPop </script>';
        foreach ($lastsee as $movie) {

            echo "<script> 
    var filmvue = '';
    
        filmvue = " . implode('' ,$movie). ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        
        let div = document . createElement('div')
        div . innerHTML = `<a href='movie.php?ids=".implode('' ,$movie). "'><div><h2 class='p-1 h-[75px]'>". '${data.original_title}'. "</h2><img src='https://image.tmdb.org/t/p/original".'${data . poster_path}'."'></div></a>
        `
        document . querySelector('.mov_areas') . appendChild(div)
        


    });

                </script > ";
        }
    };




    if ($name == 'album'){
        echo'<div class="flex flex-row gap-x-8"> 
        <h2>Film à voir</h2> 
        <form method="POST" action="addinlike.php"> 
        <input type="hidden" name="album_id" value="'.$_GET['ids'].'">
        <input type="submit" id="btnlike" class="bg-slate-700  p-2 rounded-full" value="❤️ Add like ">
        </form> 
        </div>
        <br>

        
    <section class=" block xl:flex gap-[25px] items-center m-auto pt-10  xl:-m-0 flex-wrap mov_areas">';



        $query = new Connection();


        $lastsee = $query->GetMovie($_GET['ids']);
        echo '<script>  var listMovPop </script>';
        foreach ($lastsee as $movie) {
            $admin = $query-> GidAdmin($_GET['ids']);
            if($admin === $_SESSION['id']){
                echo "<script> 
    var filmvue = '';
    
        filmvue = " . implode('' ,$movie). ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        
        let div = document . createElement('div')
        div . innerHTML = `
            <a href='movie.php?ids=".implode('' ,$movie). "'><div><h2 class='p-1 h-[75px]'>". '${data.original_title}'. "</h2><img src='https://image.tmdb.org/t/p/original".'${data . poster_path}'."'></div></a>
            <form method='POST' action='deleteF.php' class='p-2'>
            <input type='hidden' name='album_id' value='".$_GET['ids']."'>
            <input type='hidden' name='movie_id' value='".implode("" , $movie)."'>
            <input type='submit'' name='submit' value='Supprimer le film'>
            
            </form>
        `
        document . querySelector('.mov_areas') . appendChild(div)
        


    });

                </script > ";
        }
            else{
                            echo "<script> 
    var filmvue = '';
    
        filmvue = " . implode('' ,$movie). ";
        
        
                        listMovPop = fetch('https://api.themoviedb.org/3/movie/'+ filmvue +'?api_key=512f0783bae246658f714cd1abc41513&language=en-US')
    console . log('listMovPop')
    
    listMovPop . then(function (response) {
        return response . json();
    }) . then(function (data) {
        console . log(data);
        
        let div = document . createElement('div')
        div . innerHTML = `<a href='movie.php?ids=".implode('' ,$movie). "'><div><h2 class='p-1 h-[75px]'>". '${data.original_title}'. "</h2><img src='https://image.tmdb.org/t/p/original".'${data . poster_path}'."'></div></a>`
        document . querySelector('.mov_areas') . appendChild(div)
        


    });

                </script > ";
        }
                }
        }
    ;
    
    echo'</section>';
        ?>

</main>
