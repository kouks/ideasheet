
/**
 * A helper that returns the time from the initial request to
 * the point that the DOM is interactive.
 *
 * Thx Netflix.
 *
 * @return int
 */
window.getBootTime = () => {
  const requestStart = window.performance.timing.requestStart
  const domInteractive = window.performance.timing.domInteractive

  return domInteractive - requestStart
}

String.prototype.replaceAll = function (search, replacement) { // eslint-disable-line
  return this.replace(new RegExp(search, 'g'), replacement)
}
