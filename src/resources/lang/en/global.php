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
    'error_empty_item_field' => ' No items from your inserted items are bought at this moment by your corporation. Please check your item list!',
    'error_too_much_items' => 'Too much items posted. Max allowed items: :count',
    'error_price_provider_down' => 'PriceProviderError! Seems that the selected price provider is down at the moment. Please try a different one over the buyback admin section',
    'error_item_parser_format' => 'Bad Data Format! Please check the right format of your data!',
    'currency' => 'ISK',
    'step_one_label' => '1. Start a Corp-Buyback Request',
    'step_one_introduction' => 'Copy your EVE items with ( CTRL + A & CTRL + C ) in your inventory and paste them with ( CTRL + V ) into the input field below and press on the "Send" button',
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
    'step_three_contract_tip' => 'You can click on the results marked with a * to copy them directly to your clipboard.',
    'step_three_contract_tip_title' => 'Tip:',
    'max_allowed_items' => 'Max allowed Items per Buyback:',
    'admin_title' => 'Add Item Config',
    'admin_description' => 'Fill out the form below and press the add button to generate a new item config entry',
    'admin_group_title' => 'Item Overview',
    'admin_group_table_item_name' => 'ItemName',
    'admin_group_table_jita' => ' Jita',
    'admin_group_table_percentage' => 'Percentage',
    'admin_group_table_price' => 'Price',
    'admin_group_table_market_name' => 'Market Group Name',
    'admin_group_table_actions' => 'Actions',
    'admin_group_table_button' => ' Remove',
    'admin_discord_title' => 'Discord Settings',
    'admin_discord_first_title' => 'Webhook',
    'admin_discord_webhook_url_label' => 'URL',
    'admin_discord_webhook_url_description' => 'Set a Discord channel webhook url where the notifications will be send to',
    'admin_discord_webhook_status_label' => 'Status ',
    'admin_discord_webhook_status_description' => 'Enable or Disabled Discord notifications',
    'admin_discord_button' => 'Update',
    'admin_discord_error_url' => 'This is not a Discord webhook url',
    'admin_discord_error_curl' => 'It was not possible to send the discord notification. Please check your discord settings!',
    'admin_setting_title' => 'Buyback Plugin Settings',
    'admin_setting_first_title' => 'General',
    'admin_setting_cache_label' => 'Price Cache Time',
    'admin_setting_cache_description' => 'Please enter the time in seconds that items prices should be cached.',
    'admin_setting_allowed_items_label' => 'Max Items Allowed',
    'admin_setting_allowed_items_description' => ' Please enter the maximum number of items that are allowed per buyback request',
    'admin_setting_price_provider_label' => 'Price Provider',
    'admin_setting_price_provider_description' => ' Select the price provider you want to fetch the item prices from',
    'admin_setting_second_title' => 'Contract',
    'admin_setting_contract_to_label' => 'Contract to',
    'admin_setting_contract_to_description' => 'Enter the name of the character that should be in the "Contract to" field',
    'admin_setting_expiration_label' => 'Expiration',
    'admin_setting_expiration_description' => 'Choose a contract expiration option',
    'admin_setting_button' => 'Update',
    'admin_setting_error' => 'Admin setting: :message could not be found! Please check your database records!',
    'admin_setting_key_error' => 'Admin setting key: :message could not be found! Please check your database records!',
    'admin_select_placeholder' => 'Type to select an item',
    'admin_item_select_label' => 'Select an item',
    'admin_item_select_description' => 'Select an item you wanna add to the item config below.',
    'admin_item_percentage_label' => 'Percentage (%)',
    'admin_item_percentage_description' => 'Choose a value between 1% and 99%.',
    'admin_item_price_label' => 'Price (ISK)',
    'admin_item_price_description' => 'If you set a price this price will be taken for the calculation and the percentage will be ignored',
    'admin_item_jita_label' => 'Jita',
    'admin_item_jita_description' => 'Choose if you want to set the percentage value under or above Jita. (Example: 5% under Jita = 95% of the item price)',
    'admin_error_config' => 'There is already a config for Id: ',
    'admin_success_config' => 'Admin config successfully updated.',
    'admin_success_market_add' => 'Market config successfully added.',
    'admin_success_market_remove' => 'Market config successfully deleted.',
    'contract_introduction' => 'In this section you are able to manage all the incoming buyback requests. Doing a click on a request entry will open the details. The idea behind this section is to differ the ingame contracts with the buyback requests. As last step you can delete or finish a buyback request.',
    'contract_error_no_items' => 'No contracts found yet!',
    'contract_success_submit' => 'Contract with ID: :id successfully submitted.',
    'contract_success_deleted' => 'Contract with ID: :id successfully deleted.',
    'contract_success_succeeded' => 'Contract with ID: :id successfully marked as succeeded.',
    'my_contract_introduction' => 'In this section you are able to manage your created and pending buyback contracts. If you wanna delete a pending contract press on the delete button. Don\'t forget to cancel also the contract ingame. Buyback contracts that are finished by your corp are shown under the closed contracts section. Clicking on a contract will show you the contract details.',
    'my_contracts_open_title' => 'Open Contracts',
    'my_contracts_open_error' => 'No open contracts found',
    'my_contracts_closed_title' => 'Closed Contracts',
    'my_contracts_closed_error' => 'No closed contracts found'
];
