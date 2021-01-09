export class BoffFormPassword {

    constructor(password_dom, verification_dom = null) {
        this.password_dom = password_dom;
        this.verification_dom = verification_dom;
        this.error_codes = {
            "rule_failure": "Must contain at least 8 characters, at least one uppercase letter, a lowercase letter, and a number.",
            "match_failure": "Password fields must match."
        }
    }

    checkValidity() {
        let result = {"success": true, "err_msg": ""};
        if (!this.isMatchRules()) {
            result["success"] = false;
            result["err_msg"] = this.error_codes["rule_failure"];
        } else if (!this.isMatchVerificationField()) {
            result["success"] = false;
            result["err_msg"] = this.error_codes["match_failure"];
        }

        console.log(result);
        return result;
    }

    isMatchRules() {
        // Min 8 characters, atleast one of: capital letter, lower case letter, number.
        // Credit: modified from https://stackoverflow.com/a/21456918        
        let med_strength = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)?.{8,}$/;
        let result = this.password_dom.value.match(med_strength);
        return (result != null);
    }

    isMatchVerificationField() {
        let is_valid = true;
        if (this.verification_dom) {
            is_valid = (this.password_dom.value === this.verification_dom.value);
        }
        return is_valid;
    }

}