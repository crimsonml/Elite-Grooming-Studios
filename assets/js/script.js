document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.querySelector('.menu-toggle');
  const navList = document.querySelector('.nav-list');

  menuToggle.addEventListener('click', function() {
    navList.style.display = navList.style.display === 'flex' ? 'none' : 'flex';
  });
});

menuToggle.addEventListener('click', function() {
  navList.style.display = navList.style.display === 'flex' ? 'none' : 'flex';
});
