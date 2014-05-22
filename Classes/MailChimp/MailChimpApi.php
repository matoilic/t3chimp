<?php

namespace MatoIlic\T3Chimp\MailChimp;

use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Campaigns;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Ecomm;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Error;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Folders;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Gallery;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Helper;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\HttpError;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Lists;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Mobile;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Neapolitan;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Reports;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Templates;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Users;
use MatoIlic\T3Chimp\MailChimp\MailChimpApi\Vip;

class MailChimpApi {
    const CURL_MAX_REDIRECTS = 10;

    private static $curlCodes = array(
        'CURL_OK',
        'CURLE_UNSUPPORTED_PROTOCOL',
        'CURLE_FAILED_INIT',
        'CURLE_URL_MALFORMAT',
        'CURLE_URL_MALFORMAT_USER',
        'CURLE_COULDNT_RESOLVE_PROXY',
        'CURLE_COULDNT_RESOLVE_HOST',
        'CURLE_COULDNT_CONNECT',
        'CURLE_FTP_WEIRD_SERVER_REPLY',
        'CURLE_REMOTE_ACCESS_DENIED',
        'CURLE_FTP_WEIRD_PASS_REPLY',
        'CURLE_FTP_WEIRD_PASV_REPLY',
        'CURLE_FTP_WEIRD_227_FORMAT',
        'CURLE_FTP_CANT_GET_HOST',
        'CURLE_FTP_COULDNT_SET_TYPE',
        'CURLE_PARTIAL_FILE',
        'CURLE_FTP_COULDNT_RETR_FILE',
        'CURLE_QUOTE_ERROR',
        'CURLE_HTTP_RETURNED_ERROR',
        'CURLE_WRITE_ERROR',
        'CURLE_UPLOAD_FAILED',
        'CURLE_READ_ERROR',
        'CURLE_OUT_OF_MEMORY',
        'CURLE_OPERATION_TIMEDOUT',
        'CURLE_FTP_PORT_FAILED',
        'CURLE_FTP_COULDNT_USE_REST',
        'CURLE_RANGE_ERROR',
        'CURLE_HTTP_POST_ERROR',
        'CURLE_SSL_CONNECT_ERROR',
        'CURLE_BAD_DOWNLOAD_RESUME',
        'CURLE_FILE_COULDNT_READ_FILE',
        'CURLE_LDAP_CANNOT_BIND',
        'CURLE_LDAP_SEARCH_FAILED',
        'CURLE_FUNCTION_NOT_FOUND',
        'CURLE_ABORTED_BY_CALLBACK',
        'CURLE_BAD_FUNCTION_ARGUMENT',
        'CURLE_INTERFACE_FAILED',
        'CURLE_TOO_MANY_REDIRECTS',
        'CURLE_UNKNOWN_TELNET_OPTION',
        'CURLE_TELNET_OPTION_SYNTAX',
        'CURLE_PEER_FAILED_VERIFICATION',
        'CURLE_GOT_NOTHING',
        'CURLE_SSL_ENGINE_NOTFOUND',
        'CURLE_SSL_ENGINE_SETFAILED',
        'CURLE_SEND_ERROR',
        'CURLE_RECV_ERROR',
        'CURLE_SSL_CERTPROBLEM',
        'CURLE_SSL_CIPHER',
        'CURLE_SSL_CACERT',
        'CURLE_BAD_CONTENT_ENCODING',
        'CURLE_LDAP_INVALID_URL',
        'CURLE_FILESIZE_EXCEEDED',
        'CURLE_USE_SSL_FAILED',
        'CURLE_SEND_FAIL_REWIND',
        'CURLE_SSL_ENGINE_INITFAILED',
        'CURLE_LOGIN_DENIED',
        'CURLE_TFTP_NOTFOUND',
        'CURLE_TFTP_PERM',
        'CURLE_REMOTE_DISK_FULL',
        'CURLE_TFTP_ILLEGAL',
        'CURLE_TFTP_UNKNOWNID',
        'CURLE_REMOTE_FILE_EXISTS',
        'CURLE_TFTP_NOSUCHUSER',
        'CURLE_CONV_FAILED',
        'CURLE_CONV_REQD',
        'CURLE_SSL_CACERT_BADFILE',
        'CURLE_REMOTE_FILE_NOT_FOUND',
        'CURLE_SSH',
        'CURLE_SSL_SHUTDOWN_FAILED',
        'CURLE_AGAIN',
        'CURLE_SSL_CRL_BADFILE',
        'CURLE_SSL_ISSUER_ERROR',
        'CURLE_FTP_PRET_FAILED',
        'CURLE_FTP_PRET_FAILED',
        'CURLE_RTSP_CSEQ_ERROR',
        'CURLE_RTSP_SESSION_ERROR',
        'CURLE_FTP_BAD_FILE_LIST',
        'CURLE_CHUNK_FAILED'
    );

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
     * CURLOPT_SSL_VERIFYPEER setting
     * @var  bool
     */
    public $sslVerifyPeer = TRUE;

    /**
     * CURLOPT_SSL_VERIFYHOST setting
     * @var  bool
     */
    public $sslVerifyHost = 2;

    /**
     * CURLOPT_CAINFO
     * @var  string
     */
    public $sslCaInfo = NULL;

    /**
     * the api key in use
     * @var  string
     */
    public $apiKey;

    /**
     * curl resource
     * @var resource
     */
    public $ch;

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
        "ValidationError" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ValidationError",
        "ServerError_MethodUnknown" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ServerErrorMethodUnknown",
        "ServerError_InvalidParameters" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ServerErrorInvalidParameters",
        "Unknown_Exception" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UnknownException",
        "Request_TimedOut" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\RequestTimedOut",
        "Zend_Uri_Exception" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ZendUriException",
        "PDOException" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\PdoException",
        "Avesta_Db_Exception" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AvestaDbException",
        "XML_RPC2_Exception" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\XmlRpc2Exception",
        "XML_RPC2_FaultException" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\XmlRpc2FaultException",
        "Too_Many_Connections" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\TooManyConnections",
        "Parse_Exception" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ParseException",
        "User_Unknown" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserUnknown",
        "User_Disabled" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDisabled",
        "User_DoesNotExist" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDoesNotExist",
        "User_NotApproved" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserNotApproved",
        "Invalid_ApiKey" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidApiKey",
        "User_UnderMaintenance" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserUnderMaintenance",
        "Invalid_AppKey" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidAppKey",
        "Invalid_IP" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidIp",
        "User_DoesExist" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserDoesExist",
        "User_InvalidRole" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserInvalidRole",
        "User_InvalidAction" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserInvalidAction",
        "User_MissingEmail" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserMissingEmail",
        "User_CannotSendCampaign" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserCannotSendCampaign",
        "User_MissingModuleOutbox" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserMissingModuleOutbox",
        "User_ModuleAlreadyPurchased" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserModuleAlreadyPurchased",
        "User_ModuleNotPurchased" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserModuleNotPurchased",
        "User_NotEnoughCredit" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\UserNotEnoughCredit",
        "MC_InvalidPayment" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McInvalidPayment",
        "List_DoesNotExist" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListDoesNotExist",
        "List_InvalidInterestFieldType" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidInterestFieldType",
        "List_InvalidOption" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidOption",
        "List_InvalidUnsubMember" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidUnsubMember",
        "List_InvalidBounceMember" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidBounceMember",
        "List_AlreadySubscribed" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListAlreadySubscribed",
        "List_NotSubscribed" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListNotSubscribed",
        "List_InvalidImport" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidImport",
        "MC_PastedList_Duplicate" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McPastedListDuplicate",
        "MC_PastedList_InvalidImport" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McPastedListInvalidImport",
        "Email_AlreadySubscribed" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailAlreadySubscribed",
        "Email_AlreadyUnsubscribed" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailAlreadyUnsubscribed",
        "Email_NotExists" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailNotExists",
        "Email_NotSubscribed" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\EmailNotSubscribed",
        "List_MergeFieldRequired" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListMergeFieldRequired",
        "List_CannotRemoveEmailMerge" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListCannotRemoveEmailMerge",
        "List_Merge_InvalidMergeID" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListMergeInvalidMergeId",
        "List_TooManyMergeFields" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListTooManyMergeFields",
        "List_InvalidMergeField" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidMergeField",
        "List_InvalidInterestGroup" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListInvalidInterestGroup",
        "List_TooManyInterestGroups" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ListTooManyInterestGroups",
        "Campaign_DoesNotExist" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignDoesNotExist",
        "Campaign_StatsNotAvailable" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignStatsNotAvailable",
        "Campaign_InvalidAbsplit" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidAbsplit",
        "Campaign_InvalidContent" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidContent",
        "Campaign_InvalidOption" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidOption",
        "Campaign_InvalidStatus" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidStatus",
        "Campaign_NotSaved" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignNotSaved",
        "Campaign_InvalidSegment" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidSegment",
        "Campaign_InvalidRss" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidRss",
        "Campaign_InvalidAuto" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidAuto",
        "MC_ContentImport_InvalidArchive" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McContentImportInvalidArchive",
        "Campaign_BounceMissing" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignBounceMissing",
        "Campaign_InvalidTemplate" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\CampaignInvalidTemplate",
        "Invalid_EcommOrder" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidEcommOrder",
        "Absplit_UnknownError" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownError",
        "Absplit_UnknownSplitTest" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownSplitTest",
        "Absplit_UnknownTestType" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownTestType",
        "Absplit_UnknownWaitUnit" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownWaitUnit",
        "Absplit_UnknownWinnerType" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitUnknownWinnerType",
        "Absplit_WinnerNotSelected" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\AbSplitWinnerNotSelected",
        "Invalid_Analytics" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidAnalytics",
        "Invalid_DateTime" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidDateTime",
        "Invalid_Email" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidEmail",
        "Invalid_SendType" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidSendType",
        "Invalid_Template" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidTemplate",
        "Invalid_TrackingOptions" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidTrackingOptions",
        "Invalid_Options" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidOptions",
        "Invalid_Folder" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidFolder",
        "Invalid_URL" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidURL",
        "Module_Unknown" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\ModuleUnknown",
        "MonthlyPlan_Unknown" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\MonthlyPlanUnknown",
        "Order_TypeUnknown" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\OrderTypeUnknown",
        "Invalid_PagingLimit" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidPagingLimit",
        "Invalid_PagingStart" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\InvalidPagingStart",
        "Max_Size_Reached" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\MaxSizeReached",
        "MC_SearchException" => "\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\McSearchException"
    );

    public function __construct($apiKey=NULL, $opts=array()) {
        if(!$apiKey) $apiKey = getenv('MAILCHIMP_APIKEY');
        if(!$apiKey) $apiKey = $this->readConfigs();
        if(!$apiKey) throw new Error('You must provide a MailChimp API key');

        $this->apiKey = $apiKey;
        $dc = "us1";
        if (strstr($this->apiKey, "-")){
            list($key, $dc) = explode("-", $this->apiKey,2);
            if (!$dc) $dc = "us1";
        }

        $this->root = str_replace('https://api', 'https://' . $dc . '.api', $this->root);
        $this->root = rtrim($this->root, '/') . '/';

        if (!isset($opts['timeout']) || !is_int($opts['timeout'])){
            $opts['timeout']=600;
        }

        if (isset($opts['debug'])){
            $this->debug = TRUE;
        }

        if (isset($opts['sslVerifyPeer'])){
            $this->sslVerifyPeer = $opts['sslVerifyPeer'];
        }

        if (isset($opts['sslVerifyHost'])){
            $this->sslVerifyHost = $opts['sslVerifyHost'];
        }

        if (isset($opts['sslCaInfo'])){
            $this->sslCaInfo = $opts['sslCaInfo'];
        }


        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'MailChimp-PHP/2.0.4');
        curl_setopt($this->ch, CURLOPT_POST, TRUE);
        @curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($this->ch, CURLOPT_HEADER, FALSE);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $opts['timeout']);


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

    public function __destruct() {
        curl_close($this->ch);
    }

    public function call($url, $params) {
        $params['apikey'] = $this->apiKey;
        $params = json_encode($params);
        $ch = $this->ch;

        curl_setopt($ch, CURLOPT_URL, $this->root . $url . '.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        // SSL Options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyPeer);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->sslVerifyHost);
        if ($this->sslCaInfo) curl_setopt($ch, CURLOPT_CAINFO, $this->sslCaInfo);

        $start = microtime(TRUE);
        $redirectsLeft = self::CURL_MAX_REDIRECTS;
        $this->log('Call to ' . $this->root . $url . '.json: ' . $params);
        if($this->debug) {
            $curl_buffer = fopen('php://memory', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $curl_buffer);
        }

        if(ini_get('open_basedir') == '' && (!ini_get('safe_mode') || ini_get('safe_mode') == 'Off')) {
            $response_body = curl_exec($ch);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $ch2 = curl_copy_handle($ch);
            curl_setopt($ch2, CURLOPT_HEADER, true);
            curl_setopt($ch2, CURLOPT_NOBODY, true);
            curl_setopt($ch2, CURLOPT_FORBID_REUSE, false);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

            do {
                curl_setopt($ch2, CURLOPT_URL, $finalUrl);
                $header = curl_exec($ch2);
                if ($errorCode = curl_errno($ch2)) {
                    $error = self::$curlCodes[$errorCode];
                    trigger_error('A cURL error occurred when trying to call the MailChimp API: ' . $error, E_USER_ERROR);
                } else {
                    $code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                    if ($code >= 300 && $code <= 399) {
                        preg_match('/Location:(.*?)\n/', $header, $matches);
                        $finalUrl = trim(array_pop($matches));
                    } else if($code >= 400 && $code <= 599) {
                        trigger_error('A network error occurred. Could not reach the MailChimp API endpoint.', E_USER_ERROR);
                    } else {
                        $code = 0;
                    }
                }
                $redirectsLeft--;
            } while ($code != 0 && $redirectsLeft > 0);

            curl_setopt($ch, CURLOPT_URL, $finalUrl);
            $response_body = curl_exec($ch);
        }

        if($redirectsLeft <= 0) {
            trigger_error('Too many redirects when trying to call the MailChimp API.', E_USER_ERROR);
        }

        $info = curl_getinfo($ch);
        $time = microtime(TRUE) - $start;
        if($this->debug) {
            rewind($curl_buffer);
            $this->log(stream_get_contents($curl_buffer));
            fclose($curl_buffer);
        }
        $this->log('Completed in ' . number_format($time * 1000, 2) . 'ms');
        $this->log('Got response: ' . $response_body);

        if(curl_error($ch)) {
            throw new HttpError("API call to $url failed: " . curl_error($ch));
        }
        $result = json_decode($response_body, TRUE);

        if(floor($info['http_code'] / 100) >= 4) {
            throw $this->castError($result);
        }

        return $result;
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

        $class = (isset(self::$errorMap[$result['name']])) ? self::$errorMap[$result['name']] : '\\MatoIlic\\T3Chimp\\MailChimp\\MailChimpApi\\Error';
        return new $class($result['error'], $result['code']);
    }

    public function log($msg) {
        if($this->debug) {
            $GLOBALS['BE_USER']->writeLog(4, 0, 0, 0, '[t3chimp]: ' . $msg);
        }
    }
}


