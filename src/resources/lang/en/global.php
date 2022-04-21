<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015 to 2020 Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

return [
    'browser_title' => 'Corporation Buyback',
    'page_title' => 'Corporation Buyback',
    'admin_browser_title' => 'Corporation Buyback Settings',
    'admin_page_title' => 'Corporation Buyback Settings',
    'contract_browser_title' => 'Corporation Buyback Contracts',
    'contract_page_title' => 'Corporation Buyback Contracts',
    'character_contract_browser_title' => 'My Buyback Contracts',
    'character_contract_page_title' => 'My Buyback Contracts',
    'page_subtitle' => 'Corporation Buyback',
    'itemcheck.error' => 'Please don\'t send an empty form field',
    'error' => 'An error occurred!',
    'empty_item_field' => 'No items that could be used found! Please check you item list!',
    'currency' => 'ISK',
    'step_one_label' => '1. Start a Corp-Buyback Request',
    'step_one_introduction' => 'Copy and paste your Items into the input field and press on the "Send" button',
    'step_one_button' => 'Send',
    'step_two_label' => '2. Contract Item Overview',
    'step_two_introduction' => 'Please check the items and prices before you create the contract',
    'step_two_item_table_title' => 'Item list',
    'step_two_ignored_table_title' => ' Ignored Items ( Not bought )',
    'step_two_summary' => 'Summary',
    'step_three_label' => '3. Your contract',
    'step_three_introduction' => 'Please create a contract with the data shown below',
    'step_three_button' => 'Confirm',
    'step_three_contract_type' => 'Contract type',
    'step_three_contract_to' => 'Contract to',
    'step_three_contract_receive' => 'I will receive',
    'step_three_contract_expiration' => 'Expiration',
    'step_three_contract_description' => 'Description',
    'max_allowed_items' => 'Max allowed Items:',
    'admin_title' => 'Add Group Config',
    'admin_description' => 'Fill out the form below and press the add button to generate a new item config entry',
    'admin_group_title' => 'Group Overview',
    'admin_group_table_item_name' => 'ItemName',
    'admin_group_table_jita' => ' Jita',
    'admin_group_table_percentage' => 'Percentage',
    'admin_group_table_market_name' => 'Market Group Name',
    'admin_group_table_actions' => 'Actions',
    'admin_group_table_button' => ' Remove',
    'admin_setting_title' => 'Buyback Plugin Settings',
    'admin_setting_first_title' => 'General',
    'admin_setting_cache_label' => 'Price Cache Time',
    'admin_setting_cache_description' => 'Please enter the time in seconds that items prices should be cached.',
    'admin_setting_allowed_items_label' => 'Max Items Allowed',
    'admin_setting_allowed_items_description' => ' Please enter the maximum number of items that are allowed per request',
    'admin_setting_second_title' => 'Contract',
    'admin_setting_contract_to_label' => 'Contract to',
    'admin_setting_contract_to_description' => 'Enter the name of the character that should be in the "Contract to" field',
    'admin_setting_expiration_label' => 'Expiration',
    'admin_setting_expiration_description' => 'Choose a contract expiration option',
    'admin_setting_button' => 'Update',
    'admin_setting_error' => 'Admin setting: :message could not be found! Please check your database records!',
    'admin_setting_key_error' => 'Admin setting key: :message could not be found! Please check your database records!',
    'admin_select_placeholder' => 'Select item',
    'admin_error_config' => 'There is already a config for Id: ',
    'admin_success_config' => 'Admin config successfully updated.',
    'admin_success_market_add' => 'Market config successfully added.',
    'admin_success_market_remove' => 'Market config successfully deleted.',
    'contract_error_no_items' => 'No contracts found yet!',
    'contract_success_submit' => 'Contract with ID: :id successfully submitted.',
    'contract_success_deleted' => 'Contract with ID: :id successfully deleted.',
    'contract_success_succeeded' => 'Contract with ID: :id successfully marked as succeeded.',
    'my_contracts_open_title' => 'Open Contracts',
    'my_contracts_open_error' => 'No open contracts found',
    'my_contracts_closed_title' => 'Closed Contracts',
    'my_contracts_closed_error' => 'No closed contracts found'
];
