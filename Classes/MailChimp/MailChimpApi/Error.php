<?php

namespace MatoIlic\T3Chimp\MailChimp\MailChimpApi;

class Error extends \Exception { }

class HttpError extends Error { }

class ValidationError extends Error { }

class ServerErrorMethodUnknown extends Error { }

class ServerErrorInvalidParameters extends Error { }

class UnknownException extends Error { }

class RequestTimedOut extends Error { }

class ZendUriException extends Error { }

class PdoException extends Error { }

class AvestaDbException extends Error { }

class XmlRpc2Exception extends Error { }

class XmlRpc2FaultException extends Error { }

class TooManyConnections extends Error { }

class ParseException extends Error { }

class UserUnknown extends Error { }

class UserDisabled extends Error { }

class UserDoesNotExist extends Error { }

class UserNotApproved extends Error { }

class InvalidApiKey extends Error { }

class UserUnderMaintenance extends Error { }

class InvalidAppKey extends Error { }

class InvalidIp extends Error { }

class UserDoesExist extends Error { }

class UserInvalidRole extends Error { }

class UserInvalidAction extends Error { }

class UserMissingEmail extends Error { }

class UserCannotSendCampaign extends Error { }

class UserMissingModuleOutbox extends Error { }

class UserModuleAlreadyPurchased extends Error { }

class UserModuleNotPurchased extends Error { }

class UserNotEnoughCredit extends Error { }

class McInvalidPayment extends Error { }

class ListDoesNotExist extends Error { }

class ListInvalidInterestFieldType extends Error { }

class ListInvalidOption extends Error { }

class ListInvalidUnsubMember extends Error { }

class ListInvalidBounceMember extends Error { }

class ListAlreadySubscribed extends Error { }

class ListNotSubscribed extends Error { }

class ListInvalidImport extends Error { }

class McPastedListDuplicate extends Error { }

class McPastedListInvalidImport extends Error { }

class EmailAlreadySubscribed extends Error { }

class EmailAlreadyUnsubscribed extends Error { }

class EmailNotExists extends Error { }

class EmailNotSubscribed extends Error { }

class ListMergeFieldRequired extends Error { }

class ListCannotRemoveEmailMerge extends Error { }

class ListMergeInvalidMergeID extends Error { }

class ListTooManyMergeFields extends Error { }

class ListInvalidMergeField extends Error { }

class ListInvalidInterestGroup extends Error { }

class ListTooManyInterestGroups extends Error { }

class CampaignDoesNotExist extends Error { }

class CampaignStatsNotAvailable extends Error { }

class CampaignInvalidAbSplit extends Error { }

class CampaignInvalidContent extends Error { }

class CampaignInvalidOption extends Error { }

class CampaignInvalidStatus extends Error { }

class CampaignNotSaved extends Error { }

class CampaignInvalidSegment extends Error { }

class CampaignInvalidRss extends Error { }

class CampaignInvalidAuto extends Error { }

class McContentImportInvalidArchive extends Error { }

class CampaignBounceMissing extends Error { }

class CampaignInvalidTemplate extends Error { }

class InvalidEcommOrder extends Error { }

class AbSplitUnknownError extends Error { }

class AbSplitUnknownSplitTest extends Error { }

class AbSplitUnknownTestType extends Error { }

class AbSplitUnknownWaitUnit extends Error { }

class AbSplitUnknownWinnerType extends Error { }

class AbSplitWinnerNotSelected extends Error { }

class InvalidAnalytics extends Error { }

class InvalidDateTime extends Error { }

class InvalidEmail extends Error { }

class InvalidSendType extends Error { }

class InvalidTemplate extends Error { }

class InvalidTrackingOptions extends Error { }

class InvalidOptions extends Error { }

class InvalidFolder extends Error { }

class InvalidUrl extends Error { }

class ModuleUnknown extends Error { }

class MonthlyPlanUnknown extends Error { }

class OrderTypeUnknown extends Error { }

class InvalidPagingLimit extends Error { }

class InvalidPagingStart extends Error { }

class MaxSizeReached extends Error { }

class McSearchException extends Error { }
