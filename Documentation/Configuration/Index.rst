.. include:: ../Includes.txt

.. _installation:

=============
Configuration
=============

Get Bearer Token
----------------

To get a new application key to access the Twitter API please go to https://developer.twitter.com/en/apps

Hit the "Create an app" button there.

If not already done, follow the dialog to create an developer account.

After filling the application form and confirming the email address, you can create a project on the dashboard.

Sorry for the inconvenience, but the key is connected to the developer account with all consequences.

We only need the Bearer token which should be generated for your app.

One word of advice, an application has a usage cap of 500.000 tweets.


Access Token
------------

There are three possible locations for the Bearer Token.

- the Extension Configuration
- TypoScript plugin settings
- Plugin flexform field


Required configuration
----------------------

Search term AND Limit are required to be configured, either by TypoScript or by FlexForm
