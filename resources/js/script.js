//Progress Bar
window.onscroll = function() {progressBar()};

function progressBar() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;  //kolko som uz odscrolloval
    var height =   document.documentElement.scrollHeight - document.documentElement.clientHeight; //vyska elementu - vyska CSS,hranic,margin,..
    var scrolled = (winScroll / height) * 100; //odscroll / celkova vyska * 100
    document.getElementById("myBar").style.width   = scrolled + "%";
}
// Google Maps - Internet
function initMap() {
    const location = { lat: 49.199111653925975, lng: 18.73809138145087 };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });
    const marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}
window.initMap = initMap;

function showMobMenu() {
    const x = document.getElementById('menuMob')
    if (x.style.display === 'none') {
        x.style.display = 'block'
    } else {
        x.style.display = 'none'
    }
}
function hideMobMenu() {
    const x = document.getElementById('menuMob')
    if (x.style.display === 'block') {
        x.style.display = 'none'
    } else {
        x.style.display = 'block'
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function passwordUnhidden() {
    const x = document.getElementById("loginPasswd");

    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function passwordUnhidden2() {
    const y = document.getElementById("regPSWDInput");

    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
}
