function openNav() {
    document.querySelector("#mySidenav").classList.add("side-active");
    document.querySelector(".menu-overlay").classList.add("menu-overlay-active");
}

document.querySelector('.menu-overlay').addEventListener('click', function(){
    closeNav()
})

function closeNav() {
    document.querySelector("#mySidenav").classList.remove("side-active");
    document.querySelector(".menu-overlay").classList.remove("menu-overlay-active");
}


function upheight(id){
    document.getElementById(id).classList.toggle("xl:h-auto");


}
// The area bellow is for all the script getting data from the api and displaying the film on the web site
var p = 1; //setting page number to 1
var ActuGenre = 28 ; //setting genre action
var CurentFetch = 0; //setting curent fetch to none
var CurentFilter = 0; //setting curent filter to none
var IsAdulte = false; //setting adult filter to false
let orderby = document.querySelector('#orderby');
var Keyhold = '512f0783bae246658f714cd1abc41513';
// orderby.addEventListener('change', () => {
// console.log(orderby.value);
// });

//verifier si l'input type checkbox est coché
let pegi = document.querySelector('#pegi');
window.addEventListener('click', () => {
    if (pegi.checked) {
        IsAdulte = '&include_adult=false'
        console.log(IsAdulte);
    } else {
        IsAdulte = '&include_adult=true'
        console.log(IsAdulte);
    }
});

//script display by default on the page (show pop movie)
let listMovFilter = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + IsAdulte
CurentFetch = listMovFilter
listMovFilter = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + IsAdulte)
listMovFilter.then(function (response) {
    return response.json();
    }).then(function (data) {
    //console.log(data);
    document.querySelector('.mov_area').innerHTML = '';
    document.querySelector('.li_page_n').innerHTML = p ;
    console.log('cas 3')
    for (let i = 0; i < data.results.length; i++) {
        let div = document.createElement('div')
        div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
        document.querySelector('.mov_area').appendChild(div)
    }
});
// var p = 1;
// var ActuGenre = 0 ;

//Axolote AKA the search bar with axios
let SearchInput = document.querySelector('#search');
SearchInput.addEventListener('keyup', () => {
    console.log(SearchInput.value);
    console.log("bonjour")
    if (SearchInput.value.length == 0) {
        axios.get('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=28'+ IsAdulte)
        .then(response => {
        console.log(response.data);
        p = 1
        ActuGenre = 28
        document.querySelector('.mov_area').innerHTML = '';
        document.querySelector('.li_page_n').innerHTML = p ;
        for (let i = 0; i < response.data.results.length; i++) {
            let div = document.createElement('div')
            div.innerHTML = `<a href="movie.php?ids=${response.data.results[i].id}"><div><h2>${response.data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${response.data.results[i].poster_path}"><p>${response.data.results[i].overview}</p></div></a>`
            document.querySelector('.mov_area').appendChild(div)
        }
        });
    } else {
        axios.get('https://api.themoviedb.org/3/search/movie?api_key=' + Keyhold + '&language=en-US&query=' + SearchInput.value + '&page=1' + IsAdulte)
        .then(response => {
            //console.log(response.data);
            p = 1
            document.querySelector('.mov_area').innerHTML = '';
            document.querySelector('.li_page_n').innerHTML = p ;
            for (let i = 0; i < response.data.results.length; i++) {
                let div = document.createElement('div')
                div.innerHTML = `<a href="movie.php?ids=${response.data.results[i].id}"><div><h2>${response.data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${response.data.results[i].poster_path}"><p>${response.data.results[i].overview}</p></div></a>`
                document.querySelector('.mov_area').appendChild(div)
            }
        })
        .catch(error => {
            console.log(error + 'not axolote');
        });
    }
});


// script de la side bar pour afficher les genres
const lig = document.querySelectorAll('.li_genre');
lig.forEach((item) => {
    item.addEventListener('click', () => {
        //console.log(item.id);
        ActuGenre = item.id;
        p = 1 // reset de la page
        document.querySelector('#search').value = ""; // reset de la search bar au switch de genre
        if (orderby.value != 'none'){
            let listMovFilter = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value + IsAdulte
            CurentFetch = listMovFilter
            listMovFilter = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value + IsAdulte)
            listMovFilter.then(function (response) {
            return response.json();
            }).then(function (data) {
            //console.log(data);
            document.querySelector('.mov_area').innerHTML = '';
            document.querySelector('.li_page_n').innerHTML = p ;
            console.log('cas 3')
            for (let i = 0; i < data.results.length; i++) {
                let div = document.createElement('div')
                div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                document.querySelector('.mov_area').appendChild(div)
            }
            });
        }else {
            let listMovGenre ='https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + item.id + IsAdulte
            CurentFetch = listMovGenre
            //console.log('testing ' + CurentFetch)
            listMovGenre = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + item.id + IsAdulte)     
            //console.log(listMovGenre)
            listMovGenre.then(function (response) {
                return response.json();
            }).then(function (data) {
                //console.log(data);
                p = 1
                document.querySelector('.mov_area').innerHTML = '';
                document.querySelector('.li_page_n').innerHTML = p ;
                //console.log('Actugenre item id (script 2) : ' + ActuGenre)
                for (let i = 0; i < data.results.length; i++) {
                    let div = document.createElement('div')
                    div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                    document.querySelector('.mov_area').appendChild(div)
                }
                p = 1
            });
        }
        
    })
})

// script pour ajouter des filtres classiques
let MainFilter = document.querySelector('.MainFilter');
let ValidateFilter = document.querySelector('.ValidateFilter');
ValidateFilter.addEventListener('click', () => {
    console.log('got clicked');
    if (orderby.value == 'none') {
        if (ActuGenre == 0) {

            let listMovPop = 'https:/' + '/api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=1'
            CurentFetch = listMovPop
            listMovPop = fetch('https://api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=1')
            listMovPop.then(function (response) {
            return response.json();
            }).then(function (data) {
            p = 1
            CurentFilter = 0
            document.querySelector('.mov_area').innerHTML = '';
            document.querySelector('.li_page_n').innerHTML = p ;
            console.log('cas 1')
            for (let i = 0; i < data.results.length; i++) {
                let div = document.createElement('div')
                div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                document.querySelector('.mov_area').appendChild(div)
            }
            });

        } else if (ActuGenre != 0) {

            let listMovGenre ='https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre
            CurentFetch = listMovGenre
            listMovGenre = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre)
            listMovGenre.then(function (response) {
                return response.json();
            }).then(function (data) {
                p = 1
                CurentFilter = 0
                document.querySelector('.mov_area').innerHTML = '';
                document.querySelector('.li_page_n').innerHTML = p ;
                console.log('cas 2')
                for (let i = 0; i < data.results.length; i++) {
                    let div = document.createElement('div')
                    div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                    document.querySelector('.mov_area').appendChild(div)
                }
                p = 1
            });
        } else {
            document.querySelector('.mov_area').innerHTML = '<h2>Sorry please refresh the page an error occured</h2>';
        }
    } else {
        if (ActuGenre == 0) {
            console.log('filter active');
            console.log('fetch pres filtre' +CurentFetch);
            console.log('choix filtre'+orderby.value);
            let listMovFilter = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + '&sort_by=' + orderby.value + IsAdulte
            CurentFetch = listMovFilter

            listMovFilter = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + '&sort_by=' + orderby.value + IsAdulte)
            listMovFilter.then(function (response) {
            return response.json();
            }).then(function (data) {

            p = 1
            document.querySelector('.mov_area').innerHTML = '';
            document.querySelector('.li_page_n').innerHTML = p ;
            console.log('cas 3')
            for (let i = 0; i < data.results.length; i++) {
                let div = document.createElement('div')
                div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                document.querySelector('.mov_area').appendChild(div)
            }
            });
        } else {
            console.log('filter active');
            console.log('fetch pres filtre' +CurentFetch);
            console.log('choix filtre'+orderby.value);
            let listMovFilter = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value + IsAdulte
            CurentFetch = listMovFilter
            listMovFilter = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value + IsAdulte)
            listMovFilter.then(function (response) {
            return response.json();
            }).then(function (data) {
            p = 1
            document.querySelector('.mov_area').innerHTML = '';
            document.querySelector('.li_page_n').innerHTML = p ;
            console.log('cas 3')
            for (let i = 0; i < data.results.length; i++) {
                let div = document.createElement('div')
                div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                document.querySelector('.mov_area').appendChild(div)
            }
            });
        }
    }
});


// script to change page 
document.querySelector('.li_page_n').innerHTML = p ;
const lip = document.querySelectorAll('.li_page');
lip.forEach((item) => {
    item.addEventListener('click', () => {
            if (item.id === '1'){
                p += 1
            } else if ( item.id === '2' && p !== 1) {
                p = p - 1
            } else {
                p = 1
            }

            if (SearchInput.value.length != 0) {
                
                    axios.get('https://api.themoviedb.org/3/search/movie?api_key=' + Keyhold + '&language=en-US&query=' + SearchInput.value + '&page='+ p + IsAdulte)
                    .then(response => {

                    console.log('cas B');
                    document.querySelector('.mov_area').innerHTML = '';
                    document.querySelector('.li_page_n').innerHTML = p ;
                    for (let i = 0; i < response.data.results.length; i++) {
                        let div = document.createElement('div')
                        div.innerHTML = `<a href="movie.php?ids=${response.data.results[i].id}"><div><h2>${response.data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${response.data.results[i].poster_path}"><p>${response.data.results[i].overview}</p></div></a>`
                        document.querySelector('.mov_area').appendChild(div)
                    }
                    })
                    .catch(error => {
                    console.log(error + 'not axolote');
                    });

            } else {
                if (ActuGenre != 0 && orderby.value == 'none'){ //genre mais non filter a != 0 et b = 0 
                    let listMovPage = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&page=' + p + IsAdulte
                    CurentFetch = listMovPage
                    listMovPage = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&with_genres=' + ActuGenre + '&page=' + p + IsAdulte) 

                    listMovPage.then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        console.log('cas A');
                        document.querySelector('.mov_area').innerHTML = '';
                        document.querySelector('.li_page_n').innerHTML = p ;
                        document.body.scrollTop = 0; // For Safari
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        for (let i = 0; i < data.results.length; i++) {
                            let div = document.createElement('div')
                            div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                            document.querySelector('.mov_area').appendChild(div)
                        }
                    });
                } else if (ActuGenre == 0 && orderby.value == 'none') { // default think page a = 0 et b = 0
                    let listMovPage = 'https:/'+'/api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=' + p + IsAdulte
                    CurentFetch = listMovPage
                    listMovPage = fetch('https://api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=' + p + IsAdulte)
                    //console.log(listMovPage)
                    listMovPage.then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        //console.log(data);
                        console.log('cas C');
                        document.querySelector('.mov_area').innerHTML = '';
                        document.querySelector('.li_page_n').innerHTML = p ;
                        document.body.scrollTop = 0; // For Safari
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        for (let i = 0; i < data.results.length; i++) {
                            let div = document.createElement('div')
                            div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                            document.querySelector('.mov_area').appendChild(div)
                        }
                    });
                } else if (orderby.value != 'none' && ActuGenre == 0) { //filter et pas genre a = 0 et b != 0
                    let listMovPage = 'https:/'+'/api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=' + p + '&sort_by=' + orderby.value + IsAdulte
                    CurentFetch = listMovPage
                    listMovPage = fetch('https://api.themoviedb.org/3/movie/popular?api_key=' + Keyhold + '&language=en-US&page=' + p + '&sort_by=' + orderby.value + IsAdulte)
                    //console.log(listMovPage)
                    listMovPage.then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        //console.log(data);
                        console.log('cas D');
                        document.querySelector('.mov_area').innerHTML = '';
                        document.querySelector('.li_page_n').innerHTML = p ;
                        document.body.scrollTop = 0; // For Safari
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        for (let i = 0; i < data.results.length; i++) {
                            let div = document.createElement('div')
                            div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                            document.querySelector('.mov_area').appendChild(div)
                        }
                    });
                } else if (ActuGenre != 0 && orderby.value != 'none') { //genre et  filter a != 0 et b != 0
                    let listMovPage = 'https:/'+'/api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&language=en-US&page=' + p + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value  + IsAdulte
                    CurentFetch = listMovPage
                    listMovPage = fetch('https://api.themoviedb.org/3/discover/movie?api_key=' + Keyhold + '&language=en-US&page=' + p + '&with_genres=' + ActuGenre + '&sort_by=' + orderby.value + IsAdulte)
                    //console.log(listMovPage)
                    listMovPage.then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        //console.log(data);
                        console.log('cas E');
                        document.querySelector('.mov_area').innerHTML = '';
                        document.querySelector('.li_page_n').innerHTML = p ;
                        document.body.scrollTop = 0; // For Safari
                        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                        for (let i = 0; i < data.results.length; i++) {
                            let div = document.createElement('div')
                            div.innerHTML = `<a href="movie.php?ids=${data.results[i].id}"><div><h2>${data.results[i].title}</h2><img src="https://image.tmdb.org/t/p/original${data.results[i].poster_path}"><p>${data.results[i].overview}</p></div></a>`
                            document.querySelector('.mov_area').appendChild(div)
                        }
                    });
                }
            }   
    })
})

