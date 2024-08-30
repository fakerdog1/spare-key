function toggleMenu() {
  $('#responsive-menu').toggleClass('hidden');
  $('.hamburger-icon, .close-icon').toggleClass('hidden');
}

$(document).ready(function() {
  $('.hamburger-button').click(function() {
    toggleMenu();
  });
});
