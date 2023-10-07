import button from './button.twig';
import buttonLinkData from './button-link.yml';
import buttonOutlineData from './button-outline.yml';
import downloadButtonData from './download-button.yml';
import buttonOutlineGrayData from './button-outline-gray.yml';

import './buttons';

/**
 * Storybook Definition.
 */

export default { title: 'Atoms/Button' };

export const buttonDefault = () => button(buttonOutlineData);

export const buttonOutlineGray = () => button(buttonOutlineGrayData);

export const buttonLink = () => button(buttonLinkData);

export const downloadButton = () => button(downloadButtonData);
