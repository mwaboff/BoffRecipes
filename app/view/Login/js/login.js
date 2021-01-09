// Michael Aboff - DSN6060 - Week 3

(function () {

    function main() {
        setGuestButtonEventHandler();
        setRegisterButtonEventHandler();
    }

    function setGuestButtonEventHandler() {
        let guest_button = document.getElementById("guest-button");
        guest_button.addEventListener("click", clickGuestButton);
    }

    function setRegisterButtonEventHandler() {
        let register_button = document.getElementById("register-button");
        register_button.addEventListener("click", clickRegisterButton);
    }

    function clickGuestButton() {
        event.preventDefault();
        insertDefaultLoginCredentials();
    }

    function clickRegisterButton() {
        event.preventDefault();
        window.location="?page=register";
    }

    function insertDefaultLoginCredentials() {
        let username_field = document.getElementById("username-field");
        let password_field = document.getElementById("password-field");
        username_field.value = "Guest";
        password_field.value = "Guest1234";
    }

    main();
})();