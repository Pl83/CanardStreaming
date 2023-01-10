<?php

require_once 'Connection.php';

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] === ''){
    header('Location: login.php');
}

require 'doctype.template.php';
require 'Header.template.php';

?>
    <aside class="fixed xl:w-1/6 xl:h-full bg-slate-900 text-white pt-20  md:top-0 xl:left-0 xl:overflow-y-scroll overflow-x-scroll xl:overflow-x-hidden w-full h-auto ">
        <ul class="xl:block xl:h-full flex pl-[550px] xl:pl-0 ">
            <li class="li_genre" id="28">Action</li>
            <li class="li_genre" id="12">Adventure</li>
            <li class="li_genre" id="16">Animation</li>
            <li class="li_genre" id="35">Comedy</li>
            <li class="li_genre" id="80">Crime</li>
            <li class="li_genre" id="99">Documentary</li>
            <li class="li_genre" id="18">Drama</li>
            <li class="li_genre" id="10751">Family</li>
            <li class="li_genre" id="14">Fantasy</li>
            <li class="li_genre" id="36">History</li>
            <li class="li_genre" id="27">Horror</li>
            <li class="li_genre" id="10402">Music</li>
            <li class="li_genre" id="9648">Mystery</li>
            <li class="li_genre" id="10749">Romance</li>
            <li class="li_genre" id="878">Science Fiction</li>
            <li class="li_genre" id="10770">TV Movie</li>
            <li class="li_genre" id="53">Thriller</li>
            <li class="li_genre" id="10752">War</li>
            <li class="li_genre" id="37">Western</li>
        </ul>
    </aside>

<main class="xl:ml-[18%]   pt-20 flex">



<div class="block pt-20 xl:pt-0">
    <div class="flex text-white justify-evenly p-[15px]">
        <div>
            <input type="checkbox" id="pegi" name="pegi" value="pegi" checked>
            <label for="pegi">SafeSearch</label>
        </div>
        <div class="text-black   search ">
            <input type="text" id="search" placeholder="Search" >
        </div>

        <div class="flex gap-1">
            <p> Order by</p>

            <select class="MainFilter text-black" name="orderby" id="orderby">
                <option value="none">Rien</option>
                <option value="popularity.desc">Popularity desc</option>
                <option value="vote_average.desc">Vote average desc</option>
                <option value="original_title.asc">Original title asc</option>
                <option value="popularity.asc">Popularity asc</option>
                <option value="vote_average.asc">Vote average asc</option>
                <option value="original_title.desc">Original title desc</option>
            </select>
            <button class="ValidateFilter">Filter</button>
        </div>

    </div>
        <section class="mov_area flex flex-wrap gap-[25px]">
        </section>


        <ul class="text-white">
            <li class="li_page" id="2" > << </li>
            <li class="li_page_n"></li>
            <li class="li_page" id="1" > >> </li>
        </ul>

</div>

</main>

<?php
require 'footer.template.php';
?>