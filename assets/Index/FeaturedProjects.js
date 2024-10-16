import { Carousel } from 'bootstrap'

export class FeaturedProjects {
  constructor(elementId) {
    this.id = elementId
    this.carouselElement = document.getElementById(elementId)
  }

  init() {
    if (this.carouselElement) {
      new Carousel(this.carouselElement)
    } else {
      console.warn(`#${this.id} can't be found in the DOM.`)
    }
  }
}
