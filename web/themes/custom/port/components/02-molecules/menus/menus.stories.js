import breadcrumb from './breadcrumbs/breadcrumbs.twig';
import inlineMenu from './inline/inline-menu.twig';
import mainMenu from './main-menu/main-menu.twig';

import breadcrumbsData from './breadcrumbs/breadcrumbs.yml';
import inlineMenuData from './inline/inline-menu.yml';
import mainMenuData from './main-menu/main-menu.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Menus' };

export const breadcrumbs = () => breadcrumb(breadcrumbsData);

export const inline = () => inlineMenu(inlineMenuData);

export const main = () => mainMenu(mainMenuData);
