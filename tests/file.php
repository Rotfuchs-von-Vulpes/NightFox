<?php namespace Clockwork\Authentication;

class NullAuthenticator implements AuthenticatorInterface {
    public function attempt(array $credentials) {
        return true;
    }
    public function check($token) {
        return true;
    }
    public function requires() {
        return [];
    }
}

interface AuthenticatorInterface {
    const REQUIRES_USERNAME = 'username';
    const REQUIRES_PASSWORD = 'password';
    public function attempt(array $credentials);
    public function check($token);
    public function requires();
}

use illuminate\name\anothername\module;
use illuminate\name\anothername\othermodule as newmodule;



/**
 * Pandora FMS- http://pandorafms.com
 * ==================================================
 * Copyright (c) 2005-2009 Artica Soluciones Tecnologicas
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation for version 2.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
// Login check
check_login();
// Load global vars
global $config;
require_once 'include/functions_gis.php';
// ui_require_javascript_file('openlayers.pandora');
$buttons['gis_maps_list'] = [
    'active' => true,
    'text'   => '<a href="index.php?sec=godgismaps&sec2=operation/gis_maps/gis_map">'.html_print_image(
        'images/list.png',
        true,
        ['title' => __('GIS Maps list')]
    ).'</a>',
];
ui_print_page_header(
    __('GIS Maps'),
    'images/op_gis.png',
    false,
    'configure_gis_map',
    false,
    $buttons
);
$own_info = get_user_info($config['id_user']);
if ($own_info['is_admin'] || check_acl($config['id_user'], 0, 'MM')) {
    $display_default_column = true;
} else {
    $display_default_column = false;
}
$edit_gis_maps = false;
if (check_acl($config['id_user'], 0, 'MW') || check_acl($config['id_user'], 0, 'MM')) {
    $edit_gis_maps = true;
}
if (is_ajax()) {
    $action = get_parameter('action');
    $id_map = get_parameter('id_map');
    // Set to not default the actual default map
    $returnOperationDB = db_process_sql_update('tgis_map', ['default_map' => 0], ['default_map' => 1]);
    // Set default the new default map
    $returnOperationDB = db_process_sql_update('tgis_map', ['default_map' => 1], ['id_tgis_map' => $id_map]);
    if ($returnOperationDB === false) {
        $data['correct'] = false;
    } else {
        $data['correct'] = true;
    }
    echo json_encode($data);
    return;
}
$action = get_parameter('action');
switch ($action) {
    case 'delete_map':
        $idMap = get_parameter('map_id');
        $result = gis_delete_map($idMap);
        ui_print_result_message(
            $result,
            __('Successfully deleted'),
            __('Could not be deleted')
        );
    break;
}
$maps = gis_get_maps();
$table = new stdClass();
$table->width = '100%';
$table->class = 'info_table';
$table->head = [];
$table->head['name'] = __('Name');
$table->head['group'] = __('Group');
if ($edit_gis_maps) {
    if ($display_default_column) {
        $table->head['default'] = __('Default');
    }
    $table->head['op'] = '<span title="Operations">'.__('Op.').'</span>';
}
$table->headstyle = [];
$table->headstyle['name'] = 'text-align: left;';
$table->headstyle['group'] = 'text-align: center;';
if ($edit_gis_maps) {
    if ($display_default_column) {
        $table->headstyle['default'] = 'text-align: center;';
    }
    $table->headstyle['op'] = 'text-align: center;';
}
$table->size = [];
$table->size['name'] = '80%';
$table->size['group'] = '30';
if ($edit_gis_maps) {
    if ($display_default_column) {
        $table->size['default'] = '30';
    }
    $table->size['op'] = '60';
}
$table->align = [];
$table->align['name'] = 'left';
$table->align['group'] = 'center';
if ($edit_gis_maps) {
    if ($display_default_column) {
        $table->align['default'] = 'center';
    }
    $table->align['op'] = 'center';
}
$table->data = [];
$rowPair = true;
$iterator = 0;
if ($maps !== false) {
    foreach ($maps as $map) {
        if (!check_acl($config['id_user'], $map['group_id'], 'MR')
            && !check_acl($config['id_user'], $map['group_id'], 'MW')
            && !check_acl($config['id_user'], $map['group_id'], 'MM')
        ) {
            continue;
        }
        if ($rowPair) {
            $table->rowclass[$iterator] = 'rowPair';
        } else {
            $table->rowclass[$iterator] = 'rowOdd';
        }
        $rowPair = !$rowPair;
        $iterator++;
        $data = [];
        $data['name'] = '<a href="index.php?sec=gismaps&amp;sec2=operation/gis_maps/render_view&amp;map_id='.$map['id_tgis_map'].'">'.$map['map_name'].'</a> ';
        $data['group'] = ui_print_group_icon($map['group_id'], true);
        if ($edit_gis_maps) {
            if ($display_default_column) {
                $checked = false;
                if ($map['default_map']) {
                    $checked = true;
                    $defaultMapId = $map['id_tgis_map'];
                }
                $data['default'] = html_print_radio_button_extended('default_map', $map['id_tgis_map'], '', $checked, false, 'setDefault('.$map['id_tgis_map'].');', '', true);
            }
            $table->cellclass[]['op'] = 'action_buttons';
            $data['op'] = '<a href="index.php?sec=godgismaps&amp;sec2=godmode/gis_maps/configure_gis_map&map_id='.$map['id_tgis_map'].'&amp;action=edit_map">'.html_print_image('images/config.png', true, ['title' => __('Edit')]).'</a>'.'<a href="index.php?sec=godgismaps&amp;sec2=operation/gis_maps/gis_map&amp;map_id='.$map['id_tgis_map'].'&amp;action=delete_map" onclick="return confirmDelete();">'.html_print_image('images/cross.png', true, ['title' => __('Delete')]).'</a>';
        }
        array_push($table->data, $data);
    }
}
if (!empty($table->data)) {
    html_print_table($table);
} else {
    echo '<div class="nf">'.__('No maps found').'</div>';
}
if ($edit_gis_maps) {
    echo '<div class="action-buttons" style="width: '.$table->width.'">';
    echo '<form action="index.php?sec=godgismaps&amp;sec2=godmode/gis_maps/configure_gis_map" method="post">';
    html_print_input_hidden('action', 'new_map');
    html_print_submit_button(__('Create'), '', false, 'class="sub next"');
    echo '</form>';
    echo '</div>';
}
unset($table);
?>


