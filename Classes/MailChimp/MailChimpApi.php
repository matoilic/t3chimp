<?php

namespace MatoIlic\T3Chimp\MailChimp;

require_once(__DIR__ . '/../../guzzle.phar');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Ring\Client\ClientUtils;
use GuzzleHttp\Ring\Client\StreamHandler;
use GuzzleHttp\Stream\Stream;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Campaigns;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Ecomm;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Error;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Folders;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Gallery;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Helper;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Lists;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Mobile;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Neapolitan;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Reports;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Templates;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Users;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Vip;

class MailChimpApi {
    /**
     * Placeholder attribute for Folders class
     *
     * @var Folders
     */
    public $folders;

    /**
     * Placeholder attribute for Templates class
     *
     * @var Templates
     */
    public $templates;

    /**
     * Placeholder attribute for Users class
     *
     * @var Users
     */
    public $users;

    /**
     * Placeholder attribute for Helper class
     *
     * @var Helper
     * @access public
     */
    public $helper;

    /**
     * Placeholder attribute for Mobile class
     *
     * @var Mobile
     */
    public $mobile;

    /**
     * Placeholder attribute for Ecomm class
     *
     * @var Ecomm
     */
    public $ecomm;

    /**
     * Placeholder attribute for Neapolitan class
     *
     * @var Neapolitan
     */
    public $neapolitan;

    /**
     * Placeholder attribute for Lists class
     *
     * @var Lists
     */
    public $lists;

    /**
     * Placeholder attribute for Campaigns class
     *
     * @var Campaigns
     */
    public $campaigns;
    /**
     * Placeholder attribute for Vip class
     *
     * @var Vip
     */
    public $vip;

    /**
     * Placeholder attribute for Reports class
     *
     * @var Reports
     */
    public $reports;

    /**
     * Placeholder attribute for Gallery class
     *
     * @var Gallery
     */
    public $gallery;

    /**
     * the api key in use
     * @var  string
     */
    public $apiKey;

    /**
     * HTTP client
     * @var Client
     */
    public $client;

    /**
     * api endpoint
     * @var string
     */
    public $root = 'https://api.mailchimp.com/2.0';

    /**
     * whether debug mode is enabled
     * @var  bool
     */
    public $debug = FALSE;

    public static $errorMap = array(
        "ValidationError" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ValidationError",
        "ServerError_MethodUnknown" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ServerErrorMethodUnknown",
        "ServerError_InvalidParameters" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ServerErrorInvalidParameters",
        "Unknown_Exception" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UnknownException",
        "Request_TimedOut" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\RequestTimedOut",
        "Zend_Uri_Exception" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ZendUriException",
        "PDOException" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\PdoException",
        "Avesta_Db_Exception" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AvestaDbException",
        "XML_RPC2_Exception" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\XmlRpc2Exception",
        "XML_RPC2_FaultException" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\XmlRpc2FaultException",
        "Too_Many_Connections" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\TooManyConnections",
        "Parse_Exception" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ParseException",
        "User_Unknown" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserUnknown",
        "User_Disabled" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDisabled",
        "User_DoesNotExist" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDoesNotExist",
        "User_NotApproved" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserNotApproved",
        "Invalid_ApiKey" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidApiKey",
        "User_UnderMaintenance" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserUnderMaintenance",
        "Invalid_AppKey" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidAppKey",
        "Invalid_IP" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidIp",
        "User_DoesExist" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDoesExist",
        "User_InvalidRole" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserInvalidRole",
        "User_InvalidAction" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserInvalidAction",
        "User_MissingEmail" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserMissingEmail",
        "User_CannotSendCampaign" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserCannotSendCampaign",
        "User_MissingModuleOutbox" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserMissingModuleOutbox",
        "User_ModuleAlreadyPurchased" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserModuleAlreadyPurchased",
        "User_ModuleNotPurchased" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserModuleNotPurchased",
        "User_NotEnoughCredit" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserNotEnoughCredit",
        "MC_InvalidPayment" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McInvalidPayment",
        "List_DoesNotExist" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListDoesNotExist",
        "List_InvalidInterestFieldType" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidInterestFieldType",
        "List_InvalidOption" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidOption",
        "List_InvalidUnsubMember" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidUnsubMember",
        "List_InvalidBounceMember" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidBounceMember",
        "List_AlreadySubscribed" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListAlreadySubscribed",
        "List_NotSubscribed" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListNotSubscribed",
        "List_InvalidImport" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidImport",
        "MC_PastedList_Duplicate" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McPastedListDuplicate",
        "MC_PastedList_InvalidImport" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McPastedListInvalidImport",
        "Email_AlreadySubscribed" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailAlreadySubscribed",
        "Email_AlreadyUnsubscribed" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailAlreadyUnsubscribed",
        "Email_NotExists" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailNotExists",
        "Email_NotSubscribed" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailNotSubscribed",
        "List_MergeFieldRequired" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListMergeFieldRequired",
        "List_CannotRemoveEmailMerge" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListCannotRemoveEmailMerge",
        "List_Merge_InvalidMergeID" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListMergeInvalidMergeId",
        "List_TooManyMergeFields" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListTooManyMergeFields",
        "List_InvalidMergeField" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidMergeField",
        "List_InvalidInterestGroup" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidInterestGroup",
        "List_TooManyInterestGroups" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListTooManyInterestGroups",
        "Campaign_DoesNotExist" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignDoesNotExist",
        "Campaign_StatsNotAvailable" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignStatsNotAvailable",
        "Campaign_InvalidAbsplit" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidAbsplit",
        "Campaign_InvalidContent" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidContent",
        "Campaign_InvalidOption" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidOption",
        "Campaign_InvalidStatus" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidStatus",
        "Campaign_NotSaved" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignNotSaved",
        "Campaign_InvalidSegment" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidSegment",
        "Campaign_InvalidRss" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidRss",
        "Campaign_InvalidAuto" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidAuto",
        "MC_ContentImport_InvalidArchive" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McContentImportInvalidArchive",
        "Campaign_BounceMissing" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignBounceMissing",
        "Campaign_InvalidTemplate" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidTemplate",
        "Invalid_EcommOrder" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidEcommOrder",
        "Absplit_UnknownError" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownError",
        "Absplit_UnknownSplitTest" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownSplitTest",
        "Absplit_UnknownTestType" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownTestType",
        "Absplit_UnknownWaitUnit" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownWaitUnit",
        "Absplit_UnknownWinnerType" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownWinnerType",
        "Absplit_WinnerNotSelected" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitWinnerNotSelected",
        "Invalid_Analytics" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidAnalytics",
        "Invalid_DateTime" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidDateTime",
        "Invalid_Email" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidEmail",
        "Invalid_SendType" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidSendType",
        "Invalid_Template" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidTemplate",
        "Invalid_TrackingOptions" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidTrackingOptions",
        "Invalid_Options" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidOptions",
        "Invalid_Folder" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidFolder",
        "Invalid_URL" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidURL",
        "Module_Unknown" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ModuleUnknown",
        "MonthlyPlan_Unknown" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\MonthlyPlanUnknown",
        "Order_TypeUnknown" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\OrderTypeUnknown",
        "Invalid_PagingLimit" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidPagingLimit",
        "Invalid_PagingStart" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidPagingStart",
        "Max_Size_Reached" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\MaxSizeReached",
        "MC_SearchException" => "MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McSearchException"
    );

    public function __construct($apiKey=NULL, $opts=array()) {
        if(!$apiKey) $apiKey = getenv('MAILCHIMP_APIKEY');
        if(!$apiKey) $apiKey = $this->readConfigs();
        if(!$apiKey) throw new Error('You must provide a MailChimp API key');

        $this->apiKey = $apiKey;
        $dc = "us1";

        if (strstr($this->apiKey, "-")){
            list($key, $dc) = explode("-", $this->apiKey, 2);
            if (!$dc) $dc = "us1";
        }

        $this->root = str_replace('https://api', 'https://' . $dc . '.api', $this->root);
        $this->root = rtrim($this->root, '/') . '/';

        if (isset($opts['debug'])){
            $this->debug = TRUE;
        }

        $handler = new StreamHandler();
        $this->client = new Client(array('handler' => $handler));
        $this->client->setDefaultOption('connect_timeout', 6);
        $this->client->setDefaultOption('timeout', 6);
        $this->client->setDefaultOption('exceptions', false);

        try {
            $ca = ClientUtils::getDefaultCaBundle();

            if(strlen($ca) === 0) {
                $this->client->setDefaultOption('verify', false);
                trigger_error(ClientUtils::CA_ERR, E_USER_WARNING);
            }
        } catch(\RuntimeException $ex) {
            $this->client->setDefaultOption('verify', false);
            trigger_error(ClientUtils::CA_ERR, E_USER_WARNING);
        }


        $this->folders = new Folders($this);
        $this->templates = new Templates($this);
        $this->users = new Users($this);
        $this->helper = new Helper($this);
        $this->mobile = new Mobile($this);
        $this->ecomm = new Ecomm($this);
        $this->neapolitan = new Neapolitan($this);
        $this->lists = new Lists($this);
        $this->campaigns = new Campaigns($this);
        $this->vip = new Vip($this);
        $this->reports = new Reports($this);
        $this->gallery = new Gallery($this);
    }

    public function call($url, $params) {
        $params['apikey'] = $this->apiKey;
        $params = json_encode($params);

        $request = $this->client->createRequest('POST', $this->root . $url . '.json');
        $request->setBody(Stream::factory($params));
        $request->setHeader('Content-Type', 'application/json');
        $request->setHeader('User-Agent', 'TYPO3-T3Chimp/2.5');

        try {
            $response = $this->client->send($request);
        } catch(RequestException $ex) {
            $response = $ex->getResponse();
        }

        $responseCode = $response->getStatusCode();

        if($responseCode === 200 || $responseCode >= 400) {
            $result = json_decode($response->getBody(), TRUE);

            if($responseCode === 200) {
                return $result;
            }

            $this->castError($result);
        } else {
            trigger_error('A network error occurred (' . $responseCode . '). Could not reach the MailChimp API endpoint.', E_USER_ERROR);
        }
    }

    public function readConfigs() {
        $paths = array('~/.mailchimp.key', '/etc/mailchimp.key');
        foreach($paths as $path) {
            if(file_exists($path)) {
                $apiKey = trim(file_get_contents($path));
                if($apiKey) return $apiKey;
            }
        }
        return FALSE;
    }

    public function castError($result) {
        if($result['status'] !== 'error' || !$result['name']) throw new Error('We received an unexpected error: ' . json_encode($result));

        $class = (isset(self::$errorMap[$result['name']])) ? self::$errorMap[$result['name']] : 'MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\Error';

        if(TYPO3_version < '7.1.0') {
            $class = '\\' . $class;
        }

        return new $class($result['error'], $result['code']);
    }

    public function log($msg) {
        if($this->debug) {
            $GLOBALS['BE_USER']->writeLog(4, 0, 0, 0, '[t3chimp]: ' . $msg);
        }
    }
}


