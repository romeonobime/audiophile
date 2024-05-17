import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static get targets() {
        return ["radio", "content"];
    }

    static get classes() {
        return ["block"];
    }

    connect() {
        this.display()
    }

    display() {
        const radios = this.radioTargets
        const contents = this.contentTargets

        const checkedRadio = radios.find(radio => radio.checked);

        for (const content of contents) {
            content.classList.toggle(
                "hidden",
                checkedRadio.value !== content.id
            )
        }
    }
}
