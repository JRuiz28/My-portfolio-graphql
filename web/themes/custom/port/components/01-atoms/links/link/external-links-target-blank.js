Drupal.behaviors.externalLinksTargetBlank = {
  attach: function attach() {
    const links = document.getElementsByTagName('a');
    const external = Array.from(links).filter((link) => {
      return link.hostname && link.hostname !== window.location.hostname;
    });
    external.forEach((link) => {
      link.setAttribute('target', '_blank');
      link.classList.add('external-link');
    });
  },
};
