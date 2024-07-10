import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  static targets = ["menu", "button"];
  connect() {}

  toggle() {
    this.menuTarget.classList.toggle("-translate-x-full");
    this.menuTarget.classList.toggle("shadow-2xl");
  }
}
