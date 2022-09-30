import fs from 'fs';

import make from './source/makeJson';

import darkBlue from './source/themes/dark-blue.json';
import dark from './source/themes/dark.json';

const themes = [ darkBlue, dark ];

for (const theme of themes) {
  let json = JSON.stringify(make(theme.name, theme, true));

  fs.writeFileSync('./themes/' + theme.id + '-color-theme.json', json);

  json = JSON.stringify(make(theme.name + ' (no italics)', theme, false));

  fs.writeFileSync('./themes/' + theme.id + '-no-italics-color-theme.json', json);

  console.log(theme.name + ' compiled');
}

console.log('Done.')
