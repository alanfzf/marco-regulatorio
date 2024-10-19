import "./bootstrap"

// THEME STUFF
window.toggleTheme = function () {
  const inverted = getTheme(true)
  localStorage.setItem("current-theme", inverted)
}

window.getTheme = function (inverted) {
  let active = localStorage.getItem("current-theme") ?? "light"
  active = inverted ? (active === "light" ? "dark" : "light") : active
  return active
}

document.addEventListener("DOMContentLoaded", function () {
  //theme logic
  const htmlNode = document.getElementsByTagName("html")
  const changer = document.getElementById("theme-changer")
  htmlNode[0].setAttribute("data-theme", getTheme())
  changer.setAttribute("value", getTheme(true))
  //theme logic end
})
