document.getElementById("optionSearch").addEventListener("input", function() {
    var input, filter, ul, li, button, i, txtValue;
    input = document.getElementById('optionSearch');
    filter = input.value.toUpperCase();
    ul = document.getElementById("roomList");
    li = ul.getElementsByTagName('li');

    for (i = 0; i < li.length; i++) {
        button = li[i].getElementsByTagName("button")[0];
        txtValue = button.textContent || button.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
});