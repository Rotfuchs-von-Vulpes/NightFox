import base from './base/base.json';
import tokensColors from './base/tokensColors.json';
import tokensScopes from './base/tokensScopes.json';

import { BaseColors, Theme, Settings } from './utils';

type tokensColorsType = typeof tokensColors;
type tokensColorsUnion = keyof tokensColorsType;

export default function make(name: string, colors: BaseColors, italic: boolean): Theme {
  let theme: Theme = {
    name: name,
    type: "dark",
    colors: {
      "activityBar.activeBackground": colors.primaryBackground,
      "activityBar.activeBorder": base.primaryActive,
      "activityBarBadge.background": base.primaryActive,
      "activityBar.background": colors.tertiaryBackground,
      "activityBar.foreground": base.foreground,
      "button.background": base.primaryActive,
      "focusBorder": base.primaryActive,
      "checkbox.border": base.primaryActive,
      "editor.background": colors.primaryBackground,
      "editorGroup.dropBackground": colors.dropBackground,
      "list.dropBackground": base.tertiaryActive,
      "editorGroupHeader.tabsBackground": colors.tertiaryBackground,
      "editorWidget.background": colors.tertiaryBackground,
      "dropdown.background": colors.tertiaryBackground,
      "foreground": base.foreground,
      "list.hoverBackground": colors.primaryBackground,
      "list.inactiveSelectionBackground": colors.lightBackground,
      "list.activeSelectionBackground": base.secondaryActive,
      "panelTitle.activeBorder": base.primaryActive,
      "settings.modifiedItemIndicator": base.primaryActive,
      "sideBar.background": colors.secondaryBackground,
      "sideBarSectionHeader.background": colors.tertiaryBackground,
      "minimap.background": colors.secondaryBackground,
      "minimap.selectionHighlight": base.primaryActive,
      "tab.activeBorder": base.primaryActive,
      "tab.inactiveBackground": colors.secondaryBackground,
      "textLink.foreground": base.primaryActive,
      "textLink.activeForeground": base.primaryActive,
      "titleBar.activeBackground": colors.tertiaryBackground,
      "titleBar.inactiveBackground":colors.tertiaryBackground,
      "titleBar.inactiveForeground": base.inactiveForeground,
      "input.background": colors.tertiaryBackground
    },
    tokenColors: []
  }

  let pairs = Object.entries(tokensColors);

  for (const pair of pairs) {
    let scopes = tokensScopes[pair[0] as tokensColorsUnion];
    let settings = pair[1] as Settings;

    if (!italic && settings.fontStyle) {
      settings.fontStyle = undefined;
    }

    theme.tokenColors.push({
      name: pair[0],
      scope: scopes,
      settings: pair[1]
    })
  }

  return theme;
}
