/*
Created by : Beatrice Bjorn
For : Projekt - Bloggportal - webbutveckling II, DT093G
Last updated : 2022-03-22
*/

"use strict"

// Constants that connects to different class names in the menu
const menu = document.querySelector(".menu");
const menuItems = document.querySelectorAll(".menuItem");
const hamburger = document.querySelector(".hamburger");
const closeMenu = document.querySelector(".closeMenu");
const openMenu = document.querySelector(".openMenu");

// An eventlistener that listens to click and runs the function toggleMenu when the element with the classname hamburger is being clicked
hamburger.addEventListener("click", toggleMenu);

// A function to create a drop down menu
// If the menu contains the showMenu class it gets removed to hide the menu and the "openMenu" image is being displayes
// If the menu does not contain the showMenu class it gets added and the "closeMenu" image is being displayed inspead of the "openMenu" image
function toggleMenu() {
    if (menu.classList.contains("showMenu")) {
        menu.classList.remove("showMenu");
        closeMenu.style.display = "none";
        openMenu.style.display = "block";
    } else {
        menu.classList.add("showMenu");
        closeMenu.style.display = "block";
        openMenu.style.display = "none";
    }
};