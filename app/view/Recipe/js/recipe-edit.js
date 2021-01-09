(function() {

    function main() {
        setDeleteButtonEventHandler();
        // setCancelButtonEventHandler();
    }
    
    function setDeleteButtonEventHandler() {
        let delete_button = document.getElementById("delete-button");
        delete_button.addEventListener("click", clickDeleteButton);
    }
    
    function setCancelButtonEventHandler() {
        let cancel_button = document.getElementById("cancel-button");
        cancel_button.addEventListener("click", clickCancelButton);
    }
    
    function clickDeleteButton() {
        event.preventDefault();
        let recipe_id = getCurrentRecipeId();
        if (confirm("Are you sure you want to delete this recipe? This action cannot be undone.")) {
            window.location = "?page=recipe&id=" + recipe_id + "&action=delete";
        }
    }
    
    function clickCancelButton() {
        event.preventDefault();
        let recipe_id = getCurrentRecipeId();
        window.location="?page=recipe&id=" + recipe_id;
    }

    function getCurrentRecipeId() {
        return window.location.search.split("id=")[1].split("&")[0];
    }


    main();

})();



