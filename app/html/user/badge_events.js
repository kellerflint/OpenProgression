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

let category_divs = document.getElementsByClassName("category");

for (let i = 0; i < category_divs.length; i++) {
    category_divs[i].addEventListener("click", function() {
        // If a new category is selected:
        if (!category_divs[i].classList.contains("category-selected")) {
            for(let c = 0; c < category_divs.length; c++) {
                category_divs[c].classList.remove("category-selected");
                // Hide/Show badge divs when new category is selected
                for (let j = 0; j < badge_divs.length; j++) {
                    if (badge_divs[j].getAttribute('data-category') == category_divs[i].getAttribute("data-category")) {
                        badge_divs[j].classList.remove("hidden");
                        badge_divs[j].classList.add("visible");
                    } else {
                        badge_divs[j].classList.add("hidden");
                        badge_divs[j].classList.remove("visible");
                    }
                }
            }
            category_divs[i].classList.add("category-selected");
        }
    });
}

// Hides badges on page load
for (let j = 0; j < badge_divs.length; j++) {
    if (badge_divs[j].getAttribute('data-category') == category_divs[0].getAttribute("data-category")) {
        badge_divs[j].classList.remove("hidden");
        badge_divs[j].classList.add("visible");
    } else {
        badge_divs[j].classList.add("hidden");
        badge_divs[j].classList.remove("visible");
    }
}