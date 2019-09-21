let badge_divs = document.getElementsByClassName("badge");

for (let i = 0; i < badge_divs.length; i++) {
    badge_divs[i].addEventListener("click", function () {
        if (badge_divs[i].classList.contains("active")){
            badge_divs[i].classList.add("inactive");
            badge_divs[i].classList.remove("active");
            badge_divs[i].childNodes[5].classList.add("hide");
            badge_divs[i].childNodes[5].classList.remove("show");
        } else {
            badge_divs[i].classList.add("active");
            badge_divs[i].classList.remove("inactive");
            badge_divs[i].childNodes[5].classList.add("show");
            badge_divs[i].childNodes[5].classList.remove("hide");
        }
    });
}