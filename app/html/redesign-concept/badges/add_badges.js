// python -m http.server --bind 127.0.0.1

// Getting json from file
let request = new XMLHttpRequest();
request.open("GET", "badge_data.json", false);
request.send(null);
let badge_data = JSON.parse(request.responseText);

run();

function run() {
    initializeProgress();
    initializeBadges();
}

// *** Progress bar *** //
function initializeProgress() {
    let set_id = setInterval(set_progress, 1000);

    function set_progress() {
        let elem = document.getElementById("bar");
        let width = 0; // starting width
        let max = 255; // xp required for next level
        let current = 240; // user's current xp
        let percent = max / 100; // percent to increase the width by
        let id = setInterval(frame, 15);
        function frame() {
            if (width >= 100 || Math.round(width * percent) >= current) {
                clearInterval(id);
            } else {
                width += .5;
                elem.style.width = width + '%';
                //elem.innerHTML = Math.round(width * percent) + '';
            }
        }
        clearInterval(set_id);
    }
}

function initializeBadges() {
    // Getting DOM objects
    let badges_div = document.getElementById("badges");
    let category_default;
    let category_list = [];

    for (let badge in badge_data['badges']) {
        // Set initial category
        if (category_default == null) {
            category_default = badge_data['badges'][badge]["category"];
        }
        // add badge to page
        let badge_div = createBadgeDiv(badge)
        badges_div.appendChild(badge_div);
        if (category_list.indexOf(badge_data['badges'][badge]["category"]) == -1) {
            category_list.push(badge_data['badges'][badge]["category"]);
        }
    }
    createCategories(category_list);
    updateDisplay(category_default);
}

// Builds and returns div for a badge
function createBadgeDiv(badge) {
    // Getting data from badge
    let title = badge_data['badges'][badge]["title"];
    let path = badge_data['badges'][badge]["path"];

    // Creating elements
    let div = document.createElement("div");
    let img = document.createElement("img");
    let h2 = document.createElement("h2");
    title = document.createTextNode(title);

    let reqs_div = createReqsDiv(badge);

    // Setting attributes and adding classes
    div.setAttribute("class", "badge");
    div.classList.add("inactive");
    img.setAttribute("class", "badge-image");
    img.setAttribute("src", path);
    img.setAttribute("alt", "badge");
    h2.setAttribute("class", "badge-title");
    div.setAttribute("data-category", badge_data['badges'][badge]["category"]);

    if (badge_data['badges'][badge]["missing"] == "true") {
        div.classList.add("missing");
    }
    if (badge_data['badges'][badge]["locked"] == "true") {
        div.classList.add("locked");
        img.setAttribute("src", "lock.png");
    }

    // Appending elements and adding to page
    h2.appendChild(title);
    div.appendChild(img);
    div.appendChild(h2);
    div.appendChild(reqs_div);
    return div;
}

// Builds the divs for each requirement and true/false image
// Returns complete requirements div
function createReqsDiv(badge) {
    let req_data = badge_data['badges'][badge]['reqs'];
    let reqs_div = document.createElement("div");
    reqs_div.classList.add("reqs");
    reqs_div.classList.add("hidden");
    for (let i = 0; i < req_data.length; i++) {
        let h3 = document.createElement("h3");
        let img = document.createElement("img");
        let req_div = document.createElement("div");

        img.setAttribute("class", "req-image");
        if (req_data[i][1] == "true") {
            img.setAttribute("src", "true.png");
            img.setAttribute("alt", "has req");
            h3.classList.add("strike");
            img.classList.add("mark-true");
        } else {
            img.setAttribute("src", "false.png");
            img.setAttribute("alt", "missing req");
        }

        img.classList.add("mark");

        let req_text = document.createTextNode(req_data[i][0]);
        h3.appendChild(req_text);

        req_div.classList.add("req");
        req_div.appendChild(img);
        req_div.appendChild(h3);

        reqs_div.prepend(req_div);
    }
    return reqs_div;
}

// Creates badge categories menu on page
function createCategories(category_list) {
    let category_menu = document.getElementById("category-menu");
    for (let i = 0; i < category_list.length; i++) {
        let h3 = document.createElement("h3");
        let text = document.createTextNode(category_list[i]);
        h3.appendChild(text);
        h3.classList.add("category");
        h3.setAttribute("data-category", category_list[i]);
        category_menu.appendChild(h3);
    }
}

// Updates which badges are visible based on the category selected
function updateDisplay(category) {
    let badge_divs = document.getElementsByClassName("badge");
    for (let i = 0; i < badge_divs.length; i++) {
        if (badge_divs[i].getAttribute("data-category") == category) {
            badge_divs[i].classList.remove("hidden");
        } else {
            badge_divs[i].classList.add("hidden");
        }
    }
}
