import radio from './radio/radio.twig';
import select from './select/select.twig';
import checkbox from './checkbox/checkbox.twig';
import textfields from './textfields/textfields.twig';

import radioData from './radio/radio.yml';
import checkboxData from './checkbox/checkbox.yml';
import selectOptionsData from './select/select.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/Forms' };

export const checkboxes = () => checkbox(checkboxData);

export const radioButtons = () => radio(radioData);

export const selectDropdowns = () => select(selectOptionsData);

export const textfieldsExamples = () => textfields({});
