import { Validator } from 'vee-validate';
import MinDimensions from '../vee-validate/min-dimensions';

const dictionary = {
    messages:{
        'min-dimensions': (field, [width, height]) => 'The image must be at least ' + width + 'px x' + height + 'px.',
    },
};

Validator.extend('min-dimensions', MinDimensions);
Validator.extend('username', {
    getMessage: field => `The ${field} contains invalid characters.`,
    validate: value => {
        const ex = /[^a-zA-Z0-9.\-_]/g
        if (ex.exec(value)) {
            return false
        }

        return true;
    }
});
Validator.localize('en', dictionary);
