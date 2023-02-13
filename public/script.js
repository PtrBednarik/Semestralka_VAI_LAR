//Progress Bar
window.onscroll = function() {progressBar()};

//https://www.educative.io/answers/how-to-escape-unescape-html-characters-in-string-in-javascript
function escapeString(htmlStr) {
    return htmlStr.replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#39;");
 }

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
// const topButton = document.getElementById("toTopBtn");
//
// // window.onscroll = function() {scrollFunction()};
//
// function scrollFunction() {
//     if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
//         topButton.style.display = "block";
//     } else {
//         topButton.style.display = "none";
//     }
// }

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function passwordUnhidden(elementId) {
    const inputEl = document.getElementById(elementId);
    // const x = document.getElementById("loginPasswd");

    if (inputEl.type === "password") {
        inputEl.type = "text";
    } else {
        inputEl.type = "password";
    }
}