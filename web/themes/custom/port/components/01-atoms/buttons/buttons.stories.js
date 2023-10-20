import button from './button.twig';
import buttonLinkData from './button-link.yml';
import buttonOutlineData from './button-outline.yml';
import buttonOutlineGrayData from './button-outline-gray.yml';

/**
 * Storybook Definition.
 */

export default { title: 'Atoms/Button' };

export const buttonDefault = () => button(buttonOutlineData);

export const buttonOutlineGray = () => button(buttonOutlineGrayData);

export const buttonLink = () => button(buttonLinkData);
