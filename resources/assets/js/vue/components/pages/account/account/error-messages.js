export default {
    // Email
    'email-address': {
        email: 'Please enter a valid email address',
    },
    // Password
    'password-current': {
        required: 'Please enter your current password',
    },
    'password-new': {
        required: 'Please enter a new password',
    },
    'password-confirm': {
        required: 'Please confirm your new password',
        is: 'The passwords do not match'
    },
    // Billing
    'billing-address-name': {
        required: 'This field is required',
    },
    'billing-address-line1': {
        required: 'This field is required',
    },
    'billing-address-line2': {
        required: 'This field is required',
    },
    'billing-address-city': {
        required: 'This field is required',
    },
    'billing-address-country': {
        required: 'This field is required',
    },
    'billing-address-postcode': {
        required: 'This field is required',
    },
    'billing-card-number': {
        required: 'This field is required',
        credit_card: 'The card number is invalid'
    },
    'billing-card-cvc': {
        required: 'This field is required',
        integer: 'The CVC is invalid',
    },
    'billing-card-expiration-month': {
        required: 'This field is required',
        integer: 'The month is invalid',
        between: 'The month is invalid',
    },
    'billing-card-expiration-year': {
        required: 'This field is required',
        integer: 'The year is invalid',
    },
}