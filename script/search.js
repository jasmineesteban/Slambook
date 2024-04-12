document.addEventListener("DOMContentLoaded", function() {
    var input = document.getElementById("searchInput");
    var button = document.getElementById("searchButton");

    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            search();
        }
    });

    button.addEventListener("click", function() {
        search();
    });

    function search() {
        var searchTerm = input.value;
        // Perform search action here
        console.log("Searching for: " + searchTerm);
    }
});
