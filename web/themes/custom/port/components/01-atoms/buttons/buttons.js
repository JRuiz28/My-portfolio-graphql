Drupal.behaviors.buttons = {
  attach() {
    const dropbtns = document.querySelectorAll('.button__dropdown');
    const droplinks = document.querySelectorAll('.button__dropdown .link');

    // Remove class 'show' from dropdown button.
    const closeOpenedDropdowns = (buttonIndexOpened = null) => {
      dropbtns.forEach((dropbtn, index) => {
        // Don't close the current opened button.
        if (buttonIndexOpened !== null && buttonIndexOpened === index) {
          return;
        }

        dropbtn.classList.remove('show');
      });
    };

    // For each dropdown button, add a click event listener.
    dropbtns.forEach((dropbtn, index) => {
      const { dataset } = dropbtn;

      if (!dataset.jsProcessed) {
        dataset.jsProcessed = true;
        dropbtn.firstElementChild.addEventListener('click', () => {
          closeOpenedDropdowns(index);
          dropbtn.classList.toggle('show');
        });
      }
    });

    // Close dropdown when focus is lost from the dropdown.
    droplinks.forEach((droplink) => {
      const { dataset } = droplink;
      if (!dataset.jsProcessed) {
        dataset.jsProcessed = true;
        droplink.classList.add('download-link');
        droplink.addEventListener('blur', (event) => {
          if (!event.relatedTarget.classList.contains('download-link')) {
            closeOpenedDropdowns();
          }
        });
      }
    });

    // Close the dropdown if the user clicks outside of it.
    window.onclick = (event) => {
      if (!event.target.matches('[class*=button--download]')) {
        closeOpenedDropdowns();
      }
    };
  },
};
