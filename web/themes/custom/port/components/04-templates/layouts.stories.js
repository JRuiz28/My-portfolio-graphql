import fullWidthTwig from './full-width.twig';
import withSidebarTwig from './with-sidebar.twig';

/**
 * Storybook Definition.
 */
export default {
  title: 'Templates/Layouts',
  parameters: {
    layout: 'fullscreen',
  },
};

export const fullWidth = () => fullWidthTwig();

export const withSidebar = () => withSidebarTwig();
