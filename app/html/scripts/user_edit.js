document.getElementById("user-select").addEventListener("change", function () {
    this.form.submit();
});

document.getElementById("copy-info").addEventListener("click", function () {
    let username = document.getElementById("name").value;
    let nickname = document.getElementById("nickname").value;
    let password = document.getElementById("password").value;

    let data = document.createElement("textarea");
    data.innerHTML = "nickname: " + nickname + "\nusername: " + username + "\npassword: " + password;
    document.body.appendChild(data);
    data.select();
    document.execCommand("copy");
    document.body.removeChild(data);
});
