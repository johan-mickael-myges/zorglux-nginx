import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["mobileContainer", "desktopContainer"];
  static values = {
    hiddenClass: String,
  };
  connect() {
  }

  toggle() {
    if (this.mobileContainerTarget) {
      this.mobileContainerTarget.classList.toggle('translate-y-full');
    }
    if (this.desktopContainerTarget) {
      this.desktopContainerTarget.classList.toggle('translate-x-full');
    }
  }
}
