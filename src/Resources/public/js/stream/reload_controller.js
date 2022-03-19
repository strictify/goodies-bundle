import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static values = {
        id: String,
    };

    connect() {
        let id = this.idValue;
        document.getElementById(id)?.reload();
        this.element.remove();
    }
}
