import * as yup from 'yup';

const latin_message = 'Field must contain only latin letters';
const latin_rule = /^[a-zA-Z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?\s\n]*$/;

export const schema = yup.object().shape({
    name: yup.string().required().matches(latin_rule, latin_message),
    email: yup.string().email().required().matches(latin_rule, latin_message),
    homepage: yup.string().matches(latin_rule, latin_message),
    text: yup.string()
        .matches(latin_rule, latin_message)
        .test('is-not-empty', 'Field is required', value => {
            if (!value) return false; // Empty string is not valid
            const trimmedValue = value.replace(/<[^>]*>/g, '').trim(); // Remove tags
            return trimmedValue.length > 0; // Check if there's any non-whitespace content
        }),
        captcha: yup.string().required()
});