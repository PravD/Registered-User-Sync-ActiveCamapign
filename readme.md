
# Registered User Sync ActiveCampaign

## Description 

Its very helpfull plugin for wordpress users. It adds the registered user in wordpress to ActiveCampaign's list. 
This plugin can be used in multiple ways. A custom trigger is available to add the registered user when you needed.
Also, a automatic control on sync users. Just select you list id, and little settings your plugin is ready to sync the users.

## Requirements

* API URL
* API key
* List Id if you need to sync the data with different list.

## Hooks 

Plugin is having multiple hooks to gain more control on plugin's data

## Filters
* rusac_fetch_api_details
* rusac_load_settings
* rusac_fetch_registered_user_data

### Actions
* rusac_before_send_data_to_ac
* rusac_after_sent_data_to_ac

### Custom Triggers
* rusac_add_new_address
* rusac_edit_address

## Why Choose Registered User Sync ActiveCampaign?

### Registered User Sync ActiveCampaign is a great plugin for: 

* It adds the registered users to the ActiveCampaigns.
* It syncs the mulyiple user roles with the active campaigns.

### Usage

Use custom trigger (action to register user on ActiveCampaign)

* do_action( 'rusac_add_new_address' , $user_id );

Use custom trigger (action to Edit user on ActiveCampaign)

* do_action( 'rusac_edit_address' , $user_id );

Use Auto Sync option

* Go to plugin's settings and set Sync option On.

## Installation

1. Upload the contents of `/registered-user-sync-activecampaign/` to the `/wp-content/plugins/` directory
2. Activate Registered User Sync ActiveCampaign through the 'Plugins' menu in WordPress


## Frequently Asked Questions 

#### Is Active Campaign account Required?
> Yes 

#### What does this plugin do? 
>This plugin adds feature to sync already registered users to the "Active Campaign"

#### Can the synchronization process be controlled? 
>Yes there are various settings to control the synchronization process.

#### Can I choose which users to be synced according to their user roles? 
>Yes, the plugins lists all of the user roles in the wordpress website and allows you to control which users to get synced with "Active Campaigns"

#### How to generate Active Campaign API credentials? 
>You can follow this link 
https://help.activecampaign.com/hc/en-us/articles/207317590-Getting-started-with-the-API

## Changelog

### v1.2.2
* Release Date: December 6th, 2019

#### Improvements:
* Added FAQ to help users in setup the plugin
Bugfixes:
* Tested the plugin with wordpress 5.3 version

### v1.2
* Release Date: April 26th, 2019

#### Bugfixes:

* Error on variable rusac_sync_schedule
* Tested the plugin with wordpress 5.1.1 version

### v1.1.6
* Release Date: November 20th, 2018

#### Enhancements:

* Adds the debug window to debug the requests and results of the API
* Adds new settings.
* Adds the tag removal function. If any of contact needed to remove tags in the ActiveCampaign.

#### Bugfixes:

* Fixes a bug where the profile update trigger were unable to update the profile in ActiveCampaign.
* Fixes a bug where the profile update custom triggers were unable to update the profile in ActiveCampaign.

### v1.1.5
* Release Date: Octomber 20th, 2018

#### Enhancements:

* Adds the debug window to debug option
* Adds new settings for debug.
* Adds the email change hook for updating existing user in ActiveCampaign.

#### Bugfixes:

* Fixes the user edit bug.
