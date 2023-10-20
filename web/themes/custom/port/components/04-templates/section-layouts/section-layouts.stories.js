// import React from 'react';

// import {
//   withKnobs,
//   boolean,
//   optionsKnob as options,
// } from '@storybook/addon-knobs';
// import oneCol from './section-one-col.twig';
// import twoCol from './section-two-col.twig';
// import threeCol from './section-three-col.twig';

// /**
//  * Storybook Definition.
//  */
// export default { title: 'Templates/Section Layouts', decorators: [withKnobs] };

// // Option objects used in multiple layouts.

// // Background colors.
// const colorOptions = {
//   White: 'white',
//   Gray: 'gray',
//   Blue: 'blue',
//   Purple: 'purple',
//   'light Blue': 'light-blue',
//   'light Blue Light': 'light-blue-light',
//   'Light Yellow': 'light-yellow',
// };

// // Spacing.
// const spacing = {
//   None: 'none',
//   Small: 'small',
//   Medium: 'medium',
//   Large: 'large',
// };

// export const oneColumnSection = () => {
//   // Fixed width.
//   const fixedWidth = boolean('Fixed Width', false);
//   // Background color.
//   const bgColor = options('Background color', colorOptions, 'white', {
//     display: 'select',
//   });
//   // Top/bottom spacing.
//   const spaceTop = options('Top Spacing', spacing, 'none', {
//     display: 'select',
//   });
//   const spaceBottom = options('Bottom Spacing', spacing, 'none', {
//     display: 'select',
//   });

//   // Data to pass to component.
//   const oneColData = {
//     section_layout_modifiers: [
//       `background-${bgColor}`,
//       `spacing-top-${spaceTop}`,
//       `spacing-bottom-${spaceBottom}`,
//     ],
//   };

//   // Add fixed width modifier.
//   if (fixedWidth) oneColData.section_layout_modifiers.push('fixed-width');

//   return (
//     <div>
//       <div
//         dangerouslySetInnerHTML={{
//           __html: oneCol({
//             section_layout_placeholder_content: 'Previous section',
//             section_layout_modifiers: [],
//           }),
//         }}
//       />
//       <div dangerouslySetInnerHTML={{ __html: oneCol(oneColData) }} />
//       <div
//         dangerouslySetInnerHTML={{
//           __html: oneCol({
//             section_layout_placeholder_content: 'Next section',
//             section_layout_modifiers: [],
//           }),
//         }}
//       />
//     </div>
//   );
// };

// export const twoColumnSection = () => {
//   // Fixed width.
//   const fixedWidth = boolean('Fixed Width', false);
//   // Make column content equal height.
//   const equalHeight = boolean('Make column content equal height', true);
//   // Background color.
//   const bgColor = options('Background color', colorOptions, 'white', {
//     display: 'select',
//   });
//   // Top/bottom spacing.
//   const spaceTop = options('Top Spacing', spacing, 'none', {
//     display: 'select',
//   });
//   const spaceBottom = options('Bottom Spacing', spacing, 'none', {
//     display: 'select',
//   });
//   // Column proportions.
//   const twoColProportions = {
//     '50% - 50%': '50-50',
//     '30% - 70%': '30-70',
//     '40% - 60%': '40-60',
//     '70% - 30%': '70-30',
//     '60% - 40%': '60-40',
//   };
//   const columnProportions = options(
//     'Column Proportions',
//     twoColProportions,
//     '50-50',
//     {
//       display: 'select',
//     },
//   );
//   // Space between columns.
//   const spaceColumns = options('Space between columns', spacing, 'none', {
//     display: 'select',
//   });

//   // Data to pass to component.
//   const twoColData = {
//     section_layout_modifiers: [
//       `background-${bgColor}`,
//       `spacing-top-${spaceTop}`,
//       `spacing-bottom-${spaceBottom}`,
//       `twocol-${columnProportions}`,
//       `spacing-cols-${spaceColumns}`,
//     ],
//   };

//   // Add fixed width modifier.
//   if (fixedWidth) twoColData.section_layout_modifiers.push('fixed-width');

//   // Add equal height modifier.
//   if (equalHeight)
//     twoColData.section_layout_modifiers.push('content-equal-height');

//   return <div dangerouslySetInnerHTML={{ __html: twoCol(twoColData) }} />;
// };

// export const threeColumnSection = () => {
//   // Fixed width.
//   const fixedWidth = boolean('Fixed Width', false);
//   // Make column content equal height.
//   const equalHeight = boolean('Make column content equal height', true);
//   // Background color.
//   const bgColor = options('Background color', colorOptions, 'white', {
//     display: 'select',
//   });
//   // Top/bottom spacing.
//   const spaceTop = options('Top Spacing', spacing, 'none', {
//     display: 'select',
//   });
//   const spaceBottom = options('Bottom Spacing', spacing, 'none', {
//     display: 'select',
//   });
//   // Space between columns.
//   const spaceColumns = options('Space between columns', spacing, 'none', {
//     display: 'select',
//   });

//   // Data to pass to component.
//   const threeColData = {
//     section_layout_modifiers: [
//       `background-${bgColor}`,
//       `spacing-top-${spaceTop}`,
//       `spacing-bottom-${spaceBottom}`,
//       `spacing-cols-${spaceColumns}`,
//     ],
//   };

//   // Add fixed width modifier.
//   if (fixedWidth) threeColData.section_layout_modifiers.push('fixed-width');

//   // Add equal height modifier.
//   if (equalHeight)
//     threeColData.section_layout_modifiers.push('content-equal-height');

//   return <div dangerouslySetInnerHTML={{ __html: threeCol(threeColData) }} />;
// };
