import { Controller } from "@hotwired/stimulus";
import * as Turbo from "@hotwired/turbo";
export default class extends Controller {
  static targets = ["elements"];
  static values = {
    url: String,
    target: String,
    title: String,
  }

  connect() {
    // Append hidden anchor tag after this.element to allow robots to crawl the link for SEO
    const anchor = document.createElement("a");
    anchor.href = this.urlValue;
    anchor.style.display = "none";
    anchor.rel = "noopener noreferrer";

    if (this.hasTitleValue) {
      anchor.title = this.titleValue;
      anchor.textContent = this.titleValue;
      anchor.setAttribute("aria-label", this.titleValue); // Enhance accessibility
    } else {
      anchor.textContent = "Visit the page";
      anchor.setAttribute("aria-label", "Visit the page");
    }

    this.element.insertAdjacentElement('afterend', anchor);
  }

  visit(event) {
    event.preventDefault();
    if (this.urlValue) {
      Turbo.visit(this.urlValue)
    }
  }
}
