<?php

$base = dirname(__FILE__) . '/';
return array(
    'mcapi' => $base . 'Lib/MCAPI.class.php',
    'settingsprovider' => $base . 'Lib/SettingsProvider.php',
    'tx_t3chimp_service_mailchimp' => $base . 'Classes/Service/MailChimp.php',
    'tx_t3chimp_core_bootstrap' => $base . 'Classes/Core/Bootstrap.php',
    'mailchimp_form' => $base . 'Lib/MailChimp/Form.php',
    'mailchimp_field' => $base . 'Lib/MailChimp/Field.php',
    'mailchimp_field_abstract' => $base . 'Lib/MailChimp/Field/Abstract.php',
    'mailchimp_field_action' => $base . 'Lib/MailChimp/Field/Action.php',
    'mailchimp_field_dropdown' => $base . 'Lib/MailChimp/Field/Dropdown.php',
    'mailchimp_field_email' => $base . 'Lib/MailChimp/Field/Email.php',
    'mailchimp_field_radio' => $base . 'Lib/MailChimp/Field/Radio.php',
    'mailchimp_field_text' => $base . 'Lib/MailChimp/Field/Text.php',
    'mailchimp_field_checkboxes' => $base . 'Lib/MailChimp/Field/Checkboxes.php',
    'mailchimp_field_interestgrouping' => $base . 'Lib/MailChimp/Field/InterestGrouping.php',
    'mailchimp_field_helper_choice' => $base . 'Lib/MailChimp/Field/Helper/Choice.php',
    'mailchimp_field_helper_multichoice' => $base . 'Lib/MailChimp/Field/Helper/MultiChoice.php',
);