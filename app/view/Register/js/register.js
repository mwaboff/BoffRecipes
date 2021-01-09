(function () {

    function main() {
        setLoginButtonEventHandler();
    }

    function setLoginButtonEventHandler() {
        let login_button = document.getElementById("login-button");
        login_button.addEventListener("click", clickLoginButton);
    }

    function clickLoginButton() {
        event.preventDefault();
        window.location="?page=login";
    }
    
    main();
})();