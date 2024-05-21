<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class LangEN_GB {
        private static $en_GB_instance = null , $media_instance;

        public static function getInstance() {
                if (LangEN_GB::$en_GB_instance == null) {
                    LangEN_GB::$en_GB_instance = new LangEN_GB;
                        return LangEN_GB::$en_GB_instance;
                }
                return LangEN_GB::$en_GB_instance;
        }

        public static function contents(){
                $response = array('ImportUpdate' => 'Import',
                        'Exporterwithadvancedfilters' => 'Exporter with advanced filters',
                        'Exportfiltereddata' => 'Export filtered data',
                        'Exportfiltereddatadesc' => 'Lets you get only required data with the different advanced filters',
                        'Backupineditableformat' => 'Backup in editable format',
                        'Backupineditableformatdesc' => 'Backup in 4 different file formats like CSV, XML, JSON,XLS.',
                        'AutoScheduledBackups' => 'Auto Scheduled Backups',
                        'AutoScheduledBackupsdesc' => 'Scheduled export helps backup as editable text file format in regular interval.',
                        'Buynow' => 'Buy now!',
                        'Updateolderpostsfromsingleimport' => 'Update older posts from a single import',
                        'AutoSchedulewithreusabletemplates' => 'Auto Schedule with reusable templates',
                        'AIOWooCommerceImportSuit' => 'AIO WooCommerce Import Suit',
                        'WPMLImporter' => 'WPML Importer',
                        'SEOPluginsDataImporterRankMathYoastandAllinOneSEO' => 'SEO Plugins Data Importer - RankMath, SEOPress, Yoast and All in One SEO',
                        'JetEngineMetaboxToolsetTypesACFproFreeandPodsFieldPostPluginsImporter' => 
                        'JetEngine, Metabox, Toolset Types, ACF pro / Free and Pods Field/Post Plugins Importer',
                        'Dashboard' => 'Dashboard',
                        'Manager' => 'Manager',
                        'Export' => 'Export',
                        'Settings' => 'Settings',
                        'Support' => 'Support',
                        'UploadfromDesktop' => 'Upload from Desktop',
                        'UploadfromFTPSFTP' => 'Upload from FTP / SFTP',
                        'UploadfromFTP' => 'Upload from FTP',
                        'UploadfromURL' => 'Upload from URL',
                        'ChoosFileintheServer' => 'Choose File in the Server',
                        'DragDropyourfilesor' => 'Drag & Drop your files or',
                        'Browse' => 'Browse',
                        'NewItem' => 'New Item',
                        'ExistingItems' => 'Existing Items',
                        'ImportEachRecordAs'=> 'Importa each record as',
                        'Continue' => 'Continue',
                        'Search' => 'Search',
                        'FromDate' => 'From Date',
                        'ToDate' => 'To Date',
                        'SEARCH' => 'SEARCH',
                        'Media' =>'Media',
                        'AccessKey' => 'AccessKey',
                        'SavedTemplate' => 'Saved Template',
                        'TEMPLATES' => 'TEMPLATES',
                        'MATCHEDCOLUMNSCOUNT' => 'MATCHED COLUMNS COUNT',
                        'MODULE' => 'MODULE',
                        'CREATEDTIME' => 'CREATED TIME',
                        'ACTION' => 'ACTION',
                        'USETEMPLATE' => 'USE TEMPLATE',
                        'CREATENEWMAPPING' => 'CREATE NEW MAPPING',
                        'BACK' => 'BACK',
                        'ADVANCEDMODE' => 'ADVANCED MODE',
                        'DRAGDROPMODE' => 'DRAG & DROP MODE',
                        'WordpressFields' => 'Wordpress Fields',
                        'WPFIELDS' => 'WP Fields',
                        'CSVHEADER' => 'CSV Header',
                        'Action' => 'Action',
                        'Name' => 'Name',
                        'HINT' => 'HINT',
                        'Example' => 'Example',
                        'WordPressCoreFields' => 'WordPress Core Fields',
                        'ACFFreeFields' => 'ACF Free Fields',
                        'ACFFields' => 'ACF Fields',
                        'ACFGroupFields' => 'ACF Group Fields',
                        'ACFProFields' => 'ACF Pro Fields',
                        'ACFRepeaterFields' => 'ACF Repeater Fields',
                        'TypesCustomFields' => 'Types Custom Fields',
                        'PodsFields' => 'Pods Fields',
                        'JobListingFields' => 'Job Listing Fields',
                        'CustomFieldSuite' => 'Custom Field Suite',
                        'AllInOneSeoFields' => 'All In One Seo Fields',
                        'MetaBoxFields' => 'Meta Box Fields',
                        'YoastSeoFields' => 'Yoast Seo Fields',
                        'WPMLFields' => 'WPML Fields',
                        'JetEngineFields' => 'Jet Engine Fields',
                        'JetEngineRFFields' => 'Jet Engine Repeater Fields',
                        'JetEngineCPTFields' => 'Jet Engine CPT Fields',
                        'jetEngineCPTRFFields' => 'Jet Engine CPT Repeater Fields',
                        'jetEngineTaxonomyFields' => 'Jet Engine Taxonomy Fields',
                        'jetEngineTaxonomyRFFields' => 'Jet Engine Taxonomy Repeater Fields',
                        'JetEngineRelationsFields' => 'Jet Engine Relations Fields',
                        'RankMathFields'=>'Rank Math Fields',
                        'RankMathProFields'=>'Rank Math Pro Fields',
                        'replyattributesfields' => 'Reply Attributes Fields',
                        'forumattributesfields' => 'Forum Attributes Fields',
                        'topicattributesfields' => 'Topic Attributes Fields',
                        'BillingAndShippingInformation' => 'Billing and Shipping Information',
                        'CustomFieldsWPMemberFields' => 'Custom Fields WP Member Fields',
                        'CustomFieldsMemberFields' => 'Custom Fields Member Fields',
                        'ProductMetaFields' => 'Product Meta Fields',
                        'ProductAttrFields' => 'Product Attribute Fields',
                        'ProductBundleMetaFields' => 'Product Bundle Meta Fields',                        
                        'WPECommerceCustomFields' => 'WP ECommerce Custom Fields',
                        'EventsManagerFields' => 'Events Manager Fields',
                        'CMB2CustomFields' => 'CMB2 Custom Fields',
                        'CourseSettingsFields' => 'Course Settings Fields',
                        'CurriculumSettingsFields' => 'Curriculum Settings Fields',
                        'QuizSettingsFields' => 'Quiz Settings Fields',
                        'LessonSettingsFields' => 'Lesson Settings Fields',
                        'QuestionSettingsFields' => 'Question Settings Fields',
                        'OrderSettingsFields' => 'Order Settings Fields',
                        'WordPressCustomFields' => 'WordPress Custom Fields',
                        'TermsandTaxonomies' => 'Terms and Taxonomies',
                        'IsSerialized' => 'Is Serialized',
                        'NoCustomFieldsFound' => 'No Custom Fields Found', 
                        'MediaUploadFields' => 'Media Upload Fields',
                        'UploadMedia' => 'Upload Media',
                        'UploadedListofFiles' => 'Uploaded List of Files',
                        'UploadedMediaFileLists' => 'Uploaded Media File Lists',
                        'SavethismappingasTemplate' => 'Save this mapping as Template',
                        'Save' => 'Save',
                        'Doyouneedtoupdatethecurrentmapping' => 'Do you need to update the current mapping ?',
                        'Savethecurrentmappingasnewtemplate' => 'Save the current mapping as new template',
                        'Back' => 'Back',
                        'Size' => 'Size',
                        'MediaHandling' => 'Media Handling',
                        'Downloadexternalimagestoyourmedia' => 'Download external images to your media',
                        'ImageHandling' => 'Image Handling',
                        'Usemediaimagesifalreadyavailable' => 'Use media images if already available',
                        'Doyouwanttooverwritetheexistingimages' => 'Do you want to overwrite the existing images',
                        'ImageSizes' => 'Image Sizes',
                        'Thumbnail' => 'Thumbnail',
                        'Medium' => 'Medium',
                        'MediumLarge' => 'Medium Large',
                        'Large' => 'Large',
                        'Custom' => 'Custom',
                        'Slug' => 'Slug',
                        'Width' => 'Width',
                        'Height' => 'Height',
                        'PostContentImageOption' => 'Post Content Image Option',
                        'DownloadPostContentExternalImagestoMedia' => 'Download Post Content External Images to Media',
                        'Addcustomsizes' => 'Add custom sizes',
                        'MediaSEOAdvancedOptions' => 'Media SEO & Advanced Options',
                        'SetimageTitle' => 'Set image Title',
                        'SetimageCaption' => 'Set image Caption',
                        'SetimageAltText' => 'Set image Alt Text',
                        'SetimageDescription' => 'Set image Description',
                        'Changeimagefilenameto' => 'Change image file name to',
                        'ImportconfigurationSection' => 'Import configuration Section',
                        'EnablesafeprestateRollback' => 'Enable safe prestate Rollback',
                        'Backupbeforeimport' => 'Backup before import',
                        'DoyouwanttoSWITCHONMaintenancemodewhileimport' => 'Do you want to SWITCH ON Maintenance mode while import',
                        'Doyouwanttohandletheduplicateonexistingrecords' => 'Do you want to handle the duplicate on existing records',
                        'Mentionthefieldswhichyouwanttohandleduplicates' => 'Mention the fields which you want to handle duplicates',
                        'DoyouwanttoUpdateanexistingrecords' => 'Do you want to Update an existing records',
                        'Updaterecordsbasedon' => 'Update records based on',
                        'DoyouwanttoSchedulethisImport' => 'Do you want to Schedule this Import',
                        'ScheduleDate' => 'Schedule Date',
                        'ScheduleFrequency' => 'Schedule Frequency',
                        'TimeZone' => 'Time Zone',
                        'ScheduleTime' => 'Schedule Time',
                        'Schedule' => 'Schedule',
                        'Import' => 'Start Import',
                        'Format' => 'Format',
                        'OneTime' => 'OneTime',
                        'Daily' => 'Daily',
                        'Weekly' => 'Weekly',
                        'Monthly' => 'Monthly',
                        'Hourly' => 'Hourly',
                        'Every30mins'=> 'Every 30 mins',
                        'Every15mins' => 'Every 15 mins',
                        'Every10mins' => 'Every 10 mins',
                        'Every5mins' => 'Every 5 mins',
                        'FileName' => 'File Name',
                        'FileSize' => 'File Size',
                        'Process' => 'Process',
                        'Totalnoofrecords' => 'Total no of records',
                        'CurrentProcessingRecord' => 'Current Processing Record',
                        'RemainingRecord' => 'Remaining Record',
                        'Completed' => 'Completed',
                        'TimeElapsed' => 'Time Elapsed',
                        'approximate' => 'approximate',
                        'DownloadLog' => 'View Log',
                        'NoRecord' => 'No Record',
                        'UploadedCSVFileLists' => 'Uploaded CSV File Lists',
                        'Hostname' => 'Host Name',
                        'HostPort' => 'Host Port',
                        'HostUsername' => 'Host Username',
                        'HostPassword' => 'HostPassword',
                        'HostPath' => 'HostPath',
                        'DefaultPort' => 'Default Port',
                        'FTPUsername' => 'FTP Username',
                        'FTPPassword' => 'FTP Password',
                        'ConnectionType' => 'Connection Type',
                        'ImportersActivity' => 'Importers Activity',
                        'ImportStatistics' => 'Import Statistics',
                        'FileManager' => 'File Manager',
                        'SmartSchedule' => 'Smart Schedule',
                        'ScheduledExport' => 'Scheduled Export',
                        'Templates' => 'Templates',
                        'LogManager' => 'Log Manager',
                        'NotSelectedAnyTab' => 'Not Selected Any Tab',
                        'EventInfo' => 'Event Info',
                        'EventDate' => 'Event Date',
                        'EventStatus' => 'Event Status',
                        'Actions' => 'Actions',
                        'Date' => 'Date',
                        'Purpose' => 'Purpose',
                        'Revision' => 'Revision',
                        'Select' => 'Select',
                        'Inserted' => 'Inserted',
                        'Updated' => 'Updated',
                        'Skipped' => 'Skipped',
                        'Delete' => 'Delete',
                        'Noeventsfound' => 'No events found',
                        'ScheduleInfo' => 'Schedule Info',
                        'ScheduledDate' => 'Scheduled Date',
                        'ScheduledTime' => 'Scheduled Time',
                        'Youhavenotscheduledanyevent' => 'You haven’t scheduled any event',
                        'Frequency' => 'Frequency',
                        'Time' => 'Time',
                        'EditSchedule' => 'Edit Schedule',
                        'SaveChanges' => 'Save Changes',
                        'TemplateInfo' => 'Template Info',
                        'TemplateName' => 'Template Name',
                        'Module' => 'Module',
                        'CreatedTime' => 'Created Time',
                        'NoTemplateFound' => 'No Template Found',
                        'Download' => 'Download',
                        'NoLogRecordFound' => 'No Log Record Found',
                        'GeneralSettings' => 'General Settings',
                        'DatabaseOptimization' => 'Database Optimization',
                        'SecurityandPerformance' => 'Security and Performance',
                        'Documentation' => 'Documentation',
                        'MediaReport' => 'Media Report',
                        'DropTable' => 'Drop Table',
                        'Ifenabledplugindeactivationwillremoveplugindatathiscannotberestored' => 'If enabled plugin deactivation will remove plugin data, this cannot be restored.',
                        'Scheduledlogmails' => 'Scheduled log mails',
                        'Enabletogetscheduledlogmails' => 'Enable to get scheduled log mails.',
                        'Sendpasswordtouser' => 'Send password to user',
                        'Enabletosendpasswordinformationthroughemail' => 'Enable to send password information through email.',
                        'WoocommerceCustomattribute' => 'Woocommerce Custom attribute',
                        'Enablestoregisterwoocommercecustomattribute' => 'Enables to register woocommerce custom attribute.',
                        'PleasemakesurethatyoutakenecessarybackupbeforeproceedingwithdatabaseoptimizationThedatalostcantbereverted' => 'Please make sure that you take necessary backup before proceeding with database optimization. The data lost cannot be reverted.',
                        'DeleteallorphanedPostPageMeta' => 'Delete all orphaned Post/Page Meta',
                        'Deleteallunassignedtags' => 'Delete all unassigned tags',
                        'DeleteallPostPagerevisions' => 'Delete all Post/Page revisions',
                        'DeleteallautodraftedPostPage' => 'Delete all auto drafted Post/Page',
                        'DeleteallPostPageintrash' => 'Delete all Post/Page in trash',
                        'DeleteallCommentsintrash' => 'Delete all Comments in trash',
                        'DeleteallUnapprovedComments' => 'Delete all Unapproved Comments',
                        'DeleteallPingbackComments' => 'Delete all Pingback Comments',
                        'DeleteallTrackbackComments' => 'Delete all Trackback Comments',
                        'DeleteallSpamComments' => 'Delete all Spam Comments',
                        'RunDBOptimizer' => 'Run DB Optimizer',
                        'DatabaseOptimizationLog' => 'Database Optimization Log',
                        'noofOrphanedPostPagemetahasbeenremoved' => 'no of Orphaned Post/Page meta has been removed.',
                        'noofUnassignedtagshasbeenremoved' => 'no of Unassigned tags has been removed.',
                        'noofPostPagerevisionhasbeenremoved' => 'no of Post/Page revisions has been removed.',
                        'noofAutodraftedPostPagehasbeenremoved' => 'no of Auto drafted Post/Page has been removed.',
                        'noofPostPageintrashhasbeenremoved' => 'no of Post/Page in trash has been removed.',
                        'noofSpamcommentshasbeenremoved' => 'no of Spam comments has been removed.',
                        'noofCommentsintrashhasbeenremoved' => 'no of Comments in trash has been removed.',
                        'noofUnapprovedcommentshasbeenremoved' => 'no of Unapproved comments has been removed.',
                        'noofPingbackcommentshasbeenremoved' => 'no of Pingback comments has been removed.',
                        'noofTrackbackcommentshasbeenremoved' => 'no of Trackback comments has been removed.',
                        'Allowauthorseditorstoimport' => 'Allow authors/editors to import',
                        'Allowauthorseditorstoimport' => 'Allow authors/editors to import',
                        'Thisenablesauthorseditorstoimport' => 'This enables authors/editors to import.',
                        'MinimumrequiredphpinivaluesIniconfiguredvalues' => 'Minimum required php.ini values (Ini configured values)',
                        'Variables' => 'Variables',
                        'SystemValues' => 'System Values',
                        'MinimumRequirements' => 'Minimum Requirements',
                        'RequiredtoenabledisableLoadersExtentionsandmodules' => 'Required to enable/disable Loaders, Extentions and modules:',
                        'DebugInformation' => 'Debug Information:',
                        'SmackcodersGuidelines' => 'Smackcoders Guidelines',
                        'DevelopmentNews' => 'Development News',
                        'WhatsNew' => 'Whats New?',
                        'YoutubeChannel' => 'Youtube Channel',
                        'OtherWordPressPlugins' => 'Other WordPress Plugins',
                        'Count' => 'Count',
                        'ImageType' => 'Image Type',
                        'Status' => 'Status',
                        'Loading' => 'Loading',
                        'LoveWPUltimateCSVImporterGivea5starreviewon' => 'Love WP Ultimate CSV Importer, Give a 5 star review on',
                        'ContactSupport' => 'Contact Support',
                        'Email' => 'Email',
                        'Supporttype' => 'Support type',
                        'BugReporting' => 'Bug Reporting',
                        'FeatureEnhancement' => 'Feature Enhancement',
                        'Message' => 'Message',
                        'Send' => 'Send',
                        'NewsletterSubscription' => 'Newsletter Subscription',
                        'Subscribe' => 'Subscribe',
                        'Note' => 'Note',
                        'SubscribetoSmackcodersMailinglistafewmessagesayear' => 'Subscribe to Smackcoders Mailing list (a few messages a year)',
                        'Pleasedraftamailto' => 'Please draft a mail to',
                        'Ifyoudoesnotgetanyacknowledgementwithinanhour' => 'If you does not get any acknowledgement within an hour!',
                        'Selectyourmoduletoexportthedata' => 'Select the module to Export Data',
                        'Toexportdatabasedonthefilters' => 'To export data based on the filters',
                        'ExportFileName' => 'Export File Name',
                        'AdvancedSettings' => 'Advanced Settings',
                        'ExportType' => 'Export Type',
                        'SplittheRecord' => 'Split the Record',
                        'AdvancedFilters'=> 'Advanced Filters',
                        'Exportdatawithautodelimiters' => 'Export data with auto delimiters',
                        'Delimiters' => 'Delimiters',
                        'OtherDelimiters' => 'Other Delimiters',
                        'Exportdataforthespecificperiod' => 'Export data for the specific period',
                        'StartFrom' => 'Start From',
                        'EndTo' => 'End To',
                        'Exportdatawiththespecificstatus' => 'Export data with the specific status',
                        'All' => 'All',
                        'Publish' => 'Publish',
                        'Sticky' => 'Sticky',
                        'Private' => 'Private',
                        'Protected' => 'Protected',
                        'Draft' => 'Draught',
                        'Pending' => 'Pending',
                        'Exportdatabyspecificauthors' => 'Export data by specific authors',
                        'Authors' => 'Authors',
                        'ExportdatabasedonspecificInclusions' => 'Export data based on specific Inclusions',
                        'DoyouwanttoSchedulethisExport' => 'Do you want to Schedule this Export',
                        'SelectTimeZone' => 'Select TimeZone',
                        'ScheduleExport' => 'Schedule Export',
                        'DataExported' => 'Data Exported',
                        'FilePath' => 'File Path',
                        'Thisfeatureisavailablein' => 'This feature is available in',
                        'WPUltimateCSVImporter' => 'Wp ultimate csv importer',
                        'PremiumVersion' => 'Premium Version',
                        'ContactusforPresaleEnquiry' => 'Contact us for Presale Enquiry',
                        'importwoocommerce' => 'import woocommerce',
                        'ImportanybulkWooCommerceProductsdatainCSV' => 'Import any bulk WooCommerce Products data in CSV format',
                        'Highlights' => 'Highlights',
                        'ProductTypessimplegroupedvariableexternaltypeimport' => 'Product Types simple, grouped, variable, external type import',
                        'FeaturedProductImportfromURL' => 'Featured Product Import from URL',
                        'Galleryimageimport' => 'Gallery image import',
                        'Duplicatedetection' => 'Duplicate detection',
                        'FileType' => 'File Type',
                        'SupportsUTF_8CSVfile' => 'Supports UTF-8 CSV file format',
                        'AlreadyInstalled' => 'Already Installed',
                        'Install' => 'Install',
                        'ImportUsers' => 'Import Users',
                        'ImportUserinfointoWordPressinbulk' => 'Import User information into WordPress in bulk',
                        'WPMembersaddonsupport' => 'WP-Members add-on support',
                        'Defaultcustomfieldsimport' => 'Default custom fields import',
                        'Sendsautomatedpasswordnotificationemailoptional' => 'Sends automated password notification email(optional)',
                        'WPUltimateExporter' => 'WP Ultimate Exporter',
                        'ExportallyourWordPressdataasCSVfileforbackup' => 'Export all your WordPress data as a CSV file for backup',
                        'Supportsdefaultcustomfields' => 'Supports default custom fields',
                        'UTF8encodedCSVfile' => 'UTF-8 encoded CSV file format',
                        'SupportPostPageCustomPost' => 'Supports Posts, Pages & Custom Posts',
                        'Filteredexportbasedonperiodoftimeauthors' => 'Filtered export based on period of time & authors',
                        'Addons' => 'Addons',
                        'Posts' => 'Posts',
                        'CustomPosts' => 'Custom Posts',
                        'PostTags' => 'Post Tags',
                        'PostCategories' => 'Categories of Posts',
                        'Users' => 'Users',
                        'Taxonomies' => 'Taxonomies',
                        'Comments' => 'Comments',
                        'CustomerReviews' => 'Customer Reviews',
                        'WooCommerceCoupons' => 'WooCommerce Vouchers',
                        'WooCommerceRefunds' => 'WooCommerce Refunds',
                        'WooCommerceVariations' => 'WooCommerce Options',
                        'Found' => 'Found',
                        'CreateTopic' => 'Start a Topic',
                        'Createasupport' => 'Start a support topic here for assistance',
                        'Learnfrom' => 'Learn from our blog articles',
                        'TechnicalDocumentation' => 'Technical Manuals',
                        'Getsampleandexamplefiles' => 'Obtain sample and example files',
                        'PleaseinstalltheUltimateExportertoexportallyourWordPressdataasCSV' => 'Please install the Ultimate Exporter to export all your WordPress data as CSV',
                        'Clickheretoinstall' => 'Click here to install',
                        'Hire_us' => 'Hire us',
                        'GetSupport' => 'Get Support',
                        'SampleCSVXML' => 'Sample CSV & XML',
                        'WarningImportforsomedataaredisabledInstallandactivatebelowpluginsfirst' => 'Warning: Some addons are missing, it is recommended to',
                        'LifterCourseSettingsFields' => 'Lifter Course Settings Fields',
                        'LifterReviewSettingsFields' => 'Lifter Review Settings Fields',
                        'LifterCouponSettingsFields' => 'Lifter Coupon Settings Fields',
                        'LifterLessonSettingsFields' => 'Lifter Lesson Settings Fields',
                );
        return $response;
        }
}

