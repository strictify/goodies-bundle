import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    onChange(event) {
        let form = event.target.form;
        // disable client-side validation; otherwise form.requestSubmit() will not work
        form.setAttribute('novalidate', 'novalidate');

        let hidden = document.createElement('input');
        hidden.setAttribute('type', 'hidden');
        hidden.setAttribute('name', '_dynamic_field');
        hidden.setAttribute('value', '1');
        form.appendChild(hidden);

        form.querySelectorAll('button').forEach((button) => {
            button.setAttribute('disabled', 'disabled');
        });

        form.requestSubmit();
    }
}
