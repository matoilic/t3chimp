<?php

namespace MatoIlic\T3Chimp\MailChimp\MailChimpApi;

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class Error extends \Exception { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class HttpError extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ValidationError extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ServerErrorMethodUnknown extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ServerErrorInvalidParameters extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UnknownException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class RequestTimedOut extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ZendUriException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class PdoException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AvestaDbException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class XmlRpc2Exception extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class XmlRpc2FaultException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class TooManyConnections extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ParseException extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserUnknown extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserDisabled extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserDoesNotExist extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserNotApproved extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidApiKey extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserUnderMaintenance extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidAppKey extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidIp extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserDoesExist extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserInvalidRole extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserInvalidAction extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserMissingEmail extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserCannotSendCampaign extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserMissingModuleOutbox extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserModuleAlreadyPurchased extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserModuleNotPurchased extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class UserNotEnoughCredit extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class McInvalidPayment extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListDoesNotExist extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidInterestFieldType extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidOption extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidUnsubMember extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidBounceMember extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListAlreadySubscribed extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListNotSubscribed extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidImport extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class McPastedListDuplicate extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class McPastedListInvalidImport extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class EmailAlreadySubscribed extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class EmailAlreadyUnsubscribed extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class EmailNotExists extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class EmailNotSubscribed extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListMergeFieldRequired extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListCannotRemoveEmailMerge extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListMergeInvalidMergeID extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListTooManyMergeFields extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidMergeField extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListInvalidInterestGroup extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ListTooManyInterestGroups extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignDoesNotExist extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignStatsNotAvailable extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidAbSplit extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidContent extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidOption extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidStatus extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignNotSaved extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidSegment extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidRss extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidAuto extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class McContentImportInvalidArchive extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignBounceMissing extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class CampaignInvalidTemplate extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidEcommOrder extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitUnknownError extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitUnknownSplitTest extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitUnknownTestType extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitUnknownWaitUnit extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitUnknownWinnerType extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class AbSplitWinnerNotSelected extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidAnalytics extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidDateTime extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidEmail extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidSendType extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidTemplate extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidTrackingOptions extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidOptions extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidFolder extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidUrl extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class ModuleUnknown extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class MonthlyPlanUnknown extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class OrderTypeUnknown extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidPagingLimit extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class InvalidPagingStart extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class MaxSizeReached extends Error { }

/**
 * @ignore
 * @package MatoIlic\T3Chimp\MailChimp\MailChimpApi
 */
class McSearchException extends Error { }
