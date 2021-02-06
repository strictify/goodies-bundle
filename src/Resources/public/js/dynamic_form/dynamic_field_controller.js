import { Controller } from 'stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        // console.log(this.element);
    }

    onChange(event) {
        let form = event.target.form;
        // disable client-side validation; otherwise form.requestSubmit() will not work
        form.setAttribute('novalidate', 'novalidate');

        let hidden = document.createElement('input');
        hidden.setAttribute('type', 'hidden');
        hidden.setAttribute('name', '_dynamic_field');
        hidden.setAttribute('value', '1' );
        form.appendChild(hidden);

        form.requestSubmit();
    }

}