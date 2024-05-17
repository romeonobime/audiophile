import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static get targets() {
        return ["content", "placeholder"];
    }

    static get classes() {
        return ["hidden"];
    }

    swap() {
        this.placeholderTarget.classList.toggle("hidden");
        this.contentTarget.classList.toggle("hidden");
    }
}
