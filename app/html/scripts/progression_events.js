// this throws an error but it also works. should need a loop to assign each listener. why?
document.getElementsByClassName("edit-category").addEventListener("click", function () {
    this.form.submit();
});