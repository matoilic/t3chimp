#2.5.0
- T3Chimp uses now PHP streams instead of cURL to enable a less error prone network communication
- Tested compatibility with TYPO3 7.0
- T3Chimp now requires at least PHP 5.4.0
- If you've installed Suhosin [make sure that it allows the usage of PHAR archives](https://github.com/matoilic/t3chimp/wiki/Installation#suhosin)

#2.4.1
- Fixes a TypoScript configuration issue under PHP 5.3.x which causes AJAX requests to have no parameters
- Adds a better possibility to style error and success messages
- Prevents form validation to check for captcha in CLI mode (submitted by [Ingo Renner](https://github.com/irnnr))
- Fixes compatibility issues with tt_content (submitted by [Remo Häusler](https://github.com/r3h6))

#2.4.0
- Adds a JavaScript based CAPTCHA function (no user interaction required)
- Fixes the plugin configuration in multi-page setups (submitted by [Remo Häusler](https://github.com/r3h6))

#2.3.1
- Optimized cURL calls for more restrictive server setups

#2.3.0
- Added the possibility to [customize T3Chimp through the Signal / Slot API](https://github.com/matoilic/t3chimp/wiki/Integrating-with-T3Chimp)

#2.2.2
- Fixed detection of IE 11

# 2.2.1
- Fixed wrong template tags that were introduced during the automatic change of translation keys in v2.2.0

# 2.2.0
- Fixed a bug in the API that showed a wrong error message
- Moved all translation files to xliff format (thanks to Mark Howells-Mead for the help)
- All texts are now translatable using TypoScript, [read it up here](https://github.com/matoilic/t3chimp/wiki/Custom-Translations)
- Added Dutch country list translation

# 2.1.0
- Improved the handling of settings during AJAX requests → **[you need to update your templates](https://github.com/matoilic/t3chimp/wiki/Upgrading-from-2.0.x-to-2.1.x)**
- Improved error handling for MailChimp API calls

# 2.0.6
- Fixed a incompatibility with RealURL where forms sometimes would have an empty action
- Removed all use statements from ext_tables.php since it can cause conflicts with other extensions
- Adapted the API calls so that it allows redirects with curl even when open_basedir is set or safe_mode is turned on
- Fixed some warnings

# 2.0.5
- Fixed further MailChimp API v2 incompatibilities

# 2.0.4
- Fixed an issue where the unsubscription form would always be invalid

# 2.0.3
- Fixed missing namespace import

# 2.0.2
- Fixed MailChimp API v2 incompatibilities

# 2.0.1
- Fixed #14, an issue with the field provider for the sync task, where the class from a wrong namespace got imported

# 2.0.0
- Refactored code to use v2 of the MailChimp API
- Refactored code to use namespaces
- Dropped support for TYPO3 versions older than 6.1 (1.x still supports older installations and will get bugfix updates until the EOL of TYPO3 4.7)
- Removed the "Use secure connection" option, since the new API always uses SSL
- Added option to allow the users to choose the email format

#1.5.4
- Fixed detection of IE 11

# 1.5.3
- Dutch translations by Jeroen Vanheste from tidi.be

# 1.5.2
- Added option to disable the welcome email
- Minor bug fixes

# 1.5.1
- Fixed rendering issue in 4.5.x

# 1.5.0
- Configuration issues fixed
- Optimized the extension for extensibility through other extensions
- Disabled the backend module since MailChimp doesn't seem to allow to load the page within an iframe anymore

# 1.4.2
- Adapted dependency configuration so that it gets processed properly by the new TER release

# 1.4.1
- Fixed API key configuration for 4.x

# 1.4.0
- Added the possibilities to configure site specific API keys and to adapt the country selection

# 1.3.1
- Fixed some issues with group synchronization

# 1.3.0
- Added possibility to set interest groupings when synchronizing subscribers

# 1.2.0
- Added a configurable blank option to select fields
- Fixed compatibility issue with 4.5.x
- Hidden fields are no longer rendered
- Improved error logging

# 1.1.1
- Fixed an issue where Internet Explorer would not handle AJAX responses of type application/json properly

# 1.1.0
- Removed dependency on static_info_tables

# 1.0.3
- Fixed TYPO3 6.1 compatibility

# 1.0.2
- Added missing support for radios and dropdown interest grouping field types

# 1.0.1
- Fixed a bug where commas in interest grouping names would cause an error

# 1.0.0
- Added frontend user synchronization

# 0.4.8
- Fixed further issues that can occur when doing Ajax requests in TYPO3

# 0.4.7
- Fixed several issues that can occur when doing Ajax requests in TYPO3

# 0.4.6
- Removed dependency on t3jquery
- Bundled custom jQuery version, since other plugin repeatedly cause conflicts with their own jQuery versions

# 0.4.5
- Minor bug fixes
- Typo3 6.0 compatibility

# 0.4.4
- Fixed further autoload issues

# 0.4.3
- Generated autoload registry to fix autoload issues

# 0.4.2
- Improved error handling

# 0.4.1
- Fixed compatibility with TYPO3 4.6.x and 4.7.x
- Added check for proper jQuery version

# 0.4.0
- First public release
