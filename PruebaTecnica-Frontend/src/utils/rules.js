function sendMessageIfConditionNotMet(condition, message) {
    if (!condition) {
      return message;
    }
    return condition;
  }
  
  const rules = {
    email: (value) => {
      const regularExpressionEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
      return sendMessageIfConditionNotMet(
        regularExpressionEmail.test(value),
        "E-mail must be valid."
      );
    },
    confirmPassword: (password) => (value) => {
      return sendMessageIfConditionNotMet(
        value === password,
        "Passwords don't match"
      );
    },
    password: (value) => {
      const regularExpressionPassword =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
  
      return sendMessageIfConditionNotMet(
        regularExpressionPassword.test(value),
        "Password field must have, at least, one lowercase letter, one uppercase letter, one digit, one special character, and be 8 characters or longer."
      );
    },
    required: (value) => {
      return sendMessageIfConditionNotMet(
        Boolean(value || value === 0),
        "This field is required."
      );
    },
    maximumValue: (maximumValue) => (value) => {
      return sendMessageIfConditionNotMet(
        value < maximumValue,
        `The maximum value allowed is ${maximumValue}`
      );
    },
    minimumValue: (minimumValue) => (value) => {
      return sendMessageIfConditionNotMet(
        value > minimumValue,
        `The minimun value allowed is ${minimumValue}`
      );
    },
  };
  
  export default rules;