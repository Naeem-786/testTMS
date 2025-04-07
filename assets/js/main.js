// $(document).ready(function() {
//     $('.menu-link').click(function(e) {
//         e.preventDefault(); // Prevent default link behavior

//         // Remove 'active' class from all menu items
//         $('.menu-link').removeClass('active');

//         // Add 'active' class to the clicked menu item
//         $(this).addClass('active');

//         // Remove 'submenu-active' class from all submenu items
//         $('.submenu-items  li').removeClass('submenu-active');

//         // Add 'submenu-active' class to clicked submenu item
//         $(this).next('.submenu-items').find('li a').addClass('submenu-active');
//     });
// });

// $(document).ready(function() {
//     $('.menu-link').click(function(e) {
//         e.preventDefault(); // Prevent default link behavior

//         // Remove 'active' class from all submenu items
//         $('.submenu-items a').removeClass('submenu-active');

//         // Check if it's a submenu item and handle its visibility and active class
//         if ($(this).next('.submenu-items').length) {
//             // Toggle submenu visibility
//             $(this).next('.submenu-items').slideToggle();

//             // Add 'submenu-active' class to the clicked submenu item
//             $(this).toggleClass('submenu-active');
//         } else {
//             // If it's a main menu item (not a submenu), remove 'submenu-active' class from all submenu items
//             $('.submenu-items').slideUp();
//             $('.submenu-items a').removeClass('submenu-active');

//             // Remove 'active' class from all main menu items
//             $('.menu-link').removeClass('active');

//             // Add 'active' class to the clicked main menu item
//             $(this).addClass('active');
//         }
//     });
// });

