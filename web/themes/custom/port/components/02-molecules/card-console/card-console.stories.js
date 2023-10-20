import cardConsoleTwig from './card-console.twig';

import cardConsoleData from './card-console.yml';

/**
 * Storybook Definition.
 */
export default {
  title: 'Molecules/Card Console',
};

export const cardConsole = () => cardConsoleTwig(cardConsoleData);
