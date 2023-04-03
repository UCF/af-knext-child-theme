//
// Import third-party assets
//

// ...


//
// Project-specific scripts
//

// Require your theme's custom script files here
// ...
$(document).ready(() => {
  const currentUrl = window.location.href;

  $('#wpt-menu a').each(function () {
    const linkUrl = $(this).attr('href');

    if (currentUrl === linkUrl) {
      $(this).addClass('active text-secondary');
      $(this).removeClass('text-inverse');
    }
  });
});
