import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static get targets() {
    return ["dialog"];
  }

  initialize() {
    this.dialogTarget.close();
  }

  open() {
    this.dialogTarget.showModal();
  }

  close() {
    this.dialogTarget.close();
  }
}
