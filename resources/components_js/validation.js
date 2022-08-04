
const required = (value) => {
    const requiredMessage = "This is a required";
    if (!value) return requiredMessage;
    if (!String(value).length) return requiredMessage;

    return true;
};
const emailValidation = (value) => {
    const regex =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!regex.test(String(value).toLowerCase())) {
        return "Please enter a valid email address";
    }
    return true;
};
const numberValidation = (value) => {
    const regex = /^[0-9]*$/;
    if (!regex.test(String(value))) {
        return "Please enter a valid phone number";
    }
    return true;
};

// ^[0-9]*$

const minLength = (number, value) => {
    if (String(value).length < number)
        return "Please type at least " + number + " characters";
    return true;
};
const anything = () => {
    return true;
};

export { required, emailValidation,numberValidation, minLength, anything };
