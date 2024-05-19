import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static get targets() {
    return ["counter"];
  }

  increase() {
    this.counterTarget.value++;
  }

  decrease() {
    if(this.counterTarget.value < 2)
        return

    this.counterTarget.value--;
  }
}