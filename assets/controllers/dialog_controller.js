import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static get targets() {
        return ["dialog"];
      }

      tigger() {
        if(this.dialogTarget.open) {
          this.dialogTarget.close();
        } else {
          this.dialogTarget.showModal();
        }
      }
}
