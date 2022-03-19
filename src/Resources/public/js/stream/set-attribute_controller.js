import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static values = {
        id: String,
        name: String,
        value: String,
    }

    connect() {
        let id = this.idValue;
        let attributeName = this.nameValue;
        let attributeValue = this.valueValue;

        document.getElementById(id)?.setAttribute(attributeName, attributeValue);

        this.element.remove();
    }
}
