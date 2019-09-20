// *** Display badge requirements when clicked ***//
let badges = document.getElementsByClassName("badge");
for (let i = 0; i < badges.length; i++) {
    badges[i].childNodes[0].addEventListener("click", function () {

        // Makes all other badges inactive and hidden
        for (let c = 0; c < badges.length; c++) {
            if (badges[i] !== badges[c]) {
                badges[c].childNodes[2].classList.add("hidden");
                badges[c].childNodes[2].classList.remove("show");
                badges[c].classList.add("inactive");
            }
        }

        // Toggles inactive and active for the button clicked
        if (badges[i].childNodes[2].classList.contains("hidden")) {
            badges[i].childNodes[2].classList.remove("hidden");
            badges[i].childNodes[2].classList.add("show");
            badges[i].classList.remove("inactive");
        } else {
            badges[i].childNodes[2].classList.add("hidden");
            badges[i].childNodes[2].classList.remove("show");
            badges[i].classList.add("inactive");
        }
    });
}


// *** Change categories when clicked ***//
let categories = document.getElementsByClassName("category");

for (let i = 0; i < categories.length; i++) {
    categories[i].addEventListener("click", function () {
        for (let c = 0; c < categories.length; c++) {
            categories[c].classList.remove("category-selected");
        }
        this.classList.add("category-selected");
        updateDisplay(this.getAttribute("data-category"));
    });
}