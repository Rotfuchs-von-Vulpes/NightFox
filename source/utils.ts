interface UiColors {
  "activityBar.activeBackground": string,
  "activityBar.activeBorder": string,
  "activityBarBadge.background": string,
  "activityBar.background": string,
  "activityBar.foreground": string,
  "button.background": string,
  "focusBorder": string,
  "checkbox.border": string,
  "editor.background": string,
  "editorGroup.dropBackground": string,
  "list.dropBackground": string,
  "editorGroupHeader.tabsBackground": string,
  "editorWidget.background": string,
  "dropdown.background": string,
  "foreground": string,
  "list.hoverBackground": string,
  "list.inactiveSelectionBackground": string,
  "list.activeSelectionBackground": string,
  "panelTitle.activeBorder": string,
  "settings.modifiedItemIndicator": string,
  "sideBar.background": string,
  "sideBarSectionHeader.background": string,
  "minimap.background": string,
  "minimap.selectionHighlight": string,
  "tab.activeBorder": string,
  "tab.inactiveBackground": string,
  "textLink.foreground": string,
  "textLink.activeForeground": string,
  "titleBar.activeBackground": string,
  "titleBar.inactiveBackground": string,
  "titleBar.inactiveForeground": string,
  "input.background":  string
}

export interface BaseColors {
  lightBackground: string,
  primaryBackground: string,
  secondaryBackground: string,
  tertiaryBackground: string,
  dropBackground: string
}

export interface Settings {
  foreground: string,
  fontStyle?: string
}

interface TokenColors {
  keywordControl: Settings,
  ponctuation: Settings,
  comment: Settings,
  storage: Settings,
  variables: Settings,
  constantVariable: Settings,
  functions: Settings,
  entity: Settings,
  uperator: Settings,
  logic: Settings,
  support: Settings,
  constant: Settings,
  unit: Settings,
  strings: Settings,
  JSONKeyLevel0: Settings,
  JSONKeyLevel1: Settings,
  JSONKeyLevel2: Settings,
  JSONKeyLevel3: Settings,
  JSONKeyLevel4: Settings,
  JSONKeyLevel5: Settings,
  JSONKeyLevel6: Settings,
  JSONKeyLevel7: Settings,
  JSONKeyLevel8: Settings,
  JSDocStorage: Settings,
  JSDocVariable: Settings
}

interface TokenScopes {
  keywordControl: string[],
  ponctuation: string[],
  comment: string[],
  storage: string[],
  variables: string[],
  constantVariable: string[],
  functions: string[],
  entity: string[],
  uperator: string[],
  logic: string[],
  support: string[],
  constant: string[],
  unit: string[],
  strings: string[],
  JSONKeyLevel0: string[],
  JSONKeyLevel1: string[],
  JSONKeyLevel2: string[],
  JSONKeyLevel3: string[],
  JSONKeyLevel4: string[],
  JSONKeyLevel5: string[],
  JSONKeyLevel6: string[],
  JSONKeyLevel7: string[],
  JSONKeyLevel8: string[],
  JSDocStorage: string[],
  JSDocVariable: string[]
}

interface Token {
  name: string,
  scope: string[],
  settings: Settings
}

export interface Theme {
  name: string,
  type: string,
  colors: UiColors,
  tokenColors: Token[]
}
