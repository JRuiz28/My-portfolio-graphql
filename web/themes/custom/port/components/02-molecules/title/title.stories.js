import title from './title.twig';

import titleData from './title.yml';
import titleStyled from './title-styled.yml';

/**
 * Storybook Definition.
 */
export default {
  title: 'Molecules/Title',
};

export const TitleDefault = () => title(titleData);

export const TitleStyled = () => title({ ...titleData, ...titleStyled });
